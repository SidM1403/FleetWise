<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); window.dispatchEvent(new CustomEvent('theme-changed', { detail: { isDark: val } })); })" :class="{ 'dark': darkMode }" class="bg-gray-50 dark:bg-[#0A0A0A] transition-colors duration-200">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FleetWise') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Prevent white flash: set dark mode class before paint
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        html { background-color: #f9fafb; }
        html.dark { background-color: #0A0A0A; }
        body { font-family: 'Figtree', system-ui, sans-serif; }
        .nav-link { display: flex; align-items: center; gap: 0.8rem; padding: 0.6rem 1rem; font-size: 0.85rem; font-weight: 500; color: #777; border-left: 3px solid transparent; transition: all 0.2s ease; }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.05); border-left-color: #444; }
        .nav-link.active { color: #fff; font-weight: 700; border-left-color: #F7C948; background: rgba(247, 201, 72, 0.08); }
        .nav-link.active .nav-icon { color: #F7C948; filter: drop-shadow(0 0 8px rgba(247, 201, 72, 0.3)); }
        .nav-icon { width: 1.25rem; height: 1.25rem; flex-shrink: 0; stroke-width: 1.8; }
        .toast-container { position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999; display: flex; flex-direction: column; gap: 0.5rem; }
        .toast { display: flex; align-items: center; gap: 0.75rem; padding: 0.85rem 1.25rem; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 500; min-width: 320px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); animation: toast-in 0.4s ease-out; backdrop-filter: blur(12px); }
        .toast-success { background: linear-gradient(135deg, rgba(16,185,129,0.95), rgba(5,150,105,0.95)); color: white; }
        .toast-error { background: linear-gradient(135deg, rgba(239,68,68,0.95), rgba(220,38,38,0.95)); color: white; }
        .toast-close { margin-left: auto; background: none; border: none; color: rgba(255,255,255,0.7); cursor: pointer; font-size: 1.1rem; }
        .toast-close:hover { color: white; }
        @keyframes toast-in { from { opacity: 0; transform: translateX(100px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toast-out { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100px); } }
        .user-card { display: flex; align-items: center; gap: 0.6rem; padding: 0.6rem 0.75rem; border-top: 1px solid #222; transition: background 0.15s; }
        .user-card:hover { background: rgba(255,255,255,0.03); }
        .user-avatar { width: 28px; height: 28px; background: #F7C948; color: #0A0A0A; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.65rem; flex-shrink: 0; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-[#0A0A0A] antialiased dark:text-gray-100" x-data="{ mobileSidebarOpen: false }">
<div class="toast-container" id="toast-container">
    @if(session('success'))<div class="toast toast-success" id="toast-success"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><span>{{ session('success') }}</span><button class="toast-close" onclick="dismissToast('toast-success')">&times;</button></div>@endif
    @if(session('error'))<div class="toast toast-error" id="toast-error"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg><span>{{ session('error') }}</span><button class="toast-close" onclick="dismissToast('toast-error')">&times;</button></div>@endif
</div>

{{-- Mobile Sidebar --}}
<div x-show="mobileSidebarOpen" x-cloak class="relative z-50 lg:hidden">
    <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/70"></div>
    <div class="fixed inset-0 flex">
        <div x-show="mobileSidebarOpen" x-transition:enter="transition ease-in-out duration-200 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1 bg-ink flex-col">
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5"><button type="button" @click="mobileSidebarOpen = false"><svg class="h-6 w-6 text-white" fill="none" stroke-width="1.5" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"/></svg></button></div>
            <div class="flex h-14 shrink-0 items-center border-b border-[#222] px-4">@include('layouts.partials.logo')</div>
            <nav class="flex-1 overflow-y-auto px-4 py-2"><ul class="flex flex-col gap-y-0.5">@include('layouts.sidebar-links')</ul></nav>
        </div>
    </div>
</div>

{{-- Desktop Sidebar --}}
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
    <div class="bg-ink flex grow flex-col overflow-y-auto px-4 border-r border-[#222]">
        <div class="flex h-20 shrink-0 items-center border-b border-[#222]">@include('layouts.partials.logo')</div>
        <nav class="flex flex-1 flex-col mt-4">
            <ul class="flex flex-1 flex-col gap-y-0.5">
                @include('layouts.sidebar-links')
                <li class="mt-auto pb-4"><a href="{{ route('profile.edit') }}" class="user-card"><div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div><div class="overflow-hidden"><div class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</div><div class="text-[9px] font-bold uppercase tracking-wider text-[#555]">{{ Auth::user()->is_admin ? 'Admin' : 'Staff' }}</div></div></a></li>
            </ul>
        </nav>
    </div>
</div>

{{-- Main --}}
<div class="lg:pl-64 flex flex-col min-h-screen">
    <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 bg-white/80 dark:bg-[#0A0A0A]/80 backdrop-blur-xl border-b border-gray-200 dark:border-white/5 px-4 sm:px-6 lg:px-8">
        <button type="button" class="text-gray-700 dark:text-gray-300 lg:hidden" @click="mobileSidebarOpen = true"><svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor"><path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg></button>
        <div class="h-6 w-px bg-gray-200 dark:bg-gray-100/10 lg:hidden"></div>
        <div class="flex flex-1 justify-between items-center h-full">
            <div class="text-lg font-semibold text-gray-900 dark:text-white truncate">@yield('header')</div>
            <div class="flex items-center gap-x-4">
                <button type="button" @click="darkMode = !darkMode" class="p-2 text-gray-400 hover:text-yellow-400 transition-colors">
                    <svg x-show="darkMode" x-cloak class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4.22 1.22a1 1 0 011.415 0l.828.828a1 1 0 01-1.414 1.414l-.828-.828a1 1 0 010-1.414zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zm-1.22 4.22a1 1 0 010 1.414l-.828.828a1 1 0 01-1.414-1.414l.828-.828a1 1 0 011.414 0zM10 16a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-4.22-1.22a1 1 0 010-1.414l-.828-.828a1 1 0 01-1.414 1.414l.828.828a1 1 0 011.414 0zM4 10a1 1 0 01-1 1H2a1 1 0 110-2h1a1 1 0 011 1zm1.22-4.22a1 1 0 011.414 0l.828-.828a1 1 0 01-1.414-1.414l-.828.828a1 1 0 010 1.414zM10 5a5 5 0 100 10 5 5 0 000-10z" clip-rule="evenodd"></path></svg>
                    <svg x-show="!darkMode" x-cloak class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
                <span class="hidden sm:inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ Auth::user()->is_admin ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/20 dark:bg-indigo-900/30 dark:text-indigo-300 dark:ring-indigo-800' : 'bg-gray-50 text-gray-600 ring-1 ring-gray-500/10 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700' }}">{{ Auth::user()->is_admin ? 'Admin' : 'Staff' }}</span>
                <div class="h-6 w-px bg-gray-200 dark:bg-gray-700 mx-1"></div>
                <form method="POST" action="{{ route('logout') }}"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button type="submit" class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-indigo-600 transition-colors"><svg class="h-4 w-4" fill="none" stroke-width="1.5" stroke="currentColor"><path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg><span class="hidden sm:inline">Log out</span></button></form>
            </div>
        </div>
    </header>
    <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">@yield('content')</main>
</div>

<script>
    function dismissToast(id) { const el = document.getElementById(id); if (el) { el.style.animation = 'toast-out 0.3s ease-in forwards'; setTimeout(() => el.remove(), 300); } }
    document.querySelectorAll('.toast').forEach(t => { setTimeout(() => { t.style.animation = 'toast-out 0.3s ease-in forwards'; setTimeout(() => t.remove(), 300); }, 5000); });
</script>
</body>
</html>