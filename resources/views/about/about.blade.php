<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | RozMed Enterprise, Inc.</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/about.css'])
</head>
<body>
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
                                    <i class="fas fa-heart-pulse card-icon"></i>
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
                                    <i class="fas fa-lightbulb card-icon"></i>
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
                                    <i class="fas fa-shield-halved value-icon"></i>
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
                                    <i class="fas fa-users-gear value-icon"></i>
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
                                    <i class="fas fa-trophy value-icon"></i>
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
                                    <i class="fas fa-chart-line value-icon"></i>
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
            missionCard?.classList.add('animate-in');
        }, 300);
        
        setTimeout(() => {
            visionCard?.classList.add('animate-in');
        }, 500);
        
        // Core values cards animation
        const valueCards = document.querySelectorAll('.value-card');
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const index = parseInt(card.dataset.index);
                    
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
        
        // Certification badges animation
        const certificationBadges = document.querySelectorAll('.certification-badge');
        certificationBadges.forEach((badge, index) => {
            setTimeout(() => {
                badge.style.opacity = '1';
                badge.style.transform = 'translateY(0)';
            }, 800 + (index * 200));
        });
        
        // Scroll reveal sections
        const sections = document.querySelectorAll('section');
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('section-visible');
                }
            });
        }, { threshold: 0.1 });
        
        sections.forEach(section => {
            sectionObserver.observe(section);
        });
    });
    </script>
    @endpush
</body>
</html>