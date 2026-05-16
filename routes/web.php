<?php

use App\Http\Controllers\{DashboardController, WelcomeController, ProfileController, ReportController};
use App\Http\Controllers\Fleet\{DriverController, VehicleController};
use App\Http\Controllers\Operations\{TripController, MaintenanceController, FuelRecordController, ExpenseController};
use App\Http\Controllers\Admin\{UserController, ActivityLogController};
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Vehicles & Drivers Registry
    Route::get('/vehicles/export', [VehicleController::class, 'export'])->name('vehicles.export');
    Route::resource('vehicles', VehicleController::class)->only(['index', 'show', 'create', 'store']);
    Route::get('/drivers/export', [DriverController::class, 'export'])->name('drivers.export');
    Route::resource('drivers', DriverController::class)->only(['index', 'show', 'create', 'store']);

    // Operations Management
    Route::get('/trips/export', [TripController::class, 'export'])->name('trips.export');
    Route::post('/trips/{trip}/complete', [TripController::class, 'complete'])->name('trips.complete');
    Route::resource('trips', TripController::class)->except(['edit', 'update', 'destroy']);

    Route::get('/maintenance/export', [MaintenanceController::class, 'export'])->name('maintenance.export');
    Route::post('/maintenance/{maintenance}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');
    Route::resource('maintenance', MaintenanceController::class)->except(['edit', 'update', 'destroy']);

    Route::get('/fuel/export', [FuelRecordController::class, 'export'])->name('fuel.export');
    Route::resource('fuel', FuelRecordController::class)->except(['show', 'edit', 'update', 'destroy']);

    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::resource('expenses', ExpenseController::class)->except(['show', 'edit', 'update', 'destroy']);

    // Elevated Privileges (Admin Only)
    Route::middleware(['admin'])->group(function () {
        Route::get('vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::match(['put', 'patch'], 'vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        Route::get('drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
        Route::match(['put', 'patch'], 'drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
        Route::delete('drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');

        Route::delete('trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
        Route::delete('maintenance/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenance.destroy');

        Route::patch('/expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::patch('/expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/trip-summary', [ReportController::class, 'tripSummary'])->name('reports.trip_summary');
        Route::post('/reports/vehicle-cost', [ReportController::class, 'vehicleCost'])->name('reports.vehicle_cost');

        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::patch('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::patch('/admin/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('admin.users.toggle-admin');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])->name('admin.activity-log');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
