@php
    // Define the current route name
    $currentRoute = Route::currentRouteName();
    
    // Define navigation items with their routes
    $navItems = [
        'admin' => [
            'route' => 'admin',
            'name' => 'Dashboard',
            'icon' => 'icon6.svg'
        ],
        'products' => [
            'route' => 'products',
            'name' => 'Products',
            'icon' => 'icon7.svg'
        ],
        'inventory' => [
            'route' => 'inventory',
            'name' => 'Inventory',
            'icon' => 'icon8.svg'
        ],
        'customers' => [
            'route' => 'customers',
            'name' => 'Customers',
            'icon' => 'icon9.svg'
        ],
        'finance' => [
            'route' => 'finance',
            'name' => 'Finance',
            'icon' => 'icon10.svg'
        ],
        'documents' => [
            'route' => 'documents',
            'name' => 'Documents',
            'icon' => 'icon11.svg'
        ]
    ];
@endphp

<div class="admin-sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <img class="logo-image" src="{{ asset('image-roz-med-logo0.png') }}" alt="RozMed Logo">
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
                <img class="nav-icon" src="{{ asset($item['icon']) }}" alt="{{ $item['name'] }}">
                <span class="nav-text">{{ $item['name'] }}</span>
            </a>
        @endforeach
    </nav>
</div>