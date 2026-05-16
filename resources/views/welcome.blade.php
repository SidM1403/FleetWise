@extends('layouts.landing')

@section('content')

<nav class="sticky top-0 z-50 bg-white border-b-2 border-ink">
    <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-14">
        <span class="font-black text-sm tracking-[0.15em] uppercase">FleetWise</span>

        <div class="hidden md:flex gap-8">
            <a href="#features" class="text-[10px] uppercase tracking-[0.12em] text-[#999] hover:text-ink transition-colors">Features</a>
            <a href="#financials" class="text-[10px] uppercase tracking-[0.12em] text-[#999] hover:text-ink transition-colors">Financials</a>
            <a href="#operations" class="text-[10px] uppercase tracking-[0.12em] text-[#999] hover:text-ink transition-colors">Operations</a>
        </div>

        @if(auth()->guard()->check())
            <a href="{{ route('dashboard') }}" class="bg-ink text-white text-[10px] uppercase tracking-[0.1em] px-4 py-2 hover:bg-[#222] transition-colors">
                Dashboard →
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-ink text-white text-[10px] uppercase tracking-[0.1em] px-4 py-2 hover:bg-[#222] transition-colors">
                Sign In →
            </a>
        @endif
    </div>
</nav>

<section class="max-w-6xl mx-auto px-6">
    <div class="grid border-b border-[#E5E5E5] grid-cols-1 md:grid-cols-[8px_1fr_320px]">
        <div class="hidden md:block bg-[#F7C948]"></div>
        <div class="px-4 md:px-8 py-16 md:border-r border-[#E5E5E5]">
            <p class="text-[10px] uppercase tracking-[0.15em] text-ink/40 mb-4 font-black">Fleet Management System</p>
            <h1 class="text-4xl md:text-6xl font-black leading-tight md:leading-[1.1] tracking-tighter mb-8">
                Move <span class="inline-block bg-[#F7C948] px-2 mb-2 text-ink">fleets.</span><br/>
                Not spreadsheets.
            </h1>
            <p class="text-sm text-ink/70 leading-relaxed max-w-md mb-10 font-medium">
                One high-fidelity dashboard for vehicles, drivers, trips, maintenance, and costs.
                Built for serious operators, not PowerPoint decks.
            </p>
            <div class="flex gap-3 mb-10">
                @if(auth()->guard()->check())
                    <a href="{{ route('dashboard') }}" class="bg-ink text-white text-[10px] uppercase tracking-[0.1em] px-6 py-3 hover:bg-[#222] transition-all hover:-translate-y-1 shadow-[4px_4px_0px_0px_rgba(247,201,72,1)]">Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="bg-ink text-white text-[10px] uppercase tracking-[0.1em] px-6 py-3 hover:bg-[#222] transition-all hover:-translate-y-1 shadow-[4px_4px_0px_0px_rgba(247,201,72,1)]">Get Started</a>
                    <a href="{{ route('login') }}" class="border-2 border-ink text-ink text-[10px] uppercase tracking-[0.1em] px-6 py-3 hover:bg-ink hover:text-white transition-all shadow-[4px_4px_0px_0px_rgba(230,230,230,1)]">Sign In</a>
                @endif
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach(['Vehicles','Drivers','Trips','Maintenance','Fuel','Reports'] as $tag)
                    <span class="border-2 border-ink text-[9px] font-black uppercase tracking-[0.1em] px-3 py-1.5 hover:bg-[#F7C948] transition-colors cursor-default">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
        <div class="flex flex-row md:flex-col border-t md:border-t-0 border-[#E5E5E5]">
            @foreach([['10k+','Trips Logged'],['500','Vehicles'],['24/7','Live Monitoring']] as $stat)
                <div class="flex-1 px-8 py-8 border-b border-[#E5E5E5] last:border-b-0 flex flex-col justify-center hover:bg-gray-50 transition-colors group">
                    <div class="text-4xl font-black group-hover:scale-110 transition-transform origin-left">{{ $stat[0] }}</div>
                    <div class="text-[9px] uppercase tracking-[0.15em] text-[#aaa] mt-2 font-black">{{ $stat[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div class="border-y-2 border-ink bg-[#F7C948] overflow-hidden py-3">
    <div class="flex whitespace-nowrap marquee-track">
        @php $items = ['REAL-TIME TRACKING','EXPENSE ANALYTICS','MAINTENANCE ALERTS','FUEL MONITORING','DRIVER PERFORMANCE','LOGISTICS CONTROL']; @endphp
        @foreach(array_merge($items, $items) as $item)
            <span class="text-[12px] font-black uppercase tracking-[0.25em] text-ink mx-10">{{ $item }}</span>
            <span class="text-[12px] font-black text-ink mx-4">★</span>
        @endforeach
    </div>
</div>

{{-- Original Core Capabilities --}}
<section id="features" class="max-w-6xl mx-auto px-6 py-24">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-1 bg-[#F7C948]"></div>
        <span class="text-sm uppercase font-black tracking-[0.2em] text-ink/40">Core Capabilities</span>
    </div>
    <h2 class="text-4xl md:text-5xl font-black tracking-tighter mb-20 leading-tight">Everything you need<br/>to run a <span class="text-[#F7C948] stroke-text">modern fleet.</span></h2>
    <div class="grid md:grid-cols-3 gap-0">
        @foreach([
            ['ti-truck', 'Real-Time Tracking', 'Monitor vehicle statuses, trip progress, and driver availability from a single unified dashboard.'],
            ['ti-chart-bar', 'Smart Analytics', 'Visualise expenses, trip trends, and fleet utilisation with Chart.js. Generate date-filtered reports instantly.'],
            ['ti-tool', 'Maintenance Intelligence', 'Never miss a service date. Get proactive alerts for upcoming maintenance, expiring licences, and insurance renewals.'],
        ] as $feature)
            <div class="border-t-4 border-ink pt-8 pb-12 {{ !$loop->last ? 'md:pr-12 md:border-r-2 md:border-r-[#E5E5E5]' : '' }} {{ !$loop->first ? 'md:pl-12' : '' }} group hover:bg-gray-50 transition-colors">
                <i class="ti {{ $feature[0] }} text-3xl text-ink group-hover:scale-125 transition-transform inline-block" aria-hidden="true"></i>
                <h3 class="text-sm font-black uppercase tracking-wider mt-6 mb-4">{{ $feature[1] }}</h3>
                <p class="text-xs text-ink/60 leading-relaxed font-medium">{{ $feature[2] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- SEPARATE FEATURE SECTIONS (As corrected) --}}

{{-- Section 1: Financials --}}
{{-- Section: Product in Action (Prompt 2) --}}
<section id="action" class="bg-gray-50 py-32 border-y-4 border-ink relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-16">
            <div class="w-12 h-1 bg-ink"></div>
            <span class="text-sm uppercase font-black tracking-[0.2em] text-ink">Product in Action</span>
        </div>

        <div class="space-y-40">
            {{-- Feature 1: Financials --}}
            <div class="grid md:grid-cols-2 gap-24 items-center">
                <div>
                    <h3 class="text-4xl md:text-5xl font-black mb-6 leading-none tracking-tight">Financial Clarity at a Glance.</h3>
                    <p class="text-lg text-ink/70 leading-relaxed font-medium">
                        Visualize every rupee spent on your fleet. Our analytics engine automatically categorizes expenses, calculates trends, and highlights anomalies so you can optimize your bottom line.
                    </p>
                </div>
                <div class="relative shadow-2xl rounded-2xl transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] bg-white">
                    @include('components.dashboard-preview.expense-chart')
                </div>
            </div>

            {{-- Feature 2: Operations --}}
            <div class="grid md:grid-cols-2 gap-24 items-center">
                <div class="order-2 md:order-1 relative shadow-2xl rounded-2xl transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] bg-white">
                    @include('components.dashboard-preview.fleet-health')
                </div>
                <div class="order-1 md:order-2">
                    <h3 class="text-4xl md:text-5xl font-black mb-6 leading-none tracking-tight">Fleet Health.</h3>
                    <p class="text-lg text-ink/70 leading-relaxed font-medium">
                        Monitor the health of your entire operation in real-time. From upcoming service windows to license renewals, we ensure your assets are always compliant and road-ready.
                    </p>
                </div>
            </div>

            {{-- Feature 3: Logistics --}}
            <div class="grid md:grid-cols-2 gap-24 items-center">
                <div>
                    <h3 class="text-4xl md:text-5xl font-black mb-6 leading-none tracking-tight">Activity Tracking.</h3>
                    <p class="text-lg text-ink/70 leading-relaxed font-medium">
                        Every trip, every fuel stop, every driver update. Stay connected to the heartbeat of your business with a live activity feed that keeps you informed as it happens.
                    </p>
                </div>
                <div class="relative shadow-2xl rounded-2xl transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.3)] bg-white">
                    @include('components.dashboard-preview.activity-feed')
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Section: Ditch the Spreadsheets (Phase 3) --}}
<section id="comparison" class="bg-gray-50 py-32 border-b-4 border-ink relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-16">
            <div class="w-12 h-1 bg-ink"></div>
            <span class="text-sm uppercase font-black tracking-[0.2em] text-ink">The Evolution</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black mb-24 leading-none tracking-tight text-ink">Ditch the <span class="inline-block bg-[#F7C948] px-3 border-2 border-ink shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">Spreadsheets.</span></h2>

        <div class="relative grid md:grid-cols-2 gap-16 lg:gap-24 items-start">
            
            {{-- Center VS Badge (absolute) --}}
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-20 hidden md:flex w-16 h-16 bg-ink text-white rounded-full items-center justify-center border-4 border-[#F7C948] shadow-[0px_0px_0px_8px_rgba(249,250,251,1)]">
                <span class="text-xl font-black italic">VS</span>
            </div>

            {{-- The Old Way (Left) --}}
            <div class="relative group">
                <h3 class="text-xs font-black uppercase tracking-widest mb-6 text-ink/40 text-center">The Old Way</h3>
                <div class="bg-white border-2 border-gray-200 p-6 shadow-sm opacity-60 grayscale filter transition-all duration-500 hover:grayscale-0 hover:opacity-100 overflow-hidden relative">
                    <div class="border-b-2 border-gray-300 pb-3 mb-4 flex gap-4">
                        <div class="w-1/4 h-3 bg-gray-200 rounded"></div>
                        <div class="w-1/4 h-3 bg-gray-200 rounded"></div>
                        <div class="w-1/4 h-3 bg-gray-200 rounded"></div>
                        <div class="w-1/4 h-3 bg-gray-200 rounded"></div>
                    </div>
                    @foreach(range(1,5) as $i)
                    <div class="flex gap-4 py-3 border-b border-gray-100 items-center">
                        <div class="w-1/4 text-[10px] font-mono text-gray-400">TRP-{{ 1000 + $i }}</div>
                        <div class="w-1/4 text-[10px] font-mono text-gray-400 whitespace-nowrap overflow-hidden text-ellipsis">MUM_PUN_Trip_vFINAL_2.xls</div>
                        <div class="w-1/4 text-[10px] font-mono font-bold {{ $i%2==0 ? 'text-red-500' : 'text-gray-400' }}">{{ $i%2==0 ? '#REF!' : '₹45,000' }}</div>
                        <div class="w-1/4 text-[10px] font-mono text-gray-400">#DIV/0!</div>
                    </div>
                    @endforeach
                    <div class="absolute -right-6 top-1/3 bg-red-100 text-red-600 border-2 border-red-300 px-4 py-2 text-[10px] font-black uppercase tracking-widest rotate-12 shadow-lg z-10">
                        Error: Data Corrupt
                    </div>
                </div>
            </div>

            {{-- The FleetWise Way (Right) --}}
            <div class="relative">
                <h3 class="text-xs font-black uppercase tracking-widest mb-6 text-[#F7C948] text-center">The FleetWise Way</h3>
                <div class="bg-white border-4 border-ink p-6 md:p-8 shadow-[12px_12px_0px_0px_rgba(247,201,72,1)] transition-transform duration-500 hover:-translate-y-2">
                    <div class="border-b-2 border-ink pb-3 mb-4 flex gap-4 justify-between">
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink/40 w-1/4">Trip ID</span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink/40 w-1/4">Route</span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink/40 w-1/4">Cost</span>
                        <span class="text-[10px] font-black uppercase tracking-widest text-ink/40 w-1/4 text-right">Status</span>
                    </div>
                    @foreach([['TRP-1001','Mumbai - Pune','₹12,400','Optimized'], ['TRP-1002','Delhi - Jaipur','₹18,200','Optimized'], ['TRP-1003','Chennai - Blr','₹15,000','Optimized'], ['TRP-1004','Kolkata - Dgp','₹9,800','Optimized']] as $row)
                    <div class="flex gap-4 py-4 border-b border-gray-100 items-center justify-between group cursor-default">
                        <div class="text-[12px] font-black uppercase text-ink w-1/4">{{ $row[0] }}</div>
                        <div class="text-[12px] font-bold text-ink/70 w-1/4 whitespace-nowrap">{{ $row[1] }}</div>
                        <div class="text-[12px] font-black text-ink w-1/4">{{ $row[2] }}</div>
                        <div class="w-1/4 flex justify-end">
                            <span class="text-[9px] font-black text-white bg-[#10B981] px-2 py-1 uppercase tracking-widest border-2 border-ink shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] group-hover:-translate-y-0.5 transition-transform">{{ $row[3] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Section: The Fleet Hub (Bento Grid Phase 1) --}}
<section id="fleet-hub" class="bg-[#F7C948] py-32 border-b-4 border-ink relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center gap-3 mb-12">
            <div class="w-12 h-1 bg-ink"></div>
            <span class="text-sm uppercase font-black tracking-[0.2em] text-ink">The Fleet Hub</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black mb-16 leading-none tracking-tight text-ink">Everything in its <span class="inline-block bg-white px-3 border-2 border-ink shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">Right Place.</span></h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 auto-rows-[minmax(220px,auto)]">
            {{-- 1. Intelligent Routing (Large) --}}
            <div class="md:col-span-2 md:row-span-2 bg-white border-4 border-ink p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden group min-h-[440px]">
                <div class="relative z-20">
                    <h3 class="text-xl md:text-2xl font-black uppercase tracking-widest mb-2">Intelligent Routing</h3>
                    <p class="text-sm text-ink/60 font-bold max-w-xs">AI-optimized paths that save fuel and drastically cut delivery times.</p>
                </div>
                {{-- Mocked Map UI --}}
                <div class="absolute inset-0 top-32 left-8 md:left-16 bg-gray-50 border-t-4 border-l-4 border-ink rounded-tl-3xl p-6 overflow-hidden z-10 transition-transform duration-500 group-hover:-translate-y-2 group-hover:-translate-x-2">
                    <div class="w-full h-full relative">
                        {{-- Fake Map Grid --}}
                        <div class="absolute inset-0" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px; opacity: 0.1;"></div>
                        {{-- Route Line --}}
                        <svg class="w-full h-full text-indigo-600 absolute top-0 left-0 drop-shadow-md" viewBox="0 0 400 200" preserveAspectRatio="none" fill="none" stroke="currentColor" stroke-width="6" stroke-dasharray="12 12">
                            <path d="M 20,180 Q 120,80 220,120 T 380,20" class="animate-[pulse_3s_ease-in-out_infinite]" />
                        </svg>
                        <div class="absolute top-[12px] right-[12px] w-6 h-6 bg-ink border-4 border-[#F7C948] rounded-full animate-bounce shadow-lg z-20"></div>
                        <div class="absolute bottom-[10px] left-[10px] w-6 h-6 bg-white border-4 border-ink rounded-full shadow-lg z-20"></div>
                        
                        <div class="absolute bottom-6 right-6 bg-ink text-white border-2 border-ink px-4 py-2 shadow-[4px_4px_0px_0px_rgba(247,201,72,1)] z-20">
                            <span class="text-[10px] font-black uppercase tracking-widest">ETA: 14 Mins</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Driver Scorecard (Tall) --}}
            <div class="md:col-span-1 md:row-span-2 bg-white border-4 border-ink p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] flex flex-col group min-h-[440px]">
                <div>
                    <h3 class="text-xl md:text-2xl font-black uppercase tracking-widest mb-2">Driver Score</h3>
                    <p class="text-sm text-ink/60 font-bold">Real-time safety rating.</p>
                </div>
                <div class="flex flex-col items-center justify-center flex-1 mt-8">
                    <div class="w-40 h-40 rounded-full border-[12px] border-[#F7C948] flex items-center justify-center relative shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] transition-transform duration-500 group-hover:scale-105">
                        <span class="text-6xl font-black">98</span>
                        <div class="absolute -right-4 -top-4 bg-ink text-white text-[12px] font-black px-3 py-1 uppercase border-2 border-ink shadow-[4px_4px_0px_0px_rgba(255,255,255,1)] rotate-12">Top 5%</div>
                    </div>
                    <div class="mt-12 w-full space-y-4">
                        <div class="flex justify-between border-b-2 border-gray-100 pb-2"><span class="text-xs font-black uppercase text-ink/50">Braking</span><span class="text-xs font-black uppercase">Perfect</span></div>
                        <div class="flex justify-between border-b-2 border-gray-100 pb-2"><span class="text-xs font-black uppercase text-ink/50">Speeding</span><span class="text-xs font-black uppercase">Zero Incidents</span></div>
                        <div class="flex justify-between border-b-2 border-gray-100 pb-2"><span class="text-xs font-black uppercase text-ink/50">Cornering</span><span class="text-xs font-black uppercase">Smooth</span></div>
                    </div>
                </div>
            </div>

            {{-- 4. Predictive Maintenance (Wide) --}}
            <div class="md:col-span-2 md:row-span-1 bg-white border-4 border-ink p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] flex flex-col md:flex-row items-start md:items-center justify-between group">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-xl md:text-2xl font-black uppercase tracking-widest mb-2">Predictive Alerts</h3>
                    <p class="text-sm text-ink/60 font-bold max-w-xs">Fix issues before they become expensive breakdowns.</p>
                </div>
                <div class="flex gap-4 items-center">
                    <div class="bg-red-500 text-white p-5 border-4 border-ink shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] transform -rotate-12 group-hover:rotate-0 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="bg-white p-4 border-4 border-ink shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-center transform group-hover:-translate-y-1 transition-transform duration-300">
                        <span class="text-[11px] font-black uppercase tracking-widest text-red-500">Brake Pad Wear</span>
                        <span class="text-sm font-black text-ink mt-1">Asset MH-12</span>
                    </div>
                </div>
            </div>

            {{-- 3. Automated Compliance (Square) --}}
            <div class="md:col-span-1 md:row-span-1 bg-white border-4 border-ink p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-center items-center text-center group">
                <div class="w-20 h-20 rounded-full bg-[#10B981] border-4 border-ink flex items-center justify-center shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] mb-6 transition-transform duration-500 group-hover:scale-110">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="square" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="text-lg font-black uppercase tracking-widest">Compliance</h3>
                <p class="text-xs text-ink/60 font-bold uppercase mt-2 bg-gray-100 px-3 py-1 border-2 border-ink">100% Automated</p>
            </div>
        </div>
    </div>
</section>

{{-- Section: Enterprise Tech (Phase 2) --}}
<section id="enterprise" class="bg-ink text-white py-32 border-b-4 border-ink relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 mb-20">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-1 bg-[#F7C948]"></div>
            <span class="text-sm uppercase font-black tracking-[0.2em] text-[#F7C948]">Enterprise Tech</span>
        </div>
        <h2 class="text-5xl md:text-[7rem] font-black tracking-tighter leading-none stroke-text-white">BUILT FOR SCALE.</h2>
    </div>

    {{-- Marquee --}}
    <div class="border-y-2 border-[#333] bg-[#111] overflow-hidden py-8 mb-24">
        <div class="flex whitespace-nowrap animate-marquee-half w-max">
            @php $specs = ['256-bit Encryption', '99.9% Uptime SLA', 'RESTful API', 'Real-Time Webhooks', 'Unlimited Seats']; @endphp
            @foreach(array_merge($specs, $specs, $specs, $specs, $specs, $specs) as $spec)
                <span class="text-lg md:text-2xl font-black uppercase tracking-[0.15em] text-white mx-8">{{ $spec }} <span class="text-[#F7C948] ml-8">●</span></span>
            @endforeach
        </div>
    </div>

    {{-- 3 Minimalist Columns --}}
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-16 md:gap-8 border-t border-[#333] pt-16">
            <div>
                <h3 class="text-xl font-black uppercase tracking-widest mb-4 text-[#F7C948]">Security First</h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">
                    End-to-end encryption for all vehicle telematics and financial data. Role-based access control built into the core.
                </p>
            </div>
            <div>
                <h3 class="text-xl font-black uppercase tracking-widest mb-4 text-[#F7C948]">Absolute Reliability</h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">
                    Redundant database architecture ensuring your operations never go offline. Backed by an aggressive 99.9% SLA.
                </p>
            </div>
            <div>
                <h3 class="text-xl font-black uppercase tracking-widest mb-4 text-[#F7C948]">Dedicated Support</h3>
                <p class="text-sm text-gray-400 font-medium leading-relaxed">
                    24/7 technical support from engineers who understand logistics. Direct slack channels for enterprise clients.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="metrics" class="bg-ink text-white py-32 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-[#F7C948] opacity-5 -translate-y-1/2 translate-x-1/2 rounded-full"></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-1 bg-[#444]"></div>
            <span class="text-sm uppercase font-black tracking-[0.2em] text-[#555]">Platform Scale</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black tracking-tighter mb-20">Built for fleets of any size.</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 border-l border-t border-[#222]">
            @foreach([['10,000+','Trips Tracked'],['500','Vehicles Managed'],['98%','Uptime SLA'],['24/7','Monitoring']] as $index => $stat)
                <div class="py-12 px-8 border-r border-b border-[#222] hover:bg-white/[0.02] transition-colors">
                    <div class="text-5xl md:text-6xl font-black text-[#F7C948]">{{ $stat[0] }}</div>
                    <div class="text-[10px] uppercase tracking-[0.2em] text-[#555] mt-4 font-black">{{ $stat[1] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="modules" class="max-w-6xl mx-auto px-6 py-32 border-b border-[#E5E5E5]">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-1 bg-[#999]"></div>
        <span class="text-sm uppercase font-black tracking-[0.2em] text-[#999]">Modules</span>
    </div>
    <h2 class="text-4xl md:text-5xl font-black tracking-tighter mb-4 leading-none">Integrated Ecosystem.</h2>
    <p class="text-base text-ink/60 mb-16 font-medium">Every aspect of fleet management, connected and working in harmony.</p>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach([['ti-truck', 'Vehicles'],['ti-user', 'Drivers'],['ti-map', 'Trips'],['ti-tool', 'Maintenance'],['ti-droplet', 'Fuel Logs'],['ti-coin', 'Expenses']] as $module)
            <div class="group border-2 border-ink px-6 py-5 flex items-center gap-3 cursor-default hover:bg-ink hover:text-white transition-all hover:-translate-y-1 shadow-[4px_4px_0px_0px_rgba(0,0,0,0.1)]">
                <i class="ti {{ $module[0] }} text-xl group-hover:text-[#F7C948]" aria-hidden="true"></i>
                <span class="text-[11px] font-black uppercase tracking-widest">{{ $module[1] }}</span>
            </div>
        @endforeach
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-32">
    <div class="bg-ink p-12 md:p-20 relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-64 h-64 border-[20px] border-[#F7C948] opacity-10 rounded-full"></div>
        <div class="relative z-10">
            <h2 class="text-4xl md:text-6xl font-black tracking-tighter leading-[0.85] mb-8 text-white">
                READY TO<br/>OPTIMISE?
            </h2>
            <p class="text-base text-white/50 mb-12 max-w-md font-medium">Start managing your vehicles, drivers, and operations in minutes with FleetWise.</p>
            <div class="flex flex-wrap gap-4">
                @if(auth()->guard()->check())
                    <a href="{{ route('dashboard') }}" class="inline-block bg-[#F7C948] text-ink text-xs font-black uppercase tracking-[0.2em] px-10 py-4 hover:bg-white transition-all shadow-[6px_6px_0px_0px_rgba(255,255,255,0.3)]">Go to Dashboard →</a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-[#F7C948] text-ink text-xs font-black uppercase tracking-[0.2em] px-10 py-4 hover:bg-white transition-all shadow-[6px_6px_0px_0px_rgba(255,255,255,0.3)]">Get Started — Free →</a>
                @endif
            </div>
        </div>
    </div>
</section>

<footer class="border-t-4 border-ink bg-white">
    <div class="max-w-6xl mx-auto px-6 py-16 flex flex-col sm:flex-row items-center justify-between gap-6">
        <span class="font-black text-2xl uppercase tracking-[0.15em]">FleetWise</span>
        <span class="text-[11px] font-black text-ink/40 uppercase tracking-widest">© {{ date('Y') }} FleetWise. Built for operators.</span>
    </div>
</footer>

<style>
    .stroke-text {
        -webkit-text-stroke: 1.5px black;
        color: transparent;
    }
    .stroke-text-white {
        -webkit-text-stroke: 2px white;
        color: transparent;
    }
    @media (prefers-color-scheme: dark) {
        .stroke-text {
            -webkit-text-stroke: 1.5px white;
        }
    }
    
    @keyframes marquee-half {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee-half {
        animation: marquee-half 40s linear infinite;
    }
</style>

@endsection
