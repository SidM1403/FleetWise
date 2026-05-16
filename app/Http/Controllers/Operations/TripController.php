<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\{Trip, Vehicle, Driver};
use App\Http\Requests\StoreTripRequest;
use App\Traits\ExportsCsv;
use Illuminate\Http\Request;

class TripController extends Controller
{
    use ExportsCsv;

    protected function applyFilters(Request $request)
    {
        $query = Trip::with(['vehicle', 'driver']);
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('origin', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', fn($v) => $v->where('vehicle_number', 'like', "%{$search}%"))
                  ->orWhereHas('driver', fn($d) => $d->where('name', 'like', "%{$search}%"));
            });
        }
        if ($status = $request->input('status')) $query->where('status', $status);
        return $query;
    }

    public function index(Request $request)
    {
        $trips = $this->applyFilters($request)
                      ->orderBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'))
                      ->paginate($request->input('per_page', 10))
                      ->withQueryString();
        return view('trips.index', compact('trips'));
    }

    public function export(Request $request)
    {
        $query = $this->applyFilters($request)->orderBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'));
        $headers = ['Origin', 'Destination', 'Departure Time', 'Arrival Time', 'Vehicle', 'Driver', 'Status', 'Distance', 'Created At'];
        return $this->downloadCsv($query, 'trips-export.csv', $headers, function ($t) {
            return [
                $t->origin, $t->destination, $t->departure_time->format('Y-m-d H:i'),
                $t->arrival_time ? $t->arrival_time->format('Y-m-d H:i') : 'N/A',
                $t->vehicle->vehicle_number, $t->driver->name, ucfirst($t->status),
                $t->distance . ' km', $t->created_at->format('Y-m-d H:i')
            ];
        });
    }

    public function create()
    {
        $vehicles = Vehicle::where('status', 'active')->whereDoesntHave('trips', function($q) {
            $q->whereIn('status', ['pending', 'ongoing']);
        })->get();
        $drivers = Driver::whereDoesntHave('trips', function($q) {
            $q->whereIn('status', ['pending', 'ongoing']);
        })->get();
        return view('trips.create', compact('vehicles', 'drivers'));
    }

    public function store(StoreTripRequest $request)
    {
        Trip::create($request->validated());
        return redirect()->route('trips.index')->with('success', 'Trip scheduled successfully.');
    }

    public function show(Trip $trip) { return view('trips.show', compact('trip')); }


    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Trip deleted.');
    }

    public function complete(Request $request, Trip $trip)
    {
        $request->validate(['end_odometer' => 'required|integer|gt:' . $trip->start_odometer]);
        $trip->update([
            'end_odometer' => $request->end_odometer,
            'arrival_time' => now(),
            'distance'     => $request->end_odometer - $trip->start_odometer,
            'status'       => 'completed'
        ]);
        return redirect()->route('trips.index')->with('success', 'Trip completed and vehicle released.');
    }
}
