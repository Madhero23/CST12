<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RozMed - Product Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/viewproduct.css'])
</head>
<body>
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <main class="product-detail-page">
            <!-- Back Navigation -->
            <div class="container">
                <a href="{{ route('products.index') }}" class="back-link">
                    <i class="fas fa-arrow-left back-icon"></i>
                    <span class="back-text">Back to Products</span>
                </a>
            </div>

            @if(isset($product) && $product)
            <!-- Product Detail Section -->
            <section class="product-detail-section">
                <div class="container">
                    <div class="product-detail-grid">
                        <!-- Product Image -->
                        <div class="product-image-section">
                            <div class="product-image-container">
                                @if($product->Images_Path)
                                    <img src="{{ asset('storage/' . $product->Images_Path) }}" 
                                         alt="{{ $product->Product_Name }}" 
                                         class="product-main-image">
                                @else
                                    <img src="{{ asset('default-product.jpg') }}" 
                                         alt="{{ $product->Product_Name }}" 
                                         class="product-main-image">
                                @endif
                                
                                @if($product->FDA_Certification_Status == 'Certified')
                                <div class="product-certified-badge">
                                    <i class="far fa-check-circle certified-icon"></i>
                                    <span class="certified-text">Certified</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="product-info-section">
                            <div class="product-category-wrap">
                                <span class="product-category-badge">
                                    @php
                                        $categoryLabels = [
                                            'DiagnosticEquipment' => 'Diagnostic Equipment',
                                            'MedicalInstruments' => 'Medical Instruments',
                                            'MonitoringDevices' => 'Monitoring Devices',
                                            'EmergencyEquipment' => 'Emergency Equipment',
                                            'InfusionSystems' => 'Infusion Systems',
                                            'LaboratoryEquipment' => 'Laboratory Equipment'
                                        ];
                                    @endphp
                                    {{ $categoryLabels[$product->Category] ?? $product->Category }}
                                </span>
                            </div>
                            
                            <h1 class="product-title">{{ $product->Product_Name }}</h1>
                            
                            <div class="product-status-wrap">
                                @php
                                    $stockVal = $product->total_stock ?? 0;
                                    $isInStock = $stockVal > 0;
                                    $isLowStock = $isInStock && $stockVal <= ($product->Min_Stock_Level ?? 0);
                                @endphp
                                <span class="product-status-badge @if($isLowStock) low-stock @elseif($isInStock) in-stock @else out-of-stock @endif">
                                    <i class="fas @if($isInStock) fa-check-circle @else fa-times-circle @endif status-icon"></i>
                                    <span class="status-text">
                                        @if($isLowStock)
                                            Low Stock ({{ $stockVal }} left)
                                        @elseif($isInStock)
                                            In Stock
                                        @else
                                            Out of Stock
                                        @endif
                                    </span>
                                </span>
                            </div>
                            
                            <div class="price-section">
                                <div class="price-display">
                                    <span class="price-label">Price:</span>
                                    <span class="product-price">₱{{ number_format($product->Unit_Price_PHP, 2) }}</span>
                                    <span class="price-usd">(${{ number_format($product->Unit_Price_USD, 2) }} USD)</span>
                                </div>

                            </div>
                            
                            <p class="product-description">
                                {{ $product->Description }}
                            </p>
                            
                            <!-- Product Specifications -->
                            @php
                                // FIXED: Remove json_decode() since Laravel already casts it to array
                                $specifications = is_array($product->Specifications) 
                                    ? $product->Specifications 
                                    : (is_string($product->Specifications) 
                                        ? json_decode($product->Specifications, true) 
                                        : []);
                            @endphp
                            
                            @if(!empty($specifications))
                            <div class="product-specifications">
                                <h3 class="specifications-title">Specifications</h3>
                                <div class="specifications-grid">
                                    @foreach($specifications as $key => $value)
                                    <div class="spec-item">
                                        <span class="spec-key">{{ ucwords(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="spec-value">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <!-- Product Features -->
                            <div class="product-features">
                                <ul class="features-list">
                                    <li class="feature-item">Category: {{ $categoryLabels[$product->Category] ?? $product->Category }}</li>
                                    <li class="feature-item">Professional-grade medical equipment with full warranty</li>
                                    @if($product->FDA_Certification_Status == 'Certified')
                                        <li class="feature-item">CE marked and FDA approved for clinical use</li>
                                    @endif
                                    @if($product->Description)
                                        <li class="feature-item">{{ \Illuminate\Support\Str::limit($product->Description, 100) }}</li>
                                    @endif
                                    <li class="feature-item">Added on: {{ \Carbon\Carbon::parse($product->created_at)->format('M d, Y') }}</li>
                                </ul>
                            </div>
                            
                            <!-- Inquiry Form -->
                            <div class="inquiry-card">
                                <div class="inquiry-header">
                                    <i class="fas fa-paper-plane inquiry-icon"></i>
                                    <h3 class="inquiry-title">Request a Quote</h3>
                                </div>
                                
                                <form class="quote-form" id="quoteForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->Product_ID }}">
                                    <input type="hidden" name="product_name" value="{{ $product->Product_Name }}">
                                    <input type="hidden" name="subject" value="Inquiry for {{ $product->Product_Name }}">
                                    
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Your Name" class="form-input" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Your Email" class="form-input" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="tel" name="phone" placeholder="Your Phone Number" class="form-input" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <textarea name="message" placeholder="Your Message" class="form-textarea" rows="4" required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="submit-btn">
                                        <i class="fas fa-paper-plane"></i>
                                        <span class="submit-text">Submit Inquiry</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @else
            <!-- Product Not Found -->
            <section class="product-not-found">
                <div class="container">
                    <div class="not-found-content">
                        <img src="{{ asset('error-icon.svg') }}" alt="Not Found" class="not-found-icon">
                        <h2>Product Not Found</h2>
                        <p>The product you're looking for doesn't exist or has been removed.</p>
                        <a href="{{ route('products.index') }}" class="back-to-products-btn">
                            Back to Products
                        </a>
                    </div>
                </div>
            </section>
            @endif
        </main>

        @include('components.footer')
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission with animation
    const quoteForm = document.getElementById('quoteForm');
    
    if (quoteForm) {
        quoteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.querySelector('.submit-text').textContent;
            
            // Show loading state
            submitBtn.querySelector('.submit-text').textContent = 'Sending...';
            submitBtn.style.opacity = '0.7';
            submitBtn.style.pointerEvents = 'none';
            
            // Collect form data
            const formData = new FormData(this);
            
            // AJAX submission
            fetch('{{ route("contact.inquiry") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success animation
                    submitBtn.innerHTML = `
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                        <span class="submit-text">Sent Successfully!</span>
                    `;
                    submitBtn.classList.add('success');
                    
                    // Reset form after success
                    setTimeout(() => {
                        quoteForm.reset();
                        submitBtn.innerHTML = `
                            <img src="{{ asset('icon3.svg') }}" alt="Submit" class="submit-icon">
                            <span class="submit-text">${originalText}</span>
                        `;
                        submitBtn.classList.remove('success');
                        submitBtn.style.opacity = '1';
                        submitBtn.style.pointerEvents = 'auto';
                        
                        showNotification('Your inquiry has been submitted successfully!');
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Submission failed');
                }
            })
            .catch(error => {
                // Show error state
                submitBtn.innerHTML = `
                    <img src="{{ asset('error-icon.svg') }}" alt="Error" class="error-icon">
                    <span class="submit-text">Error! Try Again</span>
                `;
                submitBtn.classList.add('error');
                
                setTimeout(() => {
                    submitBtn.innerHTML = `
                        <img src="{{ asset('icon3.svg') }}" alt="Submit" class="submit-icon">
                        <span class="submit-text">${originalText}</span>
                    `;
                    submitBtn.classList.remove('error');
                    submitBtn.style.opacity = '1';
                    submitBtn.style.pointerEvents = 'auto';
                    
                    showNotification('Failed to submit inquiry. Please try again.', 'error');
                }, 2000);
            });
        });
    }
    
    // Back link animation
    const backLink = document.querySelector('.back-link');
    if (backLink) {
        backLink.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(-5px)';
        });
        
        backLink.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    }
    
    // Product image hover effect
    const productImage = document.querySelector('.product-main-image');
    if (productImage) {
        productImage.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        productImage.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    }
    
    // Feature items animation
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add('animate-in');
    });
    
    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? 'var(--secondary-color)' : '#dc3545'};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            transform: translateX(100%);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
});

// Add CSS for animations
const viewProductStyle = document.createElement('style');
viewProductStyle.textContent = `
    .checkmark {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #fff;
        stroke-miterlimit: 10;
        margin: 0 auto;
        box-shadow: inset 0px 0px 0px #7ac142;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #7ac142;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    
    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #7ac142;
        }
    }
    
    .feature-item {
        opacity: 0;
        transform: translateX(-20px);
    }
    
    .feature-item.animate-in {
        animation: slideInRight 0.5s ease forwards;
    }
    
    .product-specifications {
        margin: 2rem 0;
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
    }
    
    .specifications-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .specifications-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 0.75rem;
    }
    
    .spec-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    
    .spec-key {
        font-weight: 600;
        color: #495057;
    }
    
    .spec-value {
        color: #6c757d;
    }
    
    .price-section {
        margin: 1.5rem 0;
    }
    
    .price-display {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .product-price {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .price-label {
        font-weight: 600;
        color: #495057;
    }
    
    .price-usd {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .reorder-info {
        display: flex;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .product-not-found {
        padding: 4rem 0;
        text-align: center;
    }
    
    .not-found-content {
        max-width: 500px;
        margin: 0 auto;
    }
    
    .not-found-icon {
        width: 100px;
        height: 100px;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }
    
    .back-to-products-btn {
        display: inline-block;
        margin-top: 1.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary-color);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .back-to-products-btn:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
    }
    
    .submit-btn.error {
        background: #dc3545 !important;
    }
    
    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(viewProductStyle);
</script>
</body>
</html>