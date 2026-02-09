@vite(['resources/css/document.css'])
<div class="admin-dashboard-container">
    @include('components.sidebar')

    <div class="admin-documents">
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">Documents</h1>
            </div>
        </div>
        
        <div class="main-content">
            <div class="main-section">
                <div class="section-header">
                    <h2 class="section-title">Document Management</h2>
                    <div class="action-buttons">
                        <button class="btn btn-secondary">
                            <img class="btn-icon" src="{{ asset('icon0.svg') }}" alt="Templates" />
                            <span>Manage Templates</span>
                        </button>
                        <button class="btn btn-secondary">
                            <img class="btn-icon" src="{{ asset('icon1.svg') }}" alt="Upload" />
                            <span>Upload Document</span>
                        </button>
                        <button class="btn btn-primary">
                            <img class="btn-icon" src="{{ asset('icon2.svg') }}" alt="New" />
                            <span>New Quotation</span>
                        </button>
                    </div>
                </div>
                
                <div class="stats-grid">
                    @foreach([
                        ['icon' => 'icon3.svg', 'count' => '4', 'label' => 'Active Quotations', 'color' => '#2f7a85'],
                        ['icon' => 'icon4.svg', 'count' => '3', 'label' => 'Templates', 'color' => '#5fb1b7'],
                        ['icon' => 'icon5.svg', 'count' => '3', 'label' => 'Certificates', 'color' => '#00a63e'],
                        ['icon' => 'icon6.svg', 'count' => '8.4', 'label' => 'Avg Days Open', 'color' => '#f54900']
                    ] as $stat)
                    <div class="stat-card" data-animate="fade-up">
                        <div class="stat-icon-container" style="background-color: {{ $stat['color'] }}">
                            <img class="stat-icon" src="{{ asset($stat['icon']) }}" alt="{{ $stat['label'] }}" />
                        </div>
                        <div class="stat-count">{{ $stat['count'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
                
                <div class="table-container" data-animate="fade-in">
                    <div class="table-header">
                        <div class="table-row">
                            <div class="header-cell">Quotation ID</div>
                            <div class="header-cell">Customer</div>
                            <div class="header-cell">Product</div>
                            <div class="header-cell">Amount</div>
                            <div class="header-cell">Version</div>
                            <div class="header-cell">Status</div>
                            <div class="header-cell">Actions</div>
                        </div>
                    </div>
                    
                    <div class="table-body">
                        @foreach([
                            ['id' => 'QT-2025-001', 'customer' => 'Dr. Sarah Johnson', 'product' => 'Portable Ultrasound Machine', 'amount' => '₱862,400', 'version' => 'v2', 'status' => 'approved', 'status_text' => 'Approved'],
                            ['id' => 'QT-2025-002', 'customer' => 'Michael Chen', 'product' => 'Patient Monitor', 'amount' => '₱459,200', 'version' => 'v1', 'status' => 'pending', 'status_text' => 'Pending'],
                            ['id' => 'QT-2025-003', 'customer' => 'City Hospital', 'product' => 'Surgical Instruments Set', 'amount' => '₱1,372,000', 'version' => 'v3', 'status' => 'converted', 'status_text' => 'Converted to Sale'],
                            ['id' => 'QT-2025-004', 'customer' => 'Medical Center East', 'product' => 'X-Ray Machine', 'amount' => '₱2,520,000', 'version' => 'v1', 'status' => 'rejected', 'status_text' => 'Rejected']
                        ] as $row)
                        <div class="table-row" data-animate="fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="table-cell">{{ $row['id'] }}</div>
                            <div class="table-cell">{{ $row['customer'] }}</div>
                            <div class="table-cell">{{ $row['product'] }}</div>
                            <div class="table-cell">{{ $row['amount'] }}</div>
                            <div class="table-cell version-badge">{{ $row['version'] }}</div>
                            <div class="table-cell">
                                <span class="status-badge status-{{ $row['status'] }}">{{ $row['status_text'] }}</span>
                            </div>
                            <div class="table-cell">
                                <div class="action-buttons-group">
                                    <button class="action-btn">Revise</button>
                                    <button class="action-btn">Status</button>
                                    <button class="icon-btn">
                                        <img src="{{ asset('icon7.svg') }}" alt="Action" />
                                    </button>
                                    <button class="icon-btn">
                                        <img src="{{ asset('icon8.svg') }}" alt="Action" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="sidebar-sections">
                <div class="sidebar-card">
                    <h3 class="card-title">Supporting Documents</h3>
                    <div class="document-list">
                        @foreach([
                            ['icon' => 'icon15.svg', 'title' => 'FDA Certificate - Ultrasound', 'description' => 'Ultrasound Machines • 2.4 MB'],
                            ['icon' => 'icon17.svg', 'title' => 'Supplier Certificate - Patient Monitors', 'description' => 'Patient Monitors • 1.8 MB'],
                            ['icon' => 'icon19.svg', 'title' => 'Customs Clearance - Nov 2025', 'description' => 'All Products • 3.2 MB']
                        ] as $doc)
                        <div class="document-item" data-animate="slide-left">
                            <div class="document-info">
                                <div class="document-icon">
                                    <img src="{{ asset($doc['icon']) }}" alt="Document" />
                                </div>
                                <div class="document-details">
                                    <div class="document-title">{{ $doc['title'] }}</div>
                                    <div class="document-description">{{ $doc['description'] }}</div>
                                </div>
                            </div>
                            <button class="document-action">
                                <img src="{{ asset('icon16.svg') }}" alt="Download" />
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="sidebar-card">
                    <div class="card-header">
                        <h3 class="card-title">Quotation Templates</h3>
                        <button class="icon-btn">
                            <img src="{{ asset('icon21.svg') }}" alt="More" />
                        </button>
                    </div>
                    <div class="template-list">
                        @foreach([
                            ['title' => 'Standard Hospital Quotation', 'description' => 'Hospital • Used 24 times'],
                            ['title' => 'Government Facility Template', 'description' => 'Government • Used 8 times'],
                            ['title' => 'Private Clinic Quotation', 'description' => 'Clinic • Used 15 times']
                        ] as $template)
                        <div class="template-item" data-animate="slide-left">
                            <div class="template-details">
                                <div class="template-title">{{ $template['title'] }}</div>
                                <div class="template-description">{{ $template['description'] }}</div>
                            </div>
                            <button class="icon-btn">
                                <img src="{{ asset('icon22.svg') }}" alt="View" />
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>