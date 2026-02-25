<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@vite(['resources/css/admin.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <main class="admin-main-content">
        <!-- Header -->
        <header class="dashboard-header">
            <h1 class="dashboard-title">Dashboard</h1>
        </header>

        <!-- Stats Cards -->
        <section class="stats-section">
            <div class="stats-grid">
                <div class="stat-card stat-teal">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Total Products</p>
                            <p class="stat-value">{{ $stats['total_products'] ?? 0 }}</p>
                        </div>
                        <div class="stat-icon-container">
                            <i class="stat-icon fas fa-box"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card stat-orange">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Pending Inquiries</p>
                            <p class="stat-value">{{ $stats['pending_inquiries'] ?? 0 }}</p>
                        </div>
                        <div class="stat-icon-container">
                            <i class="stat-icon fas fa-comment"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card stat-green">
                    <div class="stat-content">
                        <div class="stat-info">
                            <p class="stat-label">Completed Today</p>
                            <p class="stat-value">{{ $stats['completed_today'] ?? 0 }}</p>
                        </div>
                        <div class="stat-icon-container">
                            <i class="stat-icon fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Grid -->
        <div class="dashboard-main-grid">
            <div class="grid-left-col">
                <!-- Recent Activity -->
                <section class="recent-activity-section">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title">Recent Activity</h2>
                        </div>
                        
                        <div class="activity-list">
                            @forelse($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-indicator {{ ($activity['type'] ?? '') == 'Critical' ? 'indicator-red' : '' }}"></div>
                                    <div class="activity-content">
                                        <p class="activity-title">{{ $activity['title'] }}</p>
                                        <p class="activity-detail">{{ $activity['detail'] }}</p>
                                    </div>
                                    <span class="activity-time">{{ $activity['time'] }}</span>
                                </div>
                            @empty
                                <div class="empty-state">No recent activity found.</div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>

            <div class="grid-right-col">
                <!-- Quick Stats -->
                <section class="quick-stats-section">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title">Quick Stats</h2>
                        </div>
                        
                        <div class="stats-list">
                            <div class="stat-item">
                                <div class="stat-item-left">
                                    <div class="stat-item-icon bg-red-light">
                                        <i class="fas fa-exclamation-triangle text-red"></i>
                                    </div>
                                    <span class="stat-item-label">Low Stock Items</span>
                                </div>
                                <span class="stat-item-value text-red">{{ $stats['low_stock_count'] ?? 0 }}</span>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-item-left">
                                    <div class="stat-item-icon bg-red-light">
                                        <i class="fas fa-file-invoice-dollar text-red"></i>
                                    </div>
                                    <span class="stat-item-label">Overdue Invoices</span>
                                </div>
                                <span class="stat-item-value text-red">{{ $stats['overdue_invoices'] ?? 0 }}</span>
                            </div>
                            
                            <div class="stat-item">
                                <div class="stat-item-left">
                                    <div class="stat-item-icon bg-teal-light">
                                        <i class="fas fa-chart-line text-teal"></i>
                                    </div>
                                    <span class="stat-item-label">Active Quotes</span>
                                </div>
                                <span class="stat-item-value text-teal">{{ $stats['active_quotations'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Upcoming Follow-ups -->
        <section class="follow-ups-section">
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">Upcoming Follow-ups</h2>
                    <a href="#" class="view-all-link">View All</a>
                </div>
                
                <div class="follow-ups-list">
                    @forelse($upcomingFollowUps as $followUp)
                        <div class="follow-up-item border-left-{{ strtolower($followUp->Status ?? 'medium') }}">
                            <div class="follow-up-content">
                                <h3 class="follow-up-title">{{ $followUp->customer->Institution_Name ?? 'Unknown Institution' }}</h3>
                                <p class="follow-up-detail">{{ $followUp->Subject }} - Due {{ \Carbon\Carbon::parse($followUp->Follow_Up_Date)->format('M d, Y') }}</p>
                            </div>
                            <button class="view-btn" onclick="window.location.href='/admin/customers/{{ $followUp->Customer_ID }}'">View</button>
                        </div>
                    @empty
                        <div class="empty-state">No upcoming follow-ups.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stats cards animation
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 200);
    });
    
    // Activity items animation
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 600 + (index * 100));
    });
    
    // Stat items animation
    const statItems = document.querySelectorAll('.stat-item');
    
    statItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, 900 + (index * 100));
    });
    
    // Follow-up items animation
    const followUpItems = document.querySelectorAll('.follow-up-item');
    
    followUpItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 1200 + (index * 150));
    });
    
    // Hover effects for cards
    const allCards = document.querySelectorAll('.stat-card, .section-card');
    
    allCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'var(--shadow-md)';
        });
    });
    
    // Button hover effects
    const viewButtons = document.querySelectorAll('.view-btn');
    
    viewButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.boxShadow = '0 4px 12px rgba(95, 177, 183, 0.3)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
        });
        
        // Button click animation
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
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
            
            this.appendChild(ripple);
            
            // Remove ripple after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
            
            // Navigate to follow-up details
            const followUpTitle = this.closest('.follow-up-item').querySelector('.follow-up-title').textContent;
            console.log('Viewing follow-up for:', followUpTitle);
        });
    });
    
    // Navigation item hover effects
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateX(10px)';
                const icon = this.querySelector('.nav-icon');
                if (icon) {
                    icon.style.transform = 'scale(1.1)';
                }
            }
        });
        
        item.addEventListener('mouseleave', function() {
            if (!this.classList.contains('active')) {
                this.style.transform = 'translateX(0)';
                const icon = this.querySelector('.nav-icon');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                }
            }
        });
    });
    
    // Real-time updates simulation
    function simulateRealTimeUpdates() {
        // Update stats every 30 seconds
        setInterval(() => {
            const pendingInquiries = document.querySelector('.stat-warning .stat-value');
            const completedToday = document.querySelector('.stat-success .stat-value');
            
            if (Math.random() > 0.7) {
                // Simulate new inquiry
                let current = parseInt(pendingInquiries.textContent);
                pendingInquiries.textContent = (current + 1).toString();
                pendingInquiries.style.animation = 'pulse 1s ease';
                setTimeout(() => {
                    pendingInquiries.style.animation = '';
                }, 1000);
            }
            
            if (Math.random() > 0.8) {
                // Simulate completed task
                let currentPending = parseInt(pendingInquiries.textContent);
                let currentCompleted = parseInt(completedToday.textContent);
                
                if (currentPending > 0) {
                    pendingInquiries.textContent = (currentPending - 1).toString();
                    completedToday.textContent = (currentCompleted + 1).toString();
                    
                    completedToday.style.animation = 'pulse 1s ease';
                    setTimeout(() => {
                        completedToday.style.animation = '';
                    }, 1000);
                }
            }
        }, 30000);
    }
    
    // Start real-time updates simulation
    simulateRealTimeUpdates();
});

// Add CSS for animations
const adminStyles = document.createElement('style');
adminStyles.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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
    
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .stat-card {
        opacity: 0;
        transform: translateY(30px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .activity-item {
        opacity: 0;
        transform: translateX(-20px);
        transition: transform 0.3s ease;
    }
    
    .stat-item {
        opacity: 0;
        transform: translateY(10px);
        transition: transform 0.3s ease;
    }
    
    .follow-up-item {
        opacity: 0;
        transform: translateX(-20px);
        transition: transform 0.3s ease;
    }
    
    .nav-item {
        transition: transform 0.3s ease;
    }
    
    .nav-icon {
        transition: transform 0.3s ease;
    }
    
    .view-btn {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(adminStyles);
</script>

