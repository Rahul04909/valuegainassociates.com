<?php
require_once '../database/db_config.php';

$sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    admin_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobile VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<h3 style='color: green;'>Table 'admin' created successfully.</h3>";
    
    // Insert default admin if not exists
    $check_sql = "SELECT * FROM admin WHERE username='admin'";
    $result = $conn->query($check_sql);
    
    if($result->num_rows == 0) {
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO admin (admin_name, username, email, mobile, password, profile_image) VALUES ('Super Admin', 'admin', 'admin@valugainassociates.com', '9876543210', '$hashed_password', 'default.png')";
        if($conn->query($insert_sql) === TRUE) {
            echo "<p>Default admin created successfully!</p>";
            echo "<b>Username:</b> admin<br>";
            echo "<b>Password:</b> admin123<br>";
            echo "<br><a href='../admin/login.php'>Go to Admin Login</a>";
        } else {
            echo "<p style='color: red;'>Error inserting default admin: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Default admin already exists.</p>";
        echo "<br><a href='../admin/login.php'>Go to Admin Login</a>";
    }
} else {
    echo "<h3 style='color: red;'>Error creating table: " . $conn->error . "</h3>";
}

$conn->close();
?>
