@extends('layouts.app')

@section('header')
    {{ __('Service Infrastructure') }}
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Maintenance Logs</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track vehicle health, service history, and upcoming maintenance schedules.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('maintenance.export', request()->all()) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Export CSV</a>
            <a href="{{ route('maintenance.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>Log Service</a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                        @foreach([['key'=>'service_date', 'label'=>'Service Date'], ['key'=>'vehicle_id', 'label'=>'Vehicle'], ['key'=>'service_type', 'label'=>'Category'], ['key'=>'cost', 'label'=>'Cost']] as $col)
                        <th class="px-8 py-5 @if($col['key'] == 'cost') text-right @else text-left @endif">
                            <a href="{{ route('maintenance.index', array_merge(request()->query(), ['sort' => $col['key'], 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">
                                {{ $col['label'] }}
                                <svg class="w-3 h-3 transition-transform {{ request('sort') === $col['key'] && request('direction') === 'asc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </th>
                        @endforeach
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Next Scheduled</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @forelse ($maintenances as $m)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-black text-gray-900 dark:text-white tracking-tight">{{ $m->service_date->format('M d, Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Ref: #SRV-{{ str_pad($m->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <a href="{{ route('vehicles.show', $m->vehicle) }}" class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400 ring-1 ring-indigo-500/20 hover:bg-indigo-100 transition-all"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>{{ $m->vehicle->vehicle_number }}</a>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tighter">{{ $m->service_type }}</div>
                            <div class="text-[10px] text-gray-400 uppercase font-bold mt-0.5">Asset Maintenance</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right"><div class="text-sm font-black text-rose-600 dark:text-rose-400 tracking-tight">₹{{ number_format($m->cost, 2) }}</div></td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if(($m->status ?? 'completed') == 'completed') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20
                                @else bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-500/20 @endif">
                                <span class="w-1.5 h-1.5 rounded-full @if(($m->status ?? 'completed') == 'completed') bg-emerald-600 @else bg-amber-600 @endif"></span>{{ $m->status ?? 'completed' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-3">
                                <a href="{{ route('maintenance.show', $m) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl transition-all" title="View Details & Manage"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                
                                @if(auth()->user()->is_admin)
                                <form action="{{ route('maintenance.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete record?');" class="inline">@csrf @method('DELETE')<button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-8 py-20 text-center"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div><h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No Service History</h3><p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-tighter">Fleet maintenance records will appear here.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($maintenances->hasPages())<div class="px-8 py-6 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">{{ $maintenances->links() }}</div>@endif
    </div>
</div>
@endsection