@vite(['resources/css/customer.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <header class="dashboard-header">
            <h1 class="dashboard-title">Customer Management</h1>
        </header>
        
        <div class="admin-crm">
            <!-- Header Section -->
            <div class="crm-header">
                <div class="crm-title-container">
                    <h2 class="crm-title">Customer Management</h2>
                </div>
                
                <!-- Action Buttons -->
                <div class="crm-actions">
                    <button class="action-btn reminders-btn">
                        <img class="btn-icon" src="{{ asset('icon0.svg') }}" alt="Reminders">
                        <span>Reminders</span>
                    </button>
                    <button class="action-btn quote-btn">
                        <img class="btn-icon" src="{{ asset('icon1.svg') }}" alt="Create Quote">
                        <span>Create Quote</span>
                    </button>
                    <button class="action-btn primary-btn add-customer-btn">
                        <img class="btn-icon" src="{{ asset('icon2.svg') }}" alt="Add Customer">
                        <span>Add Customer</span>
                    </button>
                </div>
            </div>
            
            <!-- Quote Pipeline -->
            <div class="quote-pipeline-section">
                <h3 class="section-subtitle">Quote Pipeline</h3>
                <div class="pipeline-stats">
                    @php
                        $pipelineStats = [
                            ['count' => 1, 'label' => 'Draft', 'color' => 'draft'],
                            ['count' => 1, 'label' => 'Pending', 'color' => 'pending'],
                            ['count' => 1, 'label' => 'Sent', 'color' => 'sent'],
                            ['count' => 1, 'label' => 'Follow-Up', 'color' => 'follow-up'],
                            ['count' => 0, 'label' => 'Won', 'color' => 'won'],
                        ];
                    @endphp
                    
                    @foreach($pipelineStats as $index => $stat)
                    <div class="stat-card" data-animation-delay="{{ $index * 0.1 }}">
                        <div class="stat-count {{ $stat['color'] }}">{{ $stat['count'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Customer Table -->
            <div class="customer-table-section">
                <div class="table-container">
                    <table class="customer-table">
                        <thead>
                            <tr>
                                <th class="table-header">Name</th>
                                <th class="table-header">Email</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Last Interaction</th>
                                <th class="table-header">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $customers = [
                                    [
                                        'name' => 'Dr. Sarah Johnson',
                                        'email' => 'sarah.johnson@hospital.com',
                                        'status' => 'active',
                                        'status_text' => 'Active',
                                        'last_interaction' => '2 days ago',
                                        'view_icon' => 'icon3.svg',
                                        'logs_icon' => 'icon4.svg'
                                    ],
                                    [
                                        'name' => 'Michael Chen',
                                        'email' => 'michael.chen@clinic.com',
                                        'status' => 'lead',
                                        'status_text' => 'Lead',
                                        'last_interaction' => '1 week ago',
                                        'view_icon' => 'icon5.svg',
                                        'logs_icon' => 'icon6.svg'
                                    ],
                                    [
                                        'name' => 'Emily Rodriguez',
                                        'email' => 'emily.rodriguez@medcenter.com',
                                        'status' => 'inactive',
                                        'status_text' => 'Inactive',
                                        'last_interaction' => '3 weeks ago',
                                        'view_icon' => 'icon7.svg',
                                        'logs_icon' => 'icon8.svg'
                                    ],
                                ];
                            @endphp
                            
                            @foreach($customers as $index => $customer)
                            <tr class="customer-row" data-animation-delay="{{ $index * 0.1 }}">
                                <td class="customer-cell">
                                    <div class="customer-name">{{ $customer['name'] }}</div>
                                </td>
                                <td class="customer-cell">
                                    <div class="customer-email">{{ $customer['email'] }}</div>
                                </td>
                                <td class="customer-cell">
                                    <span class="status-badge {{ $customer['status'] }}">
                                        {{ $customer['status_text'] }}
                                    </span>
                                </td>
                                <td class="customer-cell">
                                    <div class="last-interaction">{{ $customer['last_interaction'] }}</div>
                                </td>
                                <td class="customer-cell">
                                    <div class="customer-actions">
                                        <button class="icon-btn view-btn" title="View Customer">
                                            <img src="{{ asset($customer['view_icon']) }}" alt="View">
                                            <span>View</span>
                                        </button>
                                        <button class="icon-btn logs-btn" title="View Logs">
                                            <img src="{{ asset($customer['logs_icon']) }}" alt="Logs">
                                            <span>Logs</span>
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
    // Stat cards animation
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        const delay = card.getAttribute('data-animation-delay') || index * 0.1;
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
        }, delay * 1000);
    });
    
    // Customer rows animation
    const customerRows = document.querySelectorAll('.customer-row');
    customerRows.forEach((row, index) => {
        const delay = row.getAttribute('data-animation-delay') || index * 0.1;
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, delay * 1000 + 300);
    });
    
    // Action buttons hover effects
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            if (!this.classList.contains('primary-btn')) {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 16px rgba(95, 177, 183, 0.2)';
            } else {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 10px 20px rgba(47, 122, 133, 0.3)';
            }
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Primary button (Add Customer) animation
    const addCustomerBtn = document.querySelector('.add-customer-btn');
    addCustomerBtn.addEventListener('click', function(e) {
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
        
        // Show add customer modal
        console.log('Add customer clicked');
        // Implement modal functionality here
    });
    
    // Icon buttons hover effects
    const iconBtns = document.querySelectorAll('.icon-btn');
    iconBtns.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.boxShadow = '0 4px 12px rgba(95, 177, 183, 0.2)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // Row hover effects
    customerRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(95, 177, 183, 0.05)';
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.05)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = '';
        });
    });
    
    // View button click
    const viewBtns = document.querySelectorAll('.view-btn');
    viewBtns.forEach((btn, index) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const customerName = this.closest('.customer-row').querySelector('.customer-name').textContent;
            console.log('View customer:', customerName);
            // Implement view functionality
        });
    });
    
    // Logs button click
    const logsBtns = document.querySelectorAll('.logs-btn');
    logsBtns.forEach((btn, index) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const customerName = this.closest('.customer-row').querySelector('.customer-name').textContent;
            console.log('View logs for:', customerName);
            // Implement logs functionality
        });
    });
    
    // Pipeline stat cards click
    statCards.forEach(card => {
        card.addEventListener('click', function() {
            const label = this.querySelector('.stat-label').textContent;
            console.log('Filter by:', label);
            
            // Add active state
            statCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            
            // Filter table by status (you can implement this)
            filterTableByStatus(label.toLowerCase());
        });
    });
    
    function filterTableByStatus(status) {
        const rows = document.querySelectorAll('.customer-row');
        rows.forEach(row => {
            const statusBadge = row.querySelector('.status-badge');
            if (status === 'all' || statusBadge.classList.contains(status)) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Reminders button functionality
    const remindersBtn = document.querySelector('.reminders-btn');
    remindersBtn.addEventListener('click', function() {
        console.log('Show reminders');
        // Implement reminders functionality
    });
    
    // Quote button functionality
    const quoteBtn = document.querySelector('.quote-btn');
    quoteBtn.addEventListener('click', function() {
        console.log('Create quote');
        // Implement quote creation functionality
    });
    
    // Status badge animations
    const statusBadges = document.querySelectorAll('.status-badge');
    statusBadges.forEach(badge => {
        if (badge.classList.contains('active')) {
            badge.style.animation = 'pulse 2s infinite';
        }
    });
});
</script>
@endpush