@extends('layouts.app')
@section('header'){{ __('Security & Profile') }}@endsection
@section('content')
<div class="py-6 max-w-7xl mx-auto">
    <div class="mb-10">
        <h2 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Account Control</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your identity, security protocols, and system access.</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Profile Sidebar --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6"><svg class="w-8 h-8" fill="none" stroke="currentColor"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                <h3 class="text-2xl font-black uppercase tracking-tight">{{ Auth::user()->name }}</h3>
                <p class="text-indigo-100 text-sm font-bold opacity-80 mt-1 uppercase tracking-widest">{{ Auth::user()->is_admin ? 'System Administrator' : 'Staff Member' }}</p>
                <div class="mt-8 pt-8 border-t border-white/10 space-y-4">
                    <div class="flex items-center gap-3"><div class="w-2 h-2 rounded-full bg-emerald-400"></div><span class="text-xs font-black uppercase tracking-widest">Account Active</span></div>
                    <div class="flex items-center gap-3"><div class="w-2 h-2 rounded-full bg-indigo-300"></div><span class="text-xs font-black uppercase tracking-widest">Member since {{ Auth::user()->created_at->format('M Y') }}</span></div>
                </div>
            </div>
            <div class="bg-white dark:bg-[#111111] rounded-3xl p-8 border border-gray-100 dark:border-white/5 shadow-sm">
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4">Security Notice</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 font-bold leading-relaxed">Ensure your credentials are kept secure. We recommend updating your access token periodically to maintain fleet integrity.</p>
            </div>
        </div>
        {{-- Identity Forms --}}
        <div class="lg:col-span-8 space-y-8">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection