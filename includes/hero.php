<!-- Hero Section -->
<section class="hero-section">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <picture>
                    <!-- Mobile Image -->
                    <source media="(max-width: 768px)" srcset="assets/images/hero-banner-2.jpeg">
                    <!-- Desktop Image -->
                    <img src="assets/images/hero-banner-2.jpeg" alt="Premium Real Estate Banner 1" class="hero-img">
                </picture>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <picture>
                    <source media="(max-width: 768px)" srcset="assets/images/hero-banner.jpeg">
                    <img src="assets/images/hero-banner.jpeg" alt="Premium Real Estate Banner 2" class="hero-img">
                </picture>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <picture>
                    <source media="(max-width: 768px)" srcset="assets/images/hero-banner-1.jpeg">
                    <img src="assets/images/hero-banner-1.jpeg" alt="Premium Real Estate Banner 3" class="hero-img">
                </picture>
            </div>
        </div>
        <!-- Add Navigation (Hidden on Mobile) -->
        <div class="swiper-button-next d-none d-md-flex"></div>
        <div class="swiper-button-prev d-none d-md-flex"></div>
        <!-- Add Pagination (Ecommerce Style Dots) -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    const swiper = new Swiper('.hero-swiper', {
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        speed: 800,
        grabCursor: true,
    });
</script>