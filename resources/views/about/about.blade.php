@vite(['resources/css/about.css'])
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <main class="about-page">
            <!-- Hero Section -->
            <section class="about-hero">
                <div class="container">
                    <h1 class="page-title">About RozMed</h1>
                    <p class="page-subtitle">
                        Committed to advancing healthcare through superior equipment and service
                    </p>
                </div>
            </section>

            <!-- Mission & Vision Section -->
            <section class="mission-vision-section">
                <div class="container">
                    <div class="mission-vision-grid">
                        <!-- Mission Card -->
                        <div class="mission-card">
                            <div class="card-icon-container">
                                <img src="{{ asset('icon0.svg') }}" alt="Mission" class="card-icon">
                            </div>
                            <div class="card-content">
                                <h2 class="card-title">Our Mission</h2>
                                <p class="card-description">
                                    At RozMed, we are dedicated to empowering healthcare providers with
                                    reliable, innovative medical equipment that enhances patient
                                    outcomes and operational efficiency. Our commitment extends beyond
                                    product delivery—we partner with hospitals, clinics, and specialty
                                    care centers to ensure seamless integration, comprehensive training,
                                    and ongoing technical support.
                                </p>
                                <div class="certification-badges">
                                    <span class="certification-badge">ISO 13485 Certified</span>
                                    <span class="certification-badge">FDA Approved Supplier</span>
                                </div>
                            </div>
                        </div>

                        <!-- Vision Card -->
                        <div class="vision-card">
                            <div class="card-icon-container">
                                <img src="{{ asset('icon1.svg') }}" alt="Vision" class="card-icon">
                            </div>
                            <div class="card-content">
                                <h2 class="card-title">Our Vision</h2>
                                <p class="card-description">
                                    To become the most trusted partner in medical equipment solutions
                                    across healthcare facilities worldwide. We envision a future where
                                    cutting-edge medical technology is accessible to every care
                                    provider, enabling them to deliver exceptional patient experiences
                                    through reliable, innovative equipment backed by unparalleled
                                    service excellence and technical expertise.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Core Values Section -->
            <section class="values-section">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Our Core Values</h2>
                        <p class="section-subtitle">The principles that guide everything we do</p>
                    </div>
                    
                    <div class="values-grid">
                        <!-- Quality First -->
                        <div class="value-card" data-index="0">
                            <div class="value-icon-container">
                                <img src="{{ asset('icon2.svg') }}" alt="Quality First" class="value-icon">
                            </div>
                            <div class="value-content">
                                <h3 class="value-title">Quality First</h3>
                                <p class="value-description">
                                    We source equipment from certified manufacturers and conduct
                                    rigorous quality checks to ensure every product meets
                                    international healthcare standards.
                                </p>
                            </div>
                        </div>

                        <!-- Customer Partnership -->
                        <div class="value-card" data-index="1">
                            <div class="value-icon-container">
                                <img src="{{ asset('icon3.svg') }}" alt="Customer Partnership" class="value-icon">
                            </div>
                            <div class="value-content">
                                <h3 class="value-title">Customer Partnership</h3>
                                <p class="value-description">
                                    Building long-term relationships through dedicated support,
                                    training programs, and responsive service that adapts to your
                                    facility's unique needs.
                                </p>
                            </div>
                        </div>

                        <!-- Innovation & Excellence -->
                        <div class="value-card" data-index="2">
                            <div class="value-icon-container">
                                <img src="{{ asset('icon4.svg') }}" alt="Innovation & Excellence" class="value-icon">
                            </div>
                            <div class="value-content">
                                <h3 class="value-title">Innovation & Excellence</h3>
                                <p class="value-description">
                                    Continuously expanding our portfolio with cutting-edge medical
                                    technology that empowers healthcare professionals to deliver
                                    exceptional care.
                                </p>
                            </div>
                        </div>

                        <!-- Reliable Performance -->
                        <div class="value-card" data-index="3">
                            <div class="value-icon-container">
                                <img src="{{ asset('icon5.svg') }}" alt="Reliable Performance" class="value-icon">
                            </div>
                            <div class="value-content">
                                <h3 class="value-title">Reliable Performance</h3>
                                <p class="value-description">
                                    Ensuring uptime and dependability through comprehensive
                                    maintenance support, rapid response times, and genuine replacement
                                    parts availability.
                                </p>
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
    // Mission & Vision cards animation
    const missionCard = document.querySelector('.mission-card');
    const visionCard = document.querySelector('.vision-card');
    
    // Add staggered animation
    setTimeout(() => {
        missionCard.classList.add('animate-in');
    }, 300);
    
    setTimeout(() => {
        visionCard.classList.add('animate-in');
    }, 500);
    
    // Core values cards animation
    const valueCards = document.querySelectorAll('.value-card');
    
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const card = entry.target;
                const index = parseInt(card.dataset.index);
                
                // Stagger the animation
                setTimeout(() => {
                    card.classList.add('animate-in');
                }, index * 200);
                
                observer.unobserve(card);
            }
        });
    }, observerOptions);
    
    valueCards.forEach(card => {
        observer.observe(card);
    });
    
    // Card hover effects
    const allCards = document.querySelectorAll('.mission-card, .vision-card, .value-card');
    
    allCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.1)';
            
            // Add icon animation
            const icon = this.querySelector('.card-icon, .value-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
            
            // Reset icon animation
            const icon = this.querySelector('.card-icon, .value-icon');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0)';
            }
        });
    });
    
    // Certification badges animation
    const certificationBadges = document.querySelectorAll('.certification-badge');
    
    certificationBadges.forEach((badge, index) => {
        setTimeout(() => {
            badge.style.opacity = '1';
            badge.style.transform = 'translateY(0)';
        }, 800 + (index * 200));
    });
    
    // Page scroll reveal animation
    const sections = document.querySelectorAll('section');
    
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-visible');
            }
        });
    }, {
        threshold: 0.1
    });
    
    sections.forEach(section => {
        sectionObserver.observe(section);
    });
    
    // Add parallax effect to mission & vision cards on scroll
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const missionIcon = document.querySelector('.mission-card .card-icon-container');
        const visionIcon = document.querySelector('.vision-card .card-icon-container');
        
        if (missionIcon) {
            missionIcon.style.transform = `translateY(${scrolled * 0.05}px)`;
        }
        
        if (visionIcon) {
            visionIcon.style.transform = `translateY(${scrolled * 0.05}px)`;
        }
    });
});

// Add CSS for animations
const aboutStyles = document.createElement('style');
aboutStyles.textContent = `
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
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes rotateIn {
        from {
            opacity: 0;
            transform: rotate(-10deg) scale(0.5);
        }
        to {
            opacity: 1;
            transform: rotate(0) scale(1);
        }
    }
    
    .mission-card,
    .vision-card {
        opacity: 0;
        transform: translateY(30px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .mission-card.animate-in {
        animation: slideInLeft 0.8s ease forwards;
    }
    
    .vision-card.animate-in {
        animation: slideInRight 0.8s ease forwards;
    }
    
    .value-card {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .value-card.animate-in {
        animation: scaleIn 0.6s ease forwards;
    }
    
    .certification-badge {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    
    .card-icon,
    .value-icon {
        transition: transform 0.3s ease;
    }
    
    section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }
    
    section.section-visible {
        opacity: 1;
        transform: translateY(0);
    }
`;
document.head.appendChild(aboutStyles);
</script>
@endpush