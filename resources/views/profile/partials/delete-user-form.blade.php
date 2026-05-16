<section class="bg-white dark:bg-[#111111] rounded-[2rem] border border-rose-100 dark:border-rose-900/20 overflow-hidden">
    <div class="px-8 py-6 border-b border-rose-50 dark:border-rose-900/10 bg-rose-50/30 dark:bg-rose-900/5"><h3 class="text-xs font-black text-rose-600 uppercase tracking-[0.2em]">Danger Zone</h3></div>
    <div class="p-8">
        <div class="mb-6">
            <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ __('Terminate Identity') }}</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold mt-1 leading-relaxed">{{ __('Once deleted, all data will be permanently purged.') }}</p>
        </div>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Final confirmation: Purge account identity?');">
            @csrf @method('delete')
            <div class="max-w-md">
                <label for="delete_password" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Confirm with Password</label>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input id="delete_password" name="password" type="password" placeholder="{{ __('Verify credentials...') }}" class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-0 focus:border-rose-500 transition-all dark:text-white">
                        @error('password', 'userDeletion') <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="px-8 py-4 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg active:scale-95 whitespace-nowrap">{{ __('Purge Account') }}</button>
                </div>
            </div>
        </form>
    </div>
</section>