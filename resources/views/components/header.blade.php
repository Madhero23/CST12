<header class="header">
    <div class="header-container">
        <div class="header-logo">
            <img class="image-roz-med-logo" src="{{ asset('image-roz-med-logo1.png') }}" alt="RozMed Logo" />
            <div class="logo-text">
                <div class="logo-main">
                    <span class="roz">Roz</span>
                    <span class="med">MED</span>
                </div>
                <div class="logo-subtitle">ENTERPRISE, INC.</div>
            </div>
        </div>
        <nav class="navigation">
            @php
                $currentRoute = Route::currentRouteName();
                $routes = [
                    'home' => ['route' => 'home.index', 'text' => 'Home'],
                    'products' => ['route' => 'products.index', 'text' => 'Products'],
                    'about' => ['route' => 'about', 'text' => 'About Us'],
                    'contact' => ['route' => 'contact.index', 'text' => 'Contact']
                ];
            @endphp
            
            @foreach($routes as $key => $route)
                <a href="{{ route($route['route']) }}" 
                   class="nav-link {{ $currentRoute == $route['route'] || ($key == 'home' && $currentRoute == null) ? 'active' : '' }}">
                    {{ $route['text'] }}
                </a>
            @endforeach
        </nav>
    </div>
</header>