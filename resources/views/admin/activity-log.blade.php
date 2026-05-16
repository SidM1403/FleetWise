@extends('layouts.app')

@section('header')
    {{ __('Activity Log') }}
@endsection

@section('content')
<div class="py-6 max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">System Audit Log</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Detailed history of all actions performed in the system.</p>
    </div>

    <div class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-white/5 border-b border-gray-100 dark:border-white/5">
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Time</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">User</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Action</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">Description</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-white/5">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-6 whitespace-nowrap text-xs font-bold text-gray-500 dark:text-gray-400">
                            {{ $log->created_at->format('M d, Y H:i:s') }}
                            <div class="text-[9px] uppercase tracking-tighter opacity-50">{{ $log->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-black text-gray-900 dark:text-white tracking-tight">{{ $log->user->name ?? 'System' }}</div>
                            <div class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">{{ $log->user ? ($log->user->is_admin ? 'Admin' : 'Staff') : 'Automated' }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if($log->action == 'created') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400
                                @elseif($log->action == 'updated') bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400
                                @elseif($log->action == 'deleted') bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400
                                @else bg-gray-100 text-gray-600 dark:bg-white/10 dark:text-gray-400 @endif">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-sm font-medium text-gray-600 dark:text-gray-300">
                            {{ $log->description }}
                            <div class="text-[10px] font-mono text-gray-400 mt-1">#{{ $log->model_type }} ID: {{ $log->model_id }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 dark:bg-white/5 rounded-2xl flex items-center justify-center text-gray-300 dark:text-gray-600 mb-4">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">No Activity Recorded</h3>
                                <p class="text-xs text-gray-500 mt-1 uppercase font-bold tracking-tighter">System actions will appear here as they happen.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-8 py-6 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
