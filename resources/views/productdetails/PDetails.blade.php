@vite(['resources/css/PDetails.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <header class="dashboard-header">
            <h1 class="dashboard-title">Products</h1>
        </header>
        
        <div class="admin-products">
            <!-- Header Section -->
            <div class="products-header">
                <h2 class="products-main-title">Products</h2>
            </div>
            
            <!-- Product Management Section -->
            <div class="product-management-card">
                <div class="management-header">
                    <h3 class="management-title">Product Management</h3>
                </div>
                
                <!-- Filters and Actions -->
                <div class="management-controls">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <img class="search-icon" src="{{ asset('icon0.svg') }}" alt="Search">
                            <input type="text" class="search-input" placeholder="Search products...">
                        </div>
                    </div>
                    
                    <div class="filter-container">
                        <select class="category-filter">
                            <option value="all">All Categories</option>
                            <option value="diagnostic">Diagnostic Equipment</option>
                            <option value="monitoring">Monitoring Equipment</option>
                            <option value="surgical">Surgical Equipment</option>
                        </select>
                    </div>
                    
                    <button class="add-product-btn">
                        <img class="btn-icon" src="{{ asset('icon1.svg') }}" alt="Add">
                        <span>Add Product</span>
                    </button>
                </div>
                
                <!-- Products Table -->
                <div class="products-table-wrapper">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th class="table-header-cell">Product Name</th>
                                <th class="table-header-cell">Category</th>
                                <th class="table-header-cell">Availability</th>
                                <th class="table-header-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $products = [
                                    [
                                        'name' => 'Portable Ultrasound Machine',
                                        'category' => 'Diagnostic Equipment',
                                        'availability' => 'in-stock',
                                        'availability_text' => 'In Stock'
                                    ],
                                    [
                                        'name' => 'Patient Monitor',
                                        'category' => 'Monitoring Equipment',
                                        'availability' => 'low-stock',
                                        'availability_text' => 'Low Stock'
                                    ],
                                    [
                                        'name' => 'Surgical Instruments Set',
                                        'category' => 'Surgical Equipment',
                                        'availability' => 'in-stock',
                                        'availability_text' => 'In Stock'
                                    ],
                                    [
                                        'name' => 'Digital Thermometer',
                                        'category' => 'Diagnostic Equipment',
                                        'availability' => 'out-of-stock',
                                        'availability_text' => 'Out of Stock'
                                    ],
                                    [
                                        'name' => 'Portable Ultrasound Machine',
                                        'category' => 'Diagnostic Equipment',
                                        'availability' => 'in-stock',
                                        'availability_text' => 'In Stock'
                                    ],
                                    [
                                        'name' => 'Patient Monitor',
                                        'category' => 'Monitoring Equipment',
                                        'availability' => 'low-stock',
                                        'availability_text' => 'Low Stock'
                                    ],
                                    [
                                        'name' => 'Surgical Instruments Set',
                                        'category' => 'Surgical Equipment',
                                        'availability' => 'in-stock',
                                        'availability_text' => 'In Stock'
                                    ],
                                    [
                                        'name' => 'Digital Thermometer',
                                        'category' => 'Diagnostic Equipment',
                                        'availability' => 'out-of-stock',
                                        'availability_text' => 'Out of Stock'
                                    ],
                                ];
                            @endphp
                            
                            @foreach($products as $index => $product)
                            <tr class="table-row" data-animation-delay="{{ $index * 0.1 }}">
                                <td class="table-cell product-name-cell">
                                    <span class="product-name">{{ $product['name'] }}</span>
                                </td>
                                <td class="table-cell category-cell">
                                    <span class="category-text">{{ $product['category'] }}</span>
                                </td>
                                <td class="table-cell availability-cell">
                                    <span class="availability-badge {{ $product['availability'] }}">
                                        {{ $product['availability_text'] }}
                                    </span>
                                </td>
                                <td class="table-cell actions-cell">
                                    <div class="action-buttons">
                                        <button class="action-btn edit-btn" title="Edit">
                                            <img src="{{ asset('icon' . ($index * 2 + 2) . '.svg') }}" alt="Edit">
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete">
                                            <img src="{{ asset('icon' . ($index * 2 + 3) . '.svg') }}" alt="Delete">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Table row animation
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        const delay = row.getAttribute('data-animation-delay') || 0;
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, delay * 1000);
    });
    
    // Add product button animation
    const addProductBtn = document.querySelector('.add-product-btn');
    addProductBtn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 10px 20px rgba(47, 122, 133, 0.3)';
    });
    
    addProductBtn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '0 4px 12px rgba(47, 122, 133, 0.2)';
    });
    
    // Action buttons hover effects
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Row hover effects
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(95, 177, 183, 0.05)';
            this.style.transform = 'translateX(5px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'translateX(0)';
        });
    });
    
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.table-row');
        
        rows.forEach(row => {
            const productName = row.querySelector('.product-name').textContent.toLowerCase();
            const category = row.querySelector('.category-text').textContent.toLowerCase();
            
            if (productName.includes(searchTerm) || category.includes(searchTerm)) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Category filter functionality
    const categoryFilter = document.querySelector('.category-filter');
    categoryFilter.addEventListener('change', function() {
        const selectedCategory = this.value;
        const rows = document.querySelectorAll('.table-row');
        
        rows.forEach(row => {
            const category = row.querySelector('.category-text').textContent.toLowerCase();
            
            if (selectedCategory === 'all' || 
                (selectedCategory === 'diagnostic' && category.includes('diagnostic')) ||
                (selectedCategory === 'monitoring' && category.includes('monitoring')) ||
                (selectedCategory === 'surgical' && category.includes('surgical'))) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Add product button click
    addProductBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Ripple effect
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: ripple 0.6s linear;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            z-index: 1;
        `;
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
        
        // Show add product modal (you can implement this)
        console.log('Add product clicked');
    });
    
    // Edit/Delete button clicks
    const editBtns = document.querySelectorAll('.edit-btn');
    const deleteBtns = document.querySelectorAll('.delete-btn');
    
    editBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const productName = this.closest('.table-row').querySelector('.product-name').textContent;
            console.log('Edit product:', productName);
            // Implement edit functionality
        });
    });
    
    deleteBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const productName = this.closest('.table-row').querySelector('.product-name').textContent;
            console.log('Delete product:', productName);
            // Implement delete functionality with confirmation
        });
    });
});
</script>
@endpush