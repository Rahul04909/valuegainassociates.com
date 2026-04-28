<!-- Main Footer -->
<footer class="main-footer">
    <div class="footer-top-newsletter">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="newsletter-text">
                    <h3>Subscribe to our Newsletter</h3>
                    <p>Stay updated with the latest property trends and exclusive deals.</p>
                </div>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your Email Address" required>
                    <button type="submit">Subscribe Now</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer-grid">
            <!-- Column 1: About -->
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="assets/logo.png" alt="Valugain Logo">
                </div>
                <p class="footer-desc">
                    Valugain Associates is a leading real estate agency committed to delivering excellence through
                    transparency and innovation. We help you find properties that truly add value to your life.
                </p>
                <div class="footer-socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Column 2: Support -->
            <div class="footer-col">
                <h3>Support</h3>
                <ul class="footer-links">
                    <li><a href="help-center.php">Help Center</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="faq.php">FAQ's</a></li>
                    <li><a href="legal.php">Legal Info</a></li>
                </ul>
            </div>

            <!-- Column 3: Quick Links -->
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="properties.php">Properties</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <!-- <li><a href="#">Our Agents</a></li> -->
                </ul>
            </div>

            <!-- Column 4: Contact Us -->
            <div class="footer-col">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li>
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-text">
                            <strong>Location:</strong>
                            <span>Shop No. R-144, First Floor, Tower
                                Royal Street, Omaxe World Street,
                                Sector -79, Faridabad -121004

                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                        <div class="info-text">
                            <strong>Phone:</strong>
                            <span>+91 93152 33826</span>
                        </div>
                    </li>
                    <li>
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-text">
                            <strong>Email:</strong>
                            <span>info@valugainassociates.com</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="bottom-wrapper">
                <p>&copy; 2026 Valugain Associates - All Rights Reserved</p>
                <div class="bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms & Conditions</a>
                    <a href="#">Sitemap</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>
</footer>

<script>
    // Back to top functionality
    const backToTop = document.getElementById('backToTop');
    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    };

    backToTop.onclick = function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
</script>

</body>

</html>