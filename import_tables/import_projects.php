<?php
require_once '../database/db_config.php';

$sql = "CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    featured_image VARCHAR(255),
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
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords TEXT,
    schema_markup TEXT,
    og_title VARCHAR(255),
    og_description TEXT,
    og_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'projects' ensured to exist.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Add new columns if they don't exist
$columns = [
    "featured_image" => "VARCHAR(255) AFTER id",
    "meta_title" => "VARCHAR(255)",
    "meta_description" => "TEXT",
    "meta_keywords" => "TEXT",
    "schema_markup" => "TEXT",
    "og_title" => "VARCHAR(255)",
    "og_description" => "TEXT",
    "og_image" => "VARCHAR(255)"
];

foreach ($columns as $col => $def) {
    $result = $conn->query("SHOW COLUMNS FROM projects LIKE '$col'");
    if ($result->num_rows == 0) {
        $conn->query("ALTER TABLE projects ADD $col $def");
        echo "Column '$col' added successfully.<br>";
    }
}
?>
