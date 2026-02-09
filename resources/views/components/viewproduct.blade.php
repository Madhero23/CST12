@vite(['resources/css/viewproduct.css'])
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <main class="product-detail-page">
            <!-- Back Navigation -->
            <div class="container">
                <a href="{{ route('product') }}" class="back-link">
                    <img class="icon" src="{{ asset('icon0.svg') }}" alt="Back">
                    <span class="back-text">Back to Products</span>
                </a>
            </div>

            <!-- Product Detail Section -->
            <section class="product-detail-section">
                <div class="container">
                    <div class="product-detail-grid">
                        <!-- Product Image -->
                        <div class="product-image-section">
                            <div class="product-image-container">
                                <img src="{{ asset('container18.png') }}" alt="Digital Microscope Pro" class="product-main-image">
                                <div class="product-certified-badge">
                                    <img src="{{ asset('icon4.svg') }}" alt="Certified" class="certified-icon">
                                    <span class="certified-text">Certified</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="product-info-section">
                            <div class="product-category-badge">
                                Diagnostic Equipment
                            </div>
                            
                            <h1 class="product-title">Digital Microscope Pro</h1>
                            
                            <div class="product-status-badge">
                                <img src="{{ asset('icon1.svg') }}" alt="In Stock" class="status-icon">
                                <span class="status-text">In Stock</span>
                            </div>
                            
                            <p class="product-description">
                                High-resolution digital microscope with advanced imaging
                                capabilities for precise diagnostics and research applications.
                            </p>
                            
                            <!-- Product Features -->
                            <div class="product-features">
                                <div class="feature-item">
                                    <div class="feature-dot"></div>
                                    <p class="feature-text">Category: Diagnostic Equipment</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-dot"></div>
                                    <p class="feature-text">Professional-grade medical equipment with full warranty</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-dot"></div>
                                    <p class="feature-text">CE marked and FDA approved for clinical use</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-dot"></div>
                                    <p class="feature-text">High-resolution imaging up to 1000x magnification</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-dot"></div>
                                    <p class="feature-text">Digital display with USB connectivity</p>
                                </div>
                            </div>
                            
                            <!-- Inquiry Form -->
                            <div class="inquiry-form">
                                <div class="form-header">
                                    <img src="{{ asset('icon2.svg') }}" alt="Quote" class="form-icon">
                                    <h3 class="form-title">Request a Quote</h3>
                                </div>
                                
                                <form class="quote-form" id="quoteForm">
                                    <div class="form-group">
                                        <input type="text" 
                                               placeholder="Your Name" 
                                               class="form-input"
                                               required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" 
                                               placeholder="Your Email" 
                                               class="form-input"
                                               required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <textarea placeholder="Your Message" 
                                                  class="form-textarea"
                                                  rows="4"
                                                  required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="submit-btn">
                                        <img src="{{ asset('icon3.svg') }}" alt="Submit" class="submit-icon">
                                        <span class="submit-text">Submit Inquiry</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('components.footer')
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission with animation
    const quoteForm = document.getElementById('quoteForm');
    
    quoteForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('.submit-btn');
        const originalText = submitBtn.querySelector('.submit-text').textContent;
        
        // Show loading state
        submitBtn.querySelector('.submit-text').textContent = 'Sending...';
        submitBtn.style.opacity = '0.7';
        submitBtn.style.pointerEvents = 'none';
        
        // Simulate form submission (replace with actual AJAX call)
        setTimeout(() => {
            // Show success animation
            submitBtn.innerHTML = `
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <span class="submit-text">Sent Successfully!</span>
            `;
            submitBtn.classList.add('success');
            
            // Reset form
            setTimeout(() => {
                quoteForm.reset();
                submitBtn.innerHTML = `
                    <img src="{{ asset('icon3.svg') }}" alt="Submit" class="submit-icon">
                    <span class="submit-text">${originalText}</span>
                `;
                submitBtn.classList.remove('success');
                submitBtn.style.opacity = '1';
                submitBtn.style.pointerEvents = 'auto';
                
                // Show notification
                showNotification('Your inquiry has been submitted successfully!');
            }, 2000);
        }, 1500);
    });
    
    // Back link animation
    const backLink = document.querySelector('.back-link');
    backLink.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(-5px)';
    });
    
    backLink.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
    });
    
    // Product image hover effect
    const productImage = document.querySelector('.product-main-image');
    productImage.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.02)';
    });
    
    productImage.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
    
    // Feature items animation
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
        item.classList.add('animate-in');
    });
    
    // Notification function
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: var(--secondary-color);
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
    
    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(viewProductStyle);
</script>
@endpush