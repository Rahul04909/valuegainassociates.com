<?php
session_start();
require_once '../database/db_config.php';

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Check by username or email
    $sql = "SELECT * FROM admin WHERE username='$username' OR email='$username'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verify password
        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['admin_name'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_profile'] = $admin['profile_image'];
            
            header("Location: index.php");
            exit();
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'Invalid username or email.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Valugain Associates</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
</head>
<body class="login-body">

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <img src="../assets/logo.png" alt="Valugain Logo" class="login-logo">
            <h2>Admin Portal</h2>
            <p>Enter your credentials to access the dashboard</p>
        </div>

        <?php if($error): ?>
            <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Username or Email</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" required placeholder="Enter username or email">
                </div>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" required placeholder="Enter password">
                </div>
            </div>

            <button type="submit" class="login-btn">Login to Dashboard <i class="fas fa-arrow-right"></i></button>
        </form>
    </div>
</div>

</body>
</html>
