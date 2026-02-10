// resources/js/modules/homeSlideshow.js
export class HomeSlideshow {
    constructor(elementId, images, options = {}) {
        this.heroElement = document.getElementById(elementId);
        if (!this.heroElement) {
            console.error(`Element with ID "${elementId}" not found`);
            return;
        }

        this.images = images;
        this.indicators = document.querySelectorAll('.slide-indicator');
        this.currentSlide = 0;
        this.slideInterval = null;
        this.isPaused = false;

        // Default options
        this.options = {
            duration: 30000,
            transitionDuration: 800,
            autoStart: true,
            ...options
        };

        this.init();
    }

    init() {
        // Validate images array
        if (!Array.isArray(this.images) || this.images.length === 0) {
            console.error('Invalid images array provided');
            return;
        }

        // Set initial background
        this.setBackground(this.images[0]);

        // Initialize indicators
        this.updateIndicators();

        // Add event listeners
        this.bindEvents();

        // Start slideshow if autoStart is true
        if (this.options.autoStart) {
            this.start();
        }

        // Add accessibility attributes
        this.heroElement.setAttribute('aria-live', 'polite');
    }

    setBackground(imageUrl) {
        return new Promise((resolve) => {
            // Preload image
            const img = new Image();
            img.onload = () => {
                this.heroElement.style.backgroundImage = `url('${imageUrl}')`;
                this.heroElement.style.opacity = '1';
                resolve();
            };
            img.onerror = () => {
                console.warn(`Failed to load image: ${imageUrl}`);
                resolve();
            };
            img.src = imageUrl;
        });
    }

    async changeSlide(slideIndex) {
        if (slideIndex < 0 || slideIndex >= this.images.length) {
            return;
        }

        // Fade out
        this.heroElement.style.opacity = '0.7';

        // Wait for transition
        await new Promise(resolve => 
            setTimeout(resolve, this.options.transitionDuration / 2)
        );

        // Update slide
        this.currentSlide = slideIndex;
        await this.setBackground(this.images[slideIndex]);

        // Update indicators
        this.updateIndicators();

        // Update ARIA attributes
        this.updateAriaAttributes();
    }

    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.images.length;
        this.changeSlide(nextIndex);
    }

    prevSlide() {
        const prevIndex = (this.currentSlide - 1 + this.images.length) % this.images.length;
        this.changeSlide(prevIndex);
    }

    updateIndicators() {
        this.indicators.forEach((indicator, index) => {
            const isActive = index === this.currentSlide;
            indicator.classList.toggle('active', isActive);
            indicator.setAttribute('aria-selected', isActive);
        });
    }

    updateAriaAttributes() {
        this.heroElement.setAttribute(
            'aria-label',
            `Slide ${this.currentSlide + 1} of ${this.images.length}`
        );
    }

    start() {
        if (this.slideInterval) {
            this.stop();
        }

        this.slideInterval = setInterval(() => {
            if (!this.isPaused) {
                this.nextSlide();
            }
        }, this.options.duration);
    }

    stop() {
        if (this.slideInterval) {
            clearInterval(this.slideInterval);
            this.slideInterval = null;
        }
    }

    pause() {
        this.isPaused = true;
    }

    resume() {
        this.isPaused = false;
    }

    goToSlide(index) {
        if (index >= 0 && index < this.images.length) {
            this.stop();
            this.changeSlide(index);
            this.start();
        }
    }

    bindEvents() {
        // Indicator click events
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => this.goToSlide(index));
            indicator.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.goToSlide(index);
                }
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.stop();
                    this.prevSlide();
                    this.start();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.stop();
                    this.nextSlide();
                    this.start();
                    break;
                case ' ':
                    e.preventDefault();
                    this.isPaused ? this.resume() : this.pause();
                    break;
            }
        });

        // Pause on hover
        this.heroElement.addEventListener('mouseenter', () => {
            this.pause();
        });

        this.heroElement.addEventListener('mouseleave', () => {
            this.resume();
        });

        // Handle visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pause();
            } else {
                this.resume();
            }
        });

        // Handle window focus
        window.addEventListener('focus', () => this.resume());
        window.addEventListener('blur', () => this.pause());
    }

    destroy() {
        this.stop();
        
        // Remove event listeners
        this.indicators.forEach(indicator => {
            const newIndicator = indicator.cloneNode(true);
            indicator.parentNode.replaceChild(newIndicator, indicator);
        });

        // Remove keyboard listeners
        document.removeEventListener('keydown', this.handleKeydown);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Get images from data attribute or use defaults
    const heroElement = document.getElementById('hero-slideshow');
    if (!heroElement) return;

    const images = JSON.parse(heroElement.dataset.images || '[]');
    
    // If no images in data attribute, use default ones
    const defaultImages = window.heroImages || [
        '{{ asset('hero0.png') }}',
        '{{ asset('hero1.png') }}',
        '{{ asset('hero2.png') }}',
        '{{ asset('hero3.png') }}'
    ];

    const slideshow = new HomeSlideshow('hero-slideshow', images.length ? images : defaultImages, {
        duration: 30000,
        transitionDuration: 800
    });

    // Make slideshow available globally if needed
    window.homeSlideshow = slideshow;
});