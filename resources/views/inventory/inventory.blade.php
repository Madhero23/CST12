@vite(['resources/css/inventory.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Inventory</h1>
        </div>
        
        <div class="admin-inventory">
            <!-- Inventory Dashboard Card -->
            <div class="inventory-dashboard-card">
                <div class="card-header-row">
                    <h2 class="card-title">Inventory Dashboard</h2>
                    <div class="dashboard-actions">
                        <button class="btn-outline" type="button" id="openAgingReportBtn">
                            <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12H15M9 16H15M3 7V17C3 19.2091 4.79086 21 7 21H17C19.2091 21 21 19.2091 21 17V7M3 7L12 3L21 7M3 7L12 11L21 7" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Aging Report</span>
                        </button>
                        <button class="btn-outline" type="button" id="openDailyScanLogBtn">
                            <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5M12 12H15M12 16H15M9 12H9.01M9 16H9.01" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Daily Scan Log</span>
                        </button>
                        <button class="btn-primary" type="button" id="stockInBtn">
                            <svg class="btn-icon-white" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 12V20H4V12M20 12L12 4M20 12H13M12 4L4 12M12 4V12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Record Stock In</span>
                        </button>
                        <button class="btn-primary" type="button" id="stockOutBtn">
                            <svg class="btn-icon-white" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 12V20H4V12M20 12L12 20M20 12H13M12 20L4 12M12 20V12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Record Stock Out</span>
                        </button>
                    </div>
                </div>
                
                <!-- Filters and Search -->
                <div class="inventory-controls">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="inv-search-input" placeholder="Search by item or code...">
                        </div>
                    </div>
                    <div class="filter-container">
                        <select class="inv-status-filter">
                            <option value="all">All Status</option>
                            <option value="good">Good Stock</option>
                            <option value="low">Low Stock</option>
                            <option value="out">Out of Stock</option>
                        </select>
                    </div>
                    <div class="filter-container">
                        <select class="inv-location-filter">
                            <option value="all">All Locations</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->Location_Name }}">{{ $loc->Location_Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Inventory Table -->
                <div class="inventory-table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Value (₱)</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventoryItems as $index => $item)
                            @php
                                $qty = $item->Quantity_On_Hand ?? 0;
                                $minStock = $item->product->Min_Stock_Level ?? 10;
                                if ($qty <= 0) { $status = 'out'; $statusText = 'Out of Stock'; }
                                elseif ($qty <= $minStock) { $status = 'low'; $statusText = 'Low Stock'; }
                                else { $status = 'good'; $statusText = 'Good Stock'; }
                            @endphp
                            <tr class="inventory-row" 
                                data-index="{{ $index }}"
                                data-status="{{ $status }}"
                                data-location="{{ $item->location->Location_Name ?? 'N/A' }}"
                                data-id="{{ $item->product->Product_ID ?? $item->id }}">
                                <td class="code-cell">
                                    <span class="product-code">{{ $item->product->Product_Code ?? '—' }}</span>
                                </td>
                                <td class="item-cell">
                                    <div class="item-name">{{ $item->product->Product_Name ?? 'Unknown' }}</div>
                                </td>
                                <td class="quantity-cell">
                                    <div class="item-quantity">{{ $qty }}</div>
                                </td>
                                <td class="value-cell">
                                    <span class="value-text">₱{{ number_format($item->Value_PHP ?? 0, 2) }}</span>
                                </td>
                                <td class="location-cell">
                                    <div class="item-location">
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.657 16.657L13.414 20.9C12.633 21.681 11.367 21.681 10.586 20.9L6.343 16.657C3.219 13.533 3.219 8.467 6.343 5.343C9.467 2.219 14.533 2.219 17.657 5.343C20.781 8.467 20.781 13.533 17.657 16.657Z" stroke="#235C63" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15 11C15 12.657 13.657 14 12 14C10.343 14 9 12.657 9 11C9 9.343 10.343 8 12 8C13.657 8 15 9.343 15 11Z" stroke="#235C63" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span>{{ $item->location->Location_Name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="status-cell">
                                    <span class="status-badge status-{{ $status }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <button class="action-link transfer-trigger-btn" 
                                            type="button" 
                                            data-product-id="{{ $item->product->Product_ID ?? '' }}"
                                            data-location-id="{{ $item->Location_ID ?? '' }}"
                                            data-quantity="{{ $qty }}"
                                            data-product-name="{{ $item->product->Product_Name ?? 'Unknown' }}"
                                            data-shelf="{{ $item->Shelf ?? '' }}"
                                            data-rack="{{ $item->Rack ?? '' }}"
                                            data-area="{{ $item->Area ?? '' }}">
                                        Update Location
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="empty-state">No inventory items found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Alerts Section (Bottom of Card) -->
                <div class="inventory-alerts">
                    @if(isset($lowStock) && $lowStock->count() > 0)
                    <div class="alert alert-warning">
                        <div class="alert-content">
                            <svg class="alert-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 9V11M12 15H12.01M5.07183 19H18.9282C19.7423 19 20.2105 18.0645 19.7303 17.4087L12.8021 7.94723C12.4239 7.43075 11.5761 7.43075 11.1979 7.94723L4.26973 17.4087C3.78954 18.0645 4.25773 19 5.07183 19Z" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="alert-text">
                                <span class="alert-title">Low Stock Alert</span>
                                <span class="alert-description">{{ $lowStock->count() }} items below threshold</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @php
                        $outOfStockCount = isset($inventoryItems) ? $inventoryItems->filter(function($item) {
                            return ($item->Quantity_On_Hand ?? 0) <= 0;
                        })->count() : 0;
                    @endphp
                    @if($outOfStockCount > 0)
                    <div class="alert alert-danger">
                        <div class="alert-content">
                            <svg class="alert-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#DC2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="alert-text">
                                <span class="alert-title">Replenishment Alert</span>
                                <span class="alert-description">{{ $outOfStockCount }} items need restocking</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Stock Transfer Workflow -->
            <div class="stock-transfer-card">
                <div class="card-header-row">
                    <h3 class="card-title">Stock Transfer Workflow</h3>
                    <button class="btn-primary" type="button" id="newTransferBtn">
                        <span style="font-size: 18px; margin-right: 4px;">+</span>
                        <span>New Transfer</span>
                    </button>
                </div>
                
                <div class="transfer-list">
                    @forelse($transfers as $transfer)
                    <div class="transfer-item" data-id="{{ $transfer->Transaction_ID }}">
                        <div class="transfer-info">
                            <div class="transfer-name">{{ $transfer->product->Product_Name ?? 'Unknown' }}</div>
                            <div class="transfer-route">{{ $transfer->sourceLocation->Location_Name ?? '?' }} &rarr; {{ $transfer->destinationLocation->Location_Name ?? '?' }}</div>
                        </div>
                        <div class="transfer-status status-completed">
                            Completed
                        </div>
                    </div>
                    @empty
                    <div class="transfer-item empty">
                        <div class="transfer-info">
                            <div class="transfer-name">No transfers yet</div>
                            <div class="transfer-route">Click "New Transfer" to create one</div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Load Flatpickr from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    // ========== SHARED MODAL SYSTEM ==========

    function createModal(title, bodyHTML, footerHTML) {
        const overlay = document.createElement('div');
        overlay.className = 'inv-modal-overlay';
        overlay.innerHTML = `
            <div class="inv-modal-content">
                <div class="inv-modal-header">
                    <h3>${title}</h3>
                    <button class="inv-close-modal">&times;</button>
                </div>
                <div class="inv-modal-body">${bodyHTML}</div>
                <div class="inv-modal-footer">${footerHTML}</div>
            </div>
        `;
        document.body.appendChild(overlay);
        requestAnimationFrame(() => overlay.classList.add('show'));

        overlay.querySelectorAll('.inv-close-modal').forEach(btn => {
            btn.addEventListener('click', () => closeModal(overlay));
        });
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay);
        });
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') { closeModal(overlay); document.removeEventListener('keydown', handler); }
        });

        return overlay;
    }

    function closeModal(overlay) {
        overlay.classList.remove('show');
        setTimeout(() => overlay.remove(), 300);
    }

    function showToast(msg, type = 'success') {
        const existing = document.querySelector('.inv-toast');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `inv-toast toast-${type}`;
        toast.innerHTML = `<span>${msg}</span>`;
        document.body.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 300); }, 3000);
    }

    // Product options from server
    const productOptions = `
        <option value="">Select Product</option>
        @foreach($products as $product)
        <option value="{{ $product->Product_ID }}">{{ $product->Product_Name }}</option>
        @endforeach
    `;

    // Location options from server
    const locationOptions = `
        <option value="">Select Location</option>
        @foreach($locations as $location)
        <option value="{{ $location->Location_ID }}">{{ $location->Location_Name }}</option>
        @endforeach
    `;

    // Supplier options from server
    const supplierOptions = `
        <option value="">Select Supplier</option>
        @foreach($suppliers as $supplier)
        <option value="{{ $supplier->Supplier_ID }}">{{ $supplier->Supplier_Name }}</option>
        @endforeach
    `;

    // ========== STOCK IN MODAL ==========

    document.getElementById('stockInBtn')?.addEventListener('click', function() {
        const body = `
            <form id="stockInForm" class="inv-modal-form">
                <div class="inv-form-group">
                    <label>Product <span class="required">*</span></label>
                    <select name="product_id" class="inv-form-select" required>
                        ${productOptions}
                    </select>
                </div>
                
                <div class="inv-form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="inv-form-input" min="1" required value="0">
                </div>

                <div class="inv-form-group">
                    <label>Date</label>
                    <input type="date" name="transaction_date" class="inv-form-input" value="${new Date().toISOString().split('T')[0]}" required>
                </div>

                <div class="inv-form-group">
                    <label>Batch Number</label>
                    <input type="text" name="batch_number" class="inv-form-input" placeholder="Batch or Lot #">
                </div>

                <div class="inv-form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" class="inv-form-select">
                        ${supplierOptions}
                    </select>
                </div>

                <div class="inv-form-group">
                    <label>Receiving Department</label>
                    <input type="text" name="receiving_department" class="inv-form-input" placeholder="Department name">
                </div>

                <div class="inv-form-group">
                    <label>Shelf / Rack / Area</label>
                    <div class="inv-form-row triple">
                        <input type="text" name="shelf" class="inv-form-input" placeholder="Shelf">
                        <input type="text" name="rack" class="inv-form-input" placeholder="Rack">
                        <input type="text" name="area" class="inv-form-input" placeholder="Area">
                    </div>
                </div>

                <div class="inv-form-group">
                    <label>Location (Warehouse) <span class="required">*</span></label>
                    <select name="location_id" class="inv-form-select" required>
                        ${locationOptions}
                    </select>
                </div>

                <div class="inv-form-alert teal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span>Stock will be added to inventory</span>
                </div>

                <div class="inv-form-errors" style="display:none;"></div>
            </form>
        `;
        const footer = `
            <button class="inv-btn secondary inv-close-modal">Cancel</button>
            <button class="inv-btn primary teal-bg" id="submitStockIn">
                <span class="btn-label">Save</span>
            </button>
        `;
        const modal = createModal('Record Stock In', body, footer);

        modal.querySelector('#submitStockIn').addEventListener('click', async function() {
            await submitFormModal(modal, '#stockInForm', '{{ route("admin.inventory.stock-in") }}', 'Stock in recorded!');
        });
    });

    // ========== STOCK OUT MODAL ==========

    document.getElementById('stockOutBtn')?.addEventListener('click', function() {
        const body = `
            <form id="stockOutForm" class="inv-modal-form">
                <div class="inv-form-group">
                    <label>Product <span class="required">*</span></label>
                    <select name="product_id" class="inv-form-select" required>
                        ${productOptions}
                    </select>
                </div>
                
                <div class="inv-form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="inv-form-input" min="1" required value="0">
                </div>

                <div class="inv-form-group">
                    <label>Location (Source) <span class="required">*</span></label>
                    <select name="location_id" class="inv-form-select" required>
                        ${locationOptions}
                    </select>
                </div>

                <div class="inv-form-group">
                    <label>Transaction Date</label>
                    <input type="date" name="transaction_date" class="inv-form-input" value="${new Date().toISOString().split('T')[0]}" required>
                </div>

                <div class="inv-form-group">
                    <label>Reason <span class="required">*</span></label>
                    <input type="text" name="notes" class="inv-form-input" placeholder="e.g., Sale, Damage, Internal Use" required>
                </div>

                <div class="inv-form-alert warning">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Warning: This action will reduce stock to low levels</span>
                </div>

                <div class="inv-form-errors" style="display:none;"></div>
            </form>
        `;
        const footer = `
            <button class="inv-btn secondary inv-close-modal">Cancel</button>
            <button class="inv-btn primary teal-bg" id="submitStockOut">
                <span class="btn-label">Confirm</span>
            </button>
        `;
        const modal = createModal('Record Stock Out', body, footer);

        modal.querySelector('#submitStockOut').addEventListener('click', async function() {
            await submitFormModal(modal, '#stockOutForm', '{{ route("admin.inventory.stock-out") }}', 'Stock out recorded!');
        });
    });
    // ========== STOCK TRANSFER WORKFLOW MODAL ==========

    document.getElementById('newTransferBtn')?.addEventListener('click', function() {
        const body = `
            <form id="transferForm" class="inv-modal-form">
                <div class="inv-form-group">
                    <label>Item <span class="required">*</span></label>
                    <select name="product_id" class="inv-form-select" required>
                        ${productOptions}
                    </select>
                </div>

                <div class="inv-form-group">
                    <label>Source Location <span class="required">*</span></label>
                    <select name="from_location_id" class="inv-form-select" required>
                        ${locationOptions}
                    </select>
                </div>

                <div class="inv-form-group">
                    <label>Destination Location <span class="required">*</span></label>
                    <select name="to_location_id" class="inv-form-select" required>
                        ${locationOptions}
                    </select>
                </div>

                <div class="inv-form-group">
                    <label>Quantity <span class="required">*</span></label>
                    <input type="number" name="quantity" class="inv-form-input" min="1" required placeholder="0">
                </div>

                <div class="inv-form-group">
                    <label>Transfer Date <span class="required">*</span></label>
                    <input type="date" name="transaction_date" class="inv-form-input" required value="${new Date().toISOString().split('T')[0]}">
                </div>

                <div class="inv-form-group">
                    <label>Transfer Notes / Reference</label>
                    <input type="text" name="notes" class="inv-form-input" placeholder="e.g., Transfer to Building B">
                </div>

                <div class="inv-form-alert info">
                    <div class="alert-content">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span>Confirmation dialog will be shown before transfer</span>
                    </div>
                </div>

                <div class="inv-form-errors" style="display:none;"></div>
            </form>
        `;
        const footer = `
            <button class="inv-btn secondary inv-close-modal">Cancel</button>
            <button class="inv-btn primary teal-bg" id="submitTransfer">
                <span class="btn-label">Confirm Transfer</span>
            </button>
        `;
        const modal = createModal('Stock Transfer Workflow', body, footer);

        modal.querySelector('#submitTransfer').addEventListener('click', async function() {
            if (!confirm('Are you sure you want to proceed with this stock transfer? This will immediately update inventory levels in both locations.')) {
                return;
            }
            await submitFormModal(modal, '#transferForm', '{{ route("admin.inventory.transfer") }}', 'Stock transfer initiated!');
        });
    });

    // ========== UPDATE LOCATION (per-row button) ==========

    document.querySelectorAll('.transfer-trigger-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const productId = this.dataset.productId;
            const locationId = this.dataset.locationId;
            const productName = this.dataset.productName;
            const shelf = this.dataset.shelf || '';
            const rack = this.dataset.rack || '';
            const area = this.dataset.area || '';

            const body = `
                <form id="updateLocationForm" class="inv-modal-form">
                    <input type="hidden" name="product_id" value="${productId}">
                    <input type="hidden" name="old_location_id" value="${locationId}">

                    <div class="inv-form-group">
                        <label>Item</label>
                        <input type="text" class="inv-form-input" value="${productName}" readonly style="background-color:#f3f4f6;">
                    </div>

                    <div class="inv-form-group">
                        <label>Warehouse Location</label>
                        <select name="location_id" class="inv-form-select" required>
                            ${locationOptions}
                        </select>
                    </div>

                    <div class="inv-form-group">
                        <label>Shelf</label>
                        <input type="text" name="shelf" class="inv-form-input" value="${shelf}" placeholder="e.g., A1">
                    </div>

                    <div class="inv-form-group">
                        <label>Rack</label>
                        <input type="text" name="rack" class="inv-form-input" value="${rack}" placeholder="e.g., R5">
                    </div>

                    <div class="inv-form-group">
                        <label>Area / Section</label>
                        <input type="text" name="area" class="inv-form-input" value="${area}" placeholder="e.g., Section B">
                    </div>

                    <div class="inv-form-group">
                        <label>Update Date</label>
                        <input type="date" name="transaction_date" class="inv-form-input" value="${new Date().toISOString().split('T')[0]}" required>
                    </div>

                    <div class="inv-form-group">
                        <label>Notes</label>
                        <input type="text" name="notes" class="inv-form-input" placeholder="e.g., Reorganized shelf">
                    </div>

                    <div class="inv-form-errors" style="display:none;"></div>
                </form>
            `;
            const footer = `
                <button class="inv-btn secondary inv-close-modal">Cancel</button>
                <button class="inv-btn primary teal-bg" id="submitUpdateLocation">
                    <span class="btn-label">Update Location</span>
                </button>
            `;
            const modal = createModal('Update Location', body, footer);

            // Pre-select current location
            const locSelect = modal.querySelector('select[name="location_id"]');
            if (locSelect) locSelect.value = locationId;

            modal.querySelector('#submitUpdateLocation').addEventListener('click', async function() {
                await submitFormModal(modal, '#updateLocationForm', '{{ route("admin.inventory.update-location") }}', 'Location updated!');
            });
        });
    });

    // ========== AGING REPORT MODAL ==========

    document.getElementById('openAgingReportBtn')?.addEventListener('click', function() {
        let itemsHTML = '';
        @if(isset($agingReport) && count($agingReport) > 0)
            @foreach($agingReport as $item)
            itemsHTML += `
                <div class="aging-card">
                    <div class="aging-card-header">
                        <span class="aging-card-title">{{ addslashes($item->product->Product_Name ?? 'Unknown Product') }}</span>
                        <span class="aging-tag">Aging Stock</span>
                    </div>
                    <div class="aging-details">
                        <div class="aging-detail-row">
                            <span class="aging-label">Mfg Date:</span>
                            <span class="aging-value">{{ $item->Manufacturing_Date ? $item->Manufacturing_Date->format('Y-m-d') : 'N/A' }}</span>
                        </div>
                        <div class="aging-detail-row">
                            <span class="aging-label">Received:</span>
                            <span class="aging-value">{{ $item->Received_Date ? $item->Received_Date->format('Y-m-d') : 'N/A' }}</span>
                        </div>
                        <div class="aging-detail-row">
                            <span class="aging-label">Location:</span>
                            <span class="aging-value">{{ addslashes($item->location->Location_Name ?? 'N/A') }}</span>
                        </div>
                        <div class="aging-detail-row">
                            <span class="aging-label">Qty:</span>
                            <span class="aging-value">{{ $item->Quantity_On_Hand ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            `;
            @endforeach
        @endif

        if (!itemsHTML) {
            itemsHTML = '<div style="text-align:center;padding:2rem;color:#6b7280;">No aging stock found.</div>';
        }

        const body = `
            <div class="aging-report-container">
                <div class="aging-alert">
                    <svg class="aging-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span class="aging-alert-text">Items older than 6 months with low turnover</span>
                </div>
                ${itemsHTML}
            </div>
        `;
        createModal('Aging Inventory Report', body, `<button class="inv-btn secondary inv-close-modal">Close</button>`);
    });

    // ========== DAILY SCAN LOG MODAL ==========

    // ========== DAILY SCAN LOG MODAL ==========

    document.getElementById('openDailyScanLogBtn')?.addEventListener('click', async function() {
        const modalBody = `
            <div class="scan-log-container">
                <div class="scan-log-filter">
                    <input type="date" class="scan-log-input" id="scanLogDate" value="${new Date().toISOString().split('T')[0]}">
                    <button class="btn-teal" id="loadScansBtn">Load Scans</button>
                </div>
                <div class="scan-log-list" id="scanLogList">
                    <div style="text-align:center;padding:2rem;color:#64748b;">Loading today's scans...</div>
                </div>
            </div>
        `;

        const modalFooter = `
            <div class="scan-log-footer">
                <button class="btn-export" id="exportCsvBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Export CSV
                </button>
                <button class="inv-btn secondary inv-close-modal">Close</button>
            </div>
        `;

        const modal = createModal('Daily Scan Log', modalBody, modalFooter);
        
        const loadLogs = async (date) => {
            const listContainer = document.getElementById('scanLogList');
            listContainer.innerHTML = '<div style="text-align:center;padding:2rem;color:#64748b;">Loading scans...</div>';
            
            try {
                const response = await fetch(`/admin/inventory/scan-logs?date=${date}`);
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    listContainer.innerHTML = result.data.map(log => `
                        <div class="scan-log-card">
                            <div class="scan-log-time">${log.time}</div>
                            <div class="scan-log-details">
                                <span class="scan-log-text">${log.product} ${log.type === 'StockIn' ? 'received' : (log.type === 'StockOut' ? 'dispatched' : 'scanned')}</span>
                                <br>
                                <span class="scan-log-location">at ${log.location}</span>
                            </div>
                        </div>
                    `).join('');
                } else {
                    listContainer.innerHTML = '<div style="text-align:center;padding:2rem;color:#64748b;">No scan logs found for this date.</div>';
                }
            } catch (err) {
                listContainer.innerHTML = '<div style="text-align:center;padding:2rem;color:#dc2626;">Error loading logs.</div>';
            }
        };

        // Initial load
        loadLogs(new Date().toISOString().split('T')[0]);

        // Event Listeners for modal elements
        const loadScansBtn = document.getElementById('loadScansBtn');
        const scanLogDate = document.getElementById('scanLogDate');
        
        loadScansBtn.addEventListener('click', () => {
            loadLogs(scanLogDate.value);
        });

        document.getElementById('exportCsvBtn').addEventListener('click', () => {
             showToast('CSV Exporting is coming soon!', 'info');
        });
    });

    // ========== FORM SUBMISSION HELPER ==========

    async function submitFormModal(modal, formSelector, url, successMsg) {
        const form = modal.querySelector(formSelector);
        const errorsDiv = modal.querySelector('.inv-form-errors');
        const submitBtn = modal.querySelector('.inv-btn.primary');
        const label = submitBtn.querySelector('.btn-label');
        const originalLabel = label?.textContent;

        errorsDiv.style.display = 'none';
        errorsDiv.innerHTML = '';

        if (!form.checkValidity()) { form.reportValidity(); return; }

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        submitBtn.disabled = true;
        if (label) label.textContent = 'Saving...';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok && (result.success || result.message)) {
                showToast(successMsg, 'success');
                closeModal(modal);
                setTimeout(() => window.location.reload(), 500);
            } else {
                if (result.errors) {
                    errorsDiv.innerHTML = Object.values(result.errors).flat().join('<br>');
                } else {
                    errorsDiv.innerHTML = result.message || 'Operation failed.';
                }
                errorsDiv.style.display = 'block';
            }
        } catch (err) {
            errorsDiv.innerHTML = 'Network error. Please try again.';
            errorsDiv.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            if (label) label.textContent = originalLabel;
        }
    }

    // ========== TABLE ANIMATIONS ==========

    document.querySelectorAll('.inventory-row').forEach((row, i) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = 'all 0.3s ease';
        setTimeout(() => { row.style.opacity = '1'; row.style.transform = 'translateY(0)'; }, i * 80 + 200);
    });

    // ========== UNIFIED FILTER FUNCTION ==========

    function applyInventoryFilters() {
        const searchTerm = document.querySelector('.inv-search-input')?.value.toLowerCase() || '';
        const selectedStatus = document.querySelector('.inv-status-filter')?.value || 'all';
        const selectedLocation = document.querySelector('.inv-location-filter')?.value || 'all';
        const rows = document.querySelectorAll('.inventory-row');

        rows.forEach(row => {
            const itemName = row.querySelector('.item-name')?.textContent.toLowerCase() || '';
            const productCode = row.querySelector('.product-code')?.textContent.toLowerCase() || '';
            const rowStatus = row.dataset.status;
            const rowLocation = row.dataset.location;

            const matchesSearch = !searchTerm || itemName.includes(searchTerm) || productCode.includes(searchTerm);
            const matchesStatus = selectedStatus === 'all' || selectedStatus === rowStatus;
            const matchesLocation = selectedLocation === 'all' || selectedLocation === rowLocation;

            if (matchesSearch && matchesStatus && matchesLocation) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.querySelector('.inv-search-input')?.addEventListener('input', applyInventoryFilters);
    document.querySelector('.inv-status-filter')?.addEventListener('change', applyInventoryFilters);
    document.querySelector('.inv-location-filter')?.addEventListener('change', applyInventoryFilters);

    document.querySelectorAll('.action-btn, .transfer-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-2px)'; });
        btn.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0)'; });
    });

    document.querySelectorAll('.transfer-item').forEach(item => {
        item.addEventListener('mouseenter', function() { this.style.transform = 'translateX(5px)'; });
        item.addEventListener('mouseleave', function() { this.style.transform = 'translateX(0)'; });
    });
});
</script>

<style>
.inv-modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
    z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
}
.inv-modal-overlay.show { opacity: 1; visibility: visible; }
.inv-modal-content {
    background: #fff; border-radius: 16px; width: 90%; max-width: 560px;
    max-height: 90vh; overflow-y: auto;
    transform: translateY(-20px); transition: transform 0.3s ease;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
.inv-modal-overlay.show .inv-modal-content { transform: translateY(0); }
.inv-modal-header {
    padding: 20px 24px; border-bottom: 1px solid #e5e7eb;
    display: flex; justify-content: space-between; align-items: center;
}
.inv-modal-header h3 { margin: 0; color: #235c63; font-size: 18px; }
.inv-close-modal {
    background: none; border: none; font-size: 24px; color: #6b7280;
    cursor: pointer; width: 32px; height: 32px; display: flex;
    align-items: center; justify-content: center; border-radius: 50%;
    transition: all 0.2s;
}
.inv-close-modal:hover { background: #f3f4f6; color: #374151; }
.inv-modal-body { padding: 24px; }
.inv-modal-footer {
    padding: 16px 24px; border-top: 1px solid #e5e7eb;
    display: flex; justify-content: flex-end; gap: 12px;
}
.inv-modal-form .inv-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.inv-form-group { margin-bottom: 16px; }
.inv-form-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #374151; font-size: 14px; }
.inv-form-group .required { color: #ef4444; }
.inv-form-input, .inv-form-select, .inv-form-textarea {
    width: 100%; padding: 10px 12px; border: 1px solid #d1d5db;
    border-radius: 8px; font-size: 14px; transition: border-color 0.2s;
    box-sizing: border-box;
}
.inv-form-input:focus, .inv-form-select:focus, .inv-form-textarea:focus {
    outline: none; border-color: #2f7a85; box-shadow: 0 0 0 3px rgba(47,122,133,0.1);
}
.inv-form-errors {
    background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px;
    padding: 12px 16px; color: #dc2626; font-size: 14px;
}
.inv-btn {
    padding: 10px 20px; border-radius: 8px; border: none;
    font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s;
}
.inv-btn.primary { background: #2f7a85; color: #fff; }
.inv-btn.primary:hover { background: #235c63; }
.inv-btn.primary:disabled { background: #9ca3af; cursor: not-allowed; }
.inv-btn.secondary { background: #f3f4f6; color: #374151; }
.inv-btn.secondary:hover { background: #e5e7eb; }

.inv-report-table { width: 100%; border-collapse: collapse; }
.inv-report-table th, .inv-report-table td {
    padding: 10px 12px; text-align: left; border-bottom: 1px solid #f3f4f6; font-size: 14px;
}
.inv-report-table th { font-weight: 600; color: #374151; background: #f9fafb; }

.inv-toast {
    position: fixed; top: 20px; right: 20px; padding: 12px 20px;
    border-radius: 8px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transform: translateX(calc(100% + 20px)); transition: transform 0.3s;
    z-index: 1001; font-size: 14px;
}
.inv-toast.show { transform: translateX(0); }
.toast-success { border-left: 4px solid #10b981; color: #065f46; }
.toast-error { border-left: 4px solid #ef4444; color: #991b1b; }


.inv-form-row.triple {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 12px;
}

.inv-form-alert.teal {
    background: #EBF7F8;
    color: #235C63;
    border-left: 4px solid #64B5B9;
    padding: 14px 16px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    margin-top: 20px;
}

.inv-btn.primary.teal-bg {
    background-color: #64B5B9;
}

.inv-btn.primary.teal-bg:hover {
    background-color: #4A9A9E;
}

.inv-form-alert.warning {
    background: #FFFBEB;
    color: #92400E;
    border-left: 4px solid #F59E0B;
    padding: 14px 16px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    margin-top: 20px;
}

@media (max-width: 640px) {
    .inv-modal-form .inv-form-row { grid-template-columns: 1fr; }
    .inv-modal-content { width: 95%; }
    .inv-form-row.triple { grid-template-columns: 1fr; }
}
</style>
