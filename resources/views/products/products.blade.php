@vite(['resources/css/products.css'])
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <main class="products-page">
            <!-- Hero Section -->
            <section class="products-hero">
                <div class="container">
                    <h1 class="page-title">Medical Equipment <span class="highlight">Catalog</span></h1>
                    <p class="page-subtitle">
                        Explore our comprehensive range of professional medical equipment
                    </p>
                </div>
            </section>

            <!-- Filters Section -->
            <section class="filters-section">
                <div class="container">
                    <div class="filters-grid">
                        <div class="search-input">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" placeholder="Search equipment..." class="search-field" id="searchInput">
                        </div>
                        
                        <div class="filter-controls">
                            <div class="filter-dropdown">
                                <select class="filter-select" id="categoryFilter">
                                    <option value="">All Categories</option>
                                    @php
                                        $displayCategories = [
                                            'DiagnosticEquipment' => 'Diagnostic Equipment',
                                            'MedicalInstruments' => 'Medical Instruments',
                                            'MonitoringDevices' => 'Monitoring Devices',
                                            'EmergencyEquipment' => 'Emergency Equipment',
                                            'InfusionSystems' => 'Infusion Systems',
                                            'LaboratoryEquipment' => 'Laboratory Equipment'
                                        ];
                                    @endphp
                                    @foreach($displayCategories as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </div>
                            
                            <div class="filter-dropdown">
                                <select class="filter-select" id="statusFilter">
                                    <option value="">Availability</option>
                                    <option value="in-stock">In Stock</option>
                                    <option value="low-stock">Low Stock</option>
                                    <option value="out-of-stock">Out of Stock</option>
                                </select>
                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Products Grid -->
            <section class="products-section">
                <div class="container">
                    <div class="results-header">
                        Showing <span class="highlight" id="visibleCount">{{ count($products) }}</span> of <span id="totalCount">{{ count($products) }}</span> products
                    </div>

                    <div class="products-grid" id="productsGrid">
                        @forelse($products as $product)
                        <div class="product-card" 
                             data-category="{{ $product->Category }}"
                             data-stock="{{ $product->total_stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                            <div class="product-image-container">
                                @if($product->Images_Path)
                                    <img src="{{ asset('storage/' . $product->Images_Path) }}" 
                                         alt="{{ $product->Product_Name }}" 
                                         class="product-img">
                                @else
                                    <div class="placeholder-icon">
                                        <i class="fas fa-microscope"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="product-content">
                                @php
                                    $tagClass = '';
                                    $tagText = '';
                                    $createdDate = \Carbon\Carbon::parse($product->created_at);
                                    $now = \Carbon\Carbon::now();
                                    
                                    if ($createdDate->diffInDays($now) <= 30) {
                                        $tagClass = 'tag-new';
                                        $tagText = 'New Arrival';
                                    } elseif ($product->Unit_Price_PHP > 100000) {
                                        $tagClass = 'tag-featured';
                                        $tagText = 'Featured';
                                    } elseif ($product->Category == 'EmergencyEquipment') {
                                        $tagClass = 'tag-critical';
                                        $tagText = 'Critical Care';
                                    } else {
                                        $tagClass = 'tag-professional';
                                        $tagText = 'Professional';
                                    }

                                    $displayCategory = $displayCategories[$product->Category] ?? $product->Category;
                                @endphp
                                
                                <span class="product-tag {{ $tagClass }}">{{ $tagText }}</span>
                                <h3 class="product-title">{{ $product->Product_Name }}</h3>
                                <p class="product-category">{{ $displayCategory }}</p>

                                <div class="product-footer">
                                    <div class="product-price">₱{{ number_format($product->Unit_Price_PHP, 0) }}</div>
                                    
                                    @php
                                        $stockStatus = $product->total_stock > 0 ? 'in-stock' : 'out-of-stock';
                                        $stockText = $product->total_stock > 0 ? 'In Stock' : 'Out of Stock';
                                        if ($product->total_stock > 0 && $product->total_stock <= $product->Min_Stock_Level) {
                                            $stockStatus = 'low-stock';
                                            $stockText = 'Low Stock';
                                        }
                                    @endphp
                                    <div class="stock-pill {{ $stockStatus }}">
                                        {{ $stockText }}
                                    </div>
                                </div>

                                <div class="card-link-wrapper">
                                    <a href="{{ route('products.show', ['id' => $product->Product_ID]) }}" class="view-details-link">
                                        View Details <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h3>No Equipment Found</h3>
                            <p>Try adjusting your search or filters to find what you're looking for.</p>
                        </div>
                        @endforelse
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
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const productsGrid = document.getElementById('productsGrid');
    const visibleCount = document.getElementById('visibleCount');
    
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
                card.style.display = 'flex'; // Use flex to maintain card stretch
                visibleCards++;
            } else {
                card.style.display = 'none';
            }
        });
        
        visibleCount.textContent = visibleCards;
        
        // Handle empty state visibility
        const currentEmptyState = document.querySelector('.empty-state');
        if (visibleCards === 0) {
            if (!currentEmptyState) {
                const empty = document.createElement('div');
                empty.className = 'empty-state';
                empty.innerHTML = `
                    <i class="fas fa-search"></i>
                    <h3>No Matches Found</h3>
                    <p>Try refining your search or clearing the filters.</p>
                `;
                productsGrid.appendChild(empty);
            }
        } else if (currentEmptyState) {
            currentEmptyState.remove();
        }
    }
    
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    statusFilter.addEventListener('change', filterProducts);
});
</script>
@endpush