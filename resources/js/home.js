// resources/js/home.js
import { HomeSlideshow } from './modules/homeSlideshow';
import { ButtonHandler } from './modules/buttonHandler';

class HomePage {
    constructor() {
        this.init();
    }

    init() {
        // Initialize slideshow
        this.slideshow = new HomeSlideshow('hero-slideshow', [], {
            duration: 30000,
            transitionDuration: 800
        });

        // Initialize button handlers
        this.buttonHandler = new ButtonHandler();

        // Add intersection observer for lazy loading
        this.setupIntersectionObserver();
    }

    setupIntersectionObserver() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px',
                threshold: 0.1
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                observer.observe(img);
            });
        }
    }

    destroy() {
        if (this.slideshow) {
            this.slideshow.destroy();
        }
    }
}

// Initialize home page
document.addEventListener('DOMContentLoaded', () => {
    window.homePage = new HomePage();
});