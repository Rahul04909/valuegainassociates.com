<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once '../database/db_config.php';

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
    $main_image_path = '';
    $gallery_paths = [];

    // Ensure upload dir exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $filename = 'proj_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['main_image']['tmp_name'], $upload_dir . $filename);
        $main_image_path = 'assets/images/' . $filename;
    }

    if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
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

    $stmt = $conn->prepare("INSERT INTO projects (title, location, price, price_label, property_type, area, status, possession, badge, description, amenities, main_image, gallery) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $title, $location, $price, $price_label, $property_type, $area, $status, $possession, $badge, $description, $amenities, $main_image_path, $gallery_json);
    $stmt->execute();
    
    $_SESSION['success'] = "Project added successfully.";
    header("Location: projects.php");
    exit();
}

include 'header.php';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Project</h3>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Project Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Price</label>
                    <input type="text" name="price" class="form-control" placeholder="e.g. 4.5 Cr" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Price Label</label>
                    <input type="text" name="price_label" class="form-control" placeholder="e.g. Starting Price">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Badge</label>
                    <input type="text" name="badge" class="form-control" placeholder="e.g. Under Construction">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" placeholder="e.g. Under Construction" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Property Type</label>
                    <input type="text" name="property_type" class="form-control" placeholder="e.g. 4 BHK Villa" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Area</label>
                    <input type="text" name="area" class="form-control" placeholder="e.g. 3,200 Sq.Ft." required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Possession Date</label>
                    <input type="text" name="possession" class="form-control" placeholder="e.g. Dec 2026" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Project Overview / Description</label>
                    <textarea name="description" class="form-control" rows="5"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Amenities (Comma separated)</label>
                    <input type="text" name="amenities" class="form-control" placeholder="Infinity Pool, Fitness Center, 24/7 Security...">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Main Hero Image</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gallery Images (Select multiple)</label>
                    <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Project</button>
            <a href="projects.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
