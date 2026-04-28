<?php 
require_once 'includes/auth.php';
check_login();
require_once '../database/db_config.php';

$admin_id = $_SESSION['admin_id'];
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $name = $conn->real_escape_string($_POST['admin_name']);
        $email = $conn->real_escape_string($_POST['email']);
        $mobile = $conn->real_escape_string($_POST['mobile']);

        // Handle Profile Image Upload
        $profile_img_query = "";
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES['profile_image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if (in_array(strtolower($filetype), $allowed)) {
                $new_filename = 'admin_' . time() . '.' . $filetype;
                $upload_path = '../assets/images/' . $new_filename;
                
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                    $profile_img_query = ", profile_image='$new_filename'";
                    $_SESSION['admin_profile'] = $new_filename; // Update session
                } else {
                    $error_msg = "Failed to upload image.";
                }
            } else {
                $error_msg = "Invalid file type. Only JPG, PNG, WEBP, and GIF are allowed.";
            }
        }

        if (empty($error_msg)) {
            $sql = "UPDATE admin SET admin_name='$name', email='$email', mobile='$mobile' $profile_img_query WHERE id=$admin_id";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['admin_name'] = $name;
                $success_msg = "Profile updated successfully!";
            } else {
                $error_msg = "Error updating profile: " . $conn->error;
            }
        }

    } elseif (isset($_POST['change_password'])) {
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];

        $sql = "SELECT password FROM admin WHERE id=$admin_id";
        $result = $conn->query($sql);
        $admin = $result->fetch_assoc();

        if (password_verify($old_pass, $admin['password'])) {
            if ($new_pass === $confirm_pass) {
                $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $update_pass = "UPDATE admin SET password='$hashed_pass' WHERE id=$admin_id";
                if ($conn->query($update_pass) === TRUE) {
                    $success_msg = "Password changed successfully!";
                } else {
                    $error_msg = "Error updating password.";
                }
            } else {
                $error_msg = "New passwords do not match!";
            }
        } else {
            $error_msg = "Incorrect old password!";
        }
    }
}

// Fetch current admin data
$sql = "SELECT * FROM admin WHERE id=$admin_id";
$result = $conn->query($sql);
$admin_data = $result->fetch_assoc();

include './header.php'; 
?>

<div class="row">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Update Profile</h3>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <?php if($success_msg && isset($_POST['update_profile'])): ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                    <?php endif; ?>
                    <?php if($error_msg && isset($_POST['update_profile'])): ?>
                        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <!-- Profile Image Upload Area -->
                    <div class="form-group text-center mb-4">
                        <img id="profilePreview" src="../assets/images/<?php echo htmlspecialchars($admin_data['profile_image'] ?? 'default.png'); ?>" class="img-circle elevation-2 bg-white" alt="Admin Profile" style="width: 120px; height: 120px; object-fit: contain; margin-bottom: 15px; border: 3px solid #28a745;" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($admin_data['admin_name'] ?? 'Admin'); ?>&background=28a745&color=fff'">
                        <br>
                        <label for="profile_image" class="btn btn-sm btn-outline-success" style="cursor:pointer; border-radius: 20px; padding: 5px 15px; font-weight: 600;">
                            <i class="fas fa-camera"></i> Upload New Photo
                        </label>
                        <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*" onchange="previewImage(event)">
                        <small class="d-block text-muted mt-1">Recommended size: 200x200px (JPG, PNG)</small>
                    </div>

                    <div class="form-group">
                        <label>Admin Name</label>
                        <input type="text" name="admin_name" class="form-control" value="<?php echo htmlspecialchars($admin_data['admin_name'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($admin_data['email'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($admin_data['mobile'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Username (Cannot be changed)</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($admin_data['username'] ?? ''); ?>" disabled>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="update_profile" class="btn btn-success">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>
            <form method="POST" action="">
                <div class="card-body">
                    <?php if($success_msg && isset($_POST['change_password'])): ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                    <?php endif; ?>
                    <?php if($error_msg && isset($_POST['change_password'])): ?>
                        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="change_password" class="btn btn-warning">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('profilePreview');
        output.src = reader.result;
    };
    if(event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>

<?php include './footer.php'; ?>