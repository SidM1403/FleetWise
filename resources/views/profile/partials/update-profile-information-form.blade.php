<section class="bg-white dark:bg-[#111111] rounded-[2rem] border border-gray-100 dark:border-white/5 overflow-hidden">
    <div class="px-8 py-6 border-b border-gray-50 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]"><h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Profile Information</h3></div>
    <div class="p-8">
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf @method('patch')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Full Legal Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                    @error('name') <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="block w-full border-2 border-gray-100 dark:border-white/5 dark:bg-white/5 rounded-2xl px-5 py-3.5 text-sm font-bold focus:ring-0 focus:border-indigo-500 transition-all dark:text-white">
                    @error('email') <p class="mt-2 text-[10px] font-bold text-rose-600 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center gap-6 pt-4">
                <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all shadow-lg active:scale-95">{{ __('Update Protocol') }}</button>
                @if (session('status') === 'profile-updated') <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600 flex items-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor"><path stroke-width="3" d="M5 13l4 4L19 7"/></svg>{{ __('Synchronized') }}</p> @endif
            </div>
        </form>
    </div>
</section>