<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-black text-ink uppercase tracking-tighter">Confirm Password</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 font-medium">Secure area — please confirm your password</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-1.5" />
            <x-text-input id="password" class="block w-full border-2 border-gray-200 dark:border-gray-700 focus:border-ink focus:ring-0 px-4 py-3 text-sm font-bold" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold" />
        </div>
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 bg-ink hover:bg-gray-800 text-white font-black uppercase tracking-[0.2em] text-xs">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>