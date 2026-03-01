@php
    // Define the current route name
    $currentRoute = Route::currentRouteName();
    
    // Define navigation items with their routes
    $navItems = [
        'dashboard' => [
            'route' => 'admin.dashboard',
            'name' => 'Dashboard',
            'icon' => 'images/Icon-6.svg'
        ],
        'products' => [
            'route' => 'admin.products',
            'name' => 'Products',
            'icon' => 'images/Icon-7.svg'
        ],
        'inventory' => [
            'route' => 'admin.inventory',
            'name' => 'Inventory',
            'icon' => 'images/Icon-8.svg'
        ],
        'customers' => [
            'route' => 'admin.customers',
            'name' => 'Customers',
            'icon' => 'images/Icon-9.svg'
        ],
        'finance' => [
            'route' => 'admin.finance',
            'name' => 'Finance',
            'icon' => 'images/Icon-10.svg'
        ],
        'documents' => [
            'route' => 'admin.documents',
            'name' => 'Documents',
            'icon' => 'images/Icon-11.svg'
        ]
    ];

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
                @else
                    <img class="nav-icon" src="{{ asset($item['icon']) }}" alt="{{ $item['name'] }}">
                @endif
                <span class="nav-text">{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>
</div>