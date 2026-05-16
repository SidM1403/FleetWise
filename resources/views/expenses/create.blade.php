@extends('layouts.app')
@section('header'){{ __('Fiscal Entry') }}@endsection
@section('content')
<div class="py-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('expenses.index') }}" class="p-3 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-2xl text-gray-400 hover:text-indigo-600 transition-all shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-width="3" d="M15 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <div><h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Log Expenditure</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Audit-ready recording of operational costs and miscellaneous fleet fees.</p></div>
    </div>
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Financial Manifesto</h3></div>
        <div class="p-10">
            <form method="POST" action="{{ route('expenses.store') }}" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="category" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Classification</label>
                        <select name="category" id="category" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            <option value="">Select Category</option>
                            @foreach(['Toll', 'Parking', 'Repair', 'Insurance', 'Registration', 'Miscellaneous'] as $cat)<option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ strtoupper($cat) }}</option>@endforeach
                        </select>
                        @error('category') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="amount" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Amount ($)</label>
                        <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="0.00" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('amount') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="vehicle_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Associated Asset (Optional)</label>
                        <select name="vehicle_id" id="vehicle_id" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            <option value="">-- General Cost --</option>
                            @foreach($vehicles as $v)<option value="{{ $v->id }}" {{ old('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->vehicle_number }} — {{ $v->model }}</option>@endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="date" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Transaction Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('date') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label for="trip_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Operational Trip (Optional)</label>
                        <select name="trip_id" id="trip_id" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            <option value="">-- Non-Trip Specific --</option>
                            @foreach($trips as $t)<option value="{{ $t->id }}" {{ old('trip_id') == $t->id ? 'selected' : '' }}>{{ $t->origin }} → {{ $t->destination }} ({{ $t->vehicle->vehicle_number }})</option>@endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label for="description" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Expense Narrative</label>
                        <textarea name="description" id="description" rows="3" placeholder="Justification or details..." class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-50 dark:border-white/5">
                    <a href="{{ route('expenses.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-600 transition-colors">Abort Entry</a>
                    <button type="submit" class="px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all shadow-xl active:scale-95">Submit Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
tion