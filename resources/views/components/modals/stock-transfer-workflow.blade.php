<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div id="stockTransferModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="stock-transfer-title">
  <div class="modal-content new-transfer">
    <!-- Modal Header -->
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="stock-transfer-workflow" id="stock-transfer-title">Stock Transfer Workflow</div>
          <div class="modal-subtitle">Transfer inventory between locations</div>
        </div>
      </div>
      <button class="modal-close-btn" type="button" id="closeStockTransferModalBtn" aria-label="Close modal">
        <img class="icon" src="{{ asset('icon0.svg') }}" alt="Close" />
      </button>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">
      <form id="stockTransferForm" class="transfer-form">
        <!-- Product Selection -->
        <div class="form-group">
          <label for="transferProduct" class="form-label required">
            <div class="label-text">Item</div>
          </label>
          <div class="custom-select">
            <select id="transferProduct" name="product_id" class="form-select" required>
              <option value="" disabled selected>Select Product...</option>
              @php
                $transferProducts = [
                  ['id' => 'MED-001', 'name' => 'Portable Ultrasound Machine', 'locations' => ['Warehouse A', 'Warehouse B']],
                  ['id' => 'MED-002', 'name' => 'Patient Monitor', 'locations' => ['Warehouse B', 'Warehouse C']],
                  ['id' => 'MED-003', 'name' => 'Surgical Instruments Set', 'locations' => ['Warehouse C', 'Warehouse A']],
                  ['id' => 'MED-004', 'name' => 'Digital Thermometer', 'locations' => ['Warehouse A']],
                  ['id' => 'MED-005', 'name' => 'Blood Pressure Monitor', 'locations' => ['Warehouse B', 'Warehouse C']],
                  ['id' => 'MED-006', 'name' => 'X-Ray Machine', 'locations' => ['Warehouse C']],
                ];
              @endphp
              @foreach($transferProducts as $product)
              <option value="{{ $product['id'] }}" data-locations="{{ json_encode($product['locations']) }}">
                {{ $product['id'] }} - {{ $product['name'] }}
              </option>
              @endforeach
            </select>
            <div class="select-arrow">▼</div>
          </div>
          <div class="input-hint">Select product to transfer</div>
        </div>
        
        <!-- Product Details -->
        <div class="product-transfer-details hidden" id="productTransferDetails">
          <div class="details-grid">
            <div class="detail-item">
              <span class="detail-label">Available Stock:</span>
              <span class="detail-value" id="availableStock">0</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Current Location:</span>
              <span class="detail-value" id="currentLocation">N/A</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Status:</span>
              <span class="detail-value" id="productStatus">N/A</span>
            </div>
          </div>
        </div>
        
        <!-- Source Location -->
        <div class="form-group">
          <label for="sourceLocation" class="form-label required">
            <div class="label-text">Source Location</div>
          </label>
          <div class="custom-select">
            <select id="sourceLocation" name="source_location" class="form-select" required>
              <option value="" disabled selected>Select Source Warehouse...</option>
              @php
                $warehouses = ['Warehouse A', 'Warehouse B', 'Warehouse C', 'Warehouse D'];
              @endphp
              @foreach($warehouses as $warehouse)
              <option value="{{ strtolower(str_replace(' ', '_', $warehouse)) }}">{{ $warehouse }}</option>
              @endforeach
            </select>
            <div class="select-arrow">▼</div>
          </div>
          <div class="input-hint">Where the stock is currently located</div>
        </div>
        
        <!-- Destination Location -->
        <div class="form-group">
          <label for="destinationLocation" class="form-label required">
            <div class="label-text">Destination Location</div>
          </label>
          <div class="custom-select">
            <select id="destinationLocation" name="destination_location" class="form-select" required>
              <option value="" disabled selected>Select Destination Warehouse...</option>
              @foreach($warehouses as $warehouse)
              <option value="{{ strtolower(str_replace(' ', '_', $warehouse)) }}">{{ $warehouse }}</option>
              @endforeach
            </select>
            <div class="select-arrow">▼</div>
          </div>
          <div class="input-hint">Where the stock will be transferred to</div>
        </div>
        
        <!-- Transfer Path Visualization -->
        <div class="transfer-path hidden" id="transferPath">
          <div class="path-container">
            <div class="path-source" id="pathSource">Source</div>
            <div class="path-arrow">
              <div class="arrow-line"></div>
              <div class="arrow-head">→</div>
            </div>
            <div class="path-destination" id="pathDestination">Destination</div>
          </div>
          <div class="path-distance" id="pathDistance">Distance: Calculating...</div>
        </div>
        
        <!-- Quantity Input -->
        <div class="form-group">
          <label for="transferQuantity" class="form-label required">
            <div class="label-text">Quantity</div>
          </label>
          <div class="quantity-transfer-container">
            <button type="button" class="quantity-btn minus" id="decreaseTransferQuantity" aria-label="Decrease quantity">
              <span>-</span>
            </button>
            <input type="number" 
                   id="transferQuantity" 
                   name="quantity" 
                   class="quantity-input" 
                   min="1" 
                   value="1"
                   required>
            <button type="button" class="quantity-btn plus" id="increaseTransferQuantity" aria-label="Increase quantity">
              <span>+</span>
            </button>
          </div>
          <div class="input-hint">Quantity to transfer</div>
          <div class="quantity-availability" id="quantityAvailability">
            <span class="availability-text">Available: <span id="availableQty">0</span> units</span>
            <div class="availability-bar">
              <div class="availability-fill" id="availabilityFill"></div>
            </div>
          </div>
        </div>
        
        <!-- Transfer Date -->
        <div class="form-group">
          <label for="transferDate" class="form-label required">
            <div class="label-text">Transfer Date</div>
          </label>
          <input type="text" 
                 id="transferDate" 
                 name="transfer_date" 
                 class="date-input" 
                 placeholder="Select date..."
                 required
                 readonly>
          <div class="input-hint">Scheduled transfer date</div>
        </div>
        
        <!-- Transfer Details -->
        <div class="form-group">
          <label for="transferNotes" class="form-label">
            <div class="label-text">Transfer Notes</div>
          </label>
          <textarea id="transferNotes" 
                    name="notes" 
                    class="form-textarea" 
                    placeholder="Reason for transfer, special instructions, etc."
                    rows="3"></textarea>
          <div class="input-hint">Optional: Add notes about this transfer</div>
        </div>
        
        <!-- Priority Level -->
        <div class="form-group">
          <label for="transferPriority" class="form-label">
            <div class="label-text">Priority Level</div>
          </label>
          <div class="priority-buttons">
            <button type="button" class="priority-btn low" data-priority="low">
              <span class="priority-dot"></span>
              <span class="priority-text">Low</span>
            </button>
            <button type="button" class="priority-btn medium active" data-priority="medium">
              <span class="priority-dot"></span>
              <span class="priority-text">Medium</span>
            </button>
            <button type="button" class="priority-btn high" data-priority="high">
              <span class="priority-dot"></span>
              <span class="priority-text">High</span>
            </button>
            <button type="button" class="priority-btn urgent" data-priority="urgent">
              <span class="priority-dot"></span>
              <span class="priority-text">Urgent</span>
            </button>
          </div>
          <input type="hidden" id="transferPriority" name="priority" value="medium">
        </div>
        
        <!-- Confirmation Banner -->
        <div class="confirmation-banner transfer-banner" id="transferConfirmation">
          <div class="banner-content">
            <img class="banner-icon" src="{{ asset('icon1.svg') }}" alt="Info" />
            <div class="banner-message">
              <div class="banner-title">Confirmation Required</div>
              <div class="banner-description" id="transferDescription">
                Please review all details before confirming the transfer
              </div>
            </div>
          </div>
        </div>
        
        <!-- Form Status Messages -->
        <div id="transferFormStatus" class="form-status hidden"></div>
      </form>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">
      <button class="cancel-btn" type="button" id="cancelTransferBtn">
        <div class="cancel-text">Cancel</div>
      </button>
      <button class="submit-btn transfer-submit-btn" type="button" id="submitTransferBtn">
        <div class="submit-text">Confirm Transfer</div>
        <div class="submit-loading hidden">
          <div class="loading-spinner-small"></div>
        </div>
      </button>
    </div>
  </div>
</div>

<!-- Transfer Success Toast Template -->
<template id="transferSuccessToastTemplate">
  <div class="success-toast transfer-toast">
    <div class="toast-content">
      <img class="toast-icon" src="{{ asset('icon-check.svg') }}" alt="Success" />
      <div class="toast-message"></div>
    </div>
  </div>
</template>

<!-- Transfer Preview Modal -->
<div id="transferPreviewModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="transfer-preview-title">
  <div class="modal-content transfer-preview">
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="preview-title" id="transfer-preview-title">Transfer Preview</div>
          <div class="modal-subtitle">Review transfer details</div>
        </div>
      </div>
    </div>
    
    <div class="modal-body">
      <div class="preview-content">
        <div class="preview-section">
          <h3 class="section-title">Transfer Summary</h3>
          <div class="preview-grid">
            <div class="preview-item">
              <span class="preview-label">Product:</span>
              <span class="preview-value" id="previewProduct">N/A</span>
            </div>
            <div class="preview-item">
              <span class="preview-label">Quantity:</span>
              <span class="preview-value" id="previewQuantity">0</span>
            </div>
            <div class="preview-item">
              <span class="preview-label">From:</span>
              <span class="preview-value" id="previewSource">N/A</span>
            </div>
            <div class="preview-item">
              <span class="preview-label">To:</span>
              <span class="preview-value" id="previewDestination">N/A</span>
            </div>
            <div class="preview-item">
              <span class="preview-label">Date:</span>
              <span class="preview-value" id="previewDate">N/A</span>
            </div>
            <div class="preview-item">
              <span class="preview-label">Priority:</span>
              <span class="preview-value" id="previewPriority">Medium</span>
            </div>
          </div>
        </div>
        
        <div class="preview-section">
          <h3 class="section-title">Transfer Impact</h3>
          <div class="impact-grid">
            <div class="impact-item source-impact">
              <div class="impact-label">Source After Transfer</div>
              <div class="impact-value" id="sourceAfter">0 units</div>
            </div>
            <div class="impact-item destination-impact">
              <div class="impact-label">Destination After Transfer</div>
              <div class="impact-value" id="destinationAfter">0 units</div>
            </div>
          </div>
        </div>
        
        <div class="preview-section">
          <h3 class="section-title">Notes</h3>
          <div class="preview-notes" id="previewNotes">No notes provided</div>
        </div>
        
        <div class="preview-warning" id="previewWarning">
          <img src="{{ asset('icon-warning.svg') }}" alt="Warning" />
          <span>This transfer will affect inventory levels at both locations.</span>
        </div>
      </div>
    </div>
    
    <div class="modal-footer">
      <button class="cancel-btn" type="button" id="backToEditBtn">
        <div class="cancel-text">Back to Edit</div>
      </button>
      <button class="submit-btn confirm-transfer-btn" type="button" id="finalConfirmBtn">
        <div class="submit-text">Finalize Transfer</div>
      </button>
    </div>
  </div>
</div>

<!-- Stock Transfer Workflow JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// Stock Transfer Modal Namespace
window.StockTransferModal = {
  isSubmitting: false,
  transferData: null,
  productsData: {},
  warehousesData: {},
  
  init: function() {
    this.modal = document.getElementById('stockTransferModal');
    this.previewModal = document.getElementById('transferPreviewModal');
    this.closeModalBtn = document.getElementById('closeStockTransferModalBtn');
    this.cancelBtn = document.getElementById('cancelTransferBtn');
    this.submitBtn = document.getElementById('submitTransferBtn');
    this.backToEditBtn = document.getElementById('backToEditBtn');
    this.finalConfirmBtn = document.getElementById('finalConfirmBtn');
    this.form = document.getElementById('stockTransferForm');
    this.transferProduct = document.getElementById('transferProduct');
    this.sourceLocation = document.getElementById('sourceLocation');
    this.destinationLocation = document.getElementById('destinationLocation');
    this.transferQuantity = document.getElementById('transferQuantity');
    this.decreaseBtn = document.getElementById('decreaseTransferQuantity');
    this.increaseBtn = document.getElementById('increaseTransferQuantity');
    this.transferDateInput = document.getElementById('transferDate');
    this.formStatus = document.getElementById('transferFormStatus');
    this.submitLoading = this.submitBtn?.querySelector('.submit-loading');
    this.transferPath = document.getElementById('transferPath');
    this.productTransferDetails = document.getElementById('productTransferDetails');
    
    if (!this.modal) {
      console.error('Stock Transfer Modal element not found');
      return;
    }
    
    this.loadProductsData();
    this.loadWarehousesData();
    this.setupEventListeners();
    this.initDatePicker();
    this.initPriorityButtons();
    console.log('StockTransferModal initialized');
  },
  
  loadProductsData: function() {
    this.productsData = {
      'MED-001': { name: 'Portable Ultrasound Machine', current_stock: 15, locations: ['Warehouse A', 'Warehouse B'], status: 'good' },
      'MED-002': { name: 'Patient Monitor', current_stock: 3, locations: ['Warehouse B', 'Warehouse C'], status: 'low' },
      'MED-003': { name: 'Surgical Instruments Set', current_stock: 8, locations: ['Warehouse C', 'Warehouse A'], status: 'good' },
      'MED-004': { name: 'Digital Thermometer', current_stock: 0, locations: ['Warehouse A'], status: 'out' },
      'MED-005': { name: 'Blood Pressure Monitor', current_stock: 2, locations: ['Warehouse B', 'Warehouse C'], status: 'low' },
      'MED-006': { name: 'X-Ray Machine', current_stock: 5, locations: ['Warehouse C'], status: 'good' },
    };
  },
  
  loadWarehousesData: function() {
    this.warehousesData = {
      'warehouse_a': { name: 'Warehouse A', capacity: 1000, current: 650 },
      'warehouse_b': { name: 'Warehouse B', capacity: 800, current: 420 },
      'warehouse_c': { name: 'Warehouse C', capacity: 1200, current: 780 },
      'warehouse_d': { name: 'Warehouse D', capacity: 600, current: 150 },
    };
  },
  
  initDatePicker: function() {
    if (this.transferDateInput) {
      this.datePicker = flatpickr(this.transferDateInput, {
        dateFormat: "Y-m-d",
        defaultDate: "today",
        minDate: "today",
        onChange: (selectedDates, dateStr) => {
          this.updateTransferConfirmation();
        }
      });
    }
  },
  
  initPriorityButtons: function() {
    const priorityButtons = document.querySelectorAll('.priority-btn');
    priorityButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        // Remove active class from all buttons
        priorityButtons.forEach(b => b.classList.remove('active'));
        
        // Add active class to clicked button
        btn.classList.add('active');
        
        // Update hidden input
        const priority = btn.getAttribute('data-priority');
        document.getElementById('transferPriority').value = priority;
        
        // Update transfer confirmation
        this.updateTransferConfirmation();
      });
    });
  },
  
  setupEventListeners: function() {
    // Close buttons
    if (this.closeModalBtn) {
      this.closeModalBtn.addEventListener('click', this.close.bind(this));
    }
    
    if (this.cancelBtn) {
      this.cancelBtn.addEventListener('click', this.close.bind(this));
    }
    
    // Submit buttons
    if (this.submitBtn) {
      this.submitBtn.addEventListener('click', this.showPreview.bind(this));
    }
    
    if (this.backToEditBtn) {
      this.backToEditBtn.addEventListener('click', this.hidePreview.bind(this));
    }
    
    if (this.finalConfirmBtn) {
      this.finalConfirmBtn.addEventListener('click', this.submitTransfer.bind(this));
    }
    
    // Form inputs
    if (this.transferProduct) {
      this.transferProduct.addEventListener('change', this.onProductSelect.bind(this));
    }
    
    if (this.sourceLocation) {
      this.sourceLocation.addEventListener('change', this.onLocationChange.bind(this));
    }
    
    if (this.destinationLocation) {
      this.destinationLocation.addEventListener('change', this.onLocationChange.bind(this));
    }
    
    // Quantity controls
    if (this.decreaseBtn) {
      this.decreaseBtn.addEventListener('click', () => this.adjustTransferQuantity(-1));
    }
    
    if (this.increaseBtn) {
      this.increaseBtn.addEventListener('click', () => this.adjustTransferQuantity(1));
    }
    
    if (this.transferQuantity) {
      this.transferQuantity.addEventListener('input', this.onTransferQuantityChange.bind(this));
      this.transferQuantity.addEventListener('change', this.validateTransferQuantity.bind(this));
    }
    
    // Form validation
    if (this.form) {
      this.form.addEventListener('input', this.validateTransferForm.bind(this));
    }
    
    // Close on overlay click
    this.modal.addEventListener('click', (e) => {
      if (e.target === this.modal) {
        this.close();
      }
    });
    
    this.previewModal?.addEventListener('click', (e) => {
      if (e.target === this.previewModal) {
        this.hidePreview();
      }
    });
    
    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        if (!this.modal.classList.contains('hidden')) {
          this.close();
        }
        if (this.previewModal && !this.previewModal.classList.contains('hidden')) {
          this.hidePreview();
        }
      }
    });
  },
  
  open: function() {
    if (!this.modal) return;
    
    console.log('Opening Stock Transfer Modal');
    
    // Remove hidden class and set aria attributes
    this.modal.classList.remove('hidden');
    this.modal.setAttribute('aria-hidden', 'false');
    
    // Add opening animation
    this.modal.classList.add('modal-opening');
    
    // Prevent body scrolling
    document.body.style.overflow = 'hidden';
    
    // Focus trap setup
    this.setupFocusTrap();
    
    // Reset form
    this.resetForm();
    
    // Dispatch custom event
    this.modal.dispatchEvent(new CustomEvent('stock-transfer-modal-opened'));
  },
  
  close: function() {
    if (!this.modal) return;
    
    // Hide preview if open
    this.hidePreview();
    
    // Add closing animation
    this.modal.classList.add('modal-closing');
    
    // Remove focus trap
    this.removeFocusTrap();
    
    // Hide modal after animation
    setTimeout(() => {
      this.modal.classList.add('hidden');
      this.modal.classList.remove('modal-opening', 'modal-closing');
      this.modal.setAttribute('aria-hidden', 'true');
      
      // Restore body scrolling
      document.body.style.overflow = '';
      
      // Dispatch custom event
      this.modal.dispatchEvent(new CustomEvent('stock-transfer-modal-closed'));
    }, 300);
  },
  
  setupFocusTrap: function() {
    const focusableElements = this.modal.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    if (focusableElements.length === 0) return;
    
    this.firstFocusableElement = focusableElements[0];
    this.lastFocusableElement = focusableElements[focusableElements.length - 1];
    
    this.firstFocusableElement.focus();
    
    this.handleTabKey = this.handleTabKey.bind(this);
    this.modal.addEventListener('keydown', this.handleTabKey);
  },
  
  handleTabKey: function(e) {
    if (e.key === 'Tab') {
      if (e.shiftKey) {
        if (document.activeElement === this.firstFocusableElement) {
          e.preventDefault();
          this.lastFocusableElement.focus();
        }
      } else {
        if (document.activeElement === this.lastFocusableElement) {
          e.preventDefault();
          this.firstFocusableElement.focus();
        }
      }
    }
  },
  
  removeFocusTrap: function() {
    if (this.handleTabKey) {
      this.modal.removeEventListener('keydown', this.handleTabKey);
    }
  },
  
  onProductSelect: function() {
    const productId = this.transferProduct.value;
    const selectedOption = this.transferProduct.options[this.transferProduct.selectedIndex];
    
    if (!productId) {
      this.productTransferDetails.classList.add('hidden');
      this.transferPath.classList.add('hidden');
      return;
    }
    
    const product = this.productsData[productId];
    if (product) {
      // Update product details
      document.getElementById('availableStock').textContent = product.current_stock;
      document.getElementById('currentLocation').textContent = product.locations[0] || 'N/A';
      document.getElementById('productStatus').textContent = this.getStatusText(product.status);
      
      // Update available quantity
      document.getElementById('availableQty').textContent = product.current_stock;
      this.updateAvailabilityBar(product.current_stock);
      
      // Show details with animation
      this.productTransferDetails.classList.remove('hidden');
      this.productTransferDetails.style.opacity = '0';
      this.productTransferDetails.style.transform = 'translateY(-10px)';
      
      setTimeout(() => {
        this.productTransferDetails.style.transition = 'all 0.3s ease';
        this.productTransferDetails.style.opacity = '1';
        this.productTransferDetails.style.transform = 'translateY(0)';
      }, 100);
      
      // Update source location options based on product locations
      this.updateLocationOptions(product.locations);
      
      // Update transfer confirmation
      this.updateTransferConfirmation();
    }
  },
  
  updateLocationOptions: function(availableLocations) {
    // Filter source location options
    const sourceOptions = this.sourceLocation.options;
    for (let i = 0; i < sourceOptions.length; i++) {
      const option = sourceOptions[i];
      if (option.value) {
        const warehouseName = this.warehousesData[option.value]?.name;
        option.disabled = !availableLocations.includes(warehouseName);
        option.hidden = !availableLocations.includes(warehouseName);
      }
    }
    
    // Reset selections
    this.sourceLocation.value = '';
    this.destinationLocation.value = '';
  },
  
  onLocationChange: function() {
    const source = this.sourceLocation.value;
    const destination = this.destinationLocation.value;
    
    if (source && destination) {
      // Check if source and destination are different
      if (source === destination) {
        this.showFormStatus('Source and destination cannot be the same', 'error');
        this.destinationLocation.value = '';
        this.transferPath.classList.add('hidden');
        return;
      }
      
      // Show transfer path
      this.showTransferPath(source, destination);
      
      // Update transfer confirmation
      this.updateTransferConfirmation();
    } else {
      this.transferPath.classList.add('hidden');
    }
  },
  
  showTransferPath: function(source, destination) {
    const sourceName = this.warehousesData[source]?.name || 'Source';
    const destinationName = this.warehousesData[destination]?.name || 'Destination';
    
    // Update path elements
    document.getElementById('pathSource').textContent = sourceName;
    document.getElementById('pathDestination').textContent = destinationName;
    
    // Calculate distance (simulated)
    const distance = this.calculateDistance(source, destination);
    document.getElementById('pathDistance').textContent = `Distance: ${distance} km`;
    
    // Show with animation
    this.transferPath.classList.remove('hidden');
    this.transferPath.style.opacity = '0';
    this.transferPath.style.transform = 'translateY(-10px)';
    
    setTimeout(() => {
      this.transferPath.style.transition = 'all 0.3s ease';
      this.transferPath.style.opacity = '1';
      this.transferPath.style.transform = 'translateY(0)';
    }, 100);
  },
  
  calculateDistance: function(source, destination) {
    // Simulated distance calculation
    const distances = {
      'warehouse_a-warehouse_b': 15,
      'warehouse_a-warehouse_c': 25,
      'warehouse_a-warehouse_d': 30,
      'warehouse_b-warehouse_c': 20,
      'warehouse_b-warehouse_d': 35,
      'warehouse_c-warehouse_d': 18,
    };
    
    const key = `${source}-${destination}`;
    const reverseKey = `${destination}-${source}`;
    
    return distances[key] || distances[reverseKey] || Math.floor(Math.random() * 30) + 10;
  },
  
  adjustTransferQuantity: function(change) {
    if (!this.transferQuantity) return;
    
    let current = parseInt(this.transferQuantity.value) || 0;
    let newValue = current + change;
    
    // Validate bounds
    if (newValue < 1) newValue = 1;
    
    // Check available stock
    const productId = this.transferProduct.value;
    if (productId && this.productsData[productId]) {
      const maxStock = this.productsData[productId].current_stock;
      if (newValue > maxStock) {
        newValue = maxStock;
        this.showFormStatus(`Maximum available stock is ${maxStock}`, 'warning');
      }
    }
    
    // Update input with animation
    this.transferQuantity.value = newValue;
    this.transferQuantity.classList.add('quantity-change');
    
    setTimeout(() => {
      this.transferQuantity.classList.remove('quantity-change');
    }, 300);
    
    // Update availability
    this.onTransferQuantityChange();
    
    // Dispatch event
    this.transferQuantity.dispatchEvent(new Event('change'));
  },
  
  onTransferQuantityChange: function() {
    const quantity = parseInt(this.transferQuantity.value) || 0;
    const productId = this.transferProduct.value;
    
    if (productId && this.productsData[productId]) {
      const availableStock = this.productsData[productId].current_stock;
      
      // Update availability bar
      this.updateAvailabilityBar(availableStock, quantity);
      
      // Update transfer confirmation
      this.updateTransferConfirmation();
    }
  },
  
  updateAvailabilityBar: function(availableStock, requested = null) {
    const quantity = requested || parseInt(this.transferQuantity.value) || 0;
    const fillPercentage = Math.min((quantity / availableStock) * 100, 100);
    
    const fillBar = document.getElementById('availabilityFill');
    if (fillBar) {
      fillBar.style.width = `${fillPercentage}%`;
      
      // Update color based on percentage
      if (fillPercentage > 80) {
        fillBar.style.backgroundColor = '#ef4444';
      } else if (fillPercentage > 50) {
        fillBar.style.backgroundColor = '#f59e0b';
      } else {
        fillBar.style.backgroundColor = '#10b981';
      }
    }
  },
  
  validateTransferQuantity: function() {
    let value = parseInt(this.transferQuantity.value) || 0;
    
    if (value < 1) {
      this.transferQuantity.value = 1;
      this.showFormStatus('Minimum quantity is 1', 'warning');
    }
    
    this.onTransferQuantityChange();
  },
  
  updateTransferConfirmation: function() {
    const productId = this.transferProduct.value;
    const quantity = parseInt(this.transferQuantity.value) || 0;
    const source = this.sourceLocation.value;
    const destination = this.destinationLocation.value;
    const date = this.transferDateInput.value || 'today';
    const priority = document.getElementById('transferPriority').value;
    
    if (productId && quantity > 0 && source && destination) {
      const product = this.productsData[productId];
      const sourceName = this.warehousesData[source]?.name || 'Source';
      const destinationName = this.warehousesData[destination]?.name || 'Destination';
      
      const description = `Transfer ${quantity} units of ${product?.name || 'selected product'} from ${sourceName} to ${destinationName} on ${date}. Priority: ${priority}.`;
      
      document.getElementById('transferDescription').textContent = description;
    }
  },
  
  validateTransferForm: function() {
    if (!this.form) return false;
    
    let isValid = true;
    let messages = [];
    
    // Validate product selection
    if (!this.transferProduct.value) {
      isValid = false;
      messages.push('Please select a product');
      this.transferProduct.classList.add('invalid');
    } else {
      this.transferProduct.classList.remove('invalid');
      this.transferProduct.classList.add('valid');
    }
    
    // Validate source location
    if (!this.sourceLocation.value) {
      isValid = false;
      messages.push('Please select source location');
      this.sourceLocation.classList.add('invalid');
    } else {
      this.sourceLocation.classList.remove('invalid');
      this.sourceLocation.classList.add('valid');
    }
    
    // Validate destination location
    if (!this.destinationLocation.value) {
      isValid = false;
      messages.push('Please select destination location');
      this.destinationLocation.classList.add('invalid');
    } else {
      this.destinationLocation.classList.remove('invalid');
      this.destinationLocation.classList.add('valid');
    }
    
    // Validate quantity
    const quantity = parseInt(this.transferQuantity.value) || 0;
    if (quantity < 1) {
      isValid = false;
      messages.push('Quantity must be at least 1');
      this.transferQuantity.classList.add('invalid');
    } else {
      // Check if enough stock is available
      const productId = this.transferProduct.value;
      if (productId && this.productsData[productId]) {
        const availableStock = this.productsData[productId].current_stock;
        if (quantity > availableStock) {
          isValid = false;
          messages.push(`Only ${availableStock} units available`);
          this.transferQuantity.classList.add('invalid');
        } else {
          this.transferQuantity.classList.remove('invalid');
          this.transferQuantity.classList.add('valid');
        }
      }
    }
    
    // Validate date
    if (!this.transferDateInput.value) {
      isValid = false;
      messages.push('Please select transfer date');
      this.transferDateInput.classList.add('invalid');
    } else {
      this.transferDateInput.classList.remove('invalid');
      this.transferDateInput.classList.add('valid');
    }
    
    // Update submit button state
    this.setSubmitButtonState(isValid);
    
    // Show validation messages if any
    if (messages.length > 0) {
      this.showFormStatus(messages.join('<br>'), 'error');
    } else {
      this.clearFormStatus();
    }
    
    return isValid;
  },
  
  setSubmitButtonState: function(enabled) {
    if (!this.submitBtn) return;
    
    if (enabled) {
      this.submitBtn.disabled = false;
      this.submitBtn.classList.remove('disabled');
    } else {
      this.submitBtn.disabled = true;
      this.submitBtn.classList.add('disabled');
    }
  },
  
  showFormStatus: function(message, type = 'info') {
    if (!this.formStatus) return;
    
    this.formStatus.innerHTML = message;
    this.formStatus.className = `form-status ${type}`;
    this.formStatus.classList.remove('hidden');
    
    if (type === 'info') {
      setTimeout(() => this.clearFormStatus(), 5000);
    }
  },
  
  clearFormStatus: function() {
    if (!this.formStatus) return;
    
    this.formStatus.innerHTML = '';
    this.formStatus.className = 'form-status hidden';
  },
  
  getStatusText: function(status) {
    const statusMap = {
      'good': 'Good Stock',
      'low': 'Low Stock',
      'out': 'Out of Stock',
      'critical': 'Critical'
    };
    return statusMap[status] || status;
  },
  
  resetForm: function() {
    if (!this.form) return;
    
    // Reset form elements
    this.form.reset();
    
    // Reset custom elements
    if (this.transferProduct) this.transferProduct.value = '';
    if (this.sourceLocation) this.sourceLocation.value = '';
    if (this.destinationLocation) this.destinationLocation.value = '';
    if (this.transferQuantity) this.transferQuantity.value = '1';
    if (this.transferDateInput && this.datePicker) {
      this.datePicker.setDate(new Date());
    }
    
    // Reset priority to medium
    document.getElementById('transferPriority').value = 'medium';
    document.querySelectorAll('.priority-btn').forEach(btn => {
      btn.classList.remove('active');
      if (btn.getAttribute('data-priority') === 'medium') {
        btn.classList.add('active');
      }
    });
    
    // Hide details and path
    this.productTransferDetails.classList.add('hidden');
    this.transferPath.classList.add('hidden');
    this.transferPath.style.opacity = '1';
    this.transferPath.style.transform = 'translateY(0)';
    
    // Clear validation states
    this.clearFormStatus();
    
    // Reset submit button
    this.setSubmitButtonState(false);
    
    // Remove validation classes
    const inputs = this.form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      input.classList.remove('valid', 'invalid');
      if (input.tagName === 'SELECT') {
        // Reset all options to visible and enabled
        Array.from(input.options).forEach(option => {
          option.disabled = false;
          option.hidden = false;
        });
      }
    });
  },
  
  showPreview: function() {
    if (!this.previewModal) return;
    
    // Validate form first
    if (!this.validateTransferForm()) {
      this.showFormStatus('Please fix the errors before proceeding', 'error');
      return;
    }
    
    // Collect transfer data
    this.transferData = {
      product_id: this.transferProduct.value,
      product_name: this.productsData[this.transferProduct.value]?.name || '',
      quantity: parseInt(this.transferQuantity.value) || 0,
      source_location: this.sourceLocation.value,
      source_name: this.warehousesData[this.sourceLocation.value]?.name || '',
      destination_location: this.destinationLocation.value,
      destination_name: this.warehousesData[this.destinationLocation.value]?.name || '',
      transfer_date: this.transferDateInput.value,
      priority: document.getElementById('transferPriority').value,
      notes: document.getElementById('transferNotes')?.value || '',
      available_stock: this.productsData[this.transferProduct.value]?.current_stock || 0
    };
    
    // Update preview modal
    this.updatePreviewModal();
    
    // Show preview modal
    this.previewModal.classList.remove('hidden');
    this.previewModal.setAttribute('aria-hidden', 'false');
    this.previewModal.classList.add('modal-opening');
    
    // Focus trap for preview modal
    this.setupPreviewFocusTrap();
  },
  
  hidePreview: function() {
    if (!this.previewModal) return;
    
    this.previewModal.classList.add('modal-closing');
    
    setTimeout(() => {
      this.previewModal.classList.add('hidden');
      this.previewModal.classList.remove('modal-opening', 'modal-closing');
      this.previewModal.setAttribute('aria-hidden', 'true');
    }, 300);
  },
  
  setupPreviewFocusTrap: function() {
    const focusableElements = this.previewModal.querySelectorAll(
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    if (focusableElements.length === 0) return;
    
    this.previewFirstFocusableElement = focusableElements[0];
    this.previewLastFocusableElement = focusableElements[focusableElements.length - 1];
    
    this.previewFirstFocusableElement.focus();
    
    this.handlePreviewTabKey = (e) => {
      if (e.key === 'Tab') {
        if (e.shiftKey) {
          if (document.activeElement === this.previewFirstFocusableElement) {
            e.preventDefault();
            this.previewLastFocusableElement.focus();
          }
        } else {
          if (document.activeElement === this.previewLastFocusableElement) {
            e.preventDefault();
            this.previewFirstFocusableElement.focus();
          }
        }
      }
    };
    
    this.previewModal.addEventListener('keydown', this.handlePreviewTabKey);
  },
  
  updatePreviewModal: function() {
    if (!this.transferData) return;
    
    // Update preview content
    document.getElementById('previewProduct').textContent = this.transferData.product_name;
    document.getElementById('previewQuantity').textContent = this.transferData.quantity;
    document.getElementById('previewSource').textContent = this.transferData.source_name;
    document.getElementById('previewDestination').textContent = this.transferData.destination_name;
    document.getElementById('previewDate').textContent = this.transferData.transfer_date;
    document.getElementById('previewPriority').textContent = this.capitalizeFirst(this.transferData.priority);
    document.getElementById('previewNotes').textContent = this.transferData.notes || 'No notes provided';
    
    // Calculate impacts
    const sourceAfter = this.transferData.available_stock - this.transferData.quantity;
    document.getElementById('sourceAfter').textContent = `${sourceAfter} units`;
    
    const destinationCurrent = this.warehousesData[this.transferData.destination_location]?.current || 0;
    const destinationAfter = destinationCurrent + this.transferData.quantity;
    document.getElementById('destinationAfter').textContent = `${destinationAfter} units`;
    
    // Show warning if source will be low/out
    if (sourceAfter <= 0) {
      document.getElementById('previewWarning').classList.remove('hidden');
    } else {
      document.getElementById('previewWarning').classList.add('hidden');
    }
  },
  
  submitTransfer: async function() {
    if (this.isSubmitting || !this.transferData) return;
    
    this.isSubmitting = true;
    
    // Show loading state
    this.setLoadingState(true);
    
    try {
      console.log('Submitting transfer:', this.transferData);
      
      // Simulate API call delay
      await new Promise(resolve => setTimeout(resolve, 1500));
      
      // Show success message
      this.showSuccessToast(
        `${this.transferData.quantity} units transferred from ${this.transferData.source_name} to ${this.transferData.destination_name}`
      );
      
      // Close preview modal
      this.hidePreview();
      
      // Close main modal after delay
      setTimeout(() => {
        this.close();
        
        // Dispatch success event
        this.modal.dispatchEvent(new CustomEvent('transfer-submitted', {
          detail: this.transferData
        }));
      }, 500);
      
    } catch (error) {
      console.error('Error submitting transfer:', error);
      this.showFormStatus('Failed to process transfer. Please try again.', 'error');
    } finally {
      this.isSubmitting = false;
      this.setLoadingState(false);
    }
  },
  
  setLoadingState: function(isLoading) {
    if (!this.submitBtn || !this.submitLoading) return;
    
    if (isLoading) {
      this.submitBtn.disabled = true;
      this.submitLoading?.classList.remove('hidden');
      this.submitBtn.querySelector('.submit-text').style.opacity = '0.5';
    } else {
      this.submitBtn.disabled = false;
      this.submitLoading?.classList.add('hidden');
      this.submitBtn.querySelector('.submit-text').style.opacity = '1';
    }
  },
  
  showSuccessToast: function(message) {
    // Remove existing toast
    const existingToast = document.querySelector('.transfer-toast');
    if (existingToast) {
      existingToast.remove();
    }
    
    // Get template
    const template = document.getElementById('transferSuccessToastTemplate');
    if (!template) return;
    
    // Clone and customize toast
    const toast = template.content.cloneNode(true);
    const toastElement = toast.querySelector('.transfer-toast');
    const toastMessage = toast.querySelector('.toast-message');
    
    if (toastMessage) {
      toastMessage.textContent = message;
    }
    
    // Add to document
    document.body.appendChild(toastElement);
    
    // Animate in
    setTimeout(() => {
      if (toastElement) {
        toastElement.classList.add('show');
      }
    }, 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
      if (toastElement && toastElement.parentNode) {
        toastElement.classList.remove('show');
        setTimeout(() => {
          if (toastElement.parentNode) {
            toastElement.parentNode.removeChild(toastElement);
          }
        }, 300);
      }
    }, 3000);
  },
  
  capitalizeFirst: function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
};

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  StockTransferModal.init();
});
</script>