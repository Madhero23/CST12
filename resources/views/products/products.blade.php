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
                                <input type="text" placeholder="Search equipment..." class="search-field" id="searchInput">
                                <img src="{{ asset('icon0.svg') }}" alt="Search" class="search-icon">
                            </div>
                        </div>
                        
                        <div class="filter-dropdown">
                            <select class="filter-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                @foreach(['Hospital Equipment', 'Pharmacy Supplies', 'Nursing Items', 'EMS Equipment', 'Laboratory Equipment', 'Dental Equipment'] as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-dropdown">
                            <select class="filter-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="in-stock">In Stock</option>
                                <option value="low-stock">Low Stock</option>
                                <option value="out-of-stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Products Grid -->
            <section class="products-section">
                <div class="container">
                    <div class="products-grid" id="productsGrid">
                        @forelse($products as $product)
                        <div class="product-card" 
                             data-category="{{ $product->Category }}"
                             data-stock="{{ $product->Min_Stock_Level > 0 ? 'in-stock' : 'out-of-stock' }}">
                            <div class="product-image">
                                @if($product->Images_Path)
                                    <img src="{{ asset('storage/' . $product->Images_Path) }}" 
                                         alt="{{ $product->Product_Name }}" 
                                         class="product-img">
                                @else
                                    <img src="{{ asset('default-product.jpg') }}" 
                                         alt="{{ $product->Product_Name }}" 
                                         class="product-img">
                                @endif
                                
                                @php
                                    // Determine badge based on product attributes
                                    $badge = '';
                                    $badgeText = '';
                                    $createdDate = \Carbon\Carbon::parse($product->Created_Date);
                                    $now = \Carbon\Carbon::now();
                                    
                                    if ($createdDate->diffInDays($now) <= 30) {
                                        $badge = 'new-arrival';
                                        $badgeText = 'New Arrival';
                                    } elseif ($product->Unit_Price_PHP > 100000) {
                                        $badge = 'featured';
                                        $badgeText = 'Featured';
                                    } elseif ($product->Category == 'EMS Equipment') {
                                        $badge = 'critical-care';
                                        $badgeText = 'Critical Care';
                                    } else {
                                        $badge = 'professional';
                                        $badgeText = 'Professional';
                                    }
                                @endphp
                                
                                <div class="product-badge badge-{{ $badge }}">
                                    {{ $badgeText }}
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title">{{ $product->Product_Name }}</h3>
                                <p class="product-category">{{ $product->Category }}</p>
                                <div class="product-info">
                                    <span class="product-price">₱{{ number_format($product->Unit_Price_PHP, 2) }}</span>
                                    @php
                                        $stockStatus = $product->Min_Stock_Level > 0 ? 'in-stock' : 'out-of-stock';
                                        $stockText = $product->Min_Stock_Level > 0 ? 'In Stock' : 'Out of Stock';
                                    @endphp
                                    <span class="product-status status-{{ $stockStatus }}">
                                        {{ $stockText }}
                                    </span>
                                </div>
                                <a href="{{ route('product.details', ['id' => $product->Product_ID]) }}" 
                                   class="product-btn" 
                                   data-product="{{ $product->Product_Name }}">
                                    <span>View Details</span>
                                    <img src="{{ asset('icon3.svg') }}" alt="View Details" class="btn-icon">
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="no-products">
                            <p>No products found. Please check back later.</p>
                        </div>
                        @endforelse
                    </div>
                    
                    <div class="products-count">
                        <p class="count-text">
                            Showing <span class="highlight" id="visibleCount">{{ count($products) }}</span> 
                            of <span class="highlight" id="totalCount">{{ count($products) }}</span> products
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
        if (button) {
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
            });
        }
    });
    
    // Filter functionality
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const productsGrid = document.getElementById('productsGrid');
    const visibleCount = document.getElementById('visibleCount');
    const totalCount = document.getElementById('totalCount');
    
    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        const status = statusFilter.value;
        const allCards = document.querySelectorAll('.product-card');
        let visibleCards = 0;
        
        allCards.forEach(card => {
            const title = card.querySelector('.product-title').textContent.toLowerCase();
            const productCategory = card.getAttribute('data-category');
            const stockStatus = card.getAttribute('data-stock');
            
            const matchesSearch = !searchTerm || title.includes(searchTerm);
            const matchesCategory = !category || productCategory === category;
            const matchesStatus = !status || stockStatus === status;
            
            if (matchesSearch && matchesCategory && matchesStatus) {
                card.style.display = 'block';
                visibleCards++;
            } else {
                card.style.display = 'none';
            }
        });
        
        visibleCount.textContent = visibleCards;
        
        // Show message if no products found
        if (visibleCards === 0) {
            const noProducts = document.querySelector('.no-products');
            if (!noProducts) {
                const message = document.createElement('div');
                message.className = 'no-products';
                message.innerHTML = '<p>No products match your criteria. Try different filters.</p>';
                productsGrid.appendChild(message);
            }
        } else {
            const noProducts = document.querySelector('.no-products');
            if (noProducts) noProducts.remove();
        }
    }
    
    // Event listeners for filters
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    statusFilter.addEventListener('change', filterProducts);
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
    
    .no-products {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 12px;
        color: #6c757d;
        font-size: 1.1rem;
    }
    
    .no-products p {
        margin: 0;
    }
`;
document.head.appendChild(style);
</script>
@endpush