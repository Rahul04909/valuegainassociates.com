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

        $sql = "UPDATE admin SET admin_name='$name', email='$email', mobile='$mobile' WHERE id=$admin_id";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['admin_name'] = $name;
            $success_msg = "Profile updated successfully!";
        } else {
            $error_msg = "Error updating profile: " . $conn->error;
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
            <form method="POST" action="">
                <div class="card-body">
                    <?php if($success_msg && isset($_POST['update_profile'])): ?>
                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                    <?php endif; ?>
                    <?php if($error_msg && isset($_POST['update_profile'])): ?>
                        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                    <?php endif; ?>
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

<?php include './footer.php'; ?>