<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valugain Associates - Premium Real Estate Services</title>
    <meta name="description"
        content="Valugain Associates offers premium real estate services. Find your dream property with us today.">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Google Fonts -->
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/hero.css">
    <link rel="stylesheet" href="assets/services.css">
    <link rel="stylesheet" href="assets/properties.css">
    <link rel="stylesheet" href="assets/about.css">
    <link rel="stylesheet" href="assets/why-choose-us.css">
    <link rel="stylesheet" href="assets/footer.css">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header Top Bar -->
    <div class="header-top">
        <div class="container">
            <div class="top-left">
                <a href="mailto:info@valugainassociates.com" class="top-info">
                    <i class="fas fa-envelope"></i>
                    <span>info@valugainassociates.com</span>
                </a>
                <a href="tel:+919876543210" class="top-info">
                    <i class="fas fa-phone-alt"></i>
                    <span>+91 93152 33826</span>
                </a>
            </div>
            <div class="top-right">
                <div class="top-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Faridabad, Haryana, India</span>
                </div>
                <div class="top-socials" style="display: flex; gap: 15px; margin-left: 10px;">
                    <a href="#" class="top-info"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="top-info"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="top-info"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="main-header">
        <div class="container">
            <div class="nav-wrapper">
                <!-- Logo Area -->
                <div class="logo-area">
                    <a href="index.php">
                        <img src="assets/logo.png" alt="Valugain Associates Logo">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="nav-menu">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="properties.php">Properties</a></li>
                    </ul>
                </nav>

                <!-- Header Action -->
                <div class="header-action">
                    <a href="enquiry.php" class="enquiry-btn">
                        <span>Enquiry Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <!-- Mobile Menu Toggle (Visible on small screens) -->
                <div class="mobile-toggle" id="mobileToggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.querySelector('.nav-menu');
        const toggleIcon = mobileToggle.querySelector('i');

        mobileToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            // Switch between bars and X icon
            if (navMenu.classList.contains('active')) {
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
            } else {
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        });
    </script>