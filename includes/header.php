<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>

        <?= !empty($page_title) ? htmlspecialchars($page_title) : "Valugain Associates - Premium Real Estate Services" ?>
    </title>
    <meta name="description"
        content="<?= !empty($meta_description) ? htmlspecialchars($meta_description) : "Valugain Associates offers premium real estate services. Find your dream property with us today." ?>">
    <?php if (!empty($meta_keywords)): ?>
        <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">
    <?php endif; ?>

    <!-- Open Graph (OG) Information -->
    <?php if (!empty($og_title)): ?>
        <meta property="og:title" content="<?= htmlspecialchars($og_title) ?>" />
    <?php endif; ?>
    <?php if (!empty($og_description)): ?>
        <meta property="og:description" content="<?= htmlspecialchars($og_description) ?>" />
    <?php endif; ?>
    <?php if (!empty($og_image)): ?>
        <meta property="og:image" content="<?= htmlspecialchars($og_image) ?>" />
    <?php endif; ?>

    <!-- Schema Markup -->
    <?php if (!empty($schema_markup)): ?>
        <script type="application/ld+json">
                                                                <?= $schema_markup ?>
                                                                </script>
    <?php endif; ?>

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
    <link rel="stylesheet" href="assets/project-details.css">
    <link rel="stylesheet" href="assets/about-page.css">
    <link rel="stylesheet" href="assets/contact-page.css">
    <link rel="stylesheet" href="assets/projects-page.css">
    <link rel="stylesheet" href="assets/legal-pages.css">
    <link rel="stylesheet" href="assets/testimonials.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <a href="tel:+919315233826" class="top-info">
                    <i class="fas fa-phone-alt"></i>
                    <span>+91 93152 33826</span>
                    <span>+91 98112 77779</span>
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
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="projects.php">Projects</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>

                <!-- Header Action -->
                <div class="header-action">
                    <a href="javascript:void(0)" onclick="openEnquiryModal()" class="enquiry-btn">
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
            if (navMenu.classList.contains('active')) {
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
            } else {
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        });

        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        });

        // Enquiry Modal Logic
        function openEnquiryModal(projectId = '', projectTitle = '') {
            const modal = document.getElementById('enquiryModal');
            document.getElementById('enquiryProjectId').value = projectId;
            if (projectTitle) {
                document.getElementById('enquiryModalTitle').innerText = 'Enquire for ' + projectTitle;
            } else {
                document.getElementById('enquiryModalTitle').innerText = 'Enquire Now';
            }
            modal.style.display = 'flex';
        }

        function closeEnquiryModal() {
            document.getElementById('enquiryModal').style.display = 'none';
        }
    </script>

    <div id="enquiryModal" class="enquiry-modal-overlay">
        <div class="enquiry-modal-content">
            <span class="close-modal" onclick="closeEnquiryModal()">&times;</span>
            <h2 id="enquiryModalTitle">Enquire Now</h2>
            <p>Fill out the form below and our experts will get back to you shortly.</p>
            <form id="enquiryForm">
                <input type="hidden" name="project_id" id="enquiryProjectId">
                <div class="modal-form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>
                <div class="modal-form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" placeholder="Enter your mobile number" required>
                </div>
                <div class="modal-form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email">
                </div>
                <div class="modal-form-group">
                    <label>Message</label>
                    <textarea name="message" rows="3" placeholder="I am interested in this project..."></textarea>
                </div>
                <button type="submit" class="modal-submit-btn">Submit Enquiry</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('enquiryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const originalText = btn.innerText;
            btn.innerText = 'Sending...';
            btn.disabled = true;

            const formData = new FormData(this);
            fetch('process-enquiry.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonColor: '#24b64a'
                        });
                        this.reset();
                        closeEnquiryModal();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });
                })
                .finally(() => {
                    btn.innerText = originalText;
                    btn.disabled = false;
                });
        });

        // Close modal on outside click
        window.onclick = function (event) {
            const modal = document.getElementById('enquiryModal');
            if (event.target == modal) {
                closeEnquiryModal();
            }
        }
    </script>

    <style>
        .enquiry-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        .enquiry-modal-content {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalSlide 0.4s ease;
        }

        @keyframes modalSlide {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
            color: #666;
        }

        .enquiry-modal-content h2 {
            margin-bottom: 10px;
            color: #0a192f;
        }

        .enquiry-modal-content p {
            margin-bottom: 25px;
            color: #666;
            font-size: 0.9rem;
        }

        .modal-form-group {
            margin-bottom: 15px;
        }

        .modal-form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .modal-form-group input,
        .modal-form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
        }

        .modal-submit-btn {
            width: 100%;
            padding: 15px;
            background: #24b64a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 1rem;
        }

        .modal-submit-btn:hover {
            background: #1a8e38;
        }
    </style>