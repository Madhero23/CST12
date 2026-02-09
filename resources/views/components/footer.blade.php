<footer class="footer">
    <div class="footer-content">
        <div class="footer-grid">
            <div class="company-info">
                <div class="footer-logo">
                    <img class="logo-image" src="{{ asset('image-roz-med-logo0.png') }}" alt="RozMed Logo" />
                    <div class="logo-text">
                        <div class="logo-main">
                            <span class="roz">Roz</span>
                            <span class="med">MED</span>
                        </div>
                        <div class="logo-subtitle">ENTERPRISE, INC.</div>
                    </div>
                </div>
                <p class="company-description">
                    Professional medical equipment solutions tailored for hospitals,
                    clinics, and specialty care centers.
                </p>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Quick Links</h3>
                <ul class="footer-links">
                    @php
                        $footerRoutes = [
                            ['route' => 'home.index', 'text' => 'Home'],
                            ['route' => 'products', 'text' => 'Products'],
                            ['route' => 'about', 'text' => 'About Us'],
                            ['route' => 'contact', 'text' => 'Contact']
                        ];
                    @endphp
                    
                    @foreach($footerRoutes as $route)
                        <li><a href="{{ route($route['route']) }}" class="footer-link">{{ $route['text'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Contact Info</h3>
                <ul class="footer-links">
                    <li class="footer-contact">info@rozmed.com</li>
                    <li class="footer-contact">+1 (555) 123-4567</li>
                    <li class="footer-contact">2500 Healthcare Avenue, Suite 400</li>
                    <li class="footer-contact">Davao City</li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Certifications</h3>
                <ul class="footer-links">
                    <li class="footer-contact">ISO 13485 Certified</li>
                    <li class="footer-contact">FDA Registered Supplier</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">© 2025 RozMed. All rights reserved.</p>
        </div>
    </div>
</footer>