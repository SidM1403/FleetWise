<?php

namespace App\Http\Controllers;

use App\Models\{Trip, Vehicle, Expense, FuelRecord};
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() { return view('reports.index'); }

    public function tripSummary(Request $request)
    {
        $request->validate(['start_date' => 'required|date', 'end_date' => 'required|date|after_or_equal:start_date']);
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $trips = Trip::with(['vehicle', 'driver'])->whereBetween('departure_time', [$startDate, $endDate])->orderBy('departure_time')->get();
        return view('reports.trip_summary', compact('trips', 'startDate', 'endDate'));
    }

    public function vehicleCost(Request $request)
    {
        $request->validate(['start_date' => 'required|date', 'end_date' => 'required|date|after_or_equal:start_date']);
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $vehicles = Vehicle::with([
            'expenses' => fn($q) => $q->whereBetween('date', [$startDate, $endDate]),
            'fuelRecords' => fn($q) => $q->whereBetween('date', [$startDate, $endDate])
        ])->get();

        foreach ($vehicles as $v) {
            $v->total_expenses = $v->expenses->sum('amount');
            $v->total_fuel_cost = $v->fuelRecords->sum('cost');
            $v->total_cost = $v->total_expenses + $v->total_fuel_cost;
        }

        $vehicles = $vehicles->sortByDesc('total_cost');
        return view('reports.vehicle_cost', compact('vehicles', 'startDate', 'endDate'));
    }
}
