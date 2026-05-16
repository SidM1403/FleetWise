@extends('layouts.app')
@section('header'){{ __('Asset Modification') }}@endsection
@section('content')
<div class="py-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('vehicles.index') }}" class="p-3 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-2xl text-gray-400 hover:text-indigo-600 transition-all shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-width="3" d="M15 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <div><h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Edit Configuration</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Adjusting technical parameters for asset: <span class="text-indigo-600 dark:text-indigo-400 font-black">{{ $vehicle->vehicle_number }}</span></p></div>
    </div>
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02] flex justify-between items-center"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Update Manifesto</h3></div>
        <div class="p-10">
            <form method="POST" action="{{ route('vehicles.update', $vehicle) }}" class="space-y-8">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="vehicle_number" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Vehicle Number</label>
                        <input type="text" name="vehicle_number" id="vehicle_number" value="{{ old('vehicle_number', $vehicle->vehicle_number) }}" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('vehicle_number') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="vehicle_type" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Vehicle Type</label>
                        <select name="vehicle_type" id="vehicle_type" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            @foreach(['Sedan', 'SUV', 'Truck', 'Van', 'Bus'] as $type)<option value="{{ $type }}" {{ old('vehicle_type', $vehicle->vehicle_type) == $type ? 'selected' : '' }}>{{ $type }}</option>@endforeach
                        </select>
                        @error('vehicle_type') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="model" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Model</label>
                        <input type="text" name="model" id="model" value="{{ old('model', $vehicle->model) }}" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('model') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="capacity" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Capacity</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $vehicle->capacity) }}" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('capacity') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="registration_date" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Registration Date</label>
                        <input type="date" name="registration_date" id="registration_date" value="{{ old('registration_date', $vehicle->registration_date?->format('Y-m-d')) }}" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('registration_date') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="insurance_expiry" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Insurance Expiry</label>
                        <input type="date" name="insurance_expiry" id="insurance_expiry" value="{{ old('insurance_expiry', $vehicle->insurance_expiry?->format('Y-m-d')) }}" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('insurance_expiry') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label for="status" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Status</label>
                        <select name="status" id="status" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            @foreach(['active', 'maintenance', 'inactive'] as $s)<option value="{{ $s }}" {{ old('status', $vehicle->status) == $s ? 'selected' : '' }}>{{ strtoupper($s) }}</option>@endforeach
                        </select>
                        @error('status') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-50 dark:border-white/5">
                    <a href="{{ route('vehicles.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-600 transition-colors">Abort Changes</a>
                    <button type="submit" class="px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all shadow-xl active:scale-95">Update Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection