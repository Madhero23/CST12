<div id="updateLocationModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="update-location-title">
  <div class="modal-content update-location">
    <!-- Modal Header -->
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="update-location2" id="update-location-title">Update Location</div>
          <div class="modal-subtitle" id="modalSubtitle">Update item location details</div>
        </div>
      </div>
      <button class="modal-close-btn" type="button" id="closeUpdateLocationModalBtn" aria-label="Close modal">
        <img class="icon" src="{{ asset('icon0.svg') }}" alt="Close" />
      </button>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">
      <form id="updateLocationForm" class="location-form">
        <!-- Item Display (Read-only) -->
        <div class="form-group">
          <label for="itemName" class="form-label">
            <div class="label-text">Item</div>
          </label>
          <div class="form-input-display" id="itemNameDisplay">
            <div class="item-name-text">Select an item</div>
          </div>
          <input type="hidden" id="itemName" name="item_name">
        </div>
        
        <!-- Warehouse Location Dropdown -->
        <div class="form-group">
          <label for="warehouseLocation" class="form-label">
            <div class="label-text">Warehouse Location</div>
          </label>
          <div class="custom-select">
            <select id="warehouseLocation" name="warehouse_location" class="form-select" required>
              <option value="" disabled selected>Select Warehouse...</option>
              <option value="warehouse_a">Warehouse A</option>
              <option value="warehouse_b">Warehouse B</option>
              <option value="warehouse_c">Warehouse C</option>
              <option value="warehouse_d">Warehouse D</option>
            </select>
            <div class="select-arrow">▼</div>
          </div>
        </div>
        
        <!-- Shelf Input -->
        <div class="form-group">
          <label for="shelf" class="form-label">
            <div class="label-text">Shelf</div>
          </label>
          <input type="text" 
                 id="shelf" 
                 name="shelf" 
                 class="form-input" 
                 placeholder="e.g., A1"
                 maxlength="10">
          <div class="input-hint">Enter shelf identifier</div>
        </div>
        
        <!-- Rack Input -->
        <div class="form-group">
          <label for="rack" class="form-label">
            <div class="label-text">Rack</div>
          </label>
          <input type="text" 
                 id="rack" 
                 name="rack" 
                 class="form-input" 
                 placeholder="e.g., R5"
                 maxlength="10">
          <div class="input-hint">Enter rack number</div>
        </div>
        
        <!-- Area/Section Input -->
        <div class="form-group">
          <label for="areaSection" class="form-label">
            <div class="label-text">Area / Section</div>
          </label>
          <input type="text" 
                 id="areaSection" 
                 name="area_section" 
                 class="form-input" 
                 placeholder="e.g., Section B"
                 maxlength="50">
          <div class="input-hint">Enter area or section name</div>
        </div>
        
        <!-- Additional Notes -->
        <div class="form-group">
          <label for="additionalNotes" class="form-label">
            <div class="label-text">Additional Notes</div>
          </label>
          <textarea id="additionalNotes" 
                    name="additional_notes" 
                    class="form-textarea" 
                    placeholder="Any additional location details..."
                    rows="3"></textarea>
          <div class="input-hint">Optional: Add notes about the location</div>
        </div>
        
        <!-- Form Status Messages -->
        <div id="formStatus" class="form-status hidden"></div>
      </form>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">
      <button class="cancel-btn" type="button" id="cancelUpdateBtn">
        <div class="cancel-text">Cancel</div>
      </button>
      <button class="submit-btn" type="button" id="submitUpdateBtn">
        <div class="submit-text">Update Location</div>
        <div class="submit-loading hidden">
          <div class="loading-spinner-small"></div>
        </div>
      </button>
    </div>
  </div>
</div>

<!-- Success Toast Template -->
<template id="successToastTemplate">
  <div class="success-toast">
    <div class="toast-content">
      <img class="toast-icon" src="{{ asset('icon-check.svg') }}" alt="Success" />
      <div class="toast-message"></div>
    </div>
  </div>
</template>

<!-- Update Location Modal JavaScript -->
<script>
// Update Location Modal Namespace
window.UpdateLocationModal = {
  currentItem: null,
  isSubmitting: false,
  
  init: function() {
    this.modal = document.getElementById('updateLocationModal');
    this.closeModalBtn = document.getElementById('closeUpdateLocationModalBtn');
    this.cancelBtn = document.getElementById('cancelUpdateBtn');
    this.submitBtn = document.getElementById('submitUpdateBtn');
    this.form = document.getElementById('updateLocationForm');
    this.itemNameDisplay = document.getElementById('itemNameDisplay');
    this.itemNameInput = document.getElementById('itemName');
    this.formStatus = document.getElementById('formStatus');
    this.submitLoading = this.submitBtn?.querySelector('.submit-loading');
    this.modalSubtitle = document.getElementById('modalSubtitle');
    
    if (!this.modal) {
      console.error('Update Location Modal element not found');
      return;
    }
    
    this.setupEventListeners();
    console.log('UpdateLocationModal initialized');
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
    
    // Form validation on input
    if (this.form) {
      this.form.addEventListener('input', this.validateForm.bind(this));
    }
  },
  
  open: function(itemData) {
    if (!this.modal) return;
    
    console.log('Opening Update Location Modal for:', itemData);
    
    // Store current item data
    this.currentItem = itemData;
    
    // Remove hidden class and set aria attributes
    this.modal.classList.remove('hidden');
    this.modal.setAttribute('aria-hidden', 'false');
    
    // Add opening animation
    this.modal.classList.add('modal-opening');
    
    // Prevent body scrolling
    document.body.style.overflow = 'hidden';
    
    // Focus trap setup
    this.setupFocusTrap();
    
    // Populate form with item data
    this.populateForm(itemData);
    
    // Reset form state
    this.resetForm();
    
    // Dispatch custom event
    this.modal.dispatchEvent(new CustomEvent('update-location-modal-opened', {
      detail: { item: itemData }
    }));
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
      
      // Reset current item
      this.currentItem = null;
      
      // Dispatch custom event
      this.modal.dispatchEvent(new CustomEvent('update-location-modal-closed'));
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
    
    // Store the bound function so we can remove it later
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
  
  populateForm: function(itemData) {
    if (!itemData) return;
    
    // Update item name display
    if (this.itemNameDisplay) {
      const itemNameText = this.itemNameDisplay.querySelector('.item-name-text');
      if (itemNameText) {
        itemNameText.textContent = itemData.name || 'Unknown Item';
        itemNameText.classList.add('text-pop');
      }
      
      // Set hidden input value
      if (this.itemNameInput) {
        this.itemNameInput.value = itemData.name || '';
      }
    }
    
    // Update modal subtitle
    if (this.modalSubtitle) {
      this.modalSubtitle.textContent = `Update location for: ${itemData.name}`;
    }
    
    // Populate with existing data if available
    if (itemData.existingLocation) {
      const { warehouse, shelf, rack, area_section, notes } = itemData.existingLocation;
      
      if (warehouse && document.getElementById('warehouseLocation')) {
        document.getElementById('warehouseLocation').value = warehouse;
      }
      
      if (shelf && document.getElementById('shelf')) {
        document.getElementById('shelf').value = shelf;
      }
      
      if (rack && document.getElementById('rack')) {
        document.getElementById('rack').value = rack;
      }
      
      if (area_section && document.getElementById('areaSection')) {
        document.getElementById('areaSection').value = area_section;
      }
      
      if (notes && document.getElementById('additionalNotes')) {
        document.getElementById('additionalNotes').value = notes;
      }
    }
    
    // Animate form fields
    this.animateFormFields();
  },
  
  animateFormFields: function() {
    const formGroups = this.modal.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
      group.style.opacity = '0';
      group.style.transform = 'translateY(10px)';
      
      setTimeout(() => {
        group.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        group.style.opacity = '1';
        group.style.transform = 'translateY(0)';
      }, 100 * (index + 1));
    });
  },
  
  resetForm: function() {
    if (!this.form) return;
    
    // Reset validation states
    this.clearFormStatus();
    
    // Reset submit button state
    this.setSubmitButtonState(false);
    
    // Clear all form fields except item name
    const inputs = this.form.querySelectorAll('input:not([type="hidden"]), select, textarea');
    inputs.forEach(input => {
      if (input.id !== 'itemName') {
        input.value = '';
        input.classList.remove('valid', 'invalid');
      }
    });
    
    // Reset warehouse dropdown
    const warehouseSelect = document.getElementById('warehouseLocation');
    if (warehouseSelect) {
      warehouseSelect.value = '';
    }
  },
  
  validateForm: function() {
    if (!this.form) return false;
    
    const warehouseSelect = document.getElementById('warehouseLocation');
    const shelfInput = document.getElementById('shelf');
    const rackInput = document.getElementById('rack');
    
    let isValid = true;
    let messages = [];
    
    // Validate warehouse selection
    if (!warehouseSelect.value) {
      isValid = false;
      messages.push('Please select a warehouse location');
      warehouseSelect.classList.add('invalid');
    } else {
      warehouseSelect.classList.remove('invalid');
      warehouseSelect.classList.add('valid');
    }
    
    // Validate shelf (optional but recommended)
    if (shelfInput.value && shelfInput.value.length > 10) {
      isValid = false;
      messages.push('Shelf identifier is too long (max 10 characters)');
      shelfInput.classList.add('invalid');
    } else if (shelfInput.value) {
      shelfInput.classList.remove('invalid');
      shelfInput.classList.add('valid');
    } else {
      shelfInput.classList.remove('invalid', 'valid');
    }
    
    // Validate rack (optional but recommended)
    if (rackInput.value && rackInput.value.length > 10) {
      isValid = false;
      messages.push('Rack number is too long (max 10 characters)');
      rackInput.classList.add('invalid');
    } else if (rackInput.value) {
      rackInput.classList.remove('invalid');
      rackInput.classList.add('valid');
    } else {
      rackInput.classList.remove('invalid', 'valid');
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
    
    // Auto-hide info messages after 5 seconds
    if (type === 'info') {
      setTimeout(() => {
        this.clearFormStatus();
      }, 5000);
    }
  },
  
  clearFormStatus: function() {
    if (!this.formStatus) return;
    
    this.formStatus.innerHTML = '';
    this.formStatus.className = 'form-status hidden';
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
        item_id: this.currentItem?.id || null,
        item_name: document.getElementById('itemName')?.value || '',
        warehouse_location: document.getElementById('warehouseLocation')?.value || '',
        shelf: document.getElementById('shelf')?.value || '',
        rack: document.getElementById('rack')?.value || '',
        area_section: document.getElementById('areaSection')?.value || '',
        additional_notes: document.getElementById('additionalNotes')?.value || '',
        updated_at: new Date().toISOString()
      };
      
      console.log('Submitting location update:', formData);
      
      // Simulate API call delay
      await new Promise(resolve => setTimeout(resolve, 1500));
      
      // In a real app, you would make an AJAX request here
      // Example: 
      // const response = await fetch('/api/inventory/update-location', {
      //   method: 'POST',
      //   headers: {
      //     'Content-Type': 'application/json',
      //     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      //   },
      //   body: JSON.stringify(formData)
      // });
      
      // Show success message
      this.showSuccessToast(`Location updated for ${formData.item_name}`);
      
      // Close modal after successful submission
      setTimeout(() => {
        this.close();
        
        // Dispatch success event
        this.modal.dispatchEvent(new CustomEvent('location-updated', {
          detail: { 
            item: this.currentItem, 
            newLocation: formData 
          }
        }));
      }, 1000);
      
    } catch (error) {
      console.error('Error updating location:', error);
      this.showFormStatus('Failed to update location. Please try again.', 'error');
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
    const existingToast = document.querySelector('.success-toast');
    if (existingToast) {
      existingToast.remove();
    }
    
    // Get template
    const template = document.getElementById('successToastTemplate');
    if (!template) return;
    
    // Clone and customize toast
    const toast = template.content.cloneNode(true);
    const toastElement = toast.querySelector('.success-toast');
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

// Helper to open modal from table buttons
function openUpdateLocationModal(itemName) {
  // Get additional item data from the table row if needed
  const row = document.querySelector(`[data-item="${itemName}"]`)?.closest('.table-row');
  const itemData = {
    name: itemName,
    id: row?.getAttribute('data-item-id') || null,
    existingLocation: {
      warehouse: row?.getAttribute('data-warehouse') || '',
      shelf: row?.getAttribute('data-shelf') || '',
      rack: row?.getAttribute('data-rack') || '',
      area_section: row?.getAttribute('data-area-section') || ''
    }
  };
  
  if (window.UpdateLocationModal) {
    UpdateLocationModal.open(itemData);
  }
}

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  UpdateLocationModal.init();
});
</script>