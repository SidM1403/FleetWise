<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FleetWise') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased h-screen overflow-hidden">
<div class="flex h-full w-full">
    {{-- Visuals --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-ink items-center justify-center overflow-hidden">
        <img src="{{ asset('auth_bg.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-60 scale-110" alt="FleetWise Systems">
        <div class="absolute inset-0 bg-gradient-to-tr from-ink via-ink/80 to-transparent"></div>
        <div class="relative z-10 p-16 max-w-xl">
            <div class="mb-10">@include('layouts.partials.logo')</div>
            <h1 class="text-5xl font-black text-white mb-6 leading-[1.1] tracking-tight">The Future of <span class="text-accent underline decoration-4 underline-offset-8">Fleet Logistics</span> is Here.</h1>
            <p class="text-gray-300 text-xl font-medium leading-relaxed">Join the platform that powers the most efficient fleets in the industry with real-time data and S-Tier intelligence.</p>
            <div class="mt-16 grid grid-cols-2 gap-12 border-t border-white/20 pt-10">
                <div><p class="text-3xl font-black text-white">2.4M+</p><p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] font-black mt-2">Kms Tracked Yearly</p></div>
                <div><p class="text-3xl font-black text-white">100%</p><p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] font-black mt-2">Digital Compliance</p></div>
            </div>
        </div>
    </div>

    {{-- Forms --}}
    <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-16 lg:px-24 bg-white overflow-y-auto">
        <div class="lg:hidden mb-12 flex justify-center"><a href="/">@include('layouts.partials.logo')</a></div>
        <div class="mx-auto w-full max-w-md">{{ $slot }}</div>
        <div class="mt-16 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">&copy; {{ date('Y') }} FleetWise Logistics Systems &bull; v2.0</div>
    </div>
</div>
</body>
</html>