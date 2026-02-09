@vite(['resources/css/products.css'])
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <main class="products-page">
            <!-- Hero Section -->
            <section class="products-hero">
                <div class="container">
                    <h1 class="page-title">Medical Equipment Catalog</h1>
                    <p class="page-subtitle">
                        Explore our comprehensive range of professional medical equipment
                    </p>
                </div>
            </section>

            <!-- Filters Section -->
            <section class="filters-section">
                <div class="container">
                    <div class="filters-grid">
                        <div class="search-container">
                            <div class="search-input">
                                <input type="text" placeholder="Search equipment..." class="search-field">
                                <img src="{{ asset('icon0.svg') }}" alt="Search" class="search-icon">
                            </div>
                        </div>
                        
                        <div class="filter-dropdown">
                            <select class="filter-select">
                                <option value="">All Categories</option>
                                <option value="monitoring">Monitoring Devices</option>
                                <option value="diagnostic">Diagnostic Equipment</option>
                                <option value="instruments">Medical Instruments</option>
                                <option value="emergency">Emergency Equipment</option>
                                <option value="infusion">Infusion Systems</option>
                            </select>
                        </div>
                        
                        <div class="filter-dropdown">
                            <select class="filter-select">
                                <option value="">Availability</option>
                                <option value="in-stock">In Stock</option>
                                <option value="out-of-stock">Out of Stock</option>
                                <option value="new-arrival">New Arrival</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Products Grid -->
            <section class="products-section">
                <div class="container">
                    <div class="products-grid">
                        @php
                            $products = [
                                [
                                    'id' => 1,
                                    'image' => 'container18.png',
                                    'badge' => 'featured',
                                    'badgeText' => 'Featured',
                                    'title' => 'Digital Microscope Pro',
                                    'category' => 'Diagnostic Equipment',
                                    'price' => '₱699,450',
                                    'status' => 'in-stock',
                                    'statusText' => 'In Stock',
                                    'icon' => 'icon3.svg',
                                    'description' => 'High-resolution digital microscope with advanced imaging capabilities for precise diagnostics and research applications.'
                                ],
                                [
                                    'id' => 2,
                                    'image' => 'container21.png',
                                    'badge' => 'best-seller',
                                    'badgeText' => 'Best Seller',
                                    'title' => 'Professional Stethoscope',
                                    'category' => 'Medical Instruments',
                                    'price' => '₱13,945',
                                    'status' => 'in-stock',
                                    'statusText' => 'In Stock',
                                    'icon' => 'icon4.svg',
                                    'description' => 'Professional-grade stethoscope with exceptional acoustic performance for accurate auscultation.'
                                ],
                                [
                                    'id' => 3,
                                    'image' => 'container13.png',
                                    'badge' => 'new-arrival',
                                    'badgeText' => 'New Arrival',
                                    'title' => 'ECG Monitor System',
                                    'category' => 'Monitoring Devices',
                                    'price' => '₱503,945',
                                    'status' => 'in-stock',
                                    'statusText' => 'In Stock',
                                    'icon' => 'icon2.svg',
                                    'description' => 'Advanced ECG monitoring system with real-time cardiac analysis and multi-parameter tracking.'
                                ],
                                [
                                    'id' => 4,
                                    'image' => 'container24.png',
                                    'badge' => 'critical-care',
                                    'badgeText' => 'Critical Care',
                                    'title' => 'Defibrillator AED',
                                    'category' => 'Emergency Equipment',
                                    'price' => '₱895,945',
                                    'status' => 'out-of-stock',
                                    'statusText' => 'Out of Stock',
                                    'icon' => 'icon6.svg',
                                    'description' => 'Automated External Defibrillator for emergency cardiac care with voice prompts and CPR feedback.'
                                ],
                                [
                                    'id' => 5,
                                    'image' => 'container27.png',
                                    'badge' => 'popular',
                                    'badgeText' => 'Popular',
                                    'title' => 'Infrared Thermometer',
                                    'category' => 'Diagnostic Equipment',
                                    'price' => '₱4,981',
                                    'status' => 'in-stock',
                                    'statusText' => 'In Stock',
                                    'icon' => 'icon8.svg',
                                    'description' => 'Non-contact infrared thermometer for accurate temperature measurement with instant results.'
                                ],
                                [
                                    'id' => 6,
                                    'image' => 'container30.png',
                                    'badge' => 'professional',
                                    'badgeText' => 'Professional',
                                    'title' => 'Automated Syringe Pump',
                                    'category' => 'Infusion Systems',
                                    'price' => '₱195,945',
                                    'status' => 'in-stock',
                                    'statusText' => 'In Stock',
                                    'icon' => 'icon9.svg',
                                    'description' => 'Precision syringe pump for controlled medication delivery with multiple infusion modes.'
                                ]
                            ];
                        @endphp
                        
                        @foreach($products as $index => $product)
                        <div class="product-card" data-index="{{ $index }}">
                            <div class="product-image">
                                <img src="{{ asset($product['image']) }}" alt="{{ $product['title'] }}" class="product-img">
                                <div class="product-badge badge-{{ $product['badge'] }}">
                                    {{ $product['badgeText'] }}
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title">{{ $product['title'] }}</h3>
                                <p class="product-category">{{ $product['category'] }}</p>
                                <div class="product-info">
                                    <span class="product-price">{{ $product['price'] }}</span>
                                    <span class="product-status status-{{ $product['status'] }}">
                                        {{ $product['statusText'] }}
                                    </span>
                                </div>
                                <a href="{{ route('product.details', ['id' => $product['id']]) }}" 
                                   class="product-btn" 
                                   data-product="{{ $product['title'] }}">
                                    <span>View Details</span>
                                    <img src="{{ asset($product['icon']) }}" alt="View Details" class="btn-icon">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="products-count">
                        <p class="count-text">
                            Showing <span class="highlight">{{ count($products) }}</span> of {{ count($products) }} products
                        </p>
                    </div>
                </div>
            </section>
        </main>

        @include('components.footer')
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Product card hover animations
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 6px -4px rgba(0, 0, 0, 0.1), 0 10px 15px -3px rgba(0, 0, 0, 0.1)';
        });
        
        // Add click animation for the "View Details" link
        const button = card.querySelector('.product-btn');
        button.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(95, 177, 183, 0.4);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                z-index: 1;
            `;
            
            this.appendChild(ripple);
            
            // Remove ripple after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
            
            // Add loading state
            this.style.pointerEvents = 'none';
            setTimeout(() => {
                this.style.pointerEvents = 'auto';
            }, 600);
        });
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-field');
    const productCardsAll = document.querySelectorAll('.product-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        
        productCardsAll.forEach(card => {
            const title = card.querySelector('.product-title').textContent.toLowerCase();
            const category = card.querySelector('.product-category').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || category.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCount++;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // Update product count
        document.querySelector('.highlight').textContent = visibleCount;
    });
    
    // Filter functionality
    const categoryFilter = document.querySelectorAll('.filter-select')[0];
    const availabilityFilter = document.querySelectorAll('.filter-select')[1];
    
    function applyFilters() {
        const selectedCategory = categoryFilter.value;
        const selectedAvailability = availabilityFilter.value;
        let visibleCount = 0;
        
        productCardsAll.forEach(card => {
            const category = card.querySelector('.product-category').textContent.toLowerCase().replace(' ', '-');
            const status = card.querySelector('.product-status').classList.contains('status-in-stock') ? 'in-stock' : 
                          card.querySelector('.product-status').classList.contains('status-out-of-stock') ? 'out-of-stock' : 
                          'new-arrival';
            
            const categoryMatch = !selectedCategory || category.includes(selectedCategory);
            const availabilityMatch = !selectedAvailability || status === selectedAvailability;
            
            if (categoryMatch && availabilityMatch) {
                card.style.display = 'block';
                visibleCount++;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // Update product count
        document.querySelector('.highlight').textContent = visibleCount;
    }
    
    categoryFilter.addEventListener('change', applyFilters);
    availabilityFilter.addEventListener('change', applyFilters);
});

// Add CSS animation for ripple effect
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .product-btn {
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(style);
</script>
@endpush