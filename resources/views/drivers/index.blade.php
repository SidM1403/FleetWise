@extends('layouts.app')

@section('header')
    {{ __('Human Resources') }}
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Driver Directory</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage personnel, licenses, and vehicle assignments.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('drivers.export', request()->all()) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-[#111111] border-2 border-gray-100 dark:border-white/5 rounded-xl font-black text-[10px] uppercase tracking-widest text-gray-600 dark:text-gray-400 hover:bg-gray-50 transition-all shadow-sm"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Export CSV</a>
            <a href="{{ route('drivers.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg active:scale-95"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>Register Driver</a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-[#111111] rounded-3xl border border-gray-100 dark:border-white/5 p-4 mb-8">
        <form method="GET" action="{{ route('drivers.index') }}" class="flex flex-col sm:flex-row gap-4">
            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, license number, or phone..." class="block w-full pl-11 pr-4 py-3 bg-gray-50 dark:bg-white/5 border-transparent focus:ring-2 focus:ring-indigo-500 rounded-2xl text-sm font-bold transition-all">
            </div>
            <div class="flex gap-4">
                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl transition-all active:scale-95">Search</button>
                @if(request('search'))
                <a href="{{ route('drivers.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-400 font-bold text-sm rounded-2xl hover:bg-gray-200 transition-all flex items-center">Clear</a>
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
                        @foreach([['key'=>'name', 'label'=>'Personnel Info'], ['key'=>'license_number', 'label'=>'License Details']] as $col)
                        <th class="px-8 py-5 text-left">
                            <a href="{{ route('drivers.index', array_merge(request()->query(), ['sort' => $col['key'], 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">
                                {{ $col['label'] }}
                                <svg class="w-3 h-3 transition-transform {{ request('sort') === $col['key'] && request('direction') === 'asc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </th>
                        @endforeach
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Vehicle Assignment</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @forelse ($drivers as $d)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-white/10 flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                                <div><div class="text-sm font-black text-gray-900 dark:text-white tracking-tight">{{ $d->name }}</div><div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $d->phone ?? 'No Phone' }}</div></div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900 dark:text-white tracking-tighter uppercase">{{ $d->license_number }}</div>
                            @if($d->license_expiry)
                            <div class="text-[10px] font-bold mt-0.5 {{ \Carbon\Carbon::parse($d->license_expiry)->isPast() ? 'text-rose-500' : 'text-gray-400' }} uppercase tracking-widest">Exp: {{ \Carbon\Carbon::parse($d->license_expiry)->format('M d, Y') }}</div>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            @if($d->vehicle)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400 ring-1 ring-indigo-500/20"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>{{ $d->vehicle->vehicle_number }}</span>
                            @else <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 dark:bg-white/5 dark:text-gray-500">Unassigned</span> @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            <div class="flex justify-end items-center gap-3">
                                <a href="{{ route('drivers.show', $d) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg></a>
                                @if(auth()->user()->is_admin)
                                <a href="{{ route('drivers.edit', $d) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                <form action="{{ route('drivers.destroy', $d) }}" method="POST" onsubmit="return confirm('Remove driver?');" class="inline">@csrf @method('DELETE')<button type="submit" class="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center"><div class="flex flex-col items-center justify-center"><div class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div><h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No Drivers Found</h3><p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-tighter">Adjust filters or register a new driver.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($drivers->hasPages())<div class="px-8 py-6 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">{{ $drivers->links() }}</div>@endif
    </div>
</div>
@endsection