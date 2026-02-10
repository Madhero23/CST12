// resources/js/modules/buttonHandler.js
export class ButtonHandler {
    constructor() {
        this.buttons = document.querySelectorAll('[data-action]');
        this.bindEvents();
    }

    bindEvents() {
        this.buttons.forEach(button => {
            button.addEventListener('click', (e) => this.handleClick(e));
            button.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.handleClick(e);
                }
            });
        });
    }

    async handleClick(event) {
        const button = event.currentTarget;
        const action = button.dataset.action;
        
        // Add loading state
        this.setLoadingState(button, true);

        try {
            switch (action) {
                case 'browse-products':
                    await this.handleBrowseProducts();
                    break;
                case 'contact-sales':
                    await this.handleContactSales();
                    break;
                default:
                    console.warn(`Unknown action: ${action}`);
            }
        } catch (error) {
            console.error(`Error handling action ${action}:`, error);
        } finally {
            this.setLoadingState(button, false);
        }
    }

    async handleBrowseProducts() {
        // Implement product browsing logic
        window.location.href = '/products';
    }

    async handleContactSales() {
        // Implement contact sales logic
        window.location.href = '/contact';
    }

    setLoadingState(button, isLoading) {
        if (isLoading) {
            button.setAttribute('aria-busy', 'true');
            button.classList.add('loading');
            button.disabled = true;
        } else {
            button.removeAttribute('aria-busy');
            button.classList.remove('loading');
            button.disabled = false;
        }
    }
}