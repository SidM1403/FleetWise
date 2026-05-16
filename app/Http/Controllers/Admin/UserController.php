<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Vehicle, Driver, Trip, Maintenance, FuelRecord, Expense};
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('is_active', 'asc')->orderBy('name', 'asc')->get();
        $systemOverview = [
            ['label' => 'Users',        'count' => User::count(),        'icon' => 'users'],
            ['label' => 'Vehicles',     'count' => Vehicle::count(),     'icon' => 'truck'],
            ['label' => 'Drivers',      'count' => Driver::count(),      'icon' => 'id-card'],
            ['label' => 'Trips',        'count' => Trip::count(),        'icon' => 'map'],
            ['label' => 'Maintenance',  'count' => Maintenance::count(), 'icon' => 'wrench'],
            ['label' => 'Fuel Records', 'count' => FuelRecord::count(),  'icon' => 'fuel'],
            ['label' => 'Expenses',     'count' => Expense::count(),     'icon' => 'dollar'],
        ];
        return view('admin.users.index', compact('users', 'systemOverview'));
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'You cannot deactivate yourself.');
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', "User {$user->name} has been " . ($user->is_active ? 'activated' : 'deactivated') . ".");
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'You cannot remove your own admin status.');
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', "User {$user->name} is now " . ($user->is_admin ? 'Admin' : 'Staff') . ".");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'You cannot delete yourself.');
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
