{{-- Overview --}}
<li>
    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500/80 px-6 mb-2 mt-4">Overview</div>
    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><svg
            class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
        </svg>Dashboard</a>
</li>
{{-- Fleet --}}
<li>
    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500/80 px-6 mb-2 mt-5">Fleet</div>
    <a href="{{ route('vehicles.index') }}" class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"><svg
            class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h7.5" />
        </svg>Vehicles</a>
    <a href="{{ route('drivers.index') }}" class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}"><svg
            class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
        </svg>Drivers</a>
</li>
{{-- Operations --}}
<li>
    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500/80 px-6 mb-2 mt-5">Operations</div>
    <a href="{{ route('trips.index') }}" class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}"><svg
            class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />
        </svg>Trips</a>
    <a href="{{ route('maintenance.index') }}"
        class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}"><svg class="nav-icon" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M11.42 15.17l-5.1-5.1a2.997 2.997 0 010-4.242 2.997 2.997 0 014.242 0l5.1 5.1a2.997 2.997 0 010 4.242 2.997 2.997 0 01-4.242 0z" />
            <path d="M13.56 9.879L16.5 6.94a1.5 1.5 0 012.122 0l.707.707a1.5 1.5 0 010 2.122l-3.56 3.56" />
        </svg>Maintenance</a>
</li>
{{-- Finance --}}
<li>
    <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500/80 px-6 mb-2 mt-5">Finance</div>
    <a href="{{ route('fuel.index') }}" class="nav-link {{ request()->routeIs('fuel.*') ? 'active' : '' }}"><svg
            class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
        </svg>Fuel Logs</a>
    <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}"><svg
            class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
        </svg>Expenses</a>
    @if(auth()->user()->is_admin)<a href="{{ route('reports.index') }}"
        class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"><svg class="nav-icon" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path
                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
    </svg>Reports</a>@endif
</li>
{{-- Administration --}}
@if(auth()->user()->is_admin)
    <li>
        <div class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500/80 px-6 mb-2 mt-5">Administration</div>
        <a href="{{ route('admin.users.index') }}"
            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><svg class="nav-icon" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>User Management</a>
        <a href="{{ route('admin.activity-log') }}" class="nav-link {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}"><svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Activity Log</a>
    </li>
@endif