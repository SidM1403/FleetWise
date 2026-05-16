@php
    $activities = [
        ['type' => 'Trip', 'title' => 'TRP-1004 COMPLETED', 'desc' => 'Mumbai to Pune route', 'time' => '2m', 'badge' => '#10B981', 'icon' => 'M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z'],
        ['type' => 'Fuel', 'title' => 'FUEL LOG ADDED', 'desc' => '45L added to MH-12-AX', 'time' => '15m', 'badge' => '#F7C948', 'icon' => 'M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z'],
        ['type' => 'Service', 'title' => 'MAINTENANCE ALERT', 'desc' => 'Brake check for Truck #04', 'time' => '1h', 'badge' => '#EF4444', 'icon' => 'M11.42 15.17l-5.1-5.1a2.997 2.997 0 010-4.242 2.997 2.997 0 014.242 0l5.1 5.1a2.997 2.997 0 010 4.242 2.997 2.997 0 01-4.242 0z'],
        ['type' => 'Expense', 'title' => 'NEW EXPENSE LOGGED', 'desc' => 'Toll charges: ₹450', 'time' => '3h', 'badge' => '#000000', 'icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
@endphp

<div
    class="rounded-2xl border-4 border-ink bg-white p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] dark:bg-[#111111] dark:border-white transition-all hover:translate-x-1 hover:translate-y-1 hover:shadow-none duration-300">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h3 class="text-[10px] font-black text-ink uppercase tracking-[0.2em] dark:text-white">Live Activity Feed
            </h3>
            <p class="text-4xl font-black text-ink dark:text-white mt-2 leading-none">{{ count($activities) }} <span class="text-base font-black text-ink/40 dark:text-white/40 uppercase">Events</span></p>
        </div>
        <div class="w-14 h-14 border-4 border-ink bg-[#F7C948] flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            <span class="flex h-3 w-3 rounded-full bg-[#10B981] animate-pulse"></span>
        </div>
    </div>

    <div class="space-y-3">
        @foreach($activities as $activity)
        <div class="flex items-center gap-4 p-4 border-2 border-ink bg-gray-50 dark:bg-white/5 hover:bg-[#F7C948] hover:border-ink transition-all duration-200 group cursor-default">
            <div class="w-10 h-10 shrink-0 border-2 border-ink flex items-center justify-center" style="background-color: {{ $activity['badge'] }};">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $activity['icon'] }}" />
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h5 class="text-[11px] font-black text-ink uppercase tracking-tight dark:text-white group-hover:text-ink truncate">{{ $activity['title'] }}</h5>
                <p class="text-[10px] font-bold text-ink/50 dark:text-white/50 group-hover:text-ink/70 truncate">{{ $activity['desc'] }}</p>
            </div>
            <span class="text-[10px] font-black text-white bg-ink px-2 py-1 uppercase tracking-widest shrink-0 group-hover:bg-white group-hover:text-ink border-2 border-ink">{{ $activity['time'] }}</span>
        </div>
        @endforeach
    </div>

    <div class="mt-8 grid grid-cols-2 gap-4">
        <div class="p-4 bg-gray-50 border-2 border-ink dark:bg-white/5">
            <p class="text-[9px] font-black text-ink uppercase opacity-50 dark:text-white">Today</p>
            <p class="text-2xl font-black text-ink dark:text-white">12</p>
        </div>
        <div class="p-4 bg-[#F7C948] border-2 border-ink">
            <p class="text-[9px] font-black text-ink uppercase">Alerts</p>
            <p class="text-2xl font-black text-ink">02</p>
        </div>
    </div>
</div>
