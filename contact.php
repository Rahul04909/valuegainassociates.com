<?php
$page_title = "Contact Us - Value Gain Associates";
$meta_description = "Get in touch with Value Gain Associates for premium real estate services. We are here to help you find your dream home.";
include 'includes/header.php';
?>

<!-- Contact Hero -->
<section class="contact-page-hero">
    <div class="container">
        <h1>Contact Us</h1>
    </div>
</section>

<section class="contact-page-content" style="padding: 80px 0;">
    <div class="container">
        <div class="contact-wrapper">
            <!-- Contact Info -->
            <div class="contact-info-section">
                <h2>Contact Information</h2>
                <p style="margin-bottom: 40px; color: #ccc;">Have questions or need assistance? Our team of real estate
                    experts is ready to help you navigate the market.</p>

                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="info-text">
                        <h4>Our Office</h4>
                        <p>Shop No. R-144, First Floor, Tower Royal Street, Omaxe World Street, Sector -79, Faridabad
                            -121004</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone-alt"></i>
                    <div class="info-text">
                        <h4>Call Us</h4>
                        <a href="tel:+919315233826">+91 93152 33826</a>
                        <br>
                        <a href="tel:+919811277779">+91 98112 77779</a>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div class="info-text">
                        <h4>Email Us</h4>
                        <a href="mailto:info@valugainassociates.com">info@valugainassociates.com</a>
                    </div>
                </div>

                <div class="social-links" style="margin-top: 40px; display: flex; gap: 15px;">
                    <a href="#" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-section">
                <h2>Send Us A Message</h2>
                <form action="process-contact.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="john@example.com"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+91 00000 00000" required>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Interested in a project"
                                required>
                        </div>
                        <div class="form-group full-width">
                            <label>Your Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="How can we help you?"
                                required></textarea>
                        </div>
                        <div class="form-group full-width">
                            <button type="submit" class="submit-btn">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Google Map -->
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.793290466479!2d72.86311657597144!3d19.072818552109677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c892b0e9d6d1%3A0x6b801a2f646039c!2sBandra%20Kurla%20Complex%2C%20Mumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1714300000000!5m2!1sen!2sin"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>