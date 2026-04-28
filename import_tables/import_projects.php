<?php
require_once '../database/db_config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create projects table
    $sql = "CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        location VARCHAR(255) NOT NULL,
        price VARCHAR(50) NOT NULL,
        price_label VARCHAR(50),
        property_type VARCHAR(100),
        area VARCHAR(100),
        status VARCHAR(100),
        possession VARCHAR(100),
        badge VARCHAR(50),
        description TEXT,
        amenities TEXT,
        main_image VARCHAR(255),
        gallery TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Table 'projects' created successfully.<br>";

} catch (PDOException $e) {
    die("Error creating table: " . $e->getMessage());
}
?>
