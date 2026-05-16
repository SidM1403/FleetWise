<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\{Expense, Vehicle, Trip};
use App\Traits\ExportsCsv;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    use ExportsCsv;

    protected function applyFilters(Request $request)
    {
        $query = Expense::with(['vehicle', 'trip']);
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('vehicle', fn($v) => $v->where('vehicle_number', 'like', "%{$search}%"));
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        $expenses = $this->applyFilters($request)
                         ->orderBy($request->input('sort', 'date'), $request->input('direction', 'desc'))
                         ->paginate($request->input('per_page', 10))
                         ->withQueryString();
        return view('expenses.index', compact('expenses'));
    }

    public function export(Request $request)
    {
        $query = $this->applyFilters($request)->orderBy($request->input('sort', 'date'), $request->input('direction', 'desc'));
        $headers = ['Category', 'Amount', 'Status', 'Approved By', 'Vehicle', 'Trip Link', 'Date', 'Description', 'Created At'];
        return $this->downloadCsv($query, 'expenses-export.csv', $headers, function ($e) {
            return [
                $e->category, $e->amount, strtoupper($e->status),
                $e->approver ? $e->approver->name : 'N/A',
                $e->vehicle ? $e->vehicle->vehicle_number : 'N/A',
                $e->trip ? $e->trip->origin . ' -> ' . $e->trip->destination : 'General',
                $e->date->format('Y-m-d'), $e->description, $e->created_at->format('Y-m-d H:i')
            ];
        });
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $trips = Trip::with('vehicle', 'driver')->latest()->take(50)->get();
        return view('expenses.create', compact('vehicles', 'trips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'trip_id'    => 'nullable|exists:trips,id',
            'amount'     => 'required|numeric|min:0.01',
            'category'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'date'       => 'required|date',
        ]);
        $expense = new Expense($validated);
        if (auth()->user()->is_admin) {
            $expense->status = 'approved';
            $expense->approved_by = auth()->id();
        } else {
            $expense->status = 'pending';
        }
        $expense->save();
        return redirect()->route('expenses.index')->with('success', 'Expense logged successfully.');
    }

    public function approve(Expense $expense)
    {
        $this->authorizeAdmin();
        $expense->update(['status' => 'approved', 'approved_by' => auth()->id()]);
        return back()->with('success', 'Expense approved.');
    }

    public function reject(Expense $expense)
    {
        $this->authorizeAdmin();
        $expense->update(['status' => 'rejected', 'approved_by' => auth()->id()]);
        return back()->with('success', 'Expense rejected.');
    }

    protected function authorizeAdmin()
    {
        if (!auth()->user()->is_admin) abort(403, 'Unauthorized action.');
    }
}
