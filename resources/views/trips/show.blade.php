@extends('layouts.app')

@section('header')
    Trip Manifest: {{ $trip->origin }} to {{ $trip->destination }}
@endsection

@section('content')
<div class="py-6 max-w-5xl mx-auto">
    {{-- Top Navigation --}}
    <div class="flex justify-between items-center mb-8">
        <a href="{{ route('trips.index') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Return to Logs
        </a>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                @if($trip->status == 'completed') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20
                @elseif($trip->status == 'ongoing') bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 ring-1 ring-blue-500/20
                @else bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-500/20 @endif">
                {{ $trip->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-[#111111] rounded-3xl border border-gray-100 dark:border-white/5 overflow-hidden shadow-sm">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-2xl">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 20l-5.447-2.724A2 2 0 013 15.483V8.416a2 2 0 011.106-1.789l5.447-2.724a2 2 0 011.894 0l5.447 2.724A2 2 0 0118 8.416v7.067a2 2 0 01-1.106 1.789L11.447 20a2 2 0 01-1.894 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Route Intelligence</h3>
                            <div class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter flex items-center gap-3 mt-1">
                                {{ $trip->origin }} <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg> {{ $trip->destination }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-y-8 gap-x-12">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Asset Assigned</p>
                            <p class="text-lg font-black text-gray-900 dark:text-white tracking-tight">{{ $trip->vehicle->vehicle_number }}</p>
                            <p class="text-xs font-bold text-gray-500 uppercase">{{ $trip->vehicle->model }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pilot in Command</p>
                            <p class="text-lg font-black text-gray-900 dark:text-white tracking-tight">{{ $trip->driver->name }}</p>
                            <p class="text-xs font-bold text-gray-500 uppercase">License: {{ $trip->driver->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Departure Schedule</p>
                            <p class="text-lg font-black text-gray-900 dark:text-white tracking-tight">{{ $trip->departure_time->format('M d, Y') }}</p>
                            <p class="text-xs font-bold text-gray-500 uppercase">{{ $trip->departure_time->format('H:i \H\r\s') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Arrival Manifest</p>
                            @if($trip->arrival_time)
                                <p class="text-lg font-black text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $trip->arrival_time->format('M d, Y') }}</p>
                                <p class="text-xs font-bold text-gray-500 uppercase">{{ $trip->arrival_time->format('H:i \H\r\s') }}</p>
                            @else
                                <p class="text-lg font-black text-amber-500 tracking-tight italic">Pending...</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- Data Strip --}}
                <div class="bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-white/5 p-8">
                    <div class="grid grid-cols-3 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Start ODO</p>
                            <p class="text-xl font-black text-gray-900 dark:text-white tracking-tighter">{{ number_format($trip->start_odometer) }} <span class="text-[10px] text-gray-400">KM</span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">End ODO</p>
                            <p class="text-xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $trip->end_odometer ? number_format($trip->end_odometer) : '--' }} <span class="text-[10px] text-gray-400">KM</span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Payload</p>
                            <p class="text-xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $trip->distance ?? '--' }} <span class="text-[10px] text-gray-400">KM</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions Card --}}
        <div class="space-y-6">
            @if($trip->status !== 'completed')
            <div class="bg-white dark:bg-[#111111] rounded-3xl border-2 border-indigo-600/20 p-8 shadow-xl relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-600/5 rounded-full blur-2xl"></div>
                
                <h3 class="text-xs font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-6">Finalize Operation</h3>
                
                <form method="POST" action="{{ route('trips.complete', $trip) }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Current End Odometer</label>
                        <div class="relative">
                            <input type="number" name="end_odometer" required min="{{ $trip->start_odometer + 1 }}" 
                                placeholder="Enter value > {{ $trip->start_odometer }}"
                                class="block w-full bg-gray-50 dark:bg-white/5 border-transparent focus:ring-2 focus:ring-indigo-600 rounded-2xl py-4 px-5 text-lg font-black transition-all">
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-[10px] font-black text-gray-400">KM</div>
                        </div>
                        @error('end_odometer') <p class="text-rose-500 text-[10px] font-bold mt-2 uppercase">{{ $message }}</p> @enderror
                    </div>
                    
                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20 active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                        Complete Trip
                    </button>
                </form>
                
                <p class="text-[10px] text-gray-400 mt-6 text-center font-bold italic leading-relaxed">
                    Completing this trip will release vehicle {{ $trip->vehicle->vehicle_number }} for the next operation.
                </p>
            </div>
            @else
            <div class="bg-emerald-50 dark:bg-emerald-900/10 rounded-3xl border border-emerald-500/20 p-8 text-center">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-800/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Mission Success</h3>
                <p class="text-[10px] font-bold text-emerald-800/60 dark:text-emerald-400/60 uppercase">Operation archived successfully</p>
            </div>
            @endif

            {{-- Support/Info --}}
            <div class="bg-gray-50/50 dark:bg-white/[0.02] rounded-3xl border border-gray-100 dark:border-white/5 p-6">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Compliance Info</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase">Trip ID</span>
                        <span class="text-xs font-black text-gray-900 dark:text-white tracking-tighter">#TRP-{{ str_pad($trip->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase">Logged By</span>
                        <span class="text-xs font-black text-gray-900 dark:text-white tracking-tighter">Automated Dispatch</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection