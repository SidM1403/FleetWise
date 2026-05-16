<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Trip Summary Report | FleetWise</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print { .no-print { display: none !important; } body { padding: 0 !important; background: white !important; } .report-container { box-shadow: none !important; border: none !important; max-width: 100% !important; } }
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-[#0A0A0A] p-4 md:p-12 transition-colors duration-200">
<div class="max-w-6xl mx-auto report-container">
    <div class="flex justify-between items-center mb-10 no-print">
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor"><path stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7H21"/></svg>Back to Reports</a>
        <button onclick="window.print()" class="bg-[#1e293b] hover:bg-[#0f172a] text-white font-black text-[10px] uppercase tracking-[0.15em] px-6 py-3 rounded-lg shadow-xl transition-all active:scale-95">Print Report</button>
    </div>
    <div class="bg-white dark:bg-[#111111] rounded-3xl border border-gray-100 dark:border-white/5 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 border-b border-gray-100 dark:border-white/5 pb-10">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-indigo-600 flex items-center justify-center rounded-xl"><span class="text-white font-black text-xl">F</span></div>
                        <span class="text-gray-900 dark:text-white font-black tracking-tighter text-2xl uppercase">FleetWise</span>
                    </div>
                    <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter uppercase leading-none">Trip Summary Report</h1>
                    <p class="text-sm font-bold text-gray-400 mt-2 uppercase tracking-widest">{{ $startDate->format('M d, Y') }} — {{ $endDate->format('M d, Y') }}</p>
                </div>
                <div class="text-left md:text-right">
                    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Generated On</div>
                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ now()->format('M d, Y | H:i') }}</div>
                    <div class="mt-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">ID Mark</div>
                    <div class="text-sm font-bold text-indigo-600 dark:text-indigo-400 font-mono tracking-tighter">FW-REP-{{ strtoupper(uniqid()) }}</div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-900 dark:border-white">
                            @foreach(['Route', 'Vehicle', 'Driver', 'Departure', 'Distance', 'Status'] as $label)<th class="py-4 text-left text-[10px] font-black uppercase tracking-widest text-gray-400">{{ $label }}</th>@endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse($trips as $t)
                        <tr class="group hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                            <td class="py-5 text-sm font-bold text-gray-900 dark:text-white"><div class="flex items-center gap-2"><span>{{ $t->origin }}</span><svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor"><path stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg><span>{{ $t->destination }}</span></div></td>
                            <td class="py-5 text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $t->vehicle->vehicle_number }}</td>
                            <td class="py-5 text-sm font-medium text-gray-600 dark:text-gray-400">{{ $t->driver->name }}</td>
                            <td class="py-5 text-sm font-medium text-gray-600 dark:text-gray-400">{{ $t->departure_time->format('M d H:i') }}</td>
                            <td class="py-5 text-sm font-bold text-gray-900 dark:text-white">{{ $t->distance ?? 'N/A' }} km</td>
                            <td class="py-5"><span class="text-[10px] font-black uppercase tracking-widest @if($t->status == 'completed') text-emerald-600 @elseif($t->status == 'ongoing') text-blue-600 @else text-gray-900 dark:text-white @endif">{{ $t->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="py-12 text-center text-sm font-bold text-gray-400 uppercase tracking-widest">No trips recorded in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-gray-100 dark:border-white/5 pt-10">
                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-6"><div class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Total Volume</div><div class="text-2xl font-black text-gray-900 dark:text-white">{{ $trips->count() }} Trips</div></div>
                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-6"><div class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Total Distance</div><div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($trips->sum('distance')) }} KM</div></div>
                <div class="bg-gray-50 dark:bg-white/5 rounded-2xl p-6"><div class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Operational Scope</div><div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $trips->unique('vehicle_id')->count() }} Vehicles</div></div>
            </div>
            <div class="mt-12 text-center"><p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">End of Official Report — FleetWise Management System</p></div>
        </div>
    </div>
</div>
</body>
</html>