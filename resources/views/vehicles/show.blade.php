@extends('layouts.app')

@section('header')
    {{ __('Asset Profile') }}: {{ $vehicle->vehicle_number }}
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto" x-data="{ activeTab: 'details' }">
            <!-- Header & Actions -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $vehicle->vehicle_number }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                            {{ $vehicle->status === 'active' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20' : '' }}
                            {{ $vehicle->status === 'maintenance' ? 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-500/20' : '' }}
                            {{ $vehicle->status === 'inactive' ? 'bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-500/20' : '' }}">
                            {{ $vehicle->status }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Operational ID: #VEH-{{ str_pad($vehicle->id, 4, '0', STR_PAD_LEFT) }} | Type: {{ $vehicle->vehicle_type }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/10 transition-all shadow-sm">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back
                    </a>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-200 dark:shadow-none active:scale-95">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Edit Configuration
                        </a>
                    @endif
                </div>
            </div>

            <!-- Tabbed Card -->
            <div class="bg-white dark:bg-[#111111] shadow-2xl shadow-gray-200/50 dark:shadow-none rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
                <!-- Navigation -->
                <div class="bg-gray-50/50 dark:bg-white/[0.02] border-b border-gray-100 dark:border-white/5 px-8 pt-6">
                    <nav class="-mb-px flex space-x-10">
                        @php
                            $tabs = [
                                'details' => 'Technical Specs',
                                'trips' => 'Trip Registry (' . $vehicle->trips->count() . ')',
                                'maintenance' => 'Service Logs (' . $vehicle->maintenances->count() . ')',
                                'fuel' => 'Energy Records (' . $vehicle->fuelRecords->count() . ')'
                            ];
                        @endphp
                        @foreach($tabs as $key => $label)
                            <button @click="activeTab = '{{ $key }}'" 
                                :class="activeTab === '{{ $key }}' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                                class="whitespace-nowrap pb-5 px-1 border-b-4 font-black text-[10px] uppercase tracking-widest transition-all focus:outline-none">
                                {{ $label }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                <div class="p-8">
                    <!-- Technical Specs -->
                    <div x-show="activeTab === 'details'" class="animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Manufacturer & Model</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $vehicle->model }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Payload Capacity</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $vehicle->capacity ?? 'N/A' }} Units</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Primary Operator</label>
                                <p class="text-sm font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tight">{{ $vehicle->driver->name ?? 'None Assigned' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400">Registry Date</label>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $vehicle->registration_date?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="mt-12 p-8 bg-gray-50 dark:bg-white/5 rounded-3xl border border-gray-100 dark:border-white/5">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 dark:text-white">Insurance Compliance</h4>
                            </div>
                            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Insurance Expiration Timeline</p>
                                    <p class="text-xl font-black text-gray-900 dark:text-white mt-1">{{ $vehicle->insurance_expiry?->format('M d, Y') ?? 'N/A' }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-black px-4 py-2 bg-white dark:bg-white/10 rounded-xl shadow-sm uppercase tracking-widest">Verified Credentials</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trip Registry -->
                    <div x-show="activeTab === 'trips'" x-cloak class="animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="overflow-x-auto -mx-8">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Route Map</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Operator</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Schedule</th>
                                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                                    @forelse($vehicle->trips as $trip)
                                        <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="text-sm font-black text-gray-900 dark:text-white tracking-tight">{{ $trip->origin }} &rarr; {{ $trip->destination }}</div>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ $trip->driver->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $trip->departure_time->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap text-right">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                                    {{ $trip->status === 'completed' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400' }}">
                                                    {{ $trip->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-8 py-12 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">No active logs found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Service Logs -->
                    <div x-show="activeTab === 'maintenance'" x-cloak class="animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="overflow-x-auto -mx-8">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Task Detail</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Date</th>
                                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Financial Impact</th>
                                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Next Due</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                                    @forelse($vehicle->maintenances as $m)
                                        <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $m->service_type }}</div>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ $m->service_date->format('M d, Y') }}</td>
                                            <td class="px-8 py-6 whitespace-nowrap text-right font-black text-rose-600">-${{ number_format($m->cost, 2) }}</td>
                                            <td class="px-8 py-6 whitespace-nowrap text-right text-[10px] font-bold text-emerald-600 uppercase tracking-widest">{{ $m->next_service_date?->format('M d, Y') ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-8 py-12 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">No maintenance history.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Energy Records -->
                    <div x-show="activeTab === 'fuel'" x-cloak class="animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="overflow-x-auto -mx-8">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Transaction Date</th>
                                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Volume</th>
                                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                                    @forelse($vehicle->fuelRecords as $fuel)
                                        <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                            <td class="px-8 py-6 whitespace-nowrap text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ $fuel->date->format('M d, Y') }}</td>
                                            <td class="px-8 py-6 whitespace-nowrap font-black text-gray-900 dark:text-white tracking-tight">{{ number_format($fuel->quantity, 2) }} L</td>
                                            <td class="px-8 py-6 whitespace-nowrap text-right font-black text-gray-900 dark:text-white tracking-tighter">${{ number_format($fuel->cost, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-8 py-12 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">No fuel consumption records.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection