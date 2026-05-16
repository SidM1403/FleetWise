@extends('layouts.app')
@section('header'){{ __('Fleet Reports') }}@endsection
@section('content')
<div class="py-6 max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Report Generator</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select a report type and date range to analyze your fleet data.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Trip Summary --}}
        <div class="group bg-white dark:bg-[#111111] rounded-3xl border border-gray-100 dark:border-white/5 overflow-hidden transition-all hover:scale-[1.01]">
            <div class="h-2 w-full bg-indigo-600"></div>
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400"><svg class="w-6 h-6" fill="none" stroke="currentColor"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                    <div><h3 class="text-xl font-black text-gray-900 dark:text-white">Trip Summary</h3><p class="text-sm text-gray-500 dark:text-gray-400">Detailed logs of all vehicle movements.</p></div>
                </div>
                <form method="POST" action="{{ route('reports.trip_summary') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5">Start Date</label><input type="date" name="start_date" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-xl px-4 py-3 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white"></div>
                        <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5">End Date</label><input type="date" name="end_date" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-xl px-4 py-3 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white"></div>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-widest py-4 rounded-xl transition-all flex items-center justify-center gap-2 shadow-xl shadow-indigo-200 dark:shadow-none">Generate Report<svg class="w-4 h-4" fill="none" stroke="currentColor"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></button>
                </form>
            </div>
        </div>
        {{-- Vehicle Cost --}}
        <div class="group bg-white dark:bg-[#111111] rounded-3xl border border-gray-100 dark:border-white/5 overflow-hidden transition-all hover:scale-[1.01]">
            <div class="h-2 w-full bg-emerald-500"></div>
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><svg class="w-6 h-6" fill="none" stroke="currentColor"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div><h3 class="text-xl font-black text-gray-900 dark:text-white">Vehicle Cost</h3><p class="text-sm text-gray-500 dark:text-gray-400">Analyze fuel and expense efficiency.</p></div>
                </div>
                <form method="POST" action="{{ route('reports.vehicle_cost') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5">Start Date</label><input type="date" name="start_date" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-xl px-4 py-3 text-sm font-bold focus:ring-0 focus:border-emerald-500 transition-all dark:text-white"></div>
                        <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5">End Date</label><input type="date" name="end_date" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-xl px-4 py-3 text-sm font-bold focus:ring-0 focus:border-emerald-500 transition-all dark:text-white"></div>
                    </div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest py-4 rounded-xl transition-all flex items-center justify-center gap-2 shadow-xl shadow-emerald-200 dark:shadow-none">Generate Report<svg class="w-4 h-4" fill="none" stroke="currentColor"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection