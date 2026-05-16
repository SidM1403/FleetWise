<x-guest-layout>
<div class="mb-8">
    <h2 class="text-3xl font-black text-ink uppercase tracking-tighter">Sign In</h2>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 font-medium">Access your fleet command center</p>
</div>

<x-auth-session-status class="mb-6" :status="session('status')" />

<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf
    <div>
        <x-input-label for="email" :value="__('Email Address')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5" />
        <x-text-input id="email" class="block w-full border-2 border-gray-200 dark:border-gray-700 focus:border-ink focus:ring-0 px-4 py-3 text-sm font-bold" type="email" name="email" :value="old('email')" required autofocus placeholder="your@email.com" />
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold" />
    </div>
    <div>
        <x-input-label for="password" :value="__('Password')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1.5" />
        <x-text-input id="password" class="block w-full border-2 border-gray-200 dark:border-gray-700 focus:border-ink focus:ring-0 px-4 py-3 text-sm font-bold" type="password" name="password" required placeholder="••••••••" />
        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold" />
    </div>
    <div class="flex items-center justify-between">
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-ink shadow-sm focus:ring-ink" name="remember">
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ __('Remember me') }}</span>
        </label>
        @if (Route::has('password.request'))<a class="text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 underline decoration-2 underline-offset-4" href="{{ route('password.request') }}">Forgot?</a>@endif
    </div>
    <div class="pt-2"><x-primary-button class="w-full justify-center py-4 bg-ink hover:bg-gray-800 text-white font-black uppercase tracking-[0.2em] text-xs">{{ __('Sign In') }}</x-primary-button></div>
    <div class="text-center">
        <span class="text-sm text-gray-500 dark:text-gray-400">Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 underline decoration-2 underline-offset-4 ml-1">Register</a>
    </div>
</form>
</x-guest-layout>