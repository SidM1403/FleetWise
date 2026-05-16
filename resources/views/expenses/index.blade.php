@extends('layouts.app')

@section('header')
    {{ __('Financial Oversight') }}
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Expense Ledger</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Audit and approve operational expenditures and miscellaneous fleet costs.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('expenses.export', request()->all()) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Export CSV</a>
            <a href="{{ route('expenses.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"/></svg>Add Expense</a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                        @foreach([['key'=>'category', 'label'=>'Classification'], ['key'=>'date', 'label'=>'Date'], ['key'=>'vehicle_id', 'label'=>'Asset Ref.'], ['key'=>'status', 'label'=>'Status'], ['key'=>'amount', 'label'=>'Amount']] as $col)
                        <th class="px-8 py-5 @if(in_array($col['key'], ['status', 'amount'])) text-right @else text-left @endif">
                            <a href="{{ route('expenses.index', array_merge(request()->query(), ['sort' => $col['key'], 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">
                                {{ $col['label'] }}
                                <svg class="w-3 h-3 transition-transform {{ request('sort') === $col['key'] && request('direction') === 'asc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @forelse ($expenses as $e)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $e->category }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">Ref: #EXP-{{ str_pad($e->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap"><div class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $e->date->format('M d, Y') }}</div></td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($e->vehicle)<span class="text-xs font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">{{ $e->vehicle->vehicle_number }}</span>
                            @else <span class="text-[10px] font-bold text-gray-300 dark:text-gray-700 uppercase tracking-widest italic">Non-Vehicle</span> @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex flex-col items-end gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                    @if($e->status == 'approved') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20
                                    @elseif($e->status == 'rejected') bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-500/20
                                    @else bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-500/20 @endif">
                                    {{ $e->status ?? 'pending' }}
                                </span>
                                @if(auth()->user()->is_admin && ($e->status == 'pending' || !$e->status))
                                <div class="flex items-center gap-1">
                                    <form action="{{ route('expenses.approve', $e) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="p-1.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg></button></form>
                                    <form action="{{ route('expenses.reject', $e) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="p-1.5 bg-rose-50 dark:bg-rose-900/20 text-rose-600 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg></button></form>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right text-base font-black text-gray-900 dark:text-white tracking-tighter">${{ number_format($e->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-8 py-20 text-center"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No Expenditures</h3><p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-tighter">Financial logs will appear here.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($expenses->hasPages())<div class="px-8 py-6 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">{{ $expenses->links() }}</div>@endif
    </div>
</div>
@endsection