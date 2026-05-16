@extends('layouts.app')

@section('header')
    {{ __('Dashboard') }}
@endsection

@section('content')
<div class="py-4 space-y-6 max-w-7xl mx-auto">
    {{-- Greeting Banner --}}
    <div class="rounded-xl p-6 text-white relative overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #6366f1 100%);">
        <div class="relative z-10">
            <p class="text-sm font-medium text-indigo-200 mb-1" id="greeting-time"></p>
            <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
            <p class="text-sm text-slate-300 mt-1">Here's what's happening with your fleet today.</p>
        </div>
        <div class="absolute right-6 top-1/2 -translate-y-1/2 opacity-10">
            <svg width="120" height="120" viewBox="0 0 24 24" fill="currentColor"><path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V9.75"/></svg>
        </div>
    </div>

    {{-- Maintenance Alerts --}}
    @if(isset($upcomingMaintenance) && $upcomingMaintenance->count() > 0)
    <div class="rounded-xl border border-amber-200 dark:border-amber-900/50 bg-amber-50 dark:bg-amber-900/20 p-4 shadow-sm flex gap-3">
        <svg class="h-5 w-5 text-amber-500 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
        <div>
            <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-500">Upcoming Maintenance</h3>
            <ul class="mt-1 text-sm text-amber-700 dark:text-amber-400 list-disc pl-5 space-y-1">
                @foreach($upcomingMaintenance as $m)
                <li><strong>{{ $m->vehicle->vehicle_number }}</strong> — {{ $m->service_type }} by {{ $m->next_service_date->format('M d, Y') }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Quick Actions --}}
    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm dark:bg-[#111111] dark:border-white/5 transition-colors">
        <h3 class="text-xs font-bold text-gray-600 uppercase tracking-wider mb-3 dark:text-gray-400">Quick Actions</h3>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('vehicles.create') }}" class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:scale-[1.02]" style="background: linear-gradient(135deg, #6366f1, #4f46e5);"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>Add Vehicle</a>
            <a href="{{ route('drivers.create') }}" class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:scale-[1.02]" style="background: linear-gradient(135deg, #3b82f6, #2563eb);"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>Add Driver</a>
            <a href="{{ route('trips.create') }}" class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:scale-[1.02]" style="background: linear-gradient(135deg, #10b981, #059669);"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>Schedule Trip</a>
        </div>
    </div>

    {{-- Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach([
            ['label' => 'Active Vehicles', 'val' => $activeVehicles, 'icon' => 'truck', 'color' => '#6366f1'],
            ['label' => 'Ongoing Trips', 'val' => $ongoingTrips, 'icon' => 'map', 'color' => '#10b981'],
            ['label' => 'Available Drivers', 'val' => $availableDrivers, 'icon' => 'user', 'color' => '#3b82f6'],
            ['label' => 'Expenses (Month)', 'val' => '₹' . number_format($totalMonthlyExpenses, 2), 'icon' => 'dollar', 'color' => '#f43f5e']
        ] as $stat)
        <div class="relative overflow-hidden rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:bg-[#111111] dark:border-white/5 group transition-colors">
            <div class="flex items-center gap-4">
                <div class="shrink-0 rounded-lg p-3 text-white" style="background: {{ $stat['color'] }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        @if($stat['icon'] == 'truck') <path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                        @elseif($stat['icon'] == 'map') <path d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                        @elseif($stat['icon'] == 'user') <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        @else <path d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        @endif
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-600 uppercase tracking-wide dark:text-gray-400">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white {{ is_numeric($stat['val']) ? 'counter' : '' }}" data-target="{{ is_numeric($stat['val']) ? $stat['val'] : '' }}">{{ $stat['val'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Charts & Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:bg-[#111111] dark:border-white/5 transition-colors">
            <h3 class="text-sm font-bold text-gray-900 mb-4 dark:text-white">Expense Trend — Last 6 Months</h3>
            <div class="relative h-[280px]">
                <div class="absolute inset-0 rounded-lg bg-gray-100 dark:bg-white/5 animate-pulse" id="expenseSkeleton"></div>
                <canvas id="expenseChart" class="opacity-0 transition-opacity duration-500"></canvas>
            </div>
        </div>
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:bg-[#111111] dark:border-white/5 transition-colors">
            <h3 class="text-sm font-bold text-gray-900 mb-4 dark:text-white">Recent Activity</h3>
            <div class="space-y-4 max-h-[280px] overflow-y-auto pr-1">
                @forelse($recentActivity as $a)
                <div class="flex items-start gap-3">
                    <div class="shrink-0 w-8 h-8 rounded-lg flex items-center justify-center 
                        @if($a['color'] == 'green') bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400
                        @elseif($a['color'] == 'blue') bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400
                        @elseif($a['color'] == 'amber') bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400
                        @elseif($a['color'] == 'rose') bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400
                        @else bg-gray-50 text-gray-500 dark:bg-white/5 dark:text-gray-400 @endif">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            @if($a['icon'] == 'map') <path d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                            @elseif($a['icon'] == 'wrench') <path d="M11.42 15.17l-5.1-5.1a2.997 2.997 0 010-4.242 2.997 2.997 0 014.242 0l5.1 5.1a2.997 2.997 0 010 4.242 2.997 2.997 0 01-4.242 0z"/>
                            @elseif($a['icon'] == 'dollar') <path d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @elseif($a['icon'] == 'truck') <path d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h7.5"/>
                            @elseif($a['icon'] == 'user') <path d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            @elseif($a['icon'] == 'fire') <path d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"/>
                            @else <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/> @endif
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-gray-200 truncate">{{ $a['title'] }}</p>
                        <p class="text-xs font-medium text-gray-800 dark:text-gray-400">{{ $a['subtitle'] }}</p>
                    </div>
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-400 whitespace-nowrap">{{ $a['time']->diffForHumans(null, true, true) }}</span>
                </div>
                @empty
                <p class="text-sm font-black text-gray-800 dark:text-gray-400 text-center py-4">No recent activity</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:bg-[#111111] dark:border-white/5 transition-colors">
            <h3 class="text-sm font-bold text-gray-900 mb-4 dark:text-white">Trip Distribution</h3>
            <div class="relative h-[240px]">
                <div class="absolute inset-0 rounded-full w-44 h-44 mx-auto bg-gray-100 dark:bg-white/5 animate-pulse" id="tripSkeleton"></div>
                <canvas id="tripStatusChart" class="opacity-0 transition-opacity duration-500"></canvas>
            </div>
        </div>
        <div class="lg:col-span-2 rounded-xl border border-gray-100 bg-white p-6 shadow-sm dark:bg-[#111111] dark:border-white/5 transition-colors">
            <h3 class="text-sm font-bold text-gray-900 mb-4 dark:text-white">Fleet Status Overview</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 rounded-lg bg-gray-50 dark:bg-white/5">
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $fleetStatus['total'] }}</p>
                    <p class="text-xs font-bold text-gray-800 mt-1 dark:text-gray-400">Total Fleet</p>
                </div>
                <div class="text-center p-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/10">
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $fleetStatus['active'] }}</p>
                    <p class="text-xs font-bold text-gray-800 mt-1 dark:text-gray-400">Active</p>
                </div>
                <div class="text-center p-4 rounded-lg bg-amber-50 dark:bg-amber-900/10">
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $fleetStatus['maintenance'] }}</p>
                    <p class="text-xs font-bold text-gray-800 mt-1 dark:text-gray-400">Maintenance</p>
                </div>
                <div class="text-center p-4 rounded-lg bg-red-50 dark:bg-rose-900/10">
                    <p class="text-3xl font-bold text-red-500 dark:text-rose-400">{{ $fleetStatus['inactive'] }}</p>
                    <p class="text-xs font-bold text-gray-800 mt-1 dark:text-gray-400">Inactive</p>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5 dark:text-gray-400">
                    <span>Fleet Health</span>
                    <span>{{ $fleetStatus['total'] > 0 ? round(($fleetStatus['active'] / $fleetStatus['total']) * 100) : 0 }}% operational</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden dark:bg-white/10">
                    @php $pct = $fleetStatus['total'] > 0 ? ($fleetStatus['active'] / $fleetStatus['total']) * 100 : 0; @endphp
                    <div class="h-2.5 rounded-full transition-all duration-1000" style="width: {{ $pct }}%; background: linear-gradient(90deg, #10b981, #059669);"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let expenseChart, tripChart;
        
        const getChartColors = () => {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                text: isDark ? '#f3f4f6' : '#000000',
                grid: isDark ? 'rgba(0,0,0,0.15)' : 'rgba(0,0,0,0.15)',
                border: isDark ? '#111111' : '#ffffff'
            };
        };

        const initCharts = () => {
            const colors = getChartColors();
            
            // Expense Chart
            const ctxEx = document.getElementById('expenseChart').getContext('2d');
            const grad = ctxEx.createLinearGradient(0, 0, 0, 280);
            grad.addColorStop(0, 'rgba(99, 102, 241, 0.9)');
            grad.addColorStop(1, 'rgba(99, 102, 241, 0.1)');
            
            if (expenseChart) expenseChart.destroy();
            expenseChart = new Chart(ctxEx, {
                type: 'bar',
                data: { 
                    labels: @json($expenseLabels), 
                    datasets: [{ 
                        label: 'Expenses (₹)', 
                        data: @json($expenseData), 
                        backgroundColor: grad, 
                        borderRadius: 8, 
                        barPercentage: 0.8 
                    }] 
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { display: false } }, 
                    scales: { 
                        y: { 
                            grid: { color: colors.grid }, 
                            ticks: { 
                                color: colors.text, 
                                font: { weight: 'bold', size: 11 },
                                callback: v => '₹' + v.toLocaleString() 
                            } 
                        }, 
                        x: { 
                            grid: { display: false }, 
                            ticks: { 
                                color: colors.text, 
                                font: { weight: 'bold', size: 11 }
                            } 
                        } 
                    } 
                }
            });

            // Trip Chart
            const tripStatuses = @json($tripStatuses);
            const ctxTrip = document.getElementById('tripStatusChart').getContext('2d');
            
            if (tripChart) tripChart.destroy();
            tripChart = new Chart(ctxTrip, {
                type: 'doughnut',
                data: { 
                    labels: Object.keys(tripStatuses), 
                    datasets: [{ 
                        data: Object.values(tripStatuses), 
                        backgroundColor: ['#94a3b8', '#6366f1', '#10b981'], 
                        borderWidth: 4, 
                        borderColor: colors.border 
                    }] 
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    cutout: '70%', 
                    plugins: { 
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                color: colors.text, 
                                usePointStyle: true, 
                                padding: 20,
                                font: { weight: 'bold', size: 12 }
                            } 
                        } 
                    } 
                }
            });
        };

        // Greeting
        const hour = new Date().getHours();
        document.getElementById('greeting-time').textContent = (hour < 12 ? 'Good morning' : (hour < 17 ? 'Good afternoon' : 'Good evening')) + ' 👋';

        // Counters
        document.querySelectorAll('.counter').forEach(el => {
            const target = parseInt(el.dataset.target) || 0, duration = 1200, start = performance.now();
            function tick(now) {
                const progress = Math.min((now - start) / duration, 1), eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target);
                if (progress < 1) requestAnimationFrame(tick); else el.textContent = target;
            }
            requestAnimationFrame(tick);
        });

        initCharts();

        // Listen for theme changes
        window.addEventListener('theme-changed', () => {
            initCharts();
        });

        setTimeout(() => {
            ['expenseSkeleton', 'tripSkeleton'].forEach(id => document.getElementById(id)?.remove());
            ['expenseChart', 'tripStatusChart'].forEach(id => document.getElementById(id)?.classList.remove('opacity-0'));
        }, 800);
    });
</script>
@endsection
