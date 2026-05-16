<section class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Security Protocol</h3></div>
    <div class="p-8">
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf @method('put')
            <div class="space-y-6">
                <div>
                    <label for="current_password" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Current Token</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                    @error('current_password', 'updatePassword') <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">New Credential</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('password', 'updatePassword') <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Verify Credential</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                        @error('password_confirmation', 'updatePassword') <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-6 pt-4">
                <button type="submit" class="px-8 py-4 bg-gray-900 dark:bg-white dark:text-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg active:scale-95">{{ __('Rotate Password') }}</button>
                @if (session('status') === 'password-updated') <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600 flex items-center gap-2"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>{{ __('Security Updated') }}</p> @endif
            </div>
        </form>
    </div>
</section>