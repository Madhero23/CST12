<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | RozMed Medical Equipment & Supplies</title>
    <meta name="description" content="Contact RozMed Enterprise for medical equipment inquiries, support, or partnership opportunities. Located in Davao City.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/contact.css'])
</head>
<body>
    <div class="user-hero">
        <div class="app">
            @include('components.header')
            
            <main class="contact-page">
                <!-- Hero Section -->
                <section class="contact-hero">
                    <div class="container">
                        <h1 class="page-title">Contact Us</h1>
                        <p class="page-subtitle">
                            Get in touch with our team for inquiries, support, or partnership opportunities
                        </p>
                    </div>
                </section>

                <!-- Contact Content -->
                <section class="contact-content">
                    <div class="container">
                        <div class="contact-grid">
                            <!-- Contact Form -->
                            <div class="contact-form-section">
                                <div class="form-card">
                                    <h2 class="form-title">Send us a Message</h2>
                                    
                                    <form class="contact-form" id="contactForm" method="POST" action="{{ route('contact.inquiry') }}">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" 
                                                   id="name" 
                                                   name="name"
                                                   placeholder="John Doe"
                                                   class="form-input"
                                                   value="{{ old('name') }}"
                                                   required>
                                            @error('name')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" 
                                                       id="email" 
                                                       name="email"
                                                       placeholder="john@example.com"
                                                       class="form-input"
                                                       value="{{ old('email') }}"
                                                       required>
                                                @error('email')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="tel" 
                                                       id="phone" 
                                                       name="phone"
                                                       placeholder="+1 (555) 000-0000"
                                                       class="form-input"
                                                       value="{{ old('phone') }}">
                                                @error('phone')
                                                    <span class="error-message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="company" class="form-label">Company (Optional)</label>
                                            <input type="text" 
                                                   id="company" 
                                                   name="company"
                                                   placeholder="Your Company Name"
                                                   class="form-input"
                                                   value="{{ old('company') }}">
                                            @error('company')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="subject" class="form-label">Subject</label>
                                            <input type="text" 
                                                   id="subject" 
                                                   name="subject"
                                                   placeholder="Equipment inquiry, support request, etc."
                                                   class="form-input"
                                                   value="{{ old('subject') }}"
                                                   required>
                                            @error('subject')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea id="message" 
                                                      name="message"
                                                      placeholder="Tell us how we can help you..."
                                                      class="form-textarea"
                                                      rows="5"
                                                      required>{{ old('message') }}</textarea>
                                            @error('message')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <button type="submit" class="submit-btn">
                                            <span class="btn-text">Send Message</span>
                                            <div class="btn-loader">
                                                <div class="loader-spinner"></div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="contact-info-section">
                                <!-- Contact Info Card -->
                                <div class="info-card">
                                    <h3 class="info-title">Contact Information</h3>
                                    
                                    <div class="contact-info-list">
                                        <div class="contact-info-item">
                                            <div class="contact-icon-container">
                                                <i class="fas fa-envelope contact-icon"></i>
                                            </div>
                                            <div class="contact-details">
                                                <p class="contact-label">Email</p>
                                                <a href="mailto:info@rozmed.com" class="contact-value">info@rozmed.com</a>
                                            </div>
                                        </div>
                                        
                                        <div class="contact-info-item">
                                            <div class="contact-icon-container">
                                                <i class="fas fa-phone contact-icon"></i>
                                            </div>
                                            <div class="contact-details">
                                                <p class="contact-label">Phone</p>
                                                <a href="tel:+15551234567" class="contact-value">+1 (555) 123-4567</a>
                                            </div>
                                        </div>
                                        
                                        <div class="contact-info-item">
                                            <div class="contact-icon-container">
                                                <i class="fas fa-location-dot contact-icon"></i>
                                            </div>
                                            <div class="contact-details">
                                                <p class="contact-label">Address</p>
                                                <p class="contact-value address">
                                                    2500 Healthcare Avenue, Suite 400, Davao City
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Hours Card -->
                                <div class="hours-card">
                                    <div class="hours-header">
                                        <div class="hours-icon-container">
                                            <i class="fas fa-clock hours-icon"></i>
                                        </div>
                                        <h3 class="hours-title">Business Hours</h3>
                                    </div>
                                    
                                    <div class="hours-list">
                                        <div class="hours-item">
                                            <span class="day">Monday - Friday</span>
                                            <span class="time">8:00 AM - 6:00 PM</span>
                                        </div>
                                        
                                        <div class="hours-item">
                                            <span class="day">Saturday</span>
                                            <span class="time">9:00 AM - 2:00 PM</span>
                                        </div>
                                        
                                        <div class="hours-item">
                                            <span class="day">Sunday</span>
                                            <span class="time closed">Closed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            @include('components.footer')
        </div>
    </div>
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForm = document.getElementById('contactForm');
    const submitBtn = contactForm.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        btnText.style.opacity = '0';
        btnLoader.style.display = 'flex';
        
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.form-input, .form-textarea').forEach(el => {
            el.classList.remove('error');
        });
        
        // Get form data
        const formData = new FormData(this);
        
        // Submit to backend
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success state
                submitBtn.classList.remove('loading');
                submitBtn.classList.add('success');
                btnLoader.style.display = 'none';
                btnText.textContent = 'Message Sent!';
                btnText.style.opacity = '1';
                
                // Add checkmark animation
                const checkmark = document.createElement('div');
                checkmark.className = 'checkmark';
                checkmark.innerHTML = `
                    <svg class="checkmark-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                `;
                submitBtn.appendChild(checkmark);
                
                // Show success notification
                showNotification(data.message || 'Your message has been sent successfully!', 'success');
                
                // Reset form after delay
                setTimeout(() => {
                    contactForm.reset();
                    submitBtn.classList.remove('success');
                    submitBtn.disabled = false;
                    btnText.textContent = 'Send Message';
                    checkmark.remove();
                    
                    // Reset button state
                    setTimeout(() => {
                        btnText.style.opacity = '1';
                    }, 300);
                }, 3000);
            } else {
                // Handle validation errors
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                btnText.style.opacity = '1';
                btnLoader.style.display = 'none';
                
                if (data.errors) {
                    // Display field-specific errors
                    Object.keys(data.errors).forEach(field => {
                        const input = contactForm.querySelector(`[name="${field}"]`);
                        if (input) {
                            input.classList.add('error');
                            const errorSpan = document.createElement('span');
                            errorSpan.className = 'error-message';
                            errorSpan.textContent = data.errors[field][0];
                            input.parentElement.appendChild(errorSpan);
                        }
                    });
                    
                    showNotification(data.message || 'Please check your input and try again.', 'error');
                } else {
                    showNotification(data.message || 'An error occurred. Please try again.', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Show error state
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
            btnText.style.opacity = '1';
            btnLoader.style.display = 'none';
            
            showNotification('Failed to submit your inquiry. Please try again later or contact us directly.', 'error');
        });
    });
    
    // Form input focus effects
    const formInputs = contactForm.querySelectorAll('.form-input, .form-textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Add input validation feedback
        input.addEventListener('input', function() {
            if (this.value) {
                this.parentElement.classList.add('has-value');
            } else {
                this.parentElement.classList.remove('has-value');
            }
            
            // Remove error state when user starts typing
            this.parentElement.classList.remove('error');
        });
    });
    
    // Contact info items hover animation
    const contactItems = document.querySelectorAll('.contact-info-item');
    
    contactItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
            const icon = this.querySelector('.contact-icon');
            if (icon) {
                icon.style.transform = 'scale(1.2)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            const icon = this.querySelector('.contact-icon');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });
    
    // Business hours items animation
    const hoursItems = document.querySelectorAll('.hours-item');
    hoursItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 300 + (index * 100));
    });
    
    // Page scroll animations
    const sections = document.querySelectorAll('section');
    
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    });
    
    sections.forEach(section => {
        sectionObserver.observe(section);
    });
    
    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon">${type === 'success' ? '✓' : '!'}</div>
                <div class="notification-text">${message}</div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
});

// Add CSS for animations
const contactStyles = document.createElement('style');
contactStyles.textContent = `
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
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
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
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
    
    .section-visible {
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .hours-item {
        opacity: 0;
        transform: translateX(-20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    
    .contact-info-item {
        transition: transform 0.3s ease;
    }
    
    .contact-icon {
        transition: transform 0.3s ease;
    }
    
    .form-group.focused .form-label {
        color: var(--secondary-color);
        transform: translateY(0);
        font-size: 14px;
    }
    
    .form-group.has-value .form-label {
        transform: translateY(0);
        font-size: 14px;
    }
    
    .submit-btn.loading {
        background: var(--secondary-color);
        cursor: not-allowed;
    }
    
    .submit-btn.success {
        background: var(--success-color);
    }
    
    .loader-spinner {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s linear infinite;
    }
    
    .checkmark {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
    }
    
    .checkmark-svg {
        width: 24px;
        height: 24px;
    }
    
    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: white;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    
    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: white;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    
    .notification {
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
    }
    
    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .notification.success {
        background: var(--success-color);
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .notification-icon {
        font-weight: bold;
        font-size: 18px;
    }
`;
document.head.appendChild(contactStyles);
</script>