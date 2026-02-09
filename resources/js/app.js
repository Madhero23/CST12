import './bootstrap';
import './modal-service';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';


// Make it available globally if needed
window.flatpickr = flatpickr;
window.ModalService = new ModalService();
