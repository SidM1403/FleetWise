@extends('layouts.app')

@section('header')
    {{ __('Energy Resources') }}
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Fuel Monitoring</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track energy consumption, costs, and efficiency across your entire fleet.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('fuel.export', request()->all()) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Export CSV</a>
            <a href="{{ route('fuel.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"/></svg>Record Refuel</a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                        @foreach([['key'=>'date', 'label'=>'Date'], ['key'=>'vehicle_id', 'label'=>'Vehicle'], ['key'=>'quantity', 'label'=>'Volume (L)'], ['key'=>'cost', 'label'=>'Expenditure']] as $col)
                        <th class="px-8 py-5 @if(in_array($col['key'], ['quantity', 'cost'])) text-right @else text-left @endif">
                            <a href="{{ route('fuel.index', array_merge(request()->query(), ['sort' => $col['key'], 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">
                                {{ $col['label'] }}
                                <svg class="w-3 h-3 transition-transform {{ request('sort') === $col['key'] && request('direction') === 'asc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @forelse ($fuelRecords as $r)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-black text-gray-900 dark:text-white tracking-tight">{{ $r->date->format('M d, Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Ref: #FUEL-{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>{{ $r->vehicle->vehicle_number }}</span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tighter">{{ number_format($r->quantity, 2) }} L</div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold mt-0.5">Refuel Volume</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right"><div class="text-base font-black text-emerald-600 dark:text-emerald-400 tracking-tighter">${{ number_format($r->cost, 2) }}</div></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.628.282a2 2 0 01-1.808 0l-.628-.282a6 6 0 00-3.86-.517l-2.387.477a2 2 0 00-1.022.547V19a2 2 0 002 2h11a2 2 0 002-2v-3.572zM15 11l-3 3m0 0l-3-3m3 3V4"/></svg></div><h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No Fuel Records</h3><p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-tighter">Energy data will appear here.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fuelRecords->hasPages())<div class="px-8 py-6 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">{{ $fuelRecords->links() }}</div>@endif
    </div>
</div>
@endsection