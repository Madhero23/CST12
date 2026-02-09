@vite(['resources/css/inventory.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <header class="dashboard-header">
            <h1 class="dashboard-title">Inventory</h1>
        </header>
        
        <div class="admin-inventory">
            <!-- Inventory Dashboard -->
            <div class="inventory-dashboard-card">
                <div class="dashboard-header">
                    <h2 class="dashboard-subtitle">Inventory Dashboard</h2>
                    <div class="dashboard-actions">
                        <button class="action-btn" type="button" id="openAgingReportBtn">
                            <img class="btn-icon" src="{{ asset('icon7.svg') }}" alt="Aging Report">
                            <span>Aging Report</span>
                        </button>
                        <button class="action-btn" type="button" id="openDailyScanLogBtn">
                            <img class="btn-icon" src="{{ asset('icon8.svg') }}" alt="Daily Scan Log">
                            <span>Daily Scan Log</span>
                        </button>
                        <button class="action-btn primary" type="button" id="stockInBtn">
                            <img class="btn-icon" src="{{ asset('icon9.svg') }}" alt="Record Stock In">
                            <span>Record Stock In</span>
                        </button>
                        <button class="action-btn primary" type="button" id="stockOutBtn">
                            <img class="btn-icon" src="{{ asset('icon10.svg') }}" alt="Record Stock Out">
                            <span>Record Stock Out</span>
                        </button>
                    </div>
                </div>
                
                <!-- Inventory Table -->
                <div class="inventory-table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $inventoryItems = [
                                    [
                                        'id' => 'MED-001',
                                        'name' => 'Portable Ultrasound Machine',
                                        'quantity' => 15,
                                        'location' => 'Warehouse A',
                                        'location_icon' => 'icon11.svg',
                                        'status' => 'good',
                                        'status_text' => 'Good Stock'
                                    ],
                                    [
                                        'id' => 'MED-002',
                                        'name' => 'Patient Monitor',
                                        'quantity' => 3,
                                        'location' => 'Warehouse B',
                                        'location_icon' => 'icon12.svg',
                                        'status' => 'low',
                                        'status_text' => 'Low Stock'
                                    ],
                                    [
                                        'id' => 'MED-003',
                                        'name' => 'Surgical Instruments Set',
                                        'quantity' => 8,
                                        'location' => 'Warehouse C',
                                        'location_icon' => 'icon13.svg',
                                        'status' => 'good',
                                        'status_text' => 'Good Stock'
                                    ],
                                    [
                                        'id' => 'MED-004',
                                        'name' => 'Digital Thermometer',
                                        'quantity' => 0,
                                        'location' => 'Warehouse A',
                                        'location_icon' => 'icon14.svg',
                                        'status' => 'out',
                                        'status_text' => 'Out of Stock'
                                    ],
                                    [
                                        'id' => 'MED-005',
                                        'name' => 'Blood Pressure Monitor',
                                        'quantity' => 2,
                                        'location' => 'Warehouse B',
                                        'location_icon' => 'icon15.svg',
                                        'status' => 'low',
                                        'status_text' => 'Low Stock'
                                    ]
                                ];
                            @endphp
                            
                            @foreach($inventoryItems as $index => $item)
                            <tr class="inventory-row" 
                                data-index="{{ $index }}"
                                data-status="{{ $item['status'] }}"
                                data-id="{{ $item['id'] }}">
                                <td class="item-cell">
                                    <div class="item-name">{{ $item['name'] }}</div>
                                </td>
                                <td class="quantity-cell">
                                    <div class="item-quantity">{{ $item['quantity'] }}</div>
                                </td>
                                <td class="location-cell">
                                    <div class="item-location">
                                        <img class="location-icon" src="{{ asset($item['location_icon']) }}" alt="{{ $item['location'] }}">
                                        <span>{{ $item['location'] }}</span>
                                    </div>
                                </td>
                                <td class="status-cell">
                                    <span class="status-badge status-{{ $item['status'] }}">
                                        {{ $item['status_text'] }}
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <button class="update-btn" 
                                            type="button" 
                                            data-item-id="{{ $item['id'] }}"
                                            data-item-name="{{ $item['name'] }}">
                                        Update Location
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Alerts Section -->
                <div class="inventory-alerts">
                    <div class="alert alert-warning">
                        <div class="alert-content">
                            <img class="alert-icon" src="{{ asset('icon16.svg') }}" alt="Low Stock Alert">
                            <div class="alert-text">
                                <div class="alert-title">Low Stock Alert</div>
                                <div class="alert-description">2 items below threshold</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-danger">
                        <div class="alert-content">
                            <img class="alert-icon" src="{{ asset('icon17.svg') }}" alt="Replenishment Alert">
                            <div class="alert-text">
                                <div class="alert-title">Replenishment Alert</div>
                                <div class="alert-description">3 items need restocking</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stock Transfer Workflow -->
            <div class="stock-transfer-card">
                <div class="transfer-header">
                    <h3 class="transfer-title">Stock Transfer Workflow</h3>
                    <button class="transfer-btn primary" type="button" id="newTransferBtn">
                        <img class="btn-icon" src="{{ asset('icon18.svg') }}" alt="New Transfer">
                        <span>New Transfer</span>
                    </button>
                </div>
                
                <div class="transfer-list">
                    @php
                        $transfers = [
                            [
                                'id' => 'TRF-001',
                                'item' => 'Patient Monitor',
                                'from_to' => 'Warehouse A → Warehouse B',
                                'status' => 'completed',
                                'status_text' => 'Completed'
                            ],
                            [
                                'id' => 'TRF-002',
                                'item' => 'Surgical Instruments Set',
                                'from_to' => 'Warehouse B → Warehouse C',
                                'status' => 'pending',
                                'status_text' => 'Pending'
                            ]
                        ];
                    @endphp
                    
                    @foreach($transfers as $transfer)
                    <div class="transfer-item" data-id="{{ $transfer['id'] }}">
                        <div class="transfer-info">
                            <div class="transfer-name">{{ $transfer['item'] }}</div>
                            <div class="transfer-route">{{ $transfer['from_to'] }}</div>
                        </div>
                        <div class="transfer-status status-{{ $transfer['status'] }}">
                            {{ $transfer['status_text'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Load Flatpickr from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Simplified Modal JavaScript -->
<script>
// Inventory Modals Manager
window.InventoryModals = {
    modals: {},
    
    init: function() {
        console.log('Initializing Inventory Modals...');
        
        // Initialize all modals
        this.initializeModal('dailyScanLog', 'openDailyScanLogBtn');
        this.initializeModal('agingReport', 'openAgingReportBtn');
        this.initializeModal('stockIn', 'stockInBtn');
        this.initializeModal('stockOut', 'stockOutBtn');
        this.initializeModal('stockTransfer', 'newTransferBtn');
        
        // Initialize table interactions
        this.initializeTableInteractions();
        
        // Initialize update location buttons
        this.initializeUpdateButtons();
        
        console.log('Inventory Modals initialized successfully');
    },
    
    initializeModal: function(modalName, buttonId) {
        const button = document.getElementById(buttonId);
        if (!button) {
            console.warn(`Button ${buttonId} not found for modal ${modalName}`);
            return;
        }
        
        button.addEventListener('click', () => {
            this.openModal(modalName);
        });
    },
    
    openModal: function(modalName) {
        console.log(`Opening ${modalName} modal`);
        
        // Show loading animation on button
        const button = event.currentTarget;
        button.classList.add('loading');
        
        setTimeout(() => {
            button.classList.remove('loading');
            
            // In a real app, this would open the actual modal
            // For now, we'll show a console message
            this.showToast(`${modalName.replace(/([A-Z])/g, ' $1').trim()} modal opened`, 'info');
            
            // Simulate modal opening
            this.simulateModalOpen(modalName);
        }, 300);
    },
    
    simulateModalOpen: function(modalName) {
        // Create a temporary modal overlay
        const modalOverlay = document.createElement('div');
        modalOverlay.className = 'modal-overlay';
        modalOverlay.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${modalName.replace(/([A-Z])/g, ' $1').trim()}</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>This is the ${modalName.replace(/([A-Z])/g, ' $1').trim()} modal. In a real implementation, this would contain the actual modal content.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn secondary close-modal">Close</button>
                    <button class="btn primary">Confirm</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modalOverlay);
        
        // Add animation
        setTimeout(() => {
            modalOverlay.classList.add('show');
        }, 10);
        
        // Close button events
        modalOverlay.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
            });
        });
        
        // Close on overlay click
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
            }
        });
        
        // Close on Escape key
        const escapeHandler = (e) => {
            if (e.key === 'Escape') {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                    document.removeEventListener('keydown', escapeHandler);
                }, 300);
            }
        };
        document.addEventListener('keydown', escapeHandler);
    },
    
    initializeTableInteractions: function() {
        const rows = document.querySelectorAll('.inventory-row');
        
        rows.forEach(row => {
            // Hover effects
            row.addEventListener('mouseenter', () => {
                row.classList.add('hovered');
            });
            
            row.addEventListener('mouseleave', () => {
                row.classList.remove('hovered');
            });
            
            // Click to view details (optional)
            row.addEventListener('click', (e) => {
                if (!e.target.closest('.update-btn')) {
                    const itemId = row.getAttribute('data-id');
                    const itemName = row.querySelector('.item-name').textContent;
                    console.log(`Viewing details for: ${itemName} (${itemId})`);
                    this.showItemDetails(itemId);
                }
            });
        });
    },
    
    initializeUpdateButtons: function() {
        const updateButtons = document.querySelectorAll('.update-btn');
        
        updateButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                
                const itemId = btn.getAttribute('data-item-id');
                const itemName = btn.getAttribute('data-item-name');
                
                // Button click animation
                btn.classList.add('clicked');
                setTimeout(() => {
                    btn.classList.remove('clicked');
                }, 300);
                
                // Show update location modal
                this.showUpdateLocationModal(itemId, itemName);
            });
        });
    },
    
    showItemDetails: function(itemId) {
        // In a real app, this would open a details modal
        this.showToast(`Viewing details for item ${itemId}`, 'info');
    },
    
    showUpdateLocationModal: function(itemId, itemName) {
        // Create update location modal
        const modalOverlay = document.createElement('div');
        modalOverlay.className = 'modal-overlay';
        modalOverlay.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Update Location for: ${itemName}</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newLocation">New Location</label>
                        <select id="newLocation" class="form-select">
                            <option value="">Select Location</option>
                            <option value="warehouse_a">Warehouse A</option>
                            <option value="warehouse_b">Warehouse B</option>
                            <option value="warehouse_c">Warehouse C</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="locationNotes">Notes (Optional)</label>
                        <textarea id="locationNotes" class="form-textarea" placeholder="Add any notes about this location change..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn secondary close-modal">Cancel</button>
                    <button class="btn primary" id="saveLocationBtn">Update Location</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modalOverlay);
        
        // Add animation
        setTimeout(() => {
            modalOverlay.classList.add('show');
        }, 10);
        
        // Save button event
        const saveBtn = modalOverlay.querySelector('#saveLocationBtn');
        saveBtn.addEventListener('click', () => {
            const newLocation = modalOverlay.querySelector('#newLocation').value;
            const notes = modalOverlay.querySelector('#locationNotes').value;
            
            if (!newLocation) {
                this.showToast('Please select a location', 'error');
                return;
            }
            
            // Show loading state
            saveBtn.classList.add('loading');
            saveBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                saveBtn.classList.remove('loading');
                saveBtn.disabled = false;
                
                // Close modal
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
                
                // Show success message
                this.showToast(`Location updated for ${itemName}`, 'success');
                
                // In a real app, update the UI
                console.log(`Updated ${itemName} to location ${newLocation}`);
            }, 1500);
        });
        
        // Close button events
        modalOverlay.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
            });
        });
        
        // Close on overlay click
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('show');
                setTimeout(() => {
                    modalOverlay.remove();
                }, 300);
            }
        });
    },
    
    showToast: function(message, type = 'info') {
        // Remove existing toast
        const existingToast = document.querySelector('.inventory-toast');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Create toast
        const toast = document.createElement('div');
        toast.className = `inventory-toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <span class="toast-message">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Add animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    },
    
    // Helper methods
    formatNumber: function(num) {
        return new Intl.NumberFormat().format(num);
    },
    
    capitalizeFirst: function(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    InventoryModals.init();
    
    // Add hover effects to action buttons
    document.querySelectorAll('.action-btn, .transfer-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add hover effects to transfer items
    document.querySelectorAll('.transfer-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>

<!-- Temporary modal styles (can be moved to CSS) -->
<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.modal-overlay.show .modal-content {
    transform: translateY(0);
}

.modal-header {
    padding: 20px 24px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    color: #235c63;
    font-size: 20px;
}

.close-modal {
    background: none;
    border: none;
    font-size: 24px;
    color: #6b7280;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.close-modal:hover {
    background: #f3f4f6;
    color: #374151;
}

.modal-body {
    padding: 24px;
}

.modal-footer {
    padding: 20px 24px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn.primary {
    background: #2f7a85;
    color: white;
}

.btn.primary:hover {
    background: #235c63;
}

.btn.secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn.secondary:hover {
    background: #e5e7eb;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #374151;
}

.form-select,
.form-textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.2s ease;
}

.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #2f7a85;
    box-shadow: 0 0 0 3px rgba(47, 122, 133, 0.1);
}

.form-textarea {
    min-height: 100px;
    resize: vertical;
}

.inventory-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    padding: 12px 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateX(calc(100% + 20px));
    transition: transform 0.3s ease;
    z-index: 1001;
    border-left: 4px solid #2f7a85;
}

.inventory-toast.show {
    transform: translateX(0);
}

.toast-info {
    border-left-color: #3b82f6;
}

.toast-success {
    border-left-color: #10b981;
}

.toast-error {
    border-left-color: #ef4444;
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 8px;
}

.toast-message {
    font-size: 14px;
    color: #374151;
}

.loading {
    position: relative;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-top: -8px;
    margin-left: -8px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>