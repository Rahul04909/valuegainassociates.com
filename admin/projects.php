<?php
require_once 'includes/auth.php';
check_login();

require_once '../database/db_config.php';

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Get image paths to delete
    $stmt = $conn->prepare("SELECT main_image, gallery FROM projects WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
    
    if ($project) {
        if ($project['main_image'] && file_exists("../" . $project['main_image'])) {
            unlink("../" . $project['main_image']);
        }
        if ($project['gallery']) {
            $gallery = json_decode($project['gallery'], true);
            if (is_array($gallery)) {
                foreach ($gallery as $img) {
                    if (file_exists("../" . $img)) {
                        unlink("../" . $img);
                    }
                }
            }
        }
        
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        
        $_SESSION['success'] = "Project deleted successfully.";
        header('Location: projects.php');
        exit();
    }
}

// Fetch all projects
$sql = "SELECT * FROM projects ORDER BY created_at DESC";
$result = $conn->query($sql);
$projects = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

include 'header.php';
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">All Projects</h3>
        <a href="project-add.php" class="btn btn-primary btn-sm ms-auto"><i class="fas fa-plus"></i> Add New Project</a>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($projects) > 0): ?>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?= $project['id'] ?></td>
                                <td>
                                    <?php if ($project['main_image']): ?>
                                        <img src="../<?= $project['main_image'] ?>" alt="<?= htmlspecialchars($project['title']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($project['title']) ?></td>
                                <td><?= htmlspecialchars($project['location']) ?></td>
                                <td><?= htmlspecialchars($project['price']) ?></td>
                                <td><span class="badge bg-info"><?= htmlspecialchars($project['status']) ?></span></td>
                                <td>
                                    <a href="project-edit.php?id=<?= $project['id'] ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="projects.php?delete_id=<?= $project['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project? This cannot be undone.')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No projects found. Add one!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
