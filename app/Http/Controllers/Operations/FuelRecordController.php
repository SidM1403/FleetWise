<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\{FuelRecord, Vehicle};
use App\Traits\ExportsCsv;
use Illuminate\Http\Request;

class FuelRecordController extends Controller
{
    use ExportsCsv;

    protected function applyFilters(Request $request)
    {
        $query = FuelRecord::with('vehicle');
        if ($search = $request->input('search')) {
            $query->whereHas('vehicle', fn($v) => $v->where('vehicle_number', 'like', "%{$search}%"));
        }
        return $query;
    }

    public function index(Request $request)
    {
        $fuelRecords = $this->applyFilters($request)
                            ->orderBy($request->input('sort', 'date'), $request->input('direction', 'desc'))
                            ->paginate($request->input('per_page', 10))
                            ->withQueryString();
        return view('fuel.index', compact('fuelRecords'));
    }

    public function export(Request $request)
    {
        $query = $this->applyFilters($request)->orderBy($request->input('sort', 'date'), $request->input('direction', 'desc'));
        $headers = ['Vehicle', 'Quantity (Liters)', 'Cost', 'Date', 'Created At'];
        return $this->downloadCsv($query, 'fuel-records-export.csv', $headers, function ($f) {
            return [$f->vehicle->vehicle_number, $f->quantity, $f->cost, $f->date->format('Y-m-d'), $f->created_at->format('Y-m-d H:i')];
        });
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('fuel.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'quantity'   => 'required|numeric|min:0.01',
            'cost'       => 'required|numeric|min:0.01',
            'date'       => 'required|date',
        ]);
        FuelRecord::create($validated);
        return redirect()->route('fuel.index')->with('success', 'Fuel record added successfully.');
    }
}
