@extends('layouts.app')
@section('header'){{ __('Administration') }}@endsection
@section('content')
<div class="py-6 max-w-7xl mx-auto">
    <div class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Identity Control</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage system access, roles, and security permissions for all personnel.</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-10">
        @foreach($systemOverview as $item)
        <div class="bg-white dark:bg-[#111111] rounded-2xl border border-gray-100 dark:border-white/5 p-5 transition-all">
            <div class="text-2xl font-black text-gray-900 dark:text-white">{{ $item['count'] }}</div>
            <div class="text-[10px] font-black uppercase tracking-widest text-gray-400 mt-1">{{ $item['label'] }}</div>
        </div>
        @endforeach
    </div>
    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02] flex justify-between items-center"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Authorized Personnel</h3></div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                        @foreach([['key'=>'name', 'label'=>'User Profile'], ['key'=>'is_admin', 'label'=>'Access Role'], ['key'=>'is_active', 'label'=>'Status']] as $col)
                        <th class="px-8 py-5 text-left">
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => $col['key'], 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="group inline-flex items-center gap-1 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-indigo-600 transition-colors">
                                {{ $col['label'] }}
                                <svg class="w-3 h-3 transition-transform {{ request('sort') === $col['key'] && request('direction') === 'asc' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </th>
                        @endforeach
                        <th class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Security Control</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @foreach($users as $user)
                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-white/10 flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 dark:text-white tracking-tight flex items-center gap-2">{{ $user->name }} @if($user->id == auth()->id()) <span class="text-[8px] px-1.5 py-0.5 bg-indigo-600 text-white rounded-md uppercase tracking-widest">Self</span> @endif</div>
                                    <div class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap"><span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $user->is_admin ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400 ring-1 ring-indigo-500/20' : 'bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-400 ring-1 ring-gray-400/20' }}">{{ $user->is_admin ? 'Admin' : 'Staff' }}</span></td>
                        <td class="px-8 py-6 whitespace-nowrap"><span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $user->is_active ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 ring-1 ring-rose-500/20' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="px-8 py-6 whitespace-nowrap text-right">
                            @if($user->id !== auth()->id())
                            <div class="flex justify-end items-center gap-2">
                                <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-xl transition-all">{{ $user->is_admin ? 'Demote' : 'Promote' }}</button></form>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">@csrf @method('PATCH')<button type="submit" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-xl transition-all">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button></form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Purge account?');" class="inline">@csrf @method('DELETE')<button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                            </div>
                            @else <span class="text-[10px] font-black text-gray-300 dark:text-gray-700 uppercase tracking-widest italic">Protected</span> @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection