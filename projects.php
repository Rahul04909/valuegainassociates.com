<?php
require_once 'database/db_config.php';
$page_title = "Our Projects - Value Gain Associates";
include 'includes/header.php';

// Pagination setup
$limit = 6; // Projects per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filters
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$sort_filter = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

$where_clauses = [];
if ($type_filter) $where_clauses[] = "property_type = '" . $conn->real_escape_string($type_filter) . "'";
if ($status_filter) $where_clauses[] = "status = '" . $conn->real_escape_string($status_filter) . "'";

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";

$order_sql = "ORDER BY created_at DESC";
if ($sort_filter === 'price_low') $order_sql = "ORDER BY CAST(price AS DECIMAL) ASC";
if ($sort_filter === 'price_high') $order_sql = "ORDER BY CAST(price AS DECIMAL) DESC";

// Count total for pagination
$total_sql = "SELECT COUNT(*) FROM projects $where_sql";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

// Fetch projects
$sql = "SELECT * FROM projects $where_sql $order_sql LIMIT $offset, $limit";
$result = $conn->query($sql);
?>

<!-- Projects Hero -->
<section class="projects-page-hero">
    <div class="container">
        <h1>Our Properties</h1>
    </div>
</section>

<section class="projects-content">
    <div class="container">
        <div class="projects-layout">
            <!-- Sidebar Filters -->
            <aside class="filter-sidebar">
                <form action="" method="GET">
                    <h3>Filter Properties</h3>
                    
                    <div class="filter-group">
                        <label>Property Type</label>
                        <select name="type" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            <option value="Apartment" <?= $type_filter == 'Apartment' ? 'selected' : '' ?>>Apartment</option>
                            <option value="Villa" <?= $type_filter == 'Villa' ? 'selected' : '' ?>>Villa</option>
                            <option value="Penthouse" <?= $type_filter == 'Penthouse' ? 'selected' : '' ?>>Penthouse</option>
                            <option value="Commercial" <?= $type_filter == 'Commercial' ? 'selected' : '' ?>>Commercial</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Status</label>
                        <select name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="Live" <?= $status_filter == 'Live' ? 'selected' : '' ?>>Live</option>
                            <option value="Ready to Move" <?= $status_filter == 'Ready to Move' ? 'selected' : '' ?>>Ready to Move</option>
                            <option value="Under Construction" <?= $status_filter == 'Under Construction' ? 'selected' : '' ?>>Under Construction</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>Sort By</label>
                        <select name="sort" onchange="this.form.submit()">
                            <option value="newest" <?= $sort_filter == 'newest' ? 'selected' : '' ?>>Newest First</option>
                            <option value="price_low" <?= $sort_filter == 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                            <option value="price_high" <?= $sort_filter == 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                        </select>
                    </div>

                    <button type="button" onclick="window.location.href='projects.php'" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</button>
                </form>
            </aside>

            <!-- Main Listing Area -->
            <main class="listing-area">
                <div class="view-controls">
                    <p>Showing <?= $total_rows ?> properties</p>
                    <div class="view-modes">
                        <button id="gridViewBtn" class="active" title="Grid View"><i class="fas fa-th-large"></i></button>
                        <button id="listViewBtn" title="List View"><i class="fas fa-list"></i></button>
                    </div>
                </div>

                <div id="projectsContainer" class="projects-grid">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($project = $result->fetch_assoc()): ?>
                            <div class="project-card">
                                <div class="project-thumb">
                                    <img src="<?= htmlspecialchars($project['main_image']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
                                    <?php if(!empty($project['badge'])): ?>
                                        <div class="project-badge"><?= htmlspecialchars($project['badge']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="project-body">
                                    <div>
                                        <div class="project-loc"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($project['location']) ?></div>
                                        <h4><?= htmlspecialchars($project['title']) ?></h4>
                                        <div class="project-price"><?= htmlspecialchars($project['price']) ?> <?= htmlspecialchars($project['price_label']) ?></div>
                                    </div>
                                    <div class="project-footer">
                                        <span class="status-label" style="font-size: 0.85rem; color: #666;"><i class="fas fa-building"></i> <?= htmlspecialchars($project['property_type']) ?></span>
                                        <a href="project-details.php?id=<?= $project['id'] ?>" class="btn btn-primary btn-sm">Details <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h3>No properties found</h3>
                            <p>Try adjusting your filters or search criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page-1 ?>&type=<?= $type_filter ?>&status=<?= $status_filter ?>&sort=<?= $sort_filter ?>"><i class="fas fa-chevron-left"></i></a>
                    <?php endif; ?>

                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i ?>&type=<?= $type_filter ?>&status=<?= $status_filter ?>&sort=<?= $sort_filter ?>" class="<?= $page == $i ? 'current' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page+1 ?>&type=<?= $type_filter ?>&status=<?= $status_filter ?>&sort=<?= $sort_filter ?>"><i class="fas fa-chevron-right"></i></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</section>

<script>
    // Grid/List View Switching
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    const container = document.getElementById('projectsContainer');

    gridBtn.addEventListener('click', () => {
        container.className = 'projects-grid';
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    });

    listBtn.addEventListener('click', () => {
        container.className = 'projects-list';
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    });
</script>

<?php include 'includes/footer.php'; ?>
