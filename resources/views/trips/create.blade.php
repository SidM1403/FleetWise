@extends('layouts.app')
@section('header'){{ __('Logistics Dispatch') }}@endsection
@section('content')
<div class="py-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('trips.index') }}" class="p-3 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-2xl text-gray-400 hover:text-indigo-600 transition-all shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-width="3" d="M15 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <div><h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Schedule Mission</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Configure route, asset, and operator for a new logistics deployment.</p></div>
    </div>
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Deployment Manifesto</h3></div>
        <div class="p-10">
            <form method="POST" action="{{ route('trips.store') }}" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="vehicle_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Target Asset</label>
                        <select name="vehicle_id" id="vehicle_id" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            <option value="">Select Vehicle</option>
                            @foreach($vehicles as $v)<option value="{{ $v->id }}" {{ old('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->vehicle_number }} — {{ $v->model }}</option>@endforeach
                        </select>
                        @error('vehicle_id') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="driver_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Assigned Operator</label>
                        <select name="driver_id" id="driver_id" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            <option value="">Select Driver</option>
                            @foreach($drivers as $d)<option value="{{ $d->id }}" {{ old('driver_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach
                        </select>
                        @error('driver_id') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="origin" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Point of Origin</label>
                        <input type="text" name="origin" id="origin" value="{{ old('origin') }}" required placeholder="Corporate Hub Alpha" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('origin') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="destination" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Target Destination</label>
                        <input type="text" name="destination" id="destination" value="{{ old('destination') }}" required placeholder="Regional Distribution Center" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('destination') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="departure_time" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Scheduled Departure</label>
                        <input type="datetime-local" name="departure_time" id="departure_time" value="{{ old('departure_time') }}" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('departure_time') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="start_odometer" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Initial Odometer (KM)</label>
                        <input type="number" name="start_odometer" id="start_odometer" value="{{ old('start_odometer') }}" required placeholder="0.00" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('start_odometer') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-50 dark:border-white/5">
                    <a href="{{ route('trips.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-600 transition-colors">Abort Deployment</a>
                    <button type="submit" class="px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all shadow-xl active:scale-95">Authorize Mission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
on