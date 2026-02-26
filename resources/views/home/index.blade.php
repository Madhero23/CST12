<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RozMed Enterprise - Professional Medical Equipment</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite('resources/css/index.css')
</head>
<body>
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <!-- Hero Section -->
        <div class="hero" id="hero-slideshow">
            <div class="hero-content">
                <div class="trust-badge">
                    <i class="fas fa-star" style="color: var(--secondary-color); font-size: 0.9rem;"></i>
                    <div class="trust-text">Trusted by 500+ Healthcare Facilities</div>
                </div>
                <h1 class="main-heading">
                    <span class="roz-red">Roz</span>
                    <span class="med-blue">Med</span>
                </h1>
                <h2 class="hero-subheading">Professional Medical Equipment For Healthcare Excellence</h2>
                <p class="hero-description">
                    Providing healthcare professionals worldwide with premium medical
                    instruments, diagnostic equipment, and surgical tools to deliver
                    exceptional patient care.
                </p>
                <div class="hero-buttons">
                    <div class="cta-actions">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-box btn-icon"></i>
                            <span>Browse Catalog</span>
                        </a>
                        <a href="{{ route('contact.index') }}" class="btn btn-secondary">
                            <i class="fas fa-phone-alt btn-icon"></i>
                            <span>Contact Sales</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide Indicator Dots -->
            <div class="slide-indicators">
                @foreach($heroImages ?? ['Hero.png', 'hero2.png', 'hero3.png', 'hero4.png'] as $index => $slide)
                    <button class="slide-indicator {{ $index === 0 ? 'active' : '' }}" 
                            data-slide="{{ $index }}" 
                            aria-label="Go to slide {{ $index + 1 }}">
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Featured Equipment Section -->
        <section class="featured-equipment">
            <div class="section-header">
                <h2 class="section-title">Featured Medical Equipment</h2>
                <p class="section-description">Discover our most popular healthcare solutions</p>
            </div>
            <div class="equipment-grid">
                @forelse($featuredProducts as $index => $product)
                <div class="equipment-card" style="--i: {{ $index }}">
                    <div class="card-image">
                        <div class="equipment-icon-wrapper">
                            @if($index == 0) <i class="fas fa-wave-square"></i>
                            @elseif($index == 1) <i class="fas fa-heart"></i>
                            @else <i class="fas fa-scissors"></i>
                            @endif
                        </div>
                        @if($product->Images_Path)
                            <img class="equipment-large-img" src="{{ asset($product->Images_Path) }}" alt="{{ $product->Product_Name }}" />
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $product->Product_Name }}</h3>
                        <p class="card-description">{{ Str::limit($product->Description, 100) }}</p>
                        <a href="{{ route('products.show', ['id' => $product->Product_ID]) }}" class="card-link">
                            <span>View Details</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="empty-state">No featured equipment available at the moment.</p>
                @endforelse
            </div>
        </section>

        <!-- Why Choose Section -->
        <section class="why-choose">
            <div class="section-header">
                <h2 class="section-title">Why Choose RozMed?</h2>
                <p class="section-description">
                    Delivering reliable equipment and expert support for every stage
                    of patient care.
                </p>
            </div>
            <div class="features-grid">
                @foreach([
                    ['icon' => 'icon0.svg', 'title' => 'Quality Assurance', 'desc' => 'All equipment is sourced from certified manufacturers and verified against strict quality benchmarks.'],
                    ['icon' => 'icon1.svg', 'title' => 'Expert Support', 'desc' => 'Specialists guide you from product selection to installation, training, and ongoing service.'],
                    ['icon' => 'icon2.svg', 'title' => 'Fast Delivery', 'desc' => 'Optimized logistics ensure critical equipment is delivered safely and on time.']
                ] as $index => $feature)
                <div class="feature-card" style="--i: {{ $index }}">
                    <div class="feature-icon-wrapper">
                        @if($index == 0) <i class="fas fa-shield-alt"></i>
                        @elseif($index == 1) <i class="fas fa-user-md"></i>
                        @else <i class="fas fa-shipping-fast"></i>
                        @endif
                    </div>
                    <h3 class="feature-title">{{ $feature['title'] }}</h3>
                    <p class="feature-description">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <section class="stats">
            <div class="stat-card" style="--i: 0">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-hospital"></i>
                </div>
                <div class="stat-value">{{ $stats['facilities'] < 10 ? '500+' : $stats['facilities'] . '+' }}</div>
                <div class="stat-label">Healthcare Facilities</div>
            </div>
            <div class="stat-card" style="--i: 1">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-value">{{ $stats['products_delivered'] < 10 ? '10K+' : number_format($stats['products_delivered']) . '+' }}</div>
                <div class="stat-label">Products Delivered</div>
            </div>
            <div class="stat-card" style="--i: 2">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="stat-value">{{ $stats['experience_years'] }}+</div>
                <div class="stat-label">Years of Experience</div>
            </div>
            <div class="stat-card" style="--i: 3">
                <div class="stat-icon-wrapper">
                    <i class="fas fa-thumbs-up"></i>
                </div>
                <div class="stat-value">{{ $stats['satisfaction_rate'] }}</div>
                <div class="stat-label">Customer Satisfaction</div>
            </div>
        </section>

        @include('components.footer')
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Array of hero background images from public/images/
    const heroImages = [
        "{{ asset('images/Hero.png') }}",
        "{{ asset('images/hero2.png') }}",
        "{{ asset('images/hero3.png') }}",
        "{{ asset('images/hero4.png') }}"
    ];
    
    // Slide duration in milliseconds (20 seconds)
    const SLIDE_DURATION = 20000;
    
    const heroElement = document.getElementById('hero-slideshow');
    const indicators = document.querySelectorAll('.slide-indicator');
    let currentSlide = 0;
    let slideInterval;
    
    // Preload images to prevent blank flickering
    heroImages.forEach(src => {
        const img = new Image();
        img.src = src;
    });
    
    // Function to change slide
    function changeSlide(slideIndex) {
        if (!heroElement || indicators.length === 0) return;
        
        // Remove active class from all indicators
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
        });
        
        // Set current slide
        currentSlide = slideIndex % heroImages.length;
        
        // Add active class to current indicator
        if (indicators[currentSlide]) {
            indicators[currentSlide].classList.add('active');
        }
        
        // Change background with fade effect
        // We use a CSS class or transition for smoothness
        heroElement.style.transition = 'background-image 0.8s ease-in-out, opacity 0.5s ease-in-out';
        
        // For the very first slide, don't flicker opacity as much
        if (heroElement.style.backgroundImage) {
            heroElement.style.opacity = '0.9';
        }
        
        setTimeout(() => {
            heroElement.style.backgroundImage = `url('${heroImages[currentSlide]}')`;
            heroElement.style.backgroundPosition = 'center';
            heroElement.style.backgroundSize = 'cover';
            heroElement.style.backgroundRepeat = 'no-repeat';
            heroElement.style.opacity = '1';
        }, 100);
    }
    
    // Function to go to next slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % heroImages.length;
        changeSlide(nextIndex);
    }
    
    // Function to start slideshow
    function startSlideshow() {
        stopSlideshow(); // Clear any existing
        slideInterval = setInterval(nextSlide, SLIDE_DURATION);
    }
    
    // Function to stop slideshow
    function stopSlideshow() {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
    }
    
    // Initialize first slide immediately
    if (heroElement) {
        // Set initial background before the first transition
        heroElement.style.backgroundImage = `url('${heroImages[0]}')`;
        heroElement.style.backgroundPosition = 'center';
        heroElement.style.backgroundSize = 'cover';
        changeSlide(0);
        startSlideshow();
    }
    
    // Add click event to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopSlideshow();
            changeSlide(index);
            startSlideshow();
        });
    });
    
    // Pause on hover
    heroElement.addEventListener('mouseenter', stopSlideshow);
    heroElement.addEventListener('mouseleave', startSlideshow);
    
    // Visibility change
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopSlideshow();
        } else {
            startSlideshow();
        }
    });
});
</script>
</body>
</html>