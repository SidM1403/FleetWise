<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Http\Requests\{StoreVehicleRequest, UpdateVehicleRequest};
use App\Traits\ExportsCsv;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use ExportsCsv;

    protected function applyFilters(Request $request)
    {
        $query = Vehicle::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_number', 'like', "%{$search}%")
                  ->orWhere('vehicle_type', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }
        if ($status = $request->input('status')) $query->where('status', $status);
        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->applyFilters($request);
        $vehicles = $query->orderBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'))
                          ->paginate($request->input('per_page', 10))
                          ->withQueryString();
        return view('vehicles.index', compact('vehicles'));
    }

    public function export(Request $request)
    {
        $query = $this->applyFilters($request)->orderBy($request->input('sort', 'created_at'), $request->input('direction', 'desc'));
        $headers = ['Vehicle Number', 'Type', 'Model', 'Status', 'Created At'];
        return $this->downloadCsv($query, 'vehicles-export.csv', $headers, function ($v) {
            return [
                $v->vehicle_number, $v->vehicle_type, $v->model, ucfirst($v->status),
                $v->created_at->format('Y-m-d H:i')
            ];
        });
    }

    public function create() { return view('vehicles.create'); }

    public function store(StoreVehicleRequest $request)
    {
        Vehicle::create($request->validated());
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['trips.driver', 'maintenances', 'fuelRecords']);
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle) { return view('vehicles.edit', compact('vehicle')); }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());
        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->trips()->whereIn('status', ['pending', 'ongoing'])->exists()) {
            return redirect()->route('vehicles.index')->with('error', 'Cannot delete a vehicle assigned to active trips.');
        }
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
