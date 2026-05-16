<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-ink uppercase tracking-tighter">Recover</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 font-medium">Reset your secure access</p>
    </div>

    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5" />
            <x-text-input id="email" class="block w-full border-2 border-gray-200 dark:border-gray-700 focus:border-ink focus:ring-0 px-4 py-3 text-sm font-bold" type="email" name="email" :value="old('email')" required autofocus placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold" />
        </div>
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 bg-ink hover:bg-gray-800 text-white font-black uppercase tracking-[0.2em] text-xs">
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 underline decoration-2 underline-offset-4">Back to Sign In</a>
        </div>
    </form>
</x-guest-layout>