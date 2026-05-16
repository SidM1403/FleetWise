<?php

namespace App\Http\Controllers;

use App\Models\{ActivityLog, Vehicle, Trip, Driver, Expense, FuelRecord, Maintenance};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeVehicles = Vehicle::where('status', 'active')->count();
        $ongoingTrips = Trip::where('status', 'ongoing')->count();
        $availableDrivers = Driver::whereDoesntHave('trips', function($q) {
            $q->whereIn('status', ['pending', 'ongoing']);
        })->count();

        // Total expenses for current month
        $monthlyExpenses = Expense::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('amount');
        $monthlyFuel = FuelRecord::whereMonth('date', now()->month)->whereYear('date', now()->year)->sum('cost');
        $totalMonthlyExpenses = $monthlyExpenses + $monthlyFuel;
        
        $upcomingMaintenance = Maintenance::upcoming()->with('vehicle')->get();

        $fleetStatus = [
            'active'      => Vehicle::where('status', 'active')->count(),
            'maintenance' => Vehicle::where('status', 'maintenance')->count(),
            'inactive'    => Vehicle::where('status', 'inactive')->count(),
            'total'       => Vehicle::count(),
        ];

        $tripStatuses = [
            'Pending'   => Trip::where('status', 'pending')->count(),
            'Ongoing'   => Trip::where('status', 'ongoing')->count(),
            'Completed' => Trip::where('status', 'completed')->count(),
        ];

        // Chart data for last 6 months
        $expenseLabels = [];
        $expenseData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $expenseLabels[] = $date->format('M Y');
            $monthExp = Expense::whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
            $monthFuel = FuelRecord::whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('cost');
            $expenseData[] = $monthExp + $monthFuel;
        }

        $recentActivity = ActivityLog::with('user')->latest()->take(10)->get()->map(function($log) {
            $colors = ['created' => 'green', 'updated' => 'blue', 'deleted' => 'rose'];
            $icons = ['Vehicle' => 'truck', 'Driver' => 'user', 'Trip' => 'map', 'Maintenance' => 'wrench', 'FuelRecord' => 'fire', 'Expense' => 'dollar'];
            return [
                'type'     => strtolower($log->model_type),
                'icon'     => $icons[$log->model_type] ?? 'clock',
                'color'    => $colors[$log->action] ?? 'gray',
                'title'    => $log->description,
                'subtitle' => "By " . ($log->user->name ?? 'System') . " · " . ucfirst($log->action),
                'time'     => $log->created_at,
            ];
        });

        return view('dashboard', compact(
            'activeVehicles', 'ongoingTrips', 'availableDrivers', 'totalMonthlyExpenses', 
            'upcomingMaintenance', 'tripStatuses', 'expenseLabels', 'expenseData', 
            'recentActivity', 'fleetStatus'
        ));
    }
}
