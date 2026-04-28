<?php
require_once 'includes/auth.php';
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Valugain Associates</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin-style.css">
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="../assets/logo.png" alt="Logo">
        </div>
        <ul class="sidebar-menu">
            <li class="active"><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-building"></i> Properties</a></li>
            <li><a href="#"><i class="fas fa-envelope"></i> Enquiries</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h2>Dashboard</h2>
            </div>
            <div class="topbar-right">
                <div class="admin-profile">
                    <img src="../assets/images/<?php echo $_SESSION['admin_profile']; ?>" alt="Profile" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_name']); ?>&background=24b64a&color=fff'">
                    <div class="admin-info">
                        <span class="name"><?php echo $_SESSION['admin_name']; ?></span>
                        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <div class="welcome-card">
                <h3>Welcome back, <?php echo $_SESSION['admin_name']; ?>! 👋</h3>
                <p>Here is what's happening with your real estate portal today.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;"><i class="fas fa-building"></i></div>
                    <div class="stat-details">
                        <h4>Total Properties</h4>
                        <h2>124</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #dcfce7; color: #16a34a;"><i class="fas fa-envelope-open-text"></i></div>
                    <div class="stat-details">
                        <h4>New Enquiries</h4>
                        <h2>38</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fef3c7; color: #d97706;"><i class="fas fa-users"></i></div>
                    <div class="stat-details">
                        <h4>Active Agents</h4>
                        <h2>12</h2>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fee2e2; color: #dc2626;"><i class="fas fa-eye"></i></div>
                    <div class="stat-details">
                        <h4>Total Views</h4>
                        <h2>8.4k</h2>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

</body>
</html>