@extends('layouts.app')

@section('header')
    {{ __('Fleet Management') }}
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Vehicle Roster</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage and monitor your entire fleet assets in one place.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('vehicles.export', request()->all()) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Export CSV</a>
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M12 4.5v15m7.5-7.5h-15"/></svg>Add Vehicle</a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-[#111111] rounded-3xl border border-gray-100 dark:border-white/5 p-4 mb-8">
        <form method="GET" action="{{ route('vehicles.index') }}" class="flex flex-col lg:flex-row gap-4">
            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by number, type, or model..." class="block w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-white/5 border-transparent focus:ring-2 focus:ring-indigo-500 rounded-2xl text-sm font-bold transition-all">
            </div>
            <div class="flex flex-wrap gap-4">
                <select name="status" onchange="this.form.submit()" class="py-3 bg-gray-50 dark:bg-white/5 border-transparent focus:ring-2 focus:ring-indigo-500 rounded-2xl text-sm font-bold cursor-pointer w-48">
                    <option value="">All Statuses</option>
                    @foreach(['active', 'maintenance', 'inactive'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <select name="per_page" onchange="this.form.submit()" class="py-3 bg-gray-50 dark:bg-white/5 border-transparent focus:ring-2 focus:ring-indigo-500 rounded-2xl text-sm font-bold cursor-pointer w-36">
                    @foreach([10, 25, 50] as $p)
                    <option value="{{ $p }}" {{ request('per_page') == $p ? 'selected' : '' }}>{{ $p }} Per Page</option>
                    @endforeach
                </select>
                @if(request('search') || request('status'))
                <a href="{{ route('vehicles.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-400 font-bold text-sm rounded-2xl hover:bg-gray-200 transition-all flex items-center">Clear</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                        @foreach([['key'=>'vehicle_number', 'label'=>'Identification'], ['key'=>'vehicle_type', 'label'=>'Class & Specs'], ['key'=>'status', 'label'=>'Current Status']] as $col)
                        <th class="px-8 py-5 text-left">
                            <a href="{{ route('vehicles.index', array_merge(request()->query(), ['sort' => $col['key'], 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">
                                {{ $col['label'] }}
                                <svg class="w-3 h-3 transition-transform {{ request('sort') === $col['key'] && request('direction') === 'asc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </th>
                        @endforeach
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Control</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @forelse ($vehicles as $v)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-white/10 flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg></div>
                                <div><div class="text-sm font-black text-gray-900 dark:text-white tracking-tight">{{ $v->vehicle_number }}</div><div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Asset ID: #{{ str_pad($v->id, 5, '0', STR_PAD_LEFT) }}</div></div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-tighter">{{ $v->vehicle_type }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 font-medium">{{ $v->model }} ({{ $v->year }})</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if($v->status == 'active') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20
                                @elseif($v->status == 'maintenance') bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 ring-1 ring-amber-500/20
                                @else bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-400 ring-1 ring-gray-400/20 @endif">
                                <span class="w-1.5 h-1.5 rounded-full @if($v->status == 'active') bg-emerald-600 @elseif($v->status == 'maintenance') bg-amber-600 @else bg-gray-400 @endif"></span>{{ $v->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-3">
                                <a href="{{ route('vehicles.show', $v) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                @if(auth()->user()->is_admin)
                                <a href="{{ route('vehicles.edit', $v) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                <form action="{{ route('vehicles.destroy', $v) }}" method="POST" onsubmit="return confirm('Archive vehicle?');" class="inline">@csrf @method('DELETE')<button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div><h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No Vehicles Found</h3><p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-tighter">Adjust filters or add a new vehicle.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($vehicles->hasPages())<div class="px-8 py-6 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">{{ $vehicles->links() }}</div>@endif
    </div>
</div>
@endsection