@extends('layouts.app')
@section('header'){{ __('Personnel Registry') }}@endsection
@section('content')
<div class="py-6 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('drivers.index') }}" class="p-3 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-2xl text-gray-400 hover:text-indigo-600 transition-all shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-width="3" d="M15 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <div><h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Onboard Driver</h2><p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Register new personnel and assign operational assets.</p></div>
    </div>
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Credential Manifesto</h3></div>
        <div class="p-10">
            <form method="POST" action="{{ route('drivers.store') }}" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="name" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Full Legal Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. John Doe" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('name') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="phone" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Communication Line</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="+1 (000) 000-0000" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('phone') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="license_number" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">License Authority ID</label>
                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" required placeholder="ABC-123456" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('license_number') <p class="text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="license_expiry" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">License Expiration</label>
                        <input type="date" name="license_expiry" id="license_expiry" value="{{ old('license_expiry') }}" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label for="vehicle_id" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Assigned Operational Asset</label>
                        <select name="vehicle_id" id="vehicle_id" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                            <option value="">-- No Assignment --</option>
                            @foreach($vehicles as $vehicle)<option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->vehicle_number }} — {{ $vehicle->model }}</option>@endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label for="address" class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Resident Address</label>
                        <textarea name="address" id="address" rows="3" placeholder="Primary residence details..." class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-4 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">{{ old('address') }}</textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-50 dark:border-white/5">
                    <a href="{{ route('drivers.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-600 transition-colors">Abort Onboarding</a>
                    <button type="submit" class="px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all shadow-xl active:scale-95">Register Driver</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection