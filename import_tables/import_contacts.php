<?php
require_once '../database/db_config.php';

$sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    subject VARCHAR(255),
    message TEXT,
    status ENUM('New', 'Read', 'Replied') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'contacts' ensured to exist.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}
?>
