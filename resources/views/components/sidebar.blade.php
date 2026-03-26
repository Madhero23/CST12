{{--
    Sidebar Component — Role-based navigation (FR-AUTH-06)

    Pre-existing state: Showed ALL nav items unconditionally.
    Changes: Added role-based conditionals so each role only sees relevant modules.
    Added logout button at bottom.

    Roles:
    - Admin / SystemAdmin: sees ALL modules
    - SalesStaff: Dashboard + Customers only
    - FinanceStaff: Dashboard + Finance only
    - InventoryManager: Dashboard + Inventory + Products
--}}

@php
    $currentRoute = Route::currentRouteName();
    $role = Auth::user()->Role ?? null;

    // Define all navigation items
    $allNavItems = [
        'dashboard' => [
            'route' => 'admin.dashboard',
            'name' => 'Dashboard',
            'roles' => ['Admin', 'SystemAdmin', 'SalesStaff', 'FinanceStaff', 'InventoryManager'],
        ],
        'products' => [
            'route' => 'admin.products',
            'name' => 'Products',
            'roles' => ['Admin', 'SystemAdmin', 'InventoryManager'],
        ],
        'inventory' => [
            'route' => 'admin.inventory',
            'name' => 'Inventory',
            'roles' => ['Admin', 'SystemAdmin', 'InventoryManager'],
        ],
        'customers' => [
            'route' => 'admin.customers',
            'name' => 'Customers',
            'roles' => ['Admin', 'SystemAdmin', 'SalesStaff'],
        ],
        'finance' => [
            'route' => 'admin.finance',
            'name' => 'Finance',
            'roles' => ['Admin', 'SystemAdmin', 'FinanceStaff'],
        ],
        'documents' => [
            'route' => 'admin.documents',
            'name' => 'Documents',
            'roles' => ['Admin', 'SystemAdmin'],
        ],
    ];

    // Filter nav items based on current user's role
    $navItems = array_filter($allNavItems, function ($item) use ($role) {
        return in_array($role, $item['roles']);
    });
@endphp

<div class="admin-sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img class="logo-image" src="{{ asset('images/rozmed image.png') }}" alt="RozMed Logo">
            <div class="logo-text">
                <div class="logo-main">
                    <span class="roz">Roz</span>
                    <span class="med">MED</span>
                </div>
                <div class="logo-subtitle">ENTERPRISE, INC.</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-navigation">
        @foreach($navItems as $key => $item)
            <a href="{{ route($item['route']) }}"
               class="nav-item {{ $currentRoute === $item['route'] ? 'active' : '' }}">
                @if($key === 'dashboard')
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                @elseif($key === 'products')
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                @elseif($key === 'inventory')
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73V8z"></path><path d="M3.27 6.96 12 12.01l8.73-5.05"></path><path d="M12 22.08V12"></path></svg>
                @elseif($key === 'customers')
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                @elseif($key === 'finance')
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                @elseif($key === 'documents')
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                @endif
                <span class="nav-text">{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- Logout Button --}}
    <div class="sidebar-footer" style="padding: 1rem 1.25rem; margin-top: auto; border-top: 1px solid rgba(95, 177, 183, 0.15);">
        @auth
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.75rem; padding: 0.5rem 0;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #2f7a85, #5fb1b7); display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: 600;">
                    {{ strtoupper(substr(Auth::user()->Full_Name ?? Auth::user()->Username, 0, 1)) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ Auth::user()->Full_Name ?? Auth::user()->Username }}
                    </div>
                    <div style="font-size: 11px; color: #64748b;">{{ Auth::user()->Role }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left; color: #ef4444; font-family: inherit; font-size: 14px;">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="nav-text">Logout</span>
                </button>
            </form>
        @endauth
    </div>
</div>