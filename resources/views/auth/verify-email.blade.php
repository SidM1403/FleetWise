<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-ink uppercase tracking-tighter">Verify Email</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 font-medium">Check your inbox for a verification link</p>
    </div>

    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-emerald-50 border-2 border-emerald-500 text-emerald-700 font-bold text-sm">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="py-3 bg-ink hover:bg-gray-800 text-white font-black uppercase tracking-[0.2em] text-xs">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-black uppercase tracking-widest text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300 underline">{{ __('Log Out') }}</button>
        </form>
    </div>
</x-guest-layout>