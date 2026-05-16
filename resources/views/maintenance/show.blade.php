@extends('layouts.app')

@section('header')
    Service Report: {{ $maintenance->service_type }}
@endsection

@section('content')
<div class="py-6 max-w-5xl mx-auto">
    {{-- Top Navigation --}}
    <div class="flex justify-between items-center mb-8">
        <a href="{{ route('maintenance.index') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-all">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Service Logs
        </a>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                @if(($maintenance->status ?? 'completed') == 'completed') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20
                @else bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-500/20 @endif">
                {{ $maintenance->status ?? 'completed' }}
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
                            <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Service Classification</h3>
                            <div class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter mt-1">
                                {{ $maintenance->service_type }}
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-y-8 gap-x-12">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Asset Identity</p>
                            <p class="text-lg font-black text-gray-900 dark:text-white tracking-tight">{{ $maintenance->vehicle->vehicle_number }}</p>
                            <p class="text-xs font-bold text-gray-500 uppercase">{{ $maintenance->vehicle->model }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Service Timeline</p>
                            <p class="text-lg font-black text-gray-900 dark:text-white tracking-tight">{{ $maintenance->service_date->format('M d, Y') }}</p>
                            <p class="text-xs font-bold text-gray-500 uppercase">Logged at: {{ $maintenance->created_at->format('H:i') }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Technician Notes</p>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 leading-relaxed">{{ $maintenance->description ?? 'No additional notes provided for this service event.' }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Data Strip --}}
                <div class="bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-white/5 p-8">
                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Fiscal Impact</p>
                            <p class="text-xl font-black text-rose-600 dark:text-rose-400 tracking-tighter">₹{{ number_format($maintenance->cost, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Next Recurrence</p>
                            @if($maintenance->next_service_date)
                                <p class="text-xl font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">{{ $maintenance->next_service_date->format('M d, Y') }}</p>
                            @else
                                <p class="text-xl font-black text-gray-300 dark:text-gray-700 tracking-tighter italic">Not Scheduled</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions Card --}}
        <div class="space-y-6">
            @if(($maintenance->status ?? 'completed') !== 'completed')
            <div class="bg-white dark:bg-[#111111] rounded-3xl border-2 border-indigo-600/20 p-8 shadow-xl relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-600/5 rounded-full blur-2xl"></div>
                
                <h3 class="text-xs font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-6">Finalize Service</h3>
                
                <form method="POST" action="{{ route('maintenance.complete', $maintenance) }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Final Service Cost (INR)</label>
                        <div class="relative">
                            <input type="number" name="cost" step="0.01" required min="0" 
                                value="{{ $maintenance->cost }}"
                                placeholder="0.00"
                                class="block w-full bg-gray-50 dark:bg-white/5 border-transparent focus:ring-2 focus:ring-indigo-600 rounded-2xl py-4 px-5 text-lg font-black transition-all">
                            <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-lg font-black text-gray-400">₹</div>
                        </div>
                        @error('cost') <p class="text-rose-500 text-[10px] font-bold mt-2 uppercase">{{ $message }}</p> @enderror
                    </div>
                    
                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20 active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                        Complete Service
                    </button>
                </form>
                
                <p class="text-[10px] text-gray-400 mt-6 text-center font-bold italic leading-relaxed">
                    Finalizing will mark vehicle {{ $maintenance->vehicle->vehicle_number }} as Active and available for dispatch.
                </p>
            </div>
            @else
            <div class="bg-emerald-50 dark:bg-emerald-900/10 rounded-3xl border border-emerald-500/20 p-8 text-center shadow-sm">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-800/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">Service Restored</h3>
                <p class="text-[10px] font-bold text-emerald-800/60 dark:text-emerald-400/60 uppercase">Unit {{ $maintenance->vehicle->vehicle_number }} is Operational</p>
            </div>
            @endif

            {{-- Support/Info --}}
            <div class="bg-gray-50/50 dark:bg-white/[0.02] rounded-3xl border border-gray-100 dark:border-white/5 p-6">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Compliance Info</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase">Service ID</span>
                        <span class="text-xs font-black text-gray-900 dark:text-white tracking-tighter">#SRV-{{ str_pad($maintenance->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase">Assigned Unit</span>
                        <span class="text-xs font-black text-indigo-600 tracking-tighter">{{ $maintenance->vehicle->vehicle_number }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
