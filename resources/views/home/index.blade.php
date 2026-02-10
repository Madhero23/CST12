@vite('resources/css/index.css')
<div class="user-hero">
    <div class="app">
        @include('components.header')
        
        <!-- Hero Section -->
        <div class="hero" id="hero-slideshow">
            <div class="hero-content">
                <div class="trust-badge">
                    <img class="icon" src="{{ asset('icon-7.svg') }}" alt="Trust Badge" />
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
                    <a href="{{ route('product') }}" class="btn btn-primary">
                        <img class="btn-icon" src="{{ asset('icon8.svg') }}" alt="Browse Products" />
                        <span>Browse Products</span>
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary">
                        <img class="btn-icon" src="{{ asset('icon9.svg') }}" alt="Contact Sales" />
                        <span>Contact Sales</span>
                    </a>
                </div>
            </div>
            
            <!-- Slide Indicator Dots -->
            <div class="slide-indicators">
                @foreach(['hero.png', 'hero1.png', 'hero2.png', 'hero3.png'] as $index => $slide)
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
                @foreach([
                    ['icon' => 'icon10.svg', 'title' => 'Medical Ultrasound Device', 'desc' => 'High-resolution imaging system for radiology, cardiology, and obstetrics departments.'],
                    ['icon' => 'icon12.svg', 'title' => 'Patient Monitor', 'desc' => 'Continuous multi-parameter monitoring with intuitive alarms for critical care units.'],
                    ['icon' => 'icon14.svg', 'title' => 'Surgical Instruments Set', 'desc' => 'Precision-crafted instruments engineered for durability and optimal surgical control.']
                ] as $index => $equipment)
                <div class="equipment-card" style="--i: {{ $index }}">
                    <div class="card-image">
                        <img class="equipment-icon" src="{{ asset($equipment['icon']) }}" alt="{{ $equipment['title'] }}" />
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $equipment['title'] }}</h3>
                        <p class="card-description">{{ $equipment['desc'] }}</p>
                        <a href="{{ route('product', ['id' => $index + 1]) }}" class="card-link">
                            <span>View More</span>
                            <img class="link-icon" src="{{ asset('icon' . ($index + 11) . '.svg') }}" alt="View More" />
                        </a>
                    </div>
                </div>
                @endforeach
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
                        <img class="feature-icon" src="{{ asset($feature['icon']) }}" alt="{{ $feature['title'] }}" />
                    </div>
                    <h3 class="feature-title">{{ $feature['title'] }}</h3>
                    <p class="feature-description">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats">
            @foreach([
                ['icon' => 'icon3.svg', 'value' => '500+', 'label' => 'Healthcare Facilities'],
                ['icon' => 'icon4.svg', 'value' => '10K+', 'label' => 'Products Delivered'],
                ['icon' => 'icon5.svg', 'value' => '14+', 'label' => 'Years of Experience'],
                ['icon' => 'icon6.svg', 'value' => '98%', 'label' => 'Customer Satisfaction']
            ] as $index => $stat)
            <div class="stat-card" style="--i: {{ $index }}">
                <div class="stat-icon-wrapper">
                    <img class="stat-icon" src="{{ asset($stat['icon']) }}" alt="{{ $stat['label'] }}" />
                </div>
                <div class="stat-value">{{ $stat['value'] }}</div>
                <div class="stat-label">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </section>

        @include('components.footer')
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Array of hero background images
    const heroImages = [
        "{{ asset('hero0.png') }}",
        "{{ asset('hero1.png') }}", // Add these images to your public folder
        "{{ asset('hero2.png') }}", // Add these images to your public folder
        "{{ asset('hero3.png') }}"  // Add these images to your public folder
    ];
    
    // Slide duration in milliseconds (30 seconds)
    const SLIDE_DURATION = 30000;
    
    const heroElement = document.getElementById('hero-slideshow');
    const indicators = document.querySelectorAll('.slide-indicator');
    let currentSlide = 0;
    let slideInterval;
    
    // Function to change slide
    function changeSlide(slideIndex) {
        // Remove active class from all indicators
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
        });
        
        // Set current slide
        currentSlide = slideIndex;
        
        // Add active class to current indicator
        indicators[currentSlide].classList.add('active');
        
        // Change background with fade effect
        heroElement.style.opacity = '0.7';
        
        setTimeout(() => {
            heroElement.style.backgroundImage = `url('${heroImages[currentSlide]}')`;
            heroElement.style.backgroundPosition = 'center';
            heroElement.style.backgroundSize = 'cover';
            heroElement.style.backgroundRepeat = 'no-repeat';
            heroElement.style.opacity = '1';
        }, 300); // Transition duration
    }
    
    // Function to go to next slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % heroImages.length;
        changeSlide(nextIndex);
    }
    
    // Function to start slideshow
    function startSlideshow() {
        slideInterval = setInterval(nextSlide, SLIDE_DURATION);
    }
    
    // Function to stop slideshow (when user interacts)
    function stopSlideshow() {
        clearInterval(slideInterval);
    }
    
    // Function to resume slideshow after pause
    function resumeSlideshow() {
        stopSlideshow();
        setTimeout(startSlideshow, 5000); // Resume after 5 seconds
    }
    
    // Initialize first slide
    changeSlide(0);
    
    // Start slideshow
    startSlideshow();
    
    // Add click event to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopSlideshow();
            changeSlide(index);
            resumeSlideshow();
        });
        
        // Add keyboard support
        indicator.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                stopSlideshow();
                changeSlide(index);
                resumeSlideshow();
            }
        });
    });
    
    // Pause slideshow when user hovers over hero section
    heroElement.addEventListener('mouseenter', stopSlideshow);
    heroElement.addEventListener('mouseleave', () => {
        // Wait a bit before resuming to prevent immediate change
        setTimeout(startSlideshow, 1000);
    });
    
    // Pause slideshow when window loses focus
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopSlideshow();
        } else {
            startSlideshow();
        }
    });
    
    // Add keyboard navigation (left/right arrows)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            stopSlideshow();
            const prevIndex = (currentSlide - 1 + heroImages.length) % heroImages.length;
            changeSlide(prevIndex);
            resumeSlideshow();
        } else if (e.key === 'ArrowRight') {
            stopSlideshow();
            nextSlide();
            resumeSlideshow();
        }
    });
});
</script>
@endpush