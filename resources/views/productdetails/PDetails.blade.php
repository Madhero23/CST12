@vite(['resources/css/PDetails.css'])
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <!-- Header Section -->
        <div class="products-page-header">
            <h1 class="products-main-title">Products</h1>
        </div>
        
        <div class="admin-products">
            
            <!-- Product Management Section -->
            <div class="product-management-card">
                <div class="management-header">
                    <h3 class="management-title">Product Management</h3>
                </div>
                
                <!-- Filters and Actions -->
                <div class="management-controls">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="search-input" placeholder="Search products...">
                        </div>
                    </div>
                    
                    <div class="filter-container">
                        <select class="category-filter">
                            <option value="all">All Categories</option>
                            @php
                                $categories = [
                                    'DiagnosticEquipment' => 'Diagnostic Equipment',
                                    'MedicalInstruments' => 'Medical Instruments',
                                    'MonitoringDevices' => 'Monitoring Devices',
                                    'EmergencyEquipment' => 'Emergency Equipment',
                                    'InfusionSystems' => 'Infusion Systems',
                                    'LaboratoryEquipment' => 'Laboratory Equipment'
                                ];
                            @endphp
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-container">
                        <select class="status-filter">
                            <option value="all">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Discontinued">Discontinued</option>
                        </select>
                    </div>
                    
                    <button class="add-product-btn">
                        <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Product</span>
                    </button>
                </div>
                
                <!-- Products Table -->
                <div class="products-table-wrapper">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th class="table-header-cell">Product Code</th>
                                <th class="table-header-cell">Product Name</th>
                                <th class="table-header-cell">Category</th>
                                <th class="table-header-cell">Price (₱)</th>
                                <th class="table-header-cell">Status</th>
                                <th class="table-header-cell">Availability</th>
                                <th class="table-header-cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                            <tr class="table-row" data-product-id="{{ $product->Product_ID }}" data-category="{{ $product->Category }}" data-status="{{ $product->Status }}">
                                <td class="table-cell code-cell">
                                    <span class="product-code">{{ $product->Product_Code ?? '—' }}</span>
                                </td>
                                <td class="table-cell product-name-cell">
                                    <span class="product-name">{{ $product->Product_Name }}</span>
                                </td>
                                <td class="table-cell category-cell">
                                    <span class="category-text">{{ $categories[$product->Category] ?? $product->Category }}</span>
                                </td>
                                <td class="table-cell price-cell">
                                    <span class="price-text">₱{{ number_format($product->Unit_Price_PHP, 2) }}</span>
                                </td>
                                <td class="table-cell status-cell">
                                    @php
                                        $statusClass = match($product->Status) {
                                            'Active' => 'status-active',
                                            'Inactive' => 'status-inactive',
                                            'Discontinued' => 'status-discontinued',
                                            default => 'status-active',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $product->Status }}</span>
                                </td>
                                <td class="table-cell availability-cell">
                                    @php
                                        $stockQty = $product->inventories->sum('Quantity_On_Hand');
                                        $minStock = $product->Min_Stock_Level ?? 10;
                                        $availabilityClass = 'in-stock';
                                        $availabilityText = 'In Stock (' . $stockQty . ')';
                                        
                                        if ($stockQty <= 0) {
                                            $availabilityClass = 'out-of-stock';
                                            $availabilityText = 'Out of Stock';
                                        } elseif ($stockQty <= $minStock) {
                                            $availabilityClass = 'low-stock';
                                            $availabilityText = 'Low Stock (' . $stockQty . ')';
                                        }
                                    @endphp
                                    <span class="availability-badge {{ $availabilityClass }}">
                                        {{ $availabilityText }}
                                    </span>
                                </td>
                                <td class="table-cell actions-cell">
                                    <div class="action-buttons">
                                        <button class="action-btn edit-btn" title="Edit" data-product-id="{{ $product->Product_ID }}">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2F7A85" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        <button class="action-btn delete-btn" title="Delete" data-product-id="{{ $product->Product_ID }}">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="no-results">
                                    No products found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content add-modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Add New Product</h2>
            <button class="modal-close" onclick="closeModal('addProductModal')">&times;</button>
        </div>
        
        <form id="addProductForm" class="modal-form" enctype="multipart/form-data">
            @csrf
            
            <div class="form-row">
                <div class="form-group flex-1">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="Product_Name" class="form-input" placeholder="Enter product name" required>
                </div>
                <div class="form-group flex-1">
                    <label class="form-label">Product Code (SKU)</label>
                    <input type="text" name="Product_Code" class="form-input" placeholder="Auto-generated if empty">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group flex-1">
                    <label class="form-label">Category</label>
                    <div class="select-wrapper">
                        <select name="Category" class="form-select" required>
                            <option value="" disabled selected>Select Category...</option>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group flex-1">
                    <label class="form-label">Status</label>
                    <div class="select-wrapper">
                        <select name="Status" class="form-select" required>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Discontinued">Discontinued</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group flex-1">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="Unit_Price_PHP" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <div class="form-group flex-1">
                    <label class="form-label">Initial Stock</label>
                    <input type="number" name="Stock_Quantity" class="form-input" placeholder="Quantity" min="0" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Product Image</label>
                <input type="file" name="product_image" class="form-input file-input" accept="image/jpeg,image/png">
                <small class="form-hint">JPG or PNG, max 2MB</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="Description" class="form-textarea" placeholder="Product description..." rows="3" required></textarea>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addProductModal')">Cancel</button>
                <button type="submit" class="btn-submit">Add Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content edit-modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Edit Product</h2>
            <button class="modal-close" onclick="closeModal('editProductModal')">&times;</button>
        </div>
        
        <form id="editProductForm" class="modal-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div id="edit_error_summary" style="display: none; background-color: #fef2f2; border: 1px solid #f87171; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px; font-size: 14px;"></div>
            <input type="hidden" id="edit_product_id" name="product_id">
            
            <div class="form-row">
                <div class="form-group flex-1">
                    <label class="form-label">Product Name</label>
                    <input type="text" id="edit_product_name" name="Product_Name" class="form-input" placeholder="Enter product name" required>
                </div>
                <div class="form-group flex-1">
                    <label class="form-label">Product Code (SKU)</label>
                    <input type="text" id="edit_product_code" name="Product_Code" class="form-input" placeholder="Product Code" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group flex-1">
                    <label class="form-label">Category</label>
                    <div class="select-wrapper">
                        <select id="edit_category" name="Category" class="form-select" required>
                            <option value="" disabled>Select Category...</option>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group flex-1">
                    <label class="form-label">Status</label>
                    <div class="select-wrapper">
                        <select id="edit_status" name="Status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Discontinued">Discontinued</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group flex-1">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" id="edit_price_php" name="Unit_Price_PHP" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <div class="form-group flex-1">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" id="edit_stock_quantity" name="Stock_Quantity" class="form-input" placeholder="Quantity" min="0" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Product Image</label>
                <input type="file" name="product_image" class="form-input file-input" accept="image/jpeg,image/png">
                <small class="form-hint">JPG or PNG, max 2MB. Leave empty to keep current image.</small>
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="edit_description" name="Description" class="form-textarea" placeholder="Product description..." rows="3" required></textarea>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editProductModal')">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Product Modal -->
<div id="deleteProductModal" class="modal" style="display: none;">
    <div class="modal-overlay"></div>
    <div class="modal-content delete-modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Confirm Delete</h2>
            <button class="modal-close" onclick="closeModal('deleteProductModal')">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="warning-alert">
                <div class="warning-icon-wrapper">
                    <svg class="warning-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 9V11M12 15H12.01M5.07183 19H18.9282C20.4678 19 21.4301 17.3333 20.6603 16L13.7321 4C12.9623 2.66667 11.0378 2.66667 10.268 4L3.33975 16C2.56995 17.3333 3.5322 19 5.07183 19Z" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="warning-content">
                    <h4 class="warning-title">Warning</h4>
                    <p class="warning-text">Are you sure you want to delete <strong id="delete_product_name"></strong>? This action cannot be undone.</p>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeModal('deleteProductModal')">Cancel</button>
            <button type="button" class="btn-delete" id="confirmDeleteBtn">Delete</button>
        </div>
    </div>
</div>

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: relative;
    background: white;
    border-radius: 12px;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #1f2937;
}

.modal-close {
    background: none;
    border: none;
    font-size: 2rem;
    color: #6b7280;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
}

.modal-close:hover {
    background: #f3f4f6;
    color: #1f2937;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: border-color 0.2s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #2f7a85;
    box-shadow: 0 0 0 3px rgba(47, 122, 133, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.btn-primary,
.btn-secondary,
.btn-danger {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: #2f7a85;
    color: white;
}

.btn-primary:hover {
    background: #26646d;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

.btn-danger {
    background: #dc2626;
    color: white;
}

.btn-danger:hover {
    background: #b91c1c;
}

.text-warning {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}
</style>



<script>
// Modal helper functions
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    // Reset forms when closing
    const modal = document.getElementById(modalId);
    const form = modal.querySelector('form');
    if (form) {
        form.reset();
    }
}

// Close modal when clicking overlay
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        const modal = e.target.closest('.modal');
        if (modal) {
            modal.style.display = 'none';
        }
    }
});

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
    
    // Unified filter function — combines search, category, and status
    function applyFilters() {
        const searchTerm = document.querySelector('.search-input').value.toLowerCase();
        const selectedCategory = document.querySelector('.category-filter').value;
        const selectedStatus = document.querySelector('.status-filter').value;
        const rows = document.querySelectorAll('.table-row');
        
        let visibleCount = 0;
        rows.forEach(row => {
            const productName = row.querySelector('.product-name').textContent.toLowerCase();
            const productCode = row.querySelector('.product-code')?.textContent.toLowerCase() || '';
            const category = row.querySelector('.category-text').textContent.toLowerCase();
            const rowCategory = row.dataset.category;
            const rowStatus = row.dataset.status;
            
            const matchesSearch = !searchTerm || productName.includes(searchTerm) || productCode.includes(searchTerm) || category.includes(searchTerm);
            const matchesCategory = selectedCategory === 'all' || selectedCategory === rowCategory;
            const matchesStatus = selectedStatus === 'all' || selectedStatus === rowStatus;
            
            if (matchesSearch && matchesCategory && matchesStatus) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // FR-PC-03: Show empty state message when no products match the filter
        let emptyRow = document.querySelector('.no-results-filter');
        if (visibleCount === 0 && rows.length > 0) {
            if (!emptyRow) {
                const tbody = document.querySelector('.products-table tbody');
                emptyRow = document.createElement('tr');
                emptyRow.className = 'no-results-filter';
                emptyRow.innerHTML = '<td colspan="7" class="no-results">No products found matching your search.</td>';
                tbody.appendChild(emptyRow);
            }
        } else if (emptyRow) {
            emptyRow.remove();
        }
    }
    
    // Attach filter listeners
    document.querySelector('.search-input').addEventListener('input', applyFilters);
    document.querySelector('.category-filter').addEventListener('change', applyFilters);
    document.querySelector('.status-filter').addEventListener('change', applyFilters);
    
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
        
        // Show add product modal
        document.getElementById('addProductModal').style.display = 'flex';
    });
    
    // Edit/Delete button clicks
    const editBtns = document.querySelectorAll('.edit-btn');
    const deleteBtns = document.querySelectorAll('.delete-btn');
    
    editBtns.forEach(btn => {
        btn.addEventListener('click', async function() {
            const productId = this.getAttribute('data-product-id');
            const submitBtn = this;
            const originalContent = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span>';
            
            try {
                const response = await fetch(`/admin/products/${productId}/edit`, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                    throw new Error(`Failed to fetch product details (Status: ${response.status})`);
                }

                const product = await response.json();
                
                if (product) {
                    document.getElementById('edit_product_id').value = product.Product_ID;
                    document.getElementById('edit_product_name').value = product.Product_Name;
                    document.getElementById('edit_product_code').value = product.Product_Code || '';
                    document.getElementById('edit_category').value = product.Category;
                    document.getElementById('edit_description').value = product.Description || '';
                    document.getElementById('edit_price_php').value = product.Unit_Price_PHP;
                    document.getElementById('edit_stock_quantity').value = product.Stock_Quantity || 0;
                    document.getElementById('edit_status').value = product.Status || 'Active';
                    
                    document.getElementById('editProductModal').style.display = 'flex';
                }
            } catch (error) {
                console.error('Error fetching product:', error);
                alert('Failed to load product details.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            }
        });
    });
    
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productName = this.closest('.table-row').querySelector('.product-name').textContent;
            
            document.getElementById('delete_product_name').textContent = productName;
            document.getElementById('confirmDeleteBtn').setAttribute('data-product-id', productId);
            
            // Show delete modal
            document.getElementById('deleteProductModal').style.display = 'flex';
        });
    });
    
    // Add Product Form Submission
    document.getElementById('addProductForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';
        
        try {
            const response = await fetch('{{ route("admin.products.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('Product added successfully!');
                closeModal('addProductModal');
                location.reload(); // Reload to show new product
            } else {
                alert('Error: ' + (data.message || 'Failed to add product'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Add Product';
        }
    });
    
    // Edit Product Form Submission
    document.getElementById('editProductForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('edit_product_id').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT'); // Explicitly append method for Laravel method spoofing
        
        // Hide previous errors
        const errorSummary = document.getElementById('edit_error_summary');
        if (errorSummary) errorSummary.style.display = 'none';

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        try {
            const response = await fetch(`/admin/products/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                alert(data.message);
                closeModal('editProductModal');
                if (!data.no_changes) {
                    location.reload();
                }
            } else if (response.status === 422) {
                // Validation Error Handling
                let errorHtml = '<strong>Please fix the following validation errors:</strong><ul style="margin-top: 5px; margin-bottom: 0; padding-left: 20px;">';
                for (let field in data.errors) {
                    errorHtml += `<li>${data.errors[field][0]}</li>`;
                }
                errorHtml += '</ul>';
                
                if (errorSummary) {
                    errorSummary.innerHTML = errorHtml;
                    errorSummary.style.display = 'block';
                } else {
                    alert('Validation Error:\n' + Object.values(data.errors).map(e => e[0]).join('\n'));
                }
            } else {
                alert('Error: ' + (data.message || 'Failed to update product'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Save Changes';
        }
    });
    
    // Delete Product Confirmation
    document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
        const productId = this.getAttribute('data-product-id');
        this.disabled = true;
        this.textContent = 'Deleting...';
        
        try {
            const response = await fetch(`/admin/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('Product deleted successfully!');
                closeModal('deleteProductModal');
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to delete product'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        } finally {
            this.disabled = false;
            this.textContent = 'Delete Product';
        }
    });
});
</script>

