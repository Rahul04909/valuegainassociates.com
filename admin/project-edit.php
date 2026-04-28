<?php
require_once 'includes/auth.php';
check_login();

require_once '../database/db_config.php';

$id = $_GET['id'] ?? 0;
if (!$id) {
    header("Location: projects.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

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

    // SEO Fields
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $schema_markup = $_POST['schema_markup'];
    $og_title = $_POST['og_title'];
    $og_description = $_POST['og_description'];
    
    // Brochure Fields
    $enable_brochure = isset($_POST['enable_brochure']) ? 1 : 0;
    
    $upload_dir = '../assets/images/';
    $pdf_dir = '../assets/pdfs/';
    $main_image_path = $project['main_image'];
    $featured_image_path = $project['featured_image'] ?? '';
    $og_image_path = $project['og_image'] ?? '';
    $brochure_file_path = $project['brochure_file'] ?? '';
    $gallery_paths = json_decode($project['gallery'], true) ?: [];

    // Ensure upload dir exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    if (!is_dir($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    if (isset($_FILES['brochure_file']) && $_FILES['brochure_file']['error'] == 0) {
        $ext = pathinfo($_FILES['brochure_file']['name'], PATHINFO_EXTENSION);
        if (strtolower($ext) === 'pdf') {
            if ($brochure_file_path && file_exists("../" . $brochure_file_path)) {
                unlink("../" . $brochure_file_path);
            }
            $filename = 'brochure_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['brochure_file']['tmp_name'], $pdf_dir . $filename);
            $brochure_file_path = 'assets/pdfs/' . $filename;
        }
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
    
    if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] == 0) {
        if ($featured_image_path && file_exists("../" . $featured_image_path)) {
            unlink("../" . $featured_image_path);
        }
        $ext = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
        $filename = 'feat_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_dir . $filename);
        $featured_image_path = 'assets/images/' . $filename;
    }
    
    if (isset($_FILES['og_image']) && $_FILES['og_image']['error'] == 0) {
        if ($og_image_path && file_exists("../" . $og_image_path)) {
            unlink("../" . $og_image_path);
        }
        $ext = pathinfo($_FILES['og_image']['name'], PATHINFO_EXTENSION);
        $filename = 'og_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['og_image']['tmp_name'], $upload_dir . $filename);
        $og_image_path = 'assets/images/' . $filename;
    }

    // Dynamic Amenities Processing
    // We get old amenities first
    $amenities_arr = json_decode($project['amenities'], true) ?: [];
    $new_amenities_arr = [];

    // Process old amenities (they might have been removed or kept)
    // Actually, it's easier to just rebuild the array based on what's submitted.
    // If the user submits existing hidden icons, we keep them.
    if (isset($_POST['amenity_titles']) && is_array($_POST['amenity_titles'])) {
        foreach ($_POST['amenity_titles'] as $index => $am_title) {
            $am_icon_path = $_POST['existing_amenity_icons'][$index] ?? '';
            
            // Did they upload a new icon?
            if (isset($_FILES['amenity_icons']['name'][$index]) && $_FILES['amenity_icons']['error'][$index] == 0) {
                // Delete old icon if it exists
                if ($am_icon_path && file_exists("../" . $am_icon_path)) {
                    unlink("../" . $am_icon_path);
                }
                $ext = pathinfo($_FILES['amenity_icons']['name'][$index], PATHINFO_EXTENSION);
                $filename = 'icon_' . time() . '_' . $index . '.' . $ext;
                move_uploaded_file($_FILES['amenity_icons']['tmp_name'][$index], $upload_dir . $filename);
                $am_icon_path = 'assets/images/' . $filename;
            }
            
            if (!empty($am_title) || !empty($am_icon_path)) {
                $new_amenities_arr[] = [
                    'title' => $am_title,
                    'icon' => $am_icon_path
                ];
            }
        }
    }
    
    // Check if any old amenities were deleted from the UI, we should unlink their images
    // To do this properly, we find the difference, but it's okay to leave old images or do a quick diff.
    foreach($amenities_arr as $old_am) {
        $found = false;
        foreach($new_amenities_arr as $new_am) {
            if($old_am['icon'] == $new_am['icon']) {
                $found = true; break;
            }
        }
        if(!$found && $old_am['icon'] && file_exists("../" . $old_am['icon'])) {
            unlink("../" . $old_am['icon']);
        }
    }
    
    $amenities_json = json_encode($new_amenities_arr);

    if (isset($_FILES['gallery']) && !empty($_FILES['gallery']['name'][0])) {
        // Since we are replacing the gallery entirely when they upload new ones on the edit page 
        // OR we can accumulate them. But typically Edit replaces or appends.
        // Let's replace for simplicity, as per previous logic, but since they want to accumulate:
        // Actually, let's keep old gallery images and APPEND new ones.
        $new_gallery_paths = [];
        
        foreach ($_FILES['gallery']['name'] as $key => $name) {
            if ($_FILES['gallery']['error'][$key] == 0) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = 'gal_' . time() . '_' . $key . '.' . $ext;
                move_uploaded_file($_FILES['gallery']['tmp_name'][$key], $upload_dir . $filename);
                $new_gallery_paths[] = 'assets/images/' . $filename;
            }
        }
        // Append to existing
        $gallery_paths = array_merge($gallery_paths, $new_gallery_paths);
    }
    
    // Also handle if they want to clear gallery? Not requested, so we'll just append.
    $gallery_json = json_encode($gallery_paths);

    $stmt = $conn->prepare("UPDATE projects SET title=?, location=?, price=?, price_label=?, property_type=?, area=?, status=?, possession=?, badge=?, description=?, amenities=?, main_image=?, gallery=?, featured_image=?, meta_title=?, meta_description=?, meta_keywords=?, schema_markup=?, og_title=?, og_description=?, og_image=?, enable_brochure=?, brochure_file=? WHERE id=?");
    $stmt->bind_param("sssssssssssssssssssssisi", $title, $location, $price, $price_label, $property_type, $area, $status, $possession, $badge, $description, $amenities_json, $main_image_path, $gallery_json, $featured_image_path, $meta_title, $meta_description, $meta_keywords, $schema_markup, $og_title, $og_description, $og_image_path, $enable_brochure, $brochure_file_path, $id);
    $stmt->execute();
    
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
        <link rel="stylesheet" href="../vendor/summernote/summernote/dist/summernote-bs4.css">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <h4 class="mb-3 text-primary border-bottom pb-2">1. Basic Information</h4>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Featured Image (Before Project Title) - Leave empty to keep current</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                    <?php if(!empty($project['featured_image'])): ?>
                        <div class="mt-2">
                            <img src="../<?= $project['featured_image'] ?>" style="height:100px; border-radius:5px; object-fit:cover;">
                        </div>
                    <?php endif; ?>
                </div>
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
                    <textarea name="description" id="summernote" class="form-control" rows="5"><?= htmlspecialchars($project['description']) ?></textarea>
                </div>
            </div>

            <h4 class="mb-3 mt-4 text-primary border-bottom pb-2">2. Amenities</h4>
            <div id="amenities-container">
                <?php 
                $existing_amenities = json_decode($project['amenities'], true);
                if($existing_amenities && is_array($existing_amenities) && count($existing_amenities) > 0):
                    foreach($existing_amenities as $am):
                ?>
                <div class="row mb-2 amenity-row">
                    <div class="col-md-5">
                        <label>Amenity Title</label>
                        <input type="text" name="amenity_titles[]" class="form-control" value="<?= htmlspecialchars($am['title']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Amenity Icon (Replace?)</label>
                        <input type="file" name="amenity_icons[]" class="form-control" accept="image/*">
                        <input type="hidden" name="existing_amenity_icons[]" value="<?= htmlspecialchars($am['icon']) ?>">
                    </div>
                    <div class="col-md-1">
                        <?php if($am['icon']): ?>
                            <img src="../<?= $am['icon'] ?>" style="height:40px; margin-top:25px; border-radius:5px;">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-amenity">Remove</button>
                    </div>
                </div>
                <?php 
                    endforeach;
                else: 
                ?>
                <div class="row mb-2 amenity-row">
                    <div class="col-md-5">
                        <label>Amenity Title</label>
                        <input type="text" name="amenity_titles[]" class="form-control" placeholder="e.g. Swimming Pool">
                    </div>
                    <div class="col-md-5">
                        <label>Amenity Icon (Image)</label>
                        <input type="file" name="amenity_icons[]" class="form-control" accept="image/*">
                        <input type="hidden" name="existing_amenity_icons[]" value="">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-amenity">Remove</button>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-success btn-sm mb-4" id="add-amenity">+ Add Another Amenity</button>

            <h4 class="mb-3 mt-4 text-primary border-bottom pb-2">3. Media</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Main Hero Image (Leave empty to keep current)</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*">
                    <div id="main-preview">
                        <?php if($project['main_image']): ?>
                            <div class="mt-2">
                                <img src="../<?= $project['main_image'] ?>" style="height:150px; border-radius:5px; object-fit:cover;">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Gallery Images (New images will be appended to existing)</label>
                    <div id="gallery-inputs-container">
                        <input type="file" name="gallery[]" class="form-control gallery-input mb-2" accept="image/*" multiple>
                    </div>
                    <button type="button" class="btn btn-info btn-sm" id="add-gallery-input">+ Add More Images to Gallery</button>
                    <div id="gallery-preview" class="d-flex flex-wrap mt-2">
                        <?php 
                        $gal = json_decode($project['gallery'], true);
                        if($gal && is_array($gal)): ?>
                            <?php foreach($gal as $img): ?>
                                <img src="../<?= $img ?>" style="height:100px; width:100px; border-radius:5px; object-fit:cover; margin-right:10px; margin-bottom:10px;">
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 mt-4 text-primary border-bottom pb-2">4. Brochure Settings</h4>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="enable_brochure" name="enable_brochure" value="1" <?= !empty($project['enable_brochure']) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="enable_brochure">Enable Brochure Download</label>
                    </div>
                </div>
                <div class="col-md-12 mb-3 brochure-file-container" style="<?= empty($project['enable_brochure']) ? 'display:none;' : '' ?>">
                    <label>Upload Brochure (PDF Only) - Leave empty to keep current</label>
                    <input type="file" name="brochure_file" class="form-control" accept=".pdf">
                    <?php if(!empty($project['brochure_file'])): ?>
                        <div class="mt-2">
                            <a href="../<?= $project['brochure_file'] ?>" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-file-pdf"></i> View Current Brochure</a>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Users will be able to download this PDF file directly from the project details page.</small>
                </div>
            </div>

            <h4 class="mb-3 mt-4 text-primary border-bottom pb-2">5. SEO Information</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>SEO Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($project['meta_title'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>SEO Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" placeholder="keyword1, keyword2..." value="<?= htmlspecialchars($project['meta_keywords'] ?? '') ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label>SEO Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3"><?= htmlspecialchars($project['meta_description'] ?? '') ?></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Schema Markup (JSON-LD)</label>
                    <?php
                    $schema = $project['schema_markup'] ?? '';
                    if(!$schema) {
                        $schema = '{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "'.htmlspecialchars($project['title']).'",
  "image": "Project Image URL",
  "description": "Project Description",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "reviewCount": "89"
  }
}';
                    }
                    ?>
                    <textarea name="schema_markup" class="form-control" rows="8"><?= htmlspecialchars($schema) ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label>OG Title</label>
                    <input type="text" name="og_title" class="form-control" value="<?= htmlspecialchars($project['og_title'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>OG Image (Leave empty to keep current)</label>
                    <input type="file" name="og_image" class="form-control" accept="image/*">
                    <?php if(!empty($project['og_image'])): ?>
                        <div class="mt-2">
                            <img src="../<?= $project['og_image'] ?>" style="height:80px; border-radius:5px; object-fit:cover;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-12 mb-3">
                    <label>OG Description</label>
                    <textarea name="og_description" class="form-control" rows="3"><?= htmlspecialchars($project['og_description'] ?? '') ?></textarea>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary btn-lg">Update Project</button>
            <a href="projects.php" class="btn btn-secondary btn-lg">Cancel</a>
        </form>
    </div>
</div>

<script src="../vendor/summernote/summernote/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        placeholder: 'Write project overview here...'
    });

    // Dynamic Amenities
    $('#add-amenity').click(function() {
        var html = `
        <div class="row mb-2 amenity-row">
            <div class="col-md-5">
                <input type="text" name="amenity_titles[]" class="form-control" placeholder="e.g. Swimming Pool">
            </div>
            <div class="col-md-5">
                <input type="file" name="amenity_icons[]" class="form-control" accept="image/*">
                <input type="hidden" name="existing_amenity_icons[]" value="">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-amenity">Remove</button>
            </div>
        </div>`;
        $('#amenities-container').append(html);
    });

    $(document).on('click', '.remove-amenity', function() {
        if($('.amenity-row').length > 1) {
            $(this).closest('.amenity-row').remove();
        } else {
            alert('At least one amenity field is required.');
        }
    });

    // Cumulative Gallery Input
    $('#add-gallery-input').click(function() {
        $('#gallery-inputs-container').append('<input type="file" name="gallery[]" class="form-control gallery-input mb-2" accept="image/*" multiple>');
    });

    // Main Image Preview
    $('input[name="main_image"]').on('change', function() {
        $('#main-preview').html('');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#main-preview').html('<img src="'+e.target.result+'" style="height:150px; border-radius:5px; margin-top:10px; object-fit:cover;">');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Gallery Preview (Delegated to handle dynamically added inputs)
    $(document).on('change', '.gallery-input', function() {
        var $previewContainer = $('#gallery-preview');
        // We accumulate preview images
        if (this.files) {
            Array.from(this.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $previewContainer.append('<img src="'+e.target.result+'" style="height:100px; width:100px; border-radius:5px; margin-top:10px; margin-right:10px; object-fit:cover; border:1px solid #ddd;">');
                }
                reader.readAsDataURL(file);
            });
        }
    });

    // Toggle Brochure Field
    $('#enable_brochure').change(function() {
        if($(this).is(':checked')) {
            $('.brochure-file-container').slideDown();
        } else {
            $('.brochure-file-container').slideUp();
        }
    });
});
</script>

<?php include 'footer.php'; ?>
