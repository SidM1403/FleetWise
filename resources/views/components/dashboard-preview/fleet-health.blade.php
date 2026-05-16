<div
    class="rounded-2xl border-4 border-ink bg-white p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] dark:bg-[#111111] dark:border-white transition-all hover:translate-x-1 hover:translate-y-1 hover:shadow-none duration-300">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h3 class="text-[10px] font-black text-ink uppercase tracking-[0.2em] dark:text-white">Operational Score
            </h3>
            <p class="text-4xl font-black text-ink dark:text-white mt-2 leading-none">98.2%</p>
        </div>
        <div class="w-14 h-14 rounded-full border-8 border-[#F7C948] border-t-ink animate-spin-slow"></div>
    </div>

    <div class="space-y-6">
        <div>
            <div class="flex justify-between text-[10px] font-black uppercase text-ink mb-2 dark:text-white">
                <span>Fleet Availability</span>
                <span class="text-[#F7C948] bg-ink px-2 text-white">42 / 45</span>
            </div>
            <div class="w-full bg-gray-100 h-4 border-2 border-ink dark:bg-white/5">
                <div class="bg-[#F7C948] h-full" style="width: 92%"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 border-2 border-ink dark:bg-white/5">
                <p class="text-[9px] font-black text-ink uppercase opacity-50 dark:text-white">Operational</p>
                <p class="text-2xl font-black text-ink dark:text-white">38</p>
            </div>
            <div class="p-4 bg-[#F7C948] border-2 border-ink">
                <p class="text-[9px] font-black text-ink uppercase">In Service</p>
                <p class="text-2xl font-black text-ink">04</p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
</style>