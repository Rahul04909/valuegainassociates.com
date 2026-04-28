<?php
require_once '../database/db_config.php';

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

if ($conn->query($sql) === TRUE) {
    echo "Table 'projects' created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error;
}
?>
