import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/css/about.css',
                    'resources/css/admin.css',
                    'resources/css/contact.css',
                    'resources/css/customer.css',
                    'resources/css/document.css',
                    'resources/css/finance.css',
                    'resources/css/footer.css',
                    'resources/css/header.css',
                    'resources/css/index.css',
                    'resources/css/inventory.css',
                    'resources/css/modal.css',
                    'resources/css/PDetails.css',
                    'resources/css/products.css',
                    'resources/css/sidebar.css',
                    'resources/css/viewproduct.css',
                    'resources/js/app.js', 
                    'resources/js/home.js',
                    'resources/js/bootstrap.js',
                    'resources/js/modal-service.js',
                    'resources/js/modules/homeSlideshow.js',
                    'resources/js/modules/buttonHandler.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
