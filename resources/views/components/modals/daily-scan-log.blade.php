@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

<div id="dailyScanLogModal" class="modal-overlay hidden" aria-hidden="true" role="dialog" aria-labelledby="daily-scan-log-title">
  <div class="modal-content daily-scan-log">
    <!-- Modal Header -->
    <div class="modal-header">
      <div class="modal-title-container">
        <div class="heading-2">
          <div class="daily-scan-log2" id="daily-scan-log-title">Daily Scan Log</div>
          <div class="modal-subtitle">Track all inventory scans for today</div>
        </div>
      </div>
      <button class="modal-close-btn" type="button" id="closeDailyScanModalBtn" aria-label="Close modal">
        <img class="icon" src="{{ asset('icon0.svg') }}" alt="Close" />
      </button>
    </div>
    
    <!-- Modal Body -->
    <div class="modal-body">
      <!-- Date Picker Section -->
      <div class="date-picker-section">
        <div class="date-picker-container">
          <input type="text" 
                 id="scanLogDatePicker" 
                 class="date-picker-input" 
                 placeholder="Select date..."
                 data-date-format="Y-m-d"
                 value="{{ date('Y-m-d') }}">
          <button class="date-picker-today-btn" id="todayBtn">Today</button>
        </div>
        <button class="load-scans-btn" id="loadScansBtn">
          <div class="load-scans">Load Scans</div>
        </button>
      </div>
      
      <!-- Scans List -->
      <div class="scans-list-container" id="scansList">
        @php
          $scans = [
            [
              'time' => '08:23 AM',
              'description' => 'Patient Monitor scanned at Warehouse A',
              'type' => 'scan',
              'status' => 'completed'
            ],
            [
              'time' => '09:15 AM',
              'description' => 'X-Ray Machine scanned at Warehouse B',
              'type' => 'scan',
              'status' => 'completed'
            ],
            [
              'time' => '10:45 AM',
              'description' => 'Surgical Instruments scanned at Warehouse C',
              'type' => 'scan',
              'status' => 'completed'
            ],
            [
              'time' => '11:30 AM',
              'description' => 'Ultrasound Device scanned at Warehouse A',
              'type' => 'scan',
              'status' => 'completed'
            ],
            [
              'time' => '02:15 PM',
              'description' => 'Patient Monitor transferred to Warehouse B',
              'type' => 'transfer',
              'status' => 'completed'
            ],
            [
              'time' => '04:45 PM',
              'description' => 'X-Ray Machine - Stock check completed',
              'type' => 'check',
              'status' => 'completed'
            ]
          ];
        @endphp
        
        @foreach($scans as $scan)
        <div class="scan-item" data-type="{{ $scan['type'] }}" data-status="{{ $scan['status'] }}">
          <div class="scan-time">
            <div class="time-text">{{ $scan['time'] }}</div>
          </div>
          <div class="scan-details">
            <div class="scan-description">{{ $scan['description'] }}</div>
            <div class="scan-type">{{ ucfirst($scan['type']) }}</div>
          </div>
          <div class="scan-status">
            <div class="status-indicator status-{{ $scan['status'] }}"></div>
          </div>
        </div>
        @endforeach
        
        <!-- Empty State -->
        <div class="empty-state hidden" id="emptyScansState">
          <img src="{{ asset('icon-empty.svg') }}" alt="No scans" class="empty-icon" />
          <div class="empty-title">No scans found</div>
          <div class="empty-description">No scans were recorded for the selected date.</div>
        </div>
        
        <!-- Loading State -->
        <div class="loading-state hidden" id="loadingScans">
          <div class="loading-spinner"></div>
          <div class="loading-text">Loading scans...</div>
        </div>
      </div>
    </div>
    
    <!-- Modal Footer -->
    <div class="modal-footer">
      <button class="export-btn" type="button" id="exportCsvBtn">
        <img class="icon" src="{{ asset('icon1.svg') }}" alt="Export" />
        <div class="export-text">Export CSV</div>
      </button>
      <button class="close-btn" type="button" id="dailyScanCloseBtn">
        <div class="close-text">Close</div>
      </button>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// Daily Scan Log Modal Namespace
window.DailyScanLogModal = {
  init: function() {
    this.modal = document.getElementById('dailyScanLogModal');
    this.closeModalBtn = document.getElementById('closeDailyScanModalBtn');
    this.closeBtn = document.getElementById('dailyScanCloseBtn');
    this.exportBtn = document.getElementById('exportCsvBtn');
    this.loadScansBtn = document.getElementById('loadScansBtn');
    this.todayBtn = document.getElementById('todayBtn');
    this.datePickerInput = document.getElementById('scanLogDatePicker');
    this.scansList = document.getElementById('scansList');
    this.emptyState = document.getElementById('emptyScansState');
    this.loadingState = document.getElementById('loadingScans');
    
    if (!this.modal) return;
    
    this.setupEventListeners();
    this.initDatePicker();
  },
  
  initDatePicker: function() {
    if (this.datePickerInput) {
      this.datePicker = flatpickr(this.datePickerInput, {
        dateFormat: "Y-m-d",
        defaultDate: "today",
        maxDate: "today",
        onChange: (selectedDates, dateStr) => {
          this.dateChanged(dateStr);
        }
      });
    }
  },
  
  setupEventListeners: function() {
    // Close buttons
    if (this.closeModalBtn) {
      this.closeModalBtn.addEventListener('click', this.close.bind(this));
    }
    
    if (this.closeBtn) {
      this.closeBtn.addEventListener('click', this.close.bind(this));
    }
    
    // Export button
    if (this.exportBtn) {
      this.exportBtn.addEventListener('click', this.exportCsv.bind(this));
    }
    
    // Load scans button
    if (this.loadScansBtn) {
      this.loadScansBtn.addEventListener('click', this.loadScans.bind(this));
    }
    
    // Today button
    if (this.todayBtn) {
      this.todayBtn.addEventListener('click', this.goToToday.bind(this));
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
    
    // Reset to today's date
    this.goToToday();
    
    // Load initial scans
    this.loadScans();
    
    // Animate scan items
    this.animateScanItems();
    
    // Dispatch custom event
    this.modal.dispatchEvent(new CustomEvent('daily-scan-modal-opened'));
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
      this.modal.dispatchEvent(new CustomEvent('daily-scan-modal-closed'));
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
  
  goToToday: function() {
    if (this.datePicker) {
      this.datePicker.setDate(new Date());
      this.dateChanged(this.datePickerInput.value);
    }
  },
  
  dateChanged: function(dateStr) {
    // Update UI to show date is being changed
    const dateDisplay = this.modal.querySelector('.selected-date');
    if (dateDisplay) {
      const date = new Date(dateStr);
      const formattedDate = date.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
      dateDisplay.textContent = formattedDate;
    }
  },
  
  loadScans: function() {
    if (!this.scansList) return;
    
    // Show loading state
    this.showLoading(true);
    
    // Simulate API call delay
    setTimeout(() => {
      const selectedDate = this.datePickerInput.value;
      
      // In a real app, you would fetch data from the server
      // Example: fetch(`/api/daily-scans/${selectedDate}`)
      
      // For demo, we'll just show/hide the empty state
      const hasScans = Math.random() > 0.2; // 80% chance of having scans
      
      if (hasScans) {
        this.emptyState.classList.add('hidden');
        this.animateScanItems();
      } else {
        this.emptyState.classList.remove('hidden');
      }
      
      // Hide loading state
      this.showLoading(false);
      
      // Dispatch event
      this.modal.dispatchEvent(new CustomEvent('scans-loaded', {
        detail: { date: selectedDate, count: hasScans ? 6 : 0 }
      }));
    }, 1000);
  },
  
  showLoading: function(show) {
    if (show) {
      this.loadingState.classList.remove('hidden');
      this.scansList.style.opacity = '0.5';
    } else {
      this.loadingState.classList.add('hidden');
      this.scansList.style.opacity = '1';
    }
  },
  
  animateScanItems: function() {
    const scanItems = this.scansList.querySelectorAll('.scan-item:not(.hidden)');
    scanItems.forEach((item, index) => {
      item.style.opacity = '0';
      item.style.transform = 'translateX(-20px)';
      
      setTimeout(() => {
        item.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        item.style.opacity = '1';
        item.style.transform = 'translateX(0)';
      }, 50 * (index + 1));
    });
  },
  
  exportCsv: function() {
    // Add click animation
    this.exportBtn.style.transform = 'scale(0.95)';
    setTimeout(() => {
      this.exportBtn.style.transform = 'scale(1)';
    }, 150);
    
    const selectedDate = this.datePickerInput.value;
    
    // Show export toast
    this.showToast(`CSV exported for ${selectedDate}`, 'success');
    
    // In a real app, you would make an AJAX request here
    // Example: fetch(`/api/export/daily-scans/${selectedDate}`, { method: 'POST' })
    
    // Dispatch export event
    this.modal.dispatchEvent(new CustomEvent('csv-exported', {
      detail: { date: selectedDate }
    }));
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
  
  // Method to add a new scan dynamically
  addScan: function(scanData) {
    const scanItem = document.createElement('div');
    scanItem.className = 'scan-item';
    scanItem.setAttribute('data-type', scanData.type || 'scan');
    scanItem.setAttribute('data-status', scanData.status || 'completed');
    
    scanItem.innerHTML = `
      <div class="scan-time">
        <div class="time-text">${scanData.time}</div>
      </div>
      <div class="scan-details">
        <div class="scan-description">${scanData.description}</div>
        <div class="scan-type">${scanData.type ? ucfirst(scanData.type) : 'Scan'}</div>
      </div>
      <div class="scan-status">
        <div class="status-indicator status-${scanData.status || 'completed'}"></div>
      </div>
    `;
    
    // Add animation for new item
    scanItem.style.opacity = '0';
    scanItem.style.transform = 'translateX(-20px)';
    
    this.scansList.insertBefore(scanItem, this.scansList.firstChild);
    
    setTimeout(() => {
      scanItem.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
      scanItem.style.opacity = '1';
      scanItem.style.transform = 'translateX(0)';
    }, 50);
    
    // Hide empty state if shown
    this.emptyState.classList.add('hidden');
  }
};

// Helper function
function ucfirst(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// Initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  DailyScanLogModal.init();
});
</script>
@endpush