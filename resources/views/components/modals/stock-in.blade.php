<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div id="stockInModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="stock-in-title">
  <div class="modal-content stock-in">
    <!-- Modal Header -->
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="record-stock-in" id="stock-in-title">Record Stock In</div>
          <div class="modal-subtitle">Add new stock to inventory</div>
        </div>
      </div>
      <button class="modal-close-btn" type="button" id="closeStockInModalBtn" aria-label="Close modal">
        <img class="icon" src="{{ asset('icon0.svg') }}" alt="Close" />
      </button>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">
      <form id="stockInForm" class="stock-form">
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
                  ['id' => 'MED-001', 'name' => 'Portable Ultrasound Machine'],
                  ['id' => 'MED-002', 'name' => 'Patient Monitor'],
                  ['id' => 'MED-003', 'name' => 'Surgical Instruments Set'],
                  ['id' => 'MED-004', 'name' => 'Digital Thermometer'],
                  ['id' => 'MED-005', 'name' => 'Blood Pressure Monitor'],
                  ['id' => 'MED-006', 'name' => 'X-Ray Machine'],
                  ['id' => 'MED-007', 'name' => 'Medical Ventilator'],
                  ['id' => 'MED-008', 'name' => 'Infusion Pump'],
                ];
              @endphp
              @foreach($products as $product)
              <option value="{{ $product['id'] }}">{{ $product['id'] }} - {{ $product['name'] }}</option>
              @endforeach
            </select>
            <div class="select-arrow">▼</div>
          </div>
          <div class="input-hint">Select a product from inventory</div>
        </div>
        
        <!-- Product Details Display -->
        <div class="product-details hidden" id="productDetails">
          <div class="product-info">
            <div class="info-row">
              <span class="info-label">Current Stock:</span>
              <span class="info-value" id="currentStock">0</span>
            </div>
            <div class="info-row">
              <span class="info-label">Warehouse:</span>
              <span class="info-value" id="currentWarehouse">N/A</span>
            </div>
            <div class="info-row">
              <span class="info-label">Status:</span>
              <span class="info-value" id="currentStatus">N/A</span>
            </div>
          </div>
        </div>
        
        <!-- Quantity Input -->
        <div class="form-group">
          <label for="quantity" class="form-label required">
            <div class="label-text">Quantity</div>
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
                   max="9999" 
                   value="1"
                   required>
            <button type="button" class="quantity-btn plus" id="increaseQuantity" aria-label="Increase quantity">
              <span>+</span>
            </button>
          </div>
          <div class="input-hint">Enter quantity (1-9999)</div>
          <div class="quantity-summary hidden" id="quantitySummary">
            <span class="summary-label">New Total:</span>
            <span class="summary-value">
              <span id="currentQty">0</span> + <span id="addedQty">1</span> = <span id="newTotal">1</span>
            </span>
          </div>
        </div>
        
        <!-- Date Picker -->
        <div class="form-group">
          <label for="stockDate" class="form-label required">
            <div class="label-text">Date Received</div>
          </label>
          <input type="text" 
                 id="stockDate" 
                 name="stock_date" 
                 class="date-input" 
                 placeholder="Select date..."
                 required
                 readonly>
          <div class="input-hint">Date when stock was received</div>
        </div>
        
        <!-- Receiving Department -->
        <div class="form-group">
          <label for="receivingDepartment" class="form-label">
            <div class="label-text">Receiving Department</div>
          </label>
          <input type="text" 
                 id="receivingDepartment" 
                 name="receiving_department" 
                 class="form-input" 
                 placeholder="e.g., Central Receiving"
                 maxlength="100">
          <div class="input-hint">Optional: Department that received the stock</div>
        </div>
        
        <!-- Location Details -->
        <div class="form-group">
          <label class="form-label">
            <div class="label-text">Storage Location</div>
          </label>
          <div class="location-grid">
            <div class="location-input">
              <label for="shelf" class="location-label">Shelf</label>
              <input type="text" 
                     id="shelf" 
                     name="shelf" 
                     class="form-input small" 
                     placeholder="A1"
                     maxlength="10">
            </div>
            <div class="location-input">
              <label for="rack" class="location-label">Rack</label>
              <input type="text" 
                     id="rack" 
                     name="rack" 
                     class="form-input small" 
                     placeholder="R5"
                     maxlength="10">
            </div>
            <div class="location-input">
              <label for="area" class="location-label">Area</label>
              <input type="text" 
                     id="area" 
                     name="area" 
                     class="form-input small" 
                     placeholder="Section B"
                     maxlength="20">
            </div>
          </div>
          <div class="input-hint">Optional: Specific storage location details</div>
        </div>
        
        <!-- Additional Notes -->
        <div class="form-group">
          <label for="notes" class="form-label">
            <div class="label-text">Additional Notes</div>
          </label>
          <textarea id="notes" 
                    name="notes" 
                    class="form-textarea" 
                    placeholder="Any additional information about this stock in..."
                    rows="2"></textarea>
          <div class="input-hint">Optional: Supplier, batch number, special instructions, etc.</div>
        </div>
        
        <!-- Confirmation Banner -->
        <div class="confirmation-banner" id="confirmationBanner">
          <div class="banner-content">
            <img class="banner-icon" src="{{ asset('icon1.svg') }}" alt="Info" />
            <div class="banner-message">
              <div class="banner-title">Stock will be added to inventory</div>
              <div class="banner-description" id="bannerDescription"></div>
            </div>
          </div>
        </div>
        
        <!-- Form Status Messages -->
        <div id="formStatus" class="form-status hidden"></div>
      </form>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">
      <button class="cancel-btn" type="button" id="cancelStockInBtn">
        <div class="cancel-text">Cancel</div>
      </button>
      <button class="submit-btn" type="button" id="submitStockInBtn">
        <div class="submit-text">Save Stock In</div>
        <div class="submit-loading hidden">
          <div class="loading-spinner-small"></div>
        </div>
      </button>
    </div>
  </div>
</div>

<!-- Success Toast Template -->
<template id="stockSuccessToastTemplate">
  <div class="success-toast stock-toast">
    <div class="toast-content">
      <img class="toast-icon" src="{{ asset('icon-check.svg') }}" alt="Success" />
      <div class="toast-message"></div>
    </div>
  </div>
</template>

<!-- Stock In Modal JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// Stock In Modal Namespace
window.StockInModal = {
  isSubmitting: false,
  productsData: {},
  
  init: function() {
    this.modal = document.getElementById('stockInModal');
    this.closeModalBtn = document.getElementById('closeStockInModalBtn');
    this.cancelBtn = document.getElementById('cancelStockInBtn');
    this.submitBtn = document.getElementById('submitStockInBtn');
    this.form = document.getElementById('stockInForm');
    this.productSelect = document.getElementById('productSelect');
    this.productDetails = document.getElementById('productDetails');
    this.quantityInput = document.getElementById('quantity');
    this.decreaseBtn = document.getElementById('decreaseQuantity');
    this.increaseBtn = document.getElementById('increaseQuantity');
    this.quantitySummary = document.getElementById('quantitySummary');
    this.formStatus = document.getElementById('formStatus');
    this.confirmationBanner = document.getElementById('confirmationBanner');
    this.submitLoading = this.submitBtn?.querySelector('.submit-loading');
    this.stockDateInput = document.getElementById('stockDate');
    
    if (!this.modal) {
      console.error('Stock In Modal element not found');
      return;
    }
    
    this.loadProductsData();
    this.setupEventListeners();
    this.initDatePicker();
    console.log('StockInModal initialized');
  },
  
  loadProductsData: function() {
    // In a real app, this would come from an API
    this.productsData = {
      'MED-001': { name: 'Portable Ultrasound Machine', current_stock: 15, warehouse: 'Warehouse A', status: 'good' },
      'MED-002': { name: 'Patient Monitor', current_stock: 3, warehouse: 'Warehouse B', status: 'low' },
      'MED-003': { name: 'Surgical Instruments Set', current_stock: 8, warehouse: 'Warehouse C', status: 'good' },
      'MED-004': { name: 'Digital Thermometer', current_stock: 0, warehouse: 'Warehouse A', status: 'out' },
      'MED-005': { name: 'Blood Pressure Monitor', current_stock: 2, warehouse: 'Warehouse B', status: 'low' },
      'MED-006': { name: 'X-Ray Machine', current_stock: 5, warehouse: 'Warehouse C', status: 'good' },
      'MED-007': { name: 'Medical Ventilator', current_stock: 12, warehouse: 'Warehouse A', status: 'good' },
      'MED-008': { name: 'Infusion Pump', current_stock: 7, warehouse: 'Warehouse B', status: 'good' },
    };
  },
  
  initDatePicker: function() {
    if (this.stockDateInput) {
      this.datePicker = flatpickr(this.stockDateInput, {
        dateFormat: "Y-m-d",
        defaultDate: "today",
        maxDate: "today",
        onChange: (selectedDates, dateStr) => {
          this.updateConfirmationBanner();
        }
      });
    }
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
      this.submitBtn.addEventListener('click', this.submitForm.bind(this));
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
    
    console.log('Opening Stock In Modal');
    
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
    this.modal.dispatchEvent(new CustomEvent('stock-in-modal-opened'));
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
      
      // Dispatch custom event
      this.modal.dispatchEvent(new CustomEvent('stock-in-modal-closed'));
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
    const productId = this.productSelect.value;
    if (!productId) {
      this.productDetails.classList.add('hidden');
      this.quantitySummary.classList.add('hidden');
      return;
    }
    
    const product = this.productsData[productId];
    if (product) {
      // Update product details
      document.getElementById('currentStock').textContent = product.current_stock;
      document.getElementById('currentWarehouse').textContent = product.warehouse;
      document.getElementById('currentStatus').textContent = this.getStatusText(product.status);
      
      // Update quantity summary
      document.getElementById('currentQty').textContent = product.current_stock;
      document.getElementById('addedQty').textContent = this.quantityInput.value;
      document.getElementById('newTotal').textContent = product.current_stock + parseInt(this.quantityInput.value);
      
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
      
      // Update confirmation banner
      this.updateConfirmationBanner();
    }
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
  
  adjustQuantity: function(change) {
    if (!this.quantityInput) return;
    
    let current = parseInt(this.quantityInput.value) || 0;
    let newValue = current + change;
    
    // Validate bounds
    if (newValue < 1) newValue = 1;
    if (newValue > 9999) newValue = 9999;
    
    // Update input with animation
    this.quantityInput.value = newValue;
    this.quantityInput.classList.add('quantity-change');
    
    setTimeout(() => {
      this.quantityInput.classList.remove('quantity-change');
    }, 300);
    
    // Update summary
    this.onQuantityChange();
    
    // Dispatch event
    this.quantityInput.dispatchEvent(new Event('change'));
  },
  
  onQuantityChange: function() {
    const quantity = parseInt(this.quantityInput.value) || 0;
    const productId = this.productSelect.value;
    
    if (productId && this.productsData[productId]) {
      const currentStock = this.productsData[productId].current_stock;
      const newTotal = currentStock + quantity;
      
      // Update quantity summary
      document.getElementById('addedQty').textContent = quantity;
      document.getElementById('newTotal').textContent = newTotal;
      
      // Highlight if quantity is significant
      if (quantity >= 100) {
        this.quantityInput.classList.add('large-quantity');
      } else {
        this.quantityInput.classList.remove('large-quantity');
      }
      
      // Update confirmation banner
      this.updateConfirmationBanner();
    }
  },
  
  validateQuantity: function() {
    let value = parseInt(this.quantityInput.value) || 0;
    
    if (value < 1) {
      this.quantityInput.value = 1;
      this.showFormStatus('Minimum quantity is 1', 'warning');
    } else if (value > 9999) {
      this.quantityInput.value = 9999;
      this.showFormStatus('Maximum quantity is 9999', 'warning');
    }
    
    this.onQuantityChange();
  },
  
  updateConfirmationBanner: function() {
    if (!this.confirmationBanner) return;
    
    const productId = this.productSelect.value;
    const quantity = parseInt(this.quantityInput.value) || 0;
    const date = this.stockDateInput.value || 'today';
    
    if (productId && quantity > 0) {
      const product = this.productsData[productId];
      const description = `${quantity} units of ${product?.name || 'selected product'} will be added to ${product?.warehouse || 'inventory'} on ${date}.`;
      
      document.getElementById('bannerDescription').textContent = description;
      this.confirmationBanner.classList.remove('hidden');
    } else {
      this.confirmationBanner.classList.add('hidden');
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
    if (quantity < 1 || quantity > 9999) {
      isValid = false;
      messages.push('Quantity must be between 1 and 9999');
      this.quantityInput.classList.add('invalid');
    } else {
      this.quantityInput.classList.remove('invalid');
      this.quantityInput.classList.add('valid');
    }
    
    // Validate date
    if (!this.stockDateInput.value) {
      isValid = false;
      messages.push('Please select a date');
      this.stockDateInput.classList.add('invalid');
    } else {
      this.stockDateInput.classList.remove('invalid');
      this.stockDateInput.classList.add('valid');
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
    if (this.stockDateInput && this.datePicker) {
      this.datePicker.setDate(new Date());
    }
    
    // Hide details and banner
    this.productDetails.classList.add('hidden');
    this.quantitySummary.classList.add('hidden');
    this.confirmationBanner.classList.add('hidden');
    
    // Clear validation states
    this.clearFormStatus();
    
    // Reset submit button
    this.setSubmitButtonState(false);
    
    // Remove validation classes
    const inputs = this.form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      input.classList.remove('valid', 'invalid');
    });
  },
  
  submitForm: async function() {
    if (this.isSubmitting) return;
    
    // Validate form
    if (!this.validateForm()) {
      this.showFormStatus('Please fix the errors before submitting.', 'error');
      return;
    }
    
    this.isSubmitting = true;
    
    // Show loading state
    this.setLoadingState(true);
    
    try {
      // Collect form data
      const formData = {
        product_id: this.productSelect.value,
        product_name: this.productsData[this.productSelect.value]?.name || '',
        quantity: parseInt(this.quantityInput.value) || 0,
        stock_date: this.stockDateInput.value,
        receiving_department: document.getElementById('receivingDepartment')?.value || '',
        shelf: document.getElementById('shelf')?.value || '',
        rack: document.getElementById('rack')?.value || '',
        area: document.getElementById('area')?.value || '',
        notes: document.getElementById('notes')?.value || '',
        submitted_at: new Date().toISOString(),
        user_id: null // In real app, get from auth
      };
      
      console.log('Submitting stock in:', formData);
      
      // Simulate API call delay
      await new Promise(resolve => setTimeout(resolve, 1500));
      
      // Show success message
      this.showSuccessToast(`${formData.quantity} units of ${formData.product_name} added to inventory`);
      
      // Close modal after successful submission
      setTimeout(() => {
        this.close();
        
        // Dispatch success event
        this.modal.dispatchEvent(new CustomEvent('stock-in-submitted', {
          detail: formData
        }));
      }, 1000);
      
    } catch (error) {
      console.error('Error submitting stock in:', error);
      this.showFormStatus('Failed to record stock in. Please try again.', 'error');
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
    const existingToast = document.querySelector('.stock-toast');
    if (existingToast) {
      existingToast.remove();
    }
    
    // Get template
    const template = document.getElementById('stockSuccessToastTemplate');
    if (!template) return;
    
    // Clone and customize toast
    const toast = template.content.cloneNode(true);
    const toastElement = toast.querySelector('.stock-toast');
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
  StockInModal.init();
});
</script>