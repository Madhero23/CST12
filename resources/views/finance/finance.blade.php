@vite(['resources/css/finance.css'])
<div class="admin-dashboard-container">
    <!-- Sidebar Component -->
    <x-sidebar />

    <main class="admin-main-content">
        <div class="admin-finance">
            <div class="page-header">
                <div class="heading-1">
                    <div class="page-title">Finance</div>
                </div>
            </div>
            
            <div class="content-container">
                <div class="section-header">
                    <div class="financial-dashboard">Financial Dashboard</div>
                    <div class="header-actions">
                        <button class="action-btn payment-plans-btn">
                            <img class="btn-icon" src="{{ asset('icon0.svg') }}" alt="Payment Plans" />
                            <span class="btn-text">Payment Plans</span>
                        </button>
                        <button class="action-btn overdue-alerts-btn">
                            <img class="btn-icon" src="{{ asset('icon1.svg') }}" alt="Overdue Alerts" />
                            <span class="btn-text">Overdue Alerts</span>
                        </button>
                        <button class="action-btn generate-invoice-btn">
                            <img class="btn-icon" src="{{ asset('icon2.svg') }}" alt="Generate Invoice" />
                            <span class="btn-text">Generate Invoice</span>
                        </button>
                    </div>
                </div>
                
                <div class="finance-stats">
                    @php
                        $stats = [
                            [
                                'icon' => 'icon3.svg',
                                'amount' => '₱10,590,300',
                                'label' => 'Paid',
                                'color' => 'paid',
                                'valueColor' => '#00a63e'
                            ],
                            [
                                'icon' => 'icon4.svg',
                                'amount' => '₱2,408,000',
                                'label' => 'Unpaid',
                                'color' => 'unpaid',
                                'valueColor' => '#f54900'
                            ],
                            [
                                'icon' => 'icon5.svg',
                                'amount' => '₱1,176,000',
                                'label' => 'Overdue',
                                'color' => 'overdue',
                                'valueColor' => '#e7000b'
                            ],
                            [
                                'icon' => 'icon6.svg',
                                'amount' => '3',
                                'label' => 'Total Invoices',
                                'color' => 'total',
                                'valueColor' => '#2f7a85'
                            ]
                        ];
                    @endphp
                    
                    @foreach($stats as $stat)
                        <div class="stat-card stat-{{ $stat['color'] }}">
                            <div class="stat-icon-container">
                                <img class="stat-icon" src="{{ asset($stat['icon']) }}" alt="{{ $stat['label'] }}" />
                            </div>
                            <div class="stat-amount" style="color: {{ $stat['valueColor'] }}">
                                {{ $stat['amount'] }}
                            </div>
                            <div class="stat-label">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
                
                <div class="exchange-rate-section">
                    <div class="section-header">
                        <div class="section-title">
                            <div class="title-icon">
                                <img src="{{ asset('icon7.svg') }}" alt="Exchange Rate" />
                            </div>
                            <div class="title-content">
                                <div class="main-title">Exchange Rate Monitor</div>
                                <div class="subtitle">USD to Local Currency</div>
                            </div>
                        </div>
                        <div class="auto-fetch-toggle">
                            <div class="toggle-label">Auto-Fetch:</div>
                            <div class="toggle-btn active">ON</div>
                        </div>
                    </div>
                    
                    <div class="exchange-rate-info">
                        <div class="info-card">
                            <div class="info-label">Current Rate</div>
                            <div class="info-value">1.35 LC/USD</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">2 hours ago</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Update Source</div>
                            <div class="info-value">Automated</div>
                        </div>
                    </div>
                    
                    <div class="alert-card">
                        <div class="alert-icon">
                            <img src="{{ asset('icon8.svg') }}" alt="Alert" />
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Threshold Alert</div>
                            <div class="alert-message">
                                Exchange rate has exceeded threshold (below 1.30). 
                                Dollar-denominated balances have been recalculated. 
                                Review pricing adjustments recommended.
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="invoices-table">
                    <div class="table-header">
                        <div class="table-row">
                            <div class="header-cell">
                                <div class="invoice-id">Invoice ID</div>
                            </div>
                            <div class="header-cell">
                                <div class="customer">Customer</div>
                            </div>
                            <div class="header-cell">
                                <div class="amount">Amount</div>
                            </div>
                            <div class="header-cell">
                                <div class="due-date">Due Date</div>
                            </div>
                            <div class="header-cell">
                                <div class="status">Status</div>
                            </div>
                            <div class="header-cell">
                                <div class="actions">Actions</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-body">
                        @php
                            $invoices = [
                                [
                                    'id' => 'INV-001',
                                    'customer' => 'Dr. Sarah Johnson',
                                    'amount' => '₱862,400',
                                    'dueDate' => 'Dec 15, 2025',
                                    'status' => 'paid',
                                    'statusText' => 'Paid'
                                ],
                                [
                                    'id' => 'INV-002',
                                    'customer' => 'Michael Chen',
                                    'amount' => '₱459,200',
                                    'dueDate' => 'Dec 20, 2025',
                                    'status' => 'pending',
                                    'statusText' => 'Pending'
                                ],
                                [
                                    'id' => 'INV-003',
                                    'customer' => 'Emily Rodriguez',
                                    'amount' => '₱1,176,000',
                                    'dueDate' => 'Nov 28, 2025',
                                    'status' => 'overdue',
                                    'statusText' => 'Overdue'
                                ],
                                [
                                    'id' => 'INV-004',
                                    'customer' => 'David Park',
                                    'amount' => '₱700,000',
                                    'dueDate' => 'Dec 25, 2025',
                                    'status' => 'pending',
                                    'statusText' => 'Pending'
                                ]
                            ];
                            
                            $actionIcons = ['icon9.svg', 'icon10.svg', 'icon11.svg', 'icon12.svg'];
                        @endphp
                        
                        @foreach($invoices as $index => $invoice)
                            <div class="table-row invoice-row" data-index="{{ $index }}">
                                <div class="table-cell">
                                    <div class="invoice-id-text">{{ $invoice['id'] }}</div>
                                </div>
                                <div class="table-cell">
                                    <div class="customer-name">{{ $invoice['customer'] }}</div>
                                </div>
                                <div class="table-cell">
                                    <div class="amount-text">{{ $invoice['amount'] }}</div>
                                </div>
                                <div class="table-cell">
                                    <div class="due-date-text">{{ $invoice['dueDate'] }}</div>
                                </div>
                                <div class="table-cell">
                                    <div class="status-badge status-{{ $invoice['status'] }}">
                                        {{ $invoice['statusText'] }}
                                    </div>
                                </div>
                                <div class="table-cell">
                                    <div class="invoice-actions">
                                        <button class="action-btn record-payment-btn" data-index="{{ $index }}">
                                            <span class="action-text">Record Payment</span>
                                        </button>
                                        <button class="action-icon-btn" data-index="{{ $index }}">
                                            <img src="{{ asset($actionIcons[$index]) }}" alt="More Actions" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stat cards animations
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
        }, index * 150);
    });
    
    // Invoice rows animations
    const invoiceRows = document.querySelectorAll('.invoice-row');
    
    invoiceRows.forEach((row, index) => {
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 600 + (index * 100));
    });
    
    // Add hover effects to stat cards
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.05)';
            this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.15)';
            this.style.zIndex = '10';
            
            // Add floating animation to icon
            const icon = this.querySelector('.stat-icon');
            if (icon) {
                icon.style.animation = 'float 2s ease-in-out infinite';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = 'var(--shadow-md)';
            this.style.zIndex = '1';
            
            // Stop floating animation
            const icon = this.querySelector('.stat-icon');
            if (icon) {
                icon.style.animation = 'none';
            }
        });
    });
    
    // Add hover effects to invoice rows
    invoiceRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(95, 177, 183, 0.05)';
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.05)';
            
            // Animate status badge
            const badge = this.querySelector('.status-badge');
            if (badge) {
                badge.style.transform = 'scale(1.1)';
            }
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
            
            // Reset status badge
            const badge = this.querySelector('.status-badge');
            if (badge) {
                badge.style.transform = 'scale(1)';
            }
        });
    });
    
    // Button click effects
    const actionButtons = document.querySelectorAll('.action-btn');
    const recordPaymentButtons = document.querySelectorAll('.record-payment-btn');
    const iconButtons = document.querySelectorAll('.action-icon-btn');
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            createRippleEffect(this);
            
            const btnType = this.classList.contains('payment-plans-btn') ? 'payment-plans' :
                           this.classList.contains('overdue-alerts-btn') ? 'overdue-alerts' :
                           this.classList.contains('generate-invoice-btn') ? 'generate-invoice' : null;
            
            if (btnType) {
                console.log(`${btnType.replace('-', ' ')} clicked`);
                
                // Add button feedback
                this.style.transform = 'translateY(2px)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            }
        });
    });
    
    recordPaymentButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            createRippleEffect(this);
            const index = this.getAttribute('data-index');
            console.log('Record payment for invoice at index:', index);
            
            // Simulate payment recording
            simulatePaymentRecording(index);
        });
    });
    
    iconButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            createRippleEffect(this);
            const index = this.getAttribute('data-index');
            console.log('More actions for invoice at index:', index);
        });
    });
    
    // Toggle button functionality
    const toggleBtn = document.querySelector('.toggle-btn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            const isActive = this.classList.contains('active');
            this.textContent = isActive ? 'ON' : 'OFF';
            this.style.backgroundColor = isActive ? 'var(--success-color)' : 'var(--text-gray)';
            
            console.log(`Auto-fetch turned ${isActive ? 'ON' : 'OFF'}`);
        });
    }
    
    // Simulate real-time exchange rate updates
    function simulateExchangeRateUpdates() {
        const rateValue = document.querySelector('.info-value');
        if (!rateValue || !rateValue.textContent.includes('LC/USD')) return;
        
        setInterval(() => {
            const currentRate = parseFloat(rateValue.textContent.split(' ')[0]);
            const change = (Math.random() - 0.5) * 0.02; // Random change ±0.01
            const newRate = Math.max(1.30, Math.min(1.40, currentRate + change));
            
            rateValue.textContent = newRate.toFixed(2) + ' LC/USD';
            
            // Add animation
            rateValue.style.animation = 'pulse 0.5s ease';
            setTimeout(() => {
                rateValue.style.animation = '';
            }, 500);
            
            // Check threshold
            if (newRate < 1.30) {
                showThresholdAlert();
            }
        }, 30000); // Update every 30 seconds
    }
    
    // Show threshold alert
    function showThresholdAlert() {
        const alertCard = document.querySelector('.alert-card');
        if (alertCard) {
            alertCard.style.animation = 'shake 0.5s ease';
            alertCard.style.backgroundColor = 'rgba(240, 177, 0, 0.15)';
            
            setTimeout(() => {
                alertCard.style.animation = '';
            }, 500);
        }
    }
    
    // Simulate payment recording
    function simulatePaymentRecording(index) {
        const statusBadge = document.querySelectorAll('.status-badge')[index];
        const row = document.querySelectorAll('.invoice-row')[index];
        
        if (statusBadge && row) {
            // Animate row
            row.style.animation = 'successPulse 1s ease';
            
            // Update status to paid
            setTimeout(() => {
                statusBadge.className = 'status-badge status-paid';
                statusBadge.textContent = 'Paid';
                statusBadge.style.backgroundColor = 'rgba(0, 201, 80, 0.2)';
                statusBadge.style.borderColor = 'rgba(0, 201, 80, 0.4)';
                statusBadge.style.color = '#00a63e';
                
                // Update stats
                updateFinanceStats();
            }, 500);
            
            setTimeout(() => {
                row.style.animation = '';
            }, 1000);
        }
    }
    
    // Update finance stats
    function updateFinanceStats() {
        const paidAmount = document.querySelector('.stat-paid .stat-amount');
        const unpaidAmount = document.querySelector('.stat-unpaid .stat-amount');
        const overdueAmount = document.querySelector('.stat-overdue .stat-amount');
        
        if (paidAmount && unpaidAmount) {
            // Animate stat updates
            [paidAmount, unpaidAmount, overdueAmount].forEach(stat => {
                stat.style.animation = 'bounce 0.5s ease';
                setTimeout(() => {
                    stat.style.animation = '';
                }, 500);
            });
        }
    }
    
    // Ripple effect function
    function createRippleEffect(element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(95, 177, 183, 0.4);
            transform: scale(0);
            animation: ripple 0.6s linear;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            z-index: 1;
        `;
        
        element.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }
    
    // Start exchange rate simulation
    setTimeout(() => {
        simulateExchangeRateUpdates();
    }, 2000);
    
    // Add CSS animations
    const financeStyles = document.createElement('style');
    financeStyles.textContent = `
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            75% {
                transform: translateX(5px);
            }
        }
        
        @keyframes successPulse {
            0%, 100% {
                background-color: transparent;
            }
            50% {
                background-color: rgba(0, 201, 80, 0.1);
            }
        }
        
        .stat-card {
            opacity: 0;
            transform: translateY(20px) scale(0.9);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .invoice-row {
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }
        
        .stat-icon {
            transition: transform 0.3s ease;
        }
        
        .status-badge {
            transition: all 0.3s ease;
        }
        
        .action-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .generate-invoice-btn:hover {
            animation: pulse 0.3s ease;
            transform: translateY(-2px);
        }
        
        .toggle-btn {
            transition: all 0.3s ease;
        }
        
        .alert-card {
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
        }
        
        .info-card:hover .info-value {
            animation: pulse 0.5s ease;
        }
    `;
    document.head.appendChild(financeStyles);
});
</script>
@endpush