class ModalService {
    constructor() {
        this.modals = new Map();
        this.activeModal = null;
        this.init();
    }

    init() {
        // Auto-register modals with data attributes
        document.querySelectorAll('[data-modal]').forEach(modal => {
            const modalId = modal.getAttribute('data-modal');
            this.registerModal(modalId, modal);
        });
    }

    registerModal(id, modalElement) {
        this.modals.set(id, {
            element: modalElement,
            isOpen: false,
            openCallbacks: [],
            closeCallbacks: []
        });

        // Set up close buttons
        const closeButtons = modalElement.querySelectorAll('[data-modal-close]');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', () => this.close(id));
        });

        // Close on overlay click
        modalElement.addEventListener('click', (e) => {
            if (e.target === modalElement) {
                this.close(id);
            }
        });
    }

    open(id) {
        if (!this.modals.has(id)) {
            console.error(`Modal with id "${id}" not found.`);
            return;
        }

        const modal = this.modals.get(id);

        // Close any active modal
        if (this.activeModal && this.activeModal !== id) {
            this.close(this.activeModal);
        }

        // Open the modal
        modal.element.classList.remove('hidden');
        modal.element.setAttribute('aria-hidden', 'false');
        modal.isOpen = true;
        this.activeModal = id;

        // Prevent body scrolling
        document.body.style.overflow = 'hidden';

        // Call open callbacks
        modal.openCallbacks.forEach(callback => callback());

        // Focus trap
        this.setupFocusTrap(id);

        // Dispatch event
        modal.element.dispatchEvent(new CustomEvent('modal-opened'));
    }

    close(id) {
        if (!this.modals.has(id)) return;

        const modal = this.modals.get(id);

        modal.element.classList.add('hidden');
        modal.element.setAttribute('aria-hidden', 'true');
        modal.isOpen = false;
        this.activeModal = null;

        // Restore body scrolling
        document.body.style.overflow = '';

        // Call close callbacks
        modal.closeCallbacks.forEach(callback => callback());

        // Remove focus trap
        this.removeFocusTrap();

        // Dispatch event
        modal.element.dispatchEvent(new CustomEvent('modal-closed'));
    }

    onOpen(id, callback) {
        if (this.modals.has(id)) {
            this.modals.get(id).openCallbacks.push(callback);
        }
    }

    onClose(id, callback) {
        if (this.modals.has(id)) {
            this.modals.get(id).closeCallbacks.push(callback);
        }
    }

    setupFocusTrap(id) {
        const modal = this.modals.get(id);
        const focusableElements = modal.element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );

        if (focusableElements.length === 0) return;

        this.firstFocusableElement = focusableElements[0];
        this.lastFocusableElement = focusableElements[focusableElements.length - 1];

        this.firstFocusableElement.focus();

        this.handleTabKey = (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === this.firstFocusableElement) {
                        e.preventDefault();
                        this.lastFocusableElement.focus();
                    }
                } else {
                    if (document.activeElement === this.lastFocusableElement) {
                        e.preventDefault();
                        this.firstFocusableElement.focus();
                    }
                }
            }
        };

        modal.element.addEventListener('keydown', this.handleTabKey);
    }

    removeFocusTrap() {
        if (this.handleTabKey) {
            const modal = this.modals.get(this.activeModal);
            if (modal) {
                modal.element.removeEventListener('keydown', this.handleTabKey);
            }
        }
    }
}

// Create global instance
window.ModalService = new ModalService();

// Add to your Vite/Webpack entry
// import './modal-service';