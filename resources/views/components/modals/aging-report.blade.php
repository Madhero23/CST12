<div id="agingReportModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="modal-title">
  <div class="modal-content aging-inventory-report">
    <!-- Modal Header -->
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="aging-inventory-report2" id="modal-title">Aging Inventory Report</div>
        </div>
      </div>
      <button class="modal-close-btn" type="button" id="closeModalBtn" aria-label="Close modal">
        <img class="icon" src="{{ asset('icon0.svg') }}" alt="Close" />
      </button>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">
      <!-- Alert Banner -->
      <div class="alert-banner">
        <div class="alert-content">
          <img class="alert-icon" src="{{ asset('icon1.svg') }}" alt="Alert" />
          <div class="alert-message">
            <div class="items-older-than-6-months-with-low-turnover">
              Items older than 6 months with low turnover
            </div>
          </div>
        </div>
      </div>
      
      <!-- Aging Items List -->
      <div class="aging-items-list">
        @php
          $agingItems = [
            [
              'name' => 'Medical Ultrasound Device',
              'mfg_date' => '2023-06-15',
              'received_date' => '2023-08-20',
              'location' => 'Warehouse A - A1',
              'quantity' => 15,
              'status' => 'aging'
            ],
            [
              'name' => 'Patient Monitor',
              'mfg_date' => '2023-09-10',
              'received_date' => '2023-11-05',
              'location' => 'Warehouse B - B2',
              'quantity' => 8,
              'status' => 'aging'
            ],
            [
              'name' => 'Surgical Instruments Set',
              'mfg_date' => '2023-05-20',
              'received_date' => '2023-07-15',
              'location' => 'Warehouse C - C1',
              'quantity' => 5,
              'status' => 'aging'
            ],
            [
              'name' => 'X-Ray Machine',
              'mfg_date' => '2023-04-12',
              'received_date' => '2023-06-25',
              'location' => 'Warehouse A - A3',
              'quantity' => 24,
              'status' => 'critical'
            ]
          ];
        @endphp
        
        @foreach($agingItems as $item)
        <div class="aging-item-card" data-status="{{ $item['status'] }}">
          <div class="item-header">
            <div class="item-title">
              <div class="item-name">{{ $item['name'] }}</div>
            </div>
            <div class="item-status">
              <div class="aging-stock">Aging Stock</div>
            </div>
          </div>
          
          <div class="item-details">
            <div class="detail-row">
              <div class="detail-label">Mfg Date:</div>
              <div class="detail-value">{{ $item['mfg_date'] }}</div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Received:</div>
              <div class="detail-value">{{ $item['received_date'] }}</div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Location:</div>
              <div class="detail-value">{{ $item['location'] }}</div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Qty:</div>
              <div class="detail-value">{{ $item['quantity'] }}</div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">
      <button class="export-btn" type="button" id="exportReportBtn">
        <img class="icon" src="{{ asset('icon-export.svg') }}" alt="Export" />
        <div class="button-label">Export Report</div>
      </button>
      <button class="close-btn" type="button" id="modalCloseBtn">
        <div class="close-text">Close</div>
      </button>
    </div>
  </div>
</div>

<!-- Modal JavaScript -->
<script>
// Create namespace to avoid conflicts
window.AgingReportModal = {
  init: function() {
    this.modal = document.getElementById('agingReportModal');
    this.closeModalBtn = document.getElementById('closeModalBtn');
    this.modalCloseBtn = document.getElementById('modalCloseBtn');
    this.exportReportBtn = document.getElementById('exportReportBtn');
    
    if (!this.modal) return;
    
    this.setupEventListeners();
  },
  
  setupEventListeners: function() {
    // Close buttons
    if (this.closeModalBtn) {
      this.closeModalBtn.addEventListener('click', this.close.bind(this));
    }
    
    if (this.modalCloseBtn) {
      this.modalCloseBtn.addEventListener('click', this.close.bind(this));
    }
    
    // Export button
    if (this.exportReportBtn) {
      this.exportReportBtn.addEventListener('click', this.exportReport.bind(this));
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
    
    // Remove hidden class and set aria attributes
    this.modal.classList.remove('hidden');
    this.modal.setAttribute('aria-hidden', 'false');
    
    // Add opening animation
    this.modal.classList.add('modal-opening');
    
    // Prevent body scrolling
    document.body.style.overflow = 'hidden';
    
    // Focus trap setup
    this.setupFocusTrap();
    
    // Animate items sequentially
    this.animateItems();
    
    // Dispatch custom event
    this.modal.dispatchEvent(new CustomEvent('modal-opened'));
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
      this.modal.dispatchEvent(new CustomEvent('modal-closed'));
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
  
  animateItems: function() {
    const items = this.modal.querySelectorAll('.aging-item-card');
    items.forEach((item, index) => {
      item.style.opacity = '0';
      item.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        item.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
      }, 100 * (index + 1));
    });
  },
  
  exportReport: function() {
    // Add click animation
    this.exportReportBtn.style.transform = 'scale(0.95)';
    setTimeout(() => {
      this.exportReportBtn.style.transform = 'scale(1)';
    }, 150);
    
    // Show export toast
    this.showToast('Aging report exported successfully!', 'success');
    
    // In a real app, you would make an AJAX request here
    // Example: fetch('/api/export/aging-report', { method: 'POST' })
    
    // Dispatch export event
    this.modal.dispatchEvent(new CustomEvent('report-exported'));
  },
  
  showToast: function(message, type = 'success') {
    // Remove existing toast
    const existingToast = document.querySelector('.export-toast');
    if (existingToast) {
      existingToast.remove();
    }
    
    // Create toast
    const toast = document.createElement('div');
    toast.className = `export-toast toast-${type}`;
    toast.innerHTML = `
      <div class="toast-content">
        <img src="{{ asset('icon-check.svg') }}" alt="Success" />
        <span>${message}</span>
      </div>
    `;
    
    document.body.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
      toast.classList.add('toast-hiding');
      setTimeout(() => {
        if (toast.parentNode) {
          toast.parentNode.removeChild(toast);
        }
      }, 300);
    }, 3000);
  },
  
  // Optional: Method to update modal data dynamically
  updateData: function(newData) {
    const itemsList = this.modal.querySelector('.aging-items-list');
    if (!itemsList) return;
    
    // Clear current items
    itemsList.innerHTML = '';
    
    // Add new items
    newData.forEach((item, index) => {
      const itemHtml = `
        <div class="aging-item-card" data-status="${item.status}">
          <div class="item-header">
            <div class="item-title">
              <div class="item-name">${item.name}</div>
            </div>
            <div class="item-status">
              <div class="aging-stock">Aging Stock</div>
            </div>
          </div>
          <div class="item-details">
            <div class="detail-row">
              <div class="detail-label">Mfg Date:</div>
              <div class="detail-value">${item.mfg_date}</div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Received:</div>
              <div class="detail-value">${item.received_date}</div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Location:</div>
              <div class="detail-value">${item.location}</div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Qty:</div>
              <div class="detail-value">${item.quantity}</div>
            </div>
          </div>
        </div>
      `;
      
      itemsList.insertAdjacentHTML('beforeend', itemHtml);
    });
    
    // Re-animate items
    this.animateItems();
  }
};

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  AgingReportModal.init();
});
</script>