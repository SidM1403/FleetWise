<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\{Driver, Vehicle};
use App\Http\Requests\{StoreDriverRequest, UpdateDriverRequest};
use App\Traits\ExportsCsv;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use ExportsCsv;

    protected function applyFilters(Request $request)
    {
        $query = Driver::with('vehicle');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('license_number', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        $drivers = $this->applyFilters($request)
                        ->orderBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'))
                        ->paginate($request->input('per_page', 10))
                        ->withQueryString();
        return view('drivers.index', compact('drivers'));
    }

    public function export(Request $request)
    {
        $query = $this->applyFilters($request)->orderBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'));
        $headers = ['Name', 'Phone', 'License Number', 'Assigned Vehicle', 'Created At'];
        return $this->downloadCsv($query, 'drivers-export.csv', $headers, function ($d) {
            return [
                $d->name, $d->phone, $d->license_number,
                $d->vehicle ? $d->vehicle->vehicle_number : 'None',
                $d->created_at->format('Y-m-d H:i')
            ];
        });
    }

    public function create()
    {
        $vehicles = Vehicle::whereDoesntHave('driver')->get();
        return view('drivers.create', compact('vehicles'));
    }

    public function store(StoreDriverRequest $request)
    {
        Driver::create($request->validated());
        return redirect()->route('drivers.index')->with('success', 'Driver created successfully.');
    }

    public function show(Driver $driver) { return view('drivers.show', compact('driver')); }

    public function edit(Driver $driver)
    {
        $vehicles = Vehicle::whereDoesntHave('driver')->orWhere('id', $driver->vehicle_id)->get();
        return view('drivers.edit', compact('driver', 'vehicles'));
    }

    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        $driver->update($request->validated());
        return redirect()->route('drivers.index')->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->trips()->whereIn('status', ['pending', 'ongoing'])->exists()) {
            return redirect()->route('drivers.index')->with('error', 'Cannot delete a driver assigned to active trips.');
        }
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully.');
    }
}
