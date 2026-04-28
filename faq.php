<?php 
$page_title = "Frequently Asked Questions - Value Gain Associates";
include 'includes/header.php'; 
?>

<section class="legal-hero">
    <div class="container">
        <h1>FAQ's</h1>
        <p>Common questions about our services.</p>
    </div>
</section>

<div class="legal-content-wrapper">
    <div class="legal-card">
        <div class="faq-item">
            <div class="faq-question">What is Value Gain Associates? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">
                <p>Value Gain Associates is a premium real estate consultancy firm specializing in luxury residential and commercial properties across India with over 15 years of experience.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Do you charge brokerage on new projects? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">
                <p>No, we offer zero brokerage on all new residential projects. We work directly with developers to bring you the best deals.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">How can I book a site visit? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">
                <p>You can book a site visit by clicking the "Enquiry Now" button on any project page or by calling us at +91 93152 33826.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Do you provide home loan assistance? <i class="fas fa-chevron-down"></i></div>
            <div class="faq-answer">
                <p>Yes, we have tie-ups with leading banks to help our clients secure home loans at the most competitive interest rates.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const item = question.parentElement;
        item.classList.toggle('active');
    });
});
</script>

<?php include 'includes/footer.php'; ?>
