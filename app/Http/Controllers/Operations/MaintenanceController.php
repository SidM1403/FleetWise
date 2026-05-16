<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\{Maintenance, Vehicle};
use App\Http\Requests\StoreMaintenanceRequest;
use App\Traits\ExportsCsv;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    use ExportsCsv;

    protected function applyFilters(Request $request)
    {
        $query = Maintenance::with('vehicle');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('service_type', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', fn($v) => $v->where('vehicle_number', 'like', "%{$search}%"));
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        $maintenances = $this->applyFilters($request)
                             ->orderBy($request->input('sort', 'service_date'), $request->input('direction', 'desc'))
                             ->paginate($request->input('per_page', 10))
                             ->withQueryString();
        return view('maintenance.index', compact('maintenances'));
    }

    public function export(Request $request)
    {
        $query = $this->applyFilters($request)->orderBy($request->input('sort', 'service_date'), $request->input('direction', 'desc'));
        $headers = ['Vehicle', 'Service Type', 'Cost', 'Service Date', 'Next Service Date', 'Status', 'Created At'];
        return $this->downloadCsv($query, 'maintenance-export.csv', $headers, function ($m) {
            return [
                $m->vehicle->vehicle_number, $m->service_type, $m->cost,
                $m->service_date->format('Y-m-d'), $m->next_service_date ? $m->next_service_date->format('Y-m-d') : 'N/A',
                'Completed', $m->created_at->format('Y-m-d H:i')
            ];
        });
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('maintenance.create', compact('vehicles'));
    }

    public function store(StoreMaintenanceRequest $request)
    {
        Maintenance::create($request->validated());
        return redirect()->route('maintenance.index')->with('success', 'Maintenance record added successfully.');
    }

    public function show(Maintenance $maintenance)
    {
        $maintenance->load('vehicle');
        return view('maintenance.show', compact('maintenance'));
    }

    public function complete(Request $request, Maintenance $maintenance)
    {
        $request->validate(['cost' => 'required|numeric|min:0']);
        $maintenance->update([
            'cost' => $request->cost,
            'status' => 'completed',
            'service_date' => now()
        ]);
        
        // Mark vehicle as active again
        $maintenance->vehicle->update(['status' => 'active']);
        
        return redirect()->route('maintenance.index')->with('success', 'Maintenance completed. Vehicle is now active.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('maintenance.index')->with('success', 'Maintenance record deleted.');
    }
}
