<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once '../database/db_config.php';

$id = $_GET['id'] ?? 0;
if (!$id) {
    header("Location: projects.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header("Location: projects.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $price_label = $_POST['price_label'];
    $property_type = $_POST['property_type'];
    $area = $_POST['area'];
    $status = $_POST['status'];
    $possession = $_POST['possession'];
    $badge = $_POST['badge'];
    $description = $_POST['description'];
    $amenities = $_POST['amenities'];
    
    $upload_dir = '../assets/images/';
    $main_image_path = $project['main_image'];
    $gallery_paths = json_decode($project['gallery'], true) ?: [];

    // Ensure upload dir exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        if ($main_image_path && file_exists("../" . $main_image_path)) {
            unlink("../" . $main_image_path);
        }
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $filename = 'proj_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['main_image']['tmp_name'], $upload_dir . $filename);
        $main_image_path = 'assets/images/' . $filename;
    }

    if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
        // Replace existing gallery images
        foreach ($gallery_paths as $img) {
            if (file_exists("../" . $img)) {
                unlink("../" . $img);
            }
        }
        $gallery_paths = [];
        
        foreach ($_FILES['gallery']['name'] as $key => $name) {
            if ($_FILES['gallery']['error'][$key] == 0) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = 'gal_' . time() . '_' . $key . '.' . $ext;
                move_uploaded_file($_FILES['gallery']['tmp_name'][$key], $upload_dir . $filename);
                $gallery_paths[] = 'assets/images/' . $filename;
            }
        }
    }
    
    $gallery_json = json_encode($gallery_paths);

    $stmt = $pdo->prepare("UPDATE projects SET title=?, location=?, price=?, price_label=?, property_type=?, area=?, status=?, possession=?, badge=?, description=?, amenities=?, main_image=?, gallery=? WHERE id=?");
    $stmt->execute([$title, $location, $price, $price_label, $property_type, $area, $status, $possession, $badge, $description, $amenities, $main_image_path, $gallery_json, $id]);
    
    $_SESSION['success'] = "Project updated successfully.";
    header("Location: projects.php");
    exit();
}

$page_title = "Edit Project";
$breadcrumb_Items = [
    ["title" => "Projects", "url" => "projects.php"],
    ["title" => "Edit Project", "url" => "#"]
];
include 'header.php';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Project</h3>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Project Title</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($project['title']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($project['location']) ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($project['price']) ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Price Label</label>
                    <input type="text" name="price_label" class="form-control" value="<?= htmlspecialchars($project['price_label']) ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Badge</label>
                    <input type="text" name="badge" class="form-control" value="<?= htmlspecialchars($project['badge']) ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="<?= htmlspecialchars($project['status']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Property Type</label>
                    <input type="text" name="property_type" class="form-control" value="<?= htmlspecialchars($project['property_type']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Area</label>
                    <input type="text" name="area" class="form-control" value="<?= htmlspecialchars($project['area']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Possession Date</label>
                    <input type="text" name="possession" class="form-control" value="<?= htmlspecialchars($project['possession']) ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Project Overview / Description</label>
                    <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($project['description']) ?></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Amenities (Comma separated)</label>
                    <input type="text" name="amenities" class="form-control" value="<?= htmlspecialchars($project['amenities']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Main Hero Image (Leave empty to keep current)</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*">
                    <?php if($project['main_image']): ?>
                        <div class="mt-2">
                            <img src="../<?= $project['main_image'] ?>" style="height:100px; border-radius:5px; object-fit:cover;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gallery Images (Select multiple - This will REPLACE current gallery)</label>
                    <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                    <?php 
                    $gal = json_decode($project['gallery'], true);
                    if($gal && is_array($gal)): ?>
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            <?php foreach($gal as $img): ?>
                                <img src="../<?= $img ?>" style="height:80px; width:80px; border-radius:5px; object-fit:cover;">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Project</button>
            <a href="projects.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
