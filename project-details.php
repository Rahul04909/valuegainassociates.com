<?php 
require_once 'database/db_config.php';

$id = $_GET['id'] ?? 0;
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    header("Location: index.php");
    exit();
}

$page_title = $project['meta_title'] ?: $project['title'];
$meta_description = $project['meta_description'] ?: "";
$meta_keywords = $project['meta_keywords'] ?: "";
$og_title = $project['og_title'] ?: $project['title'];
$og_description = $project['og_description'] ?: "";
// For OG Image, if og_image is set and not empty, use it, else use featured_image, else main_image
$og_image = !empty($project['og_image']) ? $project['og_image'] : (!empty($project['featured_image']) ? $project['featured_image'] : $project['main_image']);
if ($og_image && !preg_match('/^http/', $og_image)) {
    // Make it an absolute URL roughly, or just pass it to header if it works relative. Best to keep relative for now.
    $og_image = "https://valuegainassociates.com/" . ltrim($og_image, '/');
}
$schema_markup = $project['schema_markup'] ?: "";

include 'includes/header.php'; 

// Prepare variables for display
$main_image = !empty($project['main_image']) ? $project['main_image'] : 'assets/images/prop1.png';
$title = htmlspecialchars($project['title']);
$location = htmlspecialchars($project['location']);
$property_type = htmlspecialchars($project['property_type']);
$area = htmlspecialchars($project['area']);
$status = htmlspecialchars($project['status']);
$possession = htmlspecialchars($project['possession']);
$badge = htmlspecialchars($project['badge']);
$price = htmlspecialchars($project['price']);
$price_label = htmlspecialchars($project['price_label']);
$description = $project['description']; // Allow HTML for summernote

$amenities = json_decode($project['amenities'], true);
$gallery = json_decode($project['gallery'], true);
?>

<!-- Project Details Hero -->
<div class="pd-hero" style="height: 40vh; min-height: 300px; margin-bottom: 30px;">
    <div class="pd-hero-bg">
        <img src="<?= htmlspecialchars($main_image) ?>" alt="<?= $title ?>">
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
                        <strong><?= $property_type ?></strong>
                    </div>
                    <div class="qi-item">
                        <i class="fas fa-vector-square"></i>
                        <span>Area</span>
                        <strong><?= $area ?></strong>
                    </div>
                    <div class="qi-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Status</span>
                        <strong><?= $status ?></strong>
                    </div>
                    <div class="qi-item">
                        <i class="fas fa-key"></i>
                        <span>Possession</span>
                        <strong><?= $possession ?></strong>
                    </div>
                </div>

                <!-- Project Header Info -->
                <div class="pd-header-info">
                    <div class="pd-header-left">
                        <?php if($badge): ?>
                        <div class="pd-badge-dark"><?= $badge ?></div>
                        <?php endif; ?>
                        <h1 class="pd-title-dark"><?= $title ?></h1>
                        <p class="pd-location-dark"><i class="fas fa-map-marker-alt"></i> <?= $location ?></p>
                    </div>
                    <div class="pd-header-right">
                        <div class="pd-price-wrap-dark">
                            <span class="pd-price-dark"><?= $price ?></span>
                            <?php if($price_label): ?>
                            <span class="pd-price-label-dark"><?= $price_label ?></span>
                            <?php endif; ?>
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
                        <?= $description ?>
                    </div>
                </div>

                <!-- Amenities Section -->
                <?php if($amenities && is_array($amenities) && count($amenities) > 0): ?>
                <div class="pd-section">
                    <h2 class="pd-section-title">Premium Amenities</h2>
                    <div class="pd-amenities-grid">
                        <?php foreach($amenities as $am): ?>
                        <div class="am-item">
                            <?php if(!empty($am['icon'])): ?>
                                <img src="<?= htmlspecialchars($am['icon']) ?>" alt="<?= htmlspecialchars($am['title']) ?>" style="width: 32px; height: 32px; object-fit: contain; margin-bottom: 10px;">
                            <?php else: ?>
                                <i class="fas fa-check-circle"></i>
                            <?php endif; ?>
                            <span><?= htmlspecialchars($am['title']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Floor Plan / Gallery (Interactive Grid) -->
                <?php if($gallery && is_array($gallery) && count($gallery) > 0): ?>
                <div class="pd-section">
                    <h2 class="pd-section-title">Gallery</h2>
                    <div class="pd-gallery">
                        <?php foreach($gallery as $index => $img): ?>
                        <div class="gallery-item <?= $index == 0 ? 'large' : '' ?>">
                            <img src="<?= htmlspecialchars($img) ?>" alt="Gallery Image <?= $index + 1 ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

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
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Write your message..." rows="3" required></textarea>
                        </div>
                        <button type="submit" class="pd-submit-btn">
                            Get Free Callback
                        </button>
                    </form>
                    
                    <div class="pd-contact-direct">
                        <span>Or call us directly</span>
                        <a href="tel:+919876543210">
                            <div class="animated-call-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div> 
                            +91 93152 33826
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
