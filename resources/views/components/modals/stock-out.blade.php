<div id="stockOutModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="stock-out-title">
  <div class="modal-content stock-out">
    <!-- Modal Header -->
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="record-stock-out" id="stock-out-title">Record Stock Out</div>
          <div class="modal-subtitle">Remove stock from inventory</div>
        </div>
      </div>
      <button class="modal-close-btn" type="button" id="closeStockOutModalBtn" aria-label="Close modal">
        <img class="icon" src="{{ asset('icon0.svg') }}" alt="Close" />
      </button>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">
      <form id="stockOutForm" class="stock-out-form">
        <!-- Product Selection -->
        <div class="form-group">
          <label for="productSelect" class="form-label required">
            <div class="label-text">Product ID / Name</div>
          </label>
          <div class="custom-select">
            <select id="productSelect" name="product_id" class="form-select" required>
              <option value="" disabled selected>Select Product...</option>
              @php
                $products = [
                  ['id' => 'MED-001', 'name' => 'Portable Ultrasound Machine', 'stock' => 15, 'min_stock' => 5],
                  ['id' => 'MED-002', 'name' => 'Patient Monitor', 'stock' => 3, 'min_stock' => 2],
                  ['id' => 'MED-003', 'name' => 'Surgical Instruments Set', 'stock' => 8, 'min_stock' => 4],
                  ['id' => 'MED-004', 'name' => 'Digital Thermometer', 'stock' => 0, 'min_stock' => 10],
                  ['id' => 'MED-005', 'name' => 'Blood Pressure Monitor', 'stock' => 2, 'min_stock' => 3],
                  ['id' => 'MED-006', 'name' => 'X-Ray Machine', 'stock' => 5, 'min_stock' => 2],
                  ['id' => 'MED-007', 'name' => 'Medical Ventilator', 'stock' => 12, 'min_stock' => 4],
                  ['id' => 'MED-008', 'name' => 'Infusion Pump', 'stock' => 7, 'min_stock' => 3],
                ];
              @endphp
              @foreach($products as $product)
              <option value="{{ $product['id'] }}" 
                      data-current-stock="{{ $product['stock'] }}"
                      data-min-stock="{{ $product['min_stock'] }}">
                {{ $product['id'] }} - {{ $product['name'] }} ({{ $product['stock'] }} in stock)
              </option>
              @endforeach
            </select>
            <div class="select-arrow">▼</div>
          </div>
          <div class="input-hint">Select a product to remove from inventory</div>
        </div>
        
        <!-- Product Details Display -->
        <div class="product-details hidden" id="productDetails">
          <div class="product-info">
            <div class="info-row">
              <span class="info-label">Current Stock:</span>
              <span class="info-value" id="currentStock">0</span>
            </div>
            <div class="info-row">
              <span class="info-label">Minimum Required:</span>
              <span class="info-value" id="minStock">0</span>
            </div>
            <div class="info-row">
              <span class="info-label">Available to Remove:</span>
              <span class="info-value" id="availableStock">0</span>
            </div>
            <div class="info-row">
              <span class="info-label">Status:</span>
              <span class="info-value" id="stockStatus">N/A</span>
            </div>
          </div>
        </div>
        
        <!-- Quantity Input -->
        <div class="form-group">
          <label for="quantity" class="form-label required">
            <div class="label-text">Quantity to Remove</div>
          </label>
          <div class="quantity-input-container">
            <button type="button" class="quantity-btn minus" id="decreaseQuantity" aria-label="Decrease quantity">
              <span>-</span>
            </button>
            <input type="number" 
                   id="quantity" 
                   name="quantity" 
                   class="quantity-input" 
                   min="1" 
                   max="0"
                   value="1"
                   required>
            <button type="button" class="quantity-btn plus" id="increaseQuantity" aria-label="Increase quantity">
              <span>+</span>
            </button>
          </div>
          <div class="input-hint">Maximum: <span id="maxQuantity">0</span> units available</div>
          <div class="quantity-summary hidden" id="quantitySummary">
            <span class="summary-label">New Stock Level:</span>
            <span class="summary-value">
              <span id="currentQty">0</span> - <span id="removedQty">1</span> = <span id="newTotal">0</span>
            </span>
          </div>
        </div>
        
        <!-- Reason Selection -->
        <div class="form-group">
          <label for="reason" class="form-label required">
            <div class="label-text">Reason for Stock Out</div>
          </label>
          <div class="custom-select">
            <select id="reason" name="reason" class="form-select" required>
              <option value="" disabled selected>Select Reason...</option>
              <option value="sale">Sale to Customer</option>
              <option value="transfer">Internal Transfer</option>
              <option value="damaged">Damaged/Expired</option>
              <option value="donation">Donation</option>
              <option value="sample">Sample/Testing</option>
              <option value="adjustment">Inventory Adjustment</option>
              <option value="other">Other</option>
            </select>
            <div class="select-arrow">▼</div>
          </div>
          <div class="input-hint">Select the reason for removing stock</div>
        </div>
        
        <!-- Additional Notes -->
        <div class="form-group">
          <label for="notes" class="form-label">
            <div class="label-text">Additional Notes</div>
          </label>
          <textarea id="notes" 
                    name="notes" 
                    class="form-textarea" 
                    placeholder="Optional: Customer name, transfer location, damage details, etc."
                    rows="2"></textarea>
          <div class="input-hint">Add any relevant details about this stock out</div>
        </div>
        
        <!-- Warning Banner -->
        <div class="warning-banner hidden" id="warningBanner">
          <div class="banner-content">
            <img class="banner-icon" src="{{ asset('icon1.svg') }}" alt="Warning" />
            <div class="banner-message">
              <div class="banner-title" id="warningTitle"></div>
              <div class="banner-description" id="warningDescription"></div>
            </div>
          </div>
        </div>
        
        <!-- Critical Warning Banner -->
        <div class="critical-warning-banner hidden" id="criticalWarningBanner">
          <div class="banner-content">
            <img class="banner-icon" src="{{ asset('icon-warning.svg') }}" alt="Critical Warning" />
            <div class="banner-message">
              <div class="banner-title">Critical Stock Level Warning!</div>
              <div class="banner-description" id="criticalWarningDescription"></div>
            </div>
          </div>
        </div>
        
        <!-- Form Status Messages -->
        <div id="formStatus" class="form-status hidden"></div>
      </form>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">
      <button class="cancel-btn" type="button" id="cancelStockOutBtn">
        <div class="cancel-text">Cancel</div>
      </button>
      <button class="submit-btn critical" type="button" id="submitStockOutBtn">
        <div class="submit-text">Confirm Stock Out</div>
        <div class="submit-loading hidden">
          <div class="loading-spinner-small"></div>
        </div>
      </button>
    </div>
  </div>
</div>

<!-- Confirmation Dialog Template -->
<template id="confirmationDialogTemplate">
  <div class="confirmation-dialog-overlay">
    <div class="confirmation-dialog">
      <div class="dialog-header">
        <h3 class="dialog-title">Confirm Stock Out</h3>
        <button class="dialog-close-btn" type="button" aria-label="Close">
          <span>×</span>
        </button>
      </div>
      <div class="dialog-body">
        <p class="dialog-message"></p>
        <div class="dialog-details"></div>
      </div>
      <div class="dialog-footer">
        <button class="dialog-cancel-btn" type="button">Cancel</button>
        <button class="dialog-confirm-btn" type="button">Confirm</button>
      </div>
    </div>
  </div>
</template>

<!-- Success Toast Template -->
<template id="stockOutSuccessToastTemplate">
  <div class="success-toast stock-out-toast">
    <div class="toast-content">
      <img class="toast-icon" src="{{ asset('icon-check.svg') }}" alt="Success" />
      <div class="toast-message"></div>
    </div>
  </div>
</template>

<!-- Stock Out Modal JavaScript -->
<script>
// Stock Out Modal Namespace
window.StockOutModal = {
  isSubmitting: false,
  selectedProduct: null,
  
  init: function() {
    this.modal = document.getElementById('stockOutModal');
    this.closeModalBtn = document.getElementById('closeStockOutModalBtn');
    this.cancelBtn = document.getElementById('cancelStockOutBtn');
    this.submitBtn = document.getElementById('submitStockOutBtn');
    this.form = document.getElementById('stockOutForm');
    this.productSelect = document.getElementById('productSelect');
    this.productDetails = document.getElementById('productDetails');
    this.quantityInput = document.getElementById('quantity');
    this.decreaseBtn = document.getElementById('decreaseQuantity');
    this.increaseBtn = document.getElementById('increaseQuantity');
    this.quantitySummary = document.getElementById('quantitySummary');
    this.maxQuantitySpan = document.getElementById('maxQuantity');
    this.reasonSelect = document.getElementById('reason');
    this.warningBanner = document.getElementById('warningBanner');
    this.criticalWarningBanner = document.getElementById('criticalWarningBanner');
    this.formStatus = document.getElementById('formStatus');
    this.submitLoading = this.submitBtn?.querySelector('.submit-loading');
    
    if (!this.modal) {
      console.error('Stock Out Modal element not found');
      return;
    }
    
    this.setupEventListeners();
    console.log('StockOutModal initialized');
  },
  
  setupEventListeners: function() {
    // Close buttons
    if (this.closeModalBtn) {
      this.closeModalBtn.addEventListener('click', this.close.bind(this));
    }
    
    if (this.cancelBtn) {
      this.cancelBtn.addEventListener('click', this.close.bind(this));
    }
    
    // Submit button
    if (this.submitBtn) {
      this.submitBtn.addEventListener('click', this.showConfirmationDialog.bind(this));
    }
    
    // Product selection
    if (this.productSelect) {
      this.productSelect.addEventListener('change', this.onProductSelect.bind(this));
    }
    
    // Quantity controls
    if (this.decreaseBtn) {
      this.decreaseBtn.addEventListener('click', () => this.adjustQuantity(-1));
    }
    
    if (this.increaseBtn) {
      this.increaseBtn.addEventListener('click', () => this.adjustQuantity(1));
    }
    
    if (this.quantityInput) {
      this.quantityInput.addEventListener('input', this.onQuantityChange.bind(this));
      this.quantityInput.addEventListener('change', this.validateQuantity.bind(this));
    }
    
    // Reason selection
    if (this.reasonSelect) {
      this.reasonSelect.addEventListener('change', this.onReasonChange.bind(this));
    }
    
    // Form validation
    if (this.form) {
      this.form.addEventListener('input', this.validateForm.bind(this));
    }
    
    // Close on overlay click
    this.modal.addEventListener('click', (e) => {
      if (e.target === this.modal) {
        this.close();
      }
    });
    
    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
        this.close();
      }
    });
  },
  
  open: function() {
    if (!this.modal) return;
    
    console.log('Opening Stock Out Modal');
    
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
    this.modal.dispatchEvent(new CustomEvent('stock-out-modal-opened'));
  },
  
  close: function() {
    if (!this.modal) return;
    
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
      
      // Reset selected product
      this.selectedProduct = null;
      
      // Dispatch custom event
      this.modal.dispatchEvent(new CustomEvent('stock-out-modal-closed'));
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
    const selectedOption = this.productSelect.options[this.productSelect.selectedIndex];
    if (!selectedOption.value) {
      this.productDetails.classList.add('hidden');
      this.quantitySummary.classList.add('hidden');
      this.warningBanner.classList.add('hidden');
      this.criticalWarningBanner.classList.add('hidden');
      this.selectedProduct = null;
      return;
    }
    
    // Get product data from option attributes
    const currentStock = parseInt(selectedOption.getAttribute('data-current-stock')) || 0;
    const minStock = parseInt(selectedOption.getAttribute('data-min-stock')) || 0;
    const availableStock = Math.max(0, currentStock - minStock);
    
    this.selectedProduct = {
      id: selectedOption.value,
      name: selectedOption.text.split(' - ')[1]?.split(' (')[0] || selectedOption.text,
      currentStock: currentStock,
      minStock: minStock,
      availableStock: availableStock
    };
    
    // Update product details
    document.getElementById('currentStock').textContent = currentStock;
    document.getElementById('minStock').textContent = minStock;
    document.getElementById('availableStock').textContent = availableStock;
    document.getElementById('stockStatus').textContent = this.getStockStatus(currentStock, minStock);
    
    // Update quantity input max value
    this.quantityInput.max = availableStock;
    this.maxQuantitySpan.textContent = availableStock;
    
    // Update quantity summary
    this.updateQuantitySummary();
    
    // Show details with animation
    this.productDetails.classList.remove('hidden');
    this.productDetails.style.opacity = '0';
    this.productDetails.style.transform = 'translateY(-10px)';
    
    setTimeout(() => {
      this.productDetails.style.transition = 'all 0.3s ease';
      this.productDetails.style.opacity = '1';
      this.productDetails.style.transform = 'translateY(0)';
    }, 100);
    
    // Show quantity summary
    this.quantitySummary.classList.remove('hidden');
    
    // Update warning banners
    this.updateWarningBanners();
  },
  
  getStockStatus: function(currentStock, minStock) {
    if (currentStock <= 0) return 'Out of Stock';
    if (currentStock <= minStock) return 'Low Stock';
    if (currentStock <= minStock * 2) return 'Moderate Stock';
    return 'Good Stock';
  },
  
  adjustQuantity: function(change) {
    if (!this.quantityInput || !this.selectedProduct) return;
    
    let current = parseInt(this.quantityInput.value) || 0;
    let newValue = current + change;
    
    // Validate bounds
    if (newValue < 1) newValue = 1;
    if (newValue > this.selectedProduct.availableStock) {
      newValue = this.selectedProduct.availableStock;
    }
    
    // Update input with animation
    this.quantityInput.value = newValue;
    this.quantityInput.classList.add('quantity-change');
    
    setTimeout(() => {
      this.quantityInput.classList.remove('quantity-change');
    }, 300);
    
    // Update summary and warnings
    this.onQuantityChange();
    
    // Dispatch event
    this.quantityInput.dispatchEvent(new Event('change'));
  },
  
  onQuantityChange: function() {
    if (!this.selectedProduct) return;
    
    const quantity = parseInt(this.quantityInput.value) || 0;
    
    // Update quantity summary
    this.updateQuantitySummary();
    
    // Update warning banners
    this.updateWarningBanners();
    
    // Highlight if removing significant quantity
    if (quantity >= this.selectedProduct.availableStock * 0.5) {
      this.quantityInput.classList.add('high-quantity');
    } else {
      this.quantityInput.classList.remove('high-quantity');
    }
  },
  
  updateQuantitySummary: function() {
    if (!this.selectedProduct) return;
    
    const quantity = parseInt(this.quantityInput.value) || 0;
    const newTotal = this.selectedProduct.currentStock - quantity;
    
    document.getElementById('currentQty').textContent = this.selectedProduct.currentStock;
    document.getElementById('removedQty').textContent = quantity;
    document.getElementById('newTotal').textContent = newTotal;
    
    // Color code based on new stock level
    const newTotalElement = document.getElementById('newTotal');
    if (newTotal <= 0) {
      newTotalElement.className = 'summary-value critical';
    } else if (newTotal <= this.selectedProduct.minStock) {
      newTotalElement.className = 'summary-value warning';
    } else {
      newTotalElement.className = 'summary-value';
    }
  },
  
  validateQuantity: function() {
    if (!this.selectedProduct) return;
    
    let value = parseInt(this.quantityInput.value) || 0;
    const max = this.selectedProduct.availableStock;
    
    if (value < 1) {
      this.quantityInput.value = 1;
      this.showFormStatus('Minimum quantity is 1', 'warning');
    } else if (value > max) {
      this.quantityInput.value = max;
      this.showFormStatus(`Maximum quantity is ${max} (available stock)`, 'warning');
    }
    
    this.onQuantityChange();
  },
  
  onReasonChange: function() {
    // Update warning banners based on reason
    this.updateWarningBanners();
  },
  
  updateWarningBanners: function() {
    if (!this.selectedProduct) {
      this.warningBanner.classList.add('hidden');
      this.criticalWarningBanner.classList.add('hidden');
      return;
    }
    
    const quantity = parseInt(this.quantityInput.value) || 0;
    const newTotal = this.selectedProduct.currentStock - quantity;
    const reason = this.reasonSelect.value;
    
    // Hide both banners initially
    this.warningBanner.classList.add('hidden');
    this.criticalWarningBanner.classList.add('hidden');
    
    // Show critical warning if stock will go to zero or below minimum
    if (newTotal <= 0) {
      document.getElementById('criticalWarningDescription').textContent = 
        `Removing ${quantity} units will result in 0 stock. Consider ordering more soon.`;
      this.criticalWarningBanner.classList.remove('hidden');
      this.submitBtn.classList.add('critical');
    } 
    // Show warning if stock will go below minimum
    else if (newTotal < this.selectedProduct.minStock) {
      document.getElementById('warningTitle').textContent = 'Low Stock Warning';
      document.getElementById('warningDescription').textContent = 
        `This action will reduce stock below minimum required level (${this.selectedProduct.minStock} units).`;
      this.warningBanner.classList.remove('hidden');
      this.submitBtn.classList.add('warning');
    }
    // Show info banner for certain reasons
    else if (reason === 'damaged' || reason === 'adjustment') {
      document.getElementById('warningTitle').textContent = 'Special Attention Required';
      document.getElementById('warningDescription').textContent = 
        reason === 'damaged' 
          ? 'Please document the damage details for quality control.'
          : 'Inventory adjustments require manager approval.';
      this.warningBanner.classList.remove('hidden');
      this.submitBtn.classList.remove('critical', 'warning');
    } else {
      this.submitBtn.classList.remove('critical', 'warning');
    }
  },
  
  validateForm: function() {
    if (!this.form) return false;
    
    let isValid = true;
    let messages = [];
    
    // Validate product selection
    if (!this.productSelect.value) {
      isValid = false;
      messages.push('Please select a product');
      this.productSelect.classList.add('invalid');
    } else {
      this.productSelect.classList.remove('invalid');
      this.productSelect.classList.add('valid');
    }
    
    // Validate quantity
    const quantity = parseInt(this.quantityInput.value) || 0;
    if (quantity < 1) {
      isValid = false;
      messages.push('Quantity must be at least 1');
      this.quantityInput.classList.add('invalid');
    } else if (this.selectedProduct && quantity > this.selectedProduct.availableStock) {
      isValid = false;
      messages.push(`Cannot remove more than ${this.selectedProduct.availableStock} units`);
      this.quantityInput.classList.add('invalid');
    } else {
      this.quantityInput.classList.remove('invalid');
      this.quantityInput.classList.add('valid');
    }
    
    // Validate reason
    if (!this.reasonSelect.value) {
      isValid = false;
      messages.push('Please select a reason');
      this.reasonSelect.classList.add('invalid');
    } else {
      this.reasonSelect.classList.remove('invalid');
      this.reasonSelect.classList.add('valid');
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
  
  resetForm: function() {
    if (!this.form) return;
    
    // Reset form elements
    this.form.reset();
    
    // Reset custom elements
    if (this.productSelect) this.productSelect.value = '';
    if (this.quantityInput) this.quantityInput.value = '1';
    if (this.reasonSelect) this.reasonSelect.value = '';
    
    // Hide details and banners
    this.productDetails.classList.add('hidden');
    this.quantitySummary.classList.add('hidden');
    this.warningBanner.classList.add('hidden');
    this.criticalWarningBanner.classList.add('hidden');
    
    // Clear validation states
    this.clearFormStatus();
    
    // Reset submit button
    this.setSubmitButtonState(false);
    this.submitBtn.classList.remove('critical', 'warning');
    
    // Remove validation classes
    const inputs = this.form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      input.classList.remove('valid', 'invalid');
    });
  },
  
  showConfirmationDialog: function() {
    if (this.isSubmitting || !this.validateForm()) return;
    
    // Get template
    const template = document.getElementById('confirmationDialogTemplate');
    if (!template) {
      this.submitForm();
      return;
    }
    
    // Clone dialog
    const dialog = template.content.cloneNode(true);
    const dialogOverlay = dialog.querySelector('.confirmation-dialog-overlay');
    const dialogMessage = dialog.querySelector('.dialog-message');
    const dialogDetails = dialog.querySelector('.dialog-details');
    const dialogCloseBtn = dialog.querySelector('.dialog-close-btn');
    const dialogCancelBtn = dialog.querySelector('.dialog-cancel-btn');
    const dialogConfirmBtn = dialog.querySelector('.dialog-confirm-btn');
    
    // Populate dialog content
    const quantity = parseInt(this.quantityInput.value) || 0;
    const newTotal = this.selectedProduct.currentStock - quantity;
    
    dialogMessage.textContent = `Are you sure you want to remove ${quantity} units of ${this.selectedProduct.name}?`;
    
    dialogDetails.innerHTML = `
      <div class="detail-row">
        <span class="detail-label">Product:</span>
        <span class="detail-value">${this.selectedProduct.name}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Current Stock:</span>
        <span class="detail-value">${this.selectedProduct.currentStock}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Removing:</span>
        <span class="detail-value">${quantity} units</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">New Stock Level:</span>
        <span class="detail-value ${newTotal <= 0 ? 'critical' : newTotal < this.selectedProduct.minStock ? 'warning' : ''}">
          ${newTotal} ${newTotal < this.selectedProduct.minStock ? '(Below Minimum)' : ''}
        </span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Reason:</span>
        <span class="detail-value">${this.reasonSelect.options[this.reasonSelect.selectedIndex].text}</span>
      </div>
    `;
    
    // Add to document
    document.body.appendChild(dialogOverlay);
    
    // Show with animation
    setTimeout(() => {
      dialogOverlay.classList.add('show');
    }, 10);
    
    // Event listeners for dialog
    const closeDialog = () => {
      dialogOverlay.classList.remove('show');
      setTimeout(() => {
        if (dialogOverlay.parentNode) {
          dialogOverlay.parentNode.removeChild(dialogOverlay);
        }
      }, 300);
    };
    
    dialogCloseBtn.addEventListener('click', closeDialog);
    dialogCancelBtn.addEventListener('click', closeDialog);
    
    dialogConfirmBtn.addEventListener('click', () => {
      closeDialog();
      this.submitForm();
    });
    
    // Close on overlay click
    dialogOverlay.addEventListener('click', (e) => {
      if (e.target === dialogOverlay) {
        closeDialog();
      }
    });
    
    // Close on Escape key
    const handleEscape = (e) => {
      if (e.key === 'Escape') {
        closeDialog();
        document.removeEventListener('keydown', handleEscape);
      }
    };
    document.addEventListener('keydown', handleEscape);
  },
  
  submitForm: async function() {
    if (this.isSubmitting) return;
    
    this.isSubmitting = true;
    
    // Show loading state
    this.setLoadingState(true);
    
    try {
      // Collect form data
      const formData = {
        product_id: this.productSelect.value,
        product_name: this.selectedProduct?.name || '',
        quantity: parseInt(this.quantityInput.value) || 0,
        reason: this.reasonSelect.value,
        reason_text: this.reasonSelect.options[this.reasonSelect.selectedIndex].text,
        notes: document.getElementById('notes')?.value || '',
        current_stock: this.selectedProduct?.currentStock || 0,
        new_stock: this.selectedProduct ? this.selectedProduct.currentStock - parseInt(this.quantityInput.value) : 0,
        submitted_at: new Date().toISOString(),
        user_id: null // In real app, get from auth
      };
      
      console.log('Submitting stock out:', formData);
      
      // Simulate API call delay
      await new Promise(resolve => setTimeout(resolve, 1500));
      
      // Show success message
      this.showSuccessToast(`${formData.quantity} units of ${formData.product_name} removed from inventory`);
      
      // Close modal after successful submission
      setTimeout(() => {
        this.close();
        
        // Dispatch success event
        this.modal.dispatchEvent(new CustomEvent('stock-out-submitted', {
          detail: formData
        }));
      }, 1000);
      
    } catch (error) {
      console.error('Error submitting stock out:', error);
      this.showFormStatus('Failed to record stock out. Please try again.', 'error');
    } finally {
      this.isSubmitting = false;
      this.setLoadingState(false);
    }
  },
  
  setLoadingState: function(isLoading) {
    if (!this.submitBtn || !this.submitLoading) return;
    
    if (isLoading) {
      this.submitBtn.disabled = true;
      this.submitLoading.classList.remove('hidden');
      this.submitBtn.querySelector('.submit-text').style.opacity = '0.5';
    } else {
      this.submitBtn.disabled = false;
      this.submitLoading.classList.add('hidden');
      this.submitBtn.querySelector('.submit-text').style.opacity = '1';
    }
  },
  
  showSuccessToast: function(message) {
    // Remove existing toast
    const existingToast = document.querySelector('.stock-out-toast');
    if (existingToast) {
      existingToast.remove();
    }
    
    // Get template
    const template = document.getElementById('stockOutSuccessToastTemplate');
    if (!template) return;
    
    // Clone and customize toast
    const toast = template.content.cloneNode(true);
    const toastElement = toast.querySelector('.stock-out-toast');
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
  }
};

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  StockOutModal.init();
});
</script>