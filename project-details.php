<?php include 'includes/header.php'; ?>

<!-- Project Details Hero -->
<div class="pd-hero" style="height: 40vh; min-height: 300px; margin-bottom: 30px;">
    <div class="pd-hero-bg">
        <img src="assets/images/prop1.png" alt="Emerald Luxury Villa">
    </div>
    <div class="pd-hero-overlay" style="background: rgba(10, 25, 47, 0.4);"></div>
</div>

<div class="pd-main-section">
    <div class="container">
        <div class="pd-layout">
            
            <!-- Left Column: Content -->
            <div class="pd-content">
                


                <!-- Quick Info Bar -->
                <div class="pd-quick-info">
                    <div class="qi-item">
                        <i class="fas fa-home"></i>
                        <span>Property Type</span>
                        <strong>4 BHK Villa</strong>
                    </div>
                    <div class="qi-item">
                        <i class="fas fa-vector-square"></i>
                        <span>Area</span>
                        <strong>3,200 Sq.Ft.</strong>
                    </div>
                    <div class="qi-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Status</span>
                        <strong>Under Construction</strong>
                    </div>
                    <div class="qi-item">
                        <i class="fas fa-key"></i>
                        <span>Possession</span>
                        <strong>Dec 2026</strong>
                    </div>
                </div>

                <!-- Project Header Info -->
                <div class="pd-header-info">
                    <div class="pd-header-left">
                        <div class="pd-badge-dark">Under Construction</div>
                        <h1 class="pd-title-dark">Emerald Luxury Villa</h1>
                        <p class="pd-location-dark"><i class="fas fa-map-marker-alt"></i> Pali Hill, Mumbai</p>
                    </div>
                    <div class="pd-header-right">
                        <div class="pd-price-wrap-dark">
                            <span class="pd-price-dark">₹4.5 Cr*</span>
                            <span class="pd-price-label-dark">Starting Price</span>
                        </div>
                        <a href="#" class="btn-download-brochure">
                            <i class="fas fa-file-download"></i> Download Brochure
                        </a>
                    </div>
                </div>

                <!-- Overview Section -->
                <div class="pd-section">
                    <h2 class="pd-section-title">Project Overview</h2>
                    <div class="pd-text">
                        <p>Experience the pinnacle of luxury living at Emerald Luxury Villa. Situated in the prestigious neighborhood of Pali Hill, this architectural marvel offers panoramic views of the city skyline and the Arabian Sea. Designed for the elite, every square foot exudes elegance and sophistication.</p>
                        <p>With state-of-the-art amenities, smart home automation, and private plunge pools, this property redefines modern grandeur. Surrounded by lush greenery, it provides a serene escape from the bustling city life while keeping you connected to top-tier entertainment and business hubs.</p>
                    </div>
                </div>

                <!-- Amenities Section -->
                <div class="pd-section">
                    <h2 class="pd-section-title">Premium Amenities</h2>
                    <div class="pd-amenities-grid">
                        <div class="am-item">
                            <i class="fas fa-swimmer"></i>
                            <span>Infinity Pool</span>
                        </div>
                        <div class="am-item">
                            <i class="fas fa-dumbbell"></i>
                            <span>Fitness Center</span>
                        </div>
                        <div class="am-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>24/7 Security</span>
                        </div>
                        <div class="am-item">
                            <i class="fas fa-car"></i>
                            <span>Covered Parking</span>
                        </div>
                        <div class="am-item">
                            <i class="fas fa-tree"></i>
                            <span>Landscaped Garden</span>
                        </div>
                        <div class="am-item">
                            <i class="fas fa-wifi"></i>
                            <span>Smart Home</span>
                        </div>
                    </div>
                </div>

                <!-- Floor Plan / Gallery (Interactive Grid) -->
                <div class="pd-section">
                    <h2 class="pd-section-title">Gallery</h2>
                    <div class="pd-gallery">
                        <div class="gallery-item large">
                            <img src="assets/images/prop1.png" alt="Gallery Image 1">
                        </div>
                        <div class="gallery-item">
                            <img src="assets/images/prop2.png" alt="Gallery Image 2">
                        </div>
                        <div class="gallery-item">
                            <img src="assets/images/prop3.png" alt="Gallery Image 3">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Sidebar -->
            <div class="pd-sidebar">
                <div class="pd-contact-card sticky">
                    <h3 class="contact-title">Interested in this Project?</h3>
                    <p class="contact-subtitle">Drop your details below and our luxury property consultant will get in touch with you.</p>
                    
                    <form class="pd-form" action="" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <button type="submit" class="pd-submit-btn">
                            Get Free Callback
                        </button>
                    </form>
                    
                    <div class="pd-contact-direct">
                        <span>Or call us directly</span>
                        <a href="tel:+919876543210"><i class="fas fa-phone-alt"></i> +91 93152 33826</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
