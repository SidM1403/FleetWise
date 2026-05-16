@extends('layouts.app')

@section('header')
    {{ __('Operator Profile') }}: {{ $driver->name }}
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $driver->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Authorized Fleet Operator | ID: #DRV-{{ str_pad($driver->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('drivers.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10 transition-all shadow-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Registry
                    </a>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('drivers.edit', $driver) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-200 dark:shadow-none active:scale-95">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Modify Profile
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Profile Identity -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-white dark:bg-[#111111] shadow-2xl shadow-gray-200/50 dark:shadow-none rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
                        <div class="p-8 text-center border-b border-gray-50 dark:border-white/5">
                            <div class="w-24 h-24 bg-gray-100 dark:bg-white/10 rounded-3xl mx-auto mb-6 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $driver->name }}</h3>
                            <p class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mt-1">Fleet Operation Specialist</p>
                        </div>
                        <div class="p-8 space-y-6 bg-gray-50/50 dark:bg-white/[0.02]">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Active Duty</span>
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-200"></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Assigned Unit</span>
                                <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $driver->vehicle->vehicle_number ?? 'Standby' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Credential Details -->
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-[#111111] shadow-2xl shadow-gray-200/50 dark:shadow-none rounded-[2rem] border border-gray-100 dark:border-white/5 p-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <div class="space-y-6">
                                <div class="group">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5 group-hover:text-indigo-600 transition-colors">Identification Contact</label>
                                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $driver->phone }}</p>
                                </div>
                                <div class="group">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5 group-hover:text-indigo-600 transition-colors">License Authorization</label>
                                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $driver->license_number }}</p>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="group">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5 group-hover:text-indigo-600 transition-colors">Deployment Hub</label>
                                    <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $driver->address ?? 'Corporate HQ' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 pt-10 border-t border-gray-50 dark:border-white/5">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 dark:text-white">Security Background</h4>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold leading-relaxed">
                                Personnel has cleared all standard fleet security protocols and is authorized for multi-regional asset transport. All licenses are verified against current regulatory standards.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection