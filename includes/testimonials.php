<?php
$testimonials = [
    [
        "name" => "Aravind Sharma",
        "role" => "Premium Home Buyer",
        "quote" => "Value Gain Associates made the entire process of finding our dream home in Gurgaon absolutely seamless. Their transparency is unmatched.",
        "image" => "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600"
    ],
    [
        "name" => "Priya Deshmukh",
        "role" => "Investment Client",
        "quote" => "Investing in commercial real estate was a big step for me. Their expert guidance helped me secure a high-ROI property in record time.",
        "image" => "https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=600"
    ],
    [
        "name" => "Rohan Malhotra",
        "role" => "Luxury Villa Owner",
        "quote" => "If you are looking for premium properties with professional service, look no further. Their team treats you like family.",
        "image" => "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600"
    ],
    [
        "name" => "Aditya Singhania",
        "role" => "Commercial Investor",
        "quote" => "The team at Value Gain Associates is incredibly knowledgeable. They helped me find a premium office space in Sector 79 with excellent rental yields.",
        "image" => "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600"
    ],
    [
        "name" => "Meera Nair",
        "role" => "NRI Client (Dubai)",
        "quote" => "Being an NRI, trust was my biggest concern. Value Gain Associates proved to be the perfect partners, handling all legalities and documentation smoothly.",
        "image" => "https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600"
    ],
    [
        "name" => "Vikram Rathore",
        "role" => "Second Home Buyer",
        "quote" => "I purchased a luxury plot through them. Their advisory on high-growth corridors was spot-on, and the property has already appreciated significantly.",
        "image" => "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=600"
    ],
    [
        "name" => "Anjali Gupta",
        "role" => "First-Time Homeowner",
        "quote" => "As a first-time buyer, I had endless questions. The team guided me through every RERA detail and made the possession process stress-free.",
        "image" => "https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=600"
    ],
    [
        "name" => "Rajesh Khanna",
        "role" => "Corporate Investor",
        "quote" => "Value Gain Associates is the gold standard of real estate consultancy. Their market intelligence and corporate-level advisory are highly commendable.",
        "image" => "https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600"
    ],
    [
        "name" => "David Onley",
        "role" => "Premium Retail Client",
        "quote" => "Well executed property advisory by your professional team. The guidance was clear and elegant according to our requirement. Thank you so much!",
        "image" => "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=600"
    ]
];
?>

<section class="testimonials-section">
    <div class="container">
        <div class="testimonials-header">
            <h6 class="testimonials-subtitle">Testimonials</h6>
            <h2>What Our Clients Say</h2>
            <p>Join hundreds of happy families who found their perfect value-adding homes with us.</p>
        </div>
        
        <div class="testimonials-grid">
            <?php foreach($testimonials as $t): ?>
            <div class="testimonial-card">
                <!-- Avatar circle -->
                <div class="testimonial-avatar">
                    <img src="<?= $t['image'] ?>" alt="<?= $t['name'] ?>">
                </div>

                <!-- Name pill badge -->
                <div class="testimonial-name-badge">
                    <?= htmlspecialchars($t['name']) ?>
                </div>

                <!-- Designation -->
                <div class="testimonial-designation">
                    Designation: <?= htmlspecialchars($t['role']) ?>
                </div>

                <!-- Dots Separator -->
                <div class="testimonial-separator">
                    <div class="separator-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <!-- Testimonial Quote Box -->
                <div class="testimonial-quote-box">
                    <p><?= htmlspecialchars($t['quote']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
