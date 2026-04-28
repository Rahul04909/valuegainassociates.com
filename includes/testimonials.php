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
    ]
];
?>

<section class="testimonials-section">
    <div class="container">
        <div class="testimonials-header">
            <h2>What Our Clients Say</h2>
            <p>Join hundreds of happy families who found their perfect value-adding homes with us.</p>
        </div>
        
        <div class="testimonials-grid">
            <?php foreach($testimonials as $t): ?>
            <div class="testimonial-card">
                <div class="testimonial-img-wrapper">
                    <img src="<?= $t['image'] ?>" alt="<?= $t['name'] ?>">
                    <div class="testimonial-img-overlay"></div>
                </div>
                <div class="testimonial-body">
                    <p class="testimonial-quote">“<?= $t['quote'] ?>”</p>
                    <div class="testimonial-author">
                        <p class="testimonial-name"><?= $t['name'] ?></p>
                        <p class="testimonial-role"><?= $t['role'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
