<?php 
require_once __DIR__ . '/../database/db_config.php';

// Fetch projects from the database
$sql = "SELECT id, title, location, price, property_type, area, badge, status, featured_image, main_image FROM projects ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($sql);
$projects = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}
?>
<!-- Properties Component -->
<section class="properties-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">Explore our handpicked selection of premium projects across India.</p>
        </div>

        <div class="properties-grid">
            <?php if(count($projects) > 0): ?>
                <?php foreach($projects as $project): 
                    // Use featured image if available, else fallback to main image or placeholder
                    $image = !empty($project['featured_image']) ? $project['featured_image'] : (!empty($project['main_image']) ? $project['main_image'] : 'assets/images/prop1.png');
                    $badge = !empty($project['badge']) ? $project['badge'] : $project['status'];
                ?>
                <a href="project-details.php?id=<?= $project['id'] ?>" style="text-decoration: none; color: inherit;">
                    <div class="property-card">
                        <div class="property-image">
                            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
                            <?php if(!empty($badge)): ?>
                                <div class="property-badge"><?= htmlspecialchars($badge) ?></div>
                            <?php endif; ?>
                            <div class="property-price"><?= htmlspecialchars($project['price']) ?></div>
                        </div>
                        <div class="property-info">
                            <h3 class="prop-title"><?= htmlspecialchars($project['title']) ?></h3>
                            <p class="prop-location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($project['location']) ?></p>
                            <div class="prop-features">
                                <span><i class="fas fa-bed"></i> <?= htmlspecialchars($project['property_type']) ?></span>
                                <span><i class="fas fa-expand-arrows-alt"></i> <?= htmlspecialchars($project['area']) ?></span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </div>

        <div class="view-all-wrapper">
            <a href="projects.php" class="view-all-btn">View All Projects</a>
        </div>
    </div>
</section>