<?php
require_once 'database/db_config.php';

$queries = [
    "ALTER TABLE projects ADD featured_image VARCHAR(255) AFTER id",
    "ALTER TABLE projects ADD meta_title VARCHAR(255)",
    "ALTER TABLE projects ADD meta_description TEXT",
    "ALTER TABLE projects ADD meta_keywords TEXT",
    "ALTER TABLE projects ADD schema_markup TEXT",
    "ALTER TABLE projects ADD og_title VARCHAR(255)",
    "ALTER TABLE projects ADD og_description TEXT",
    "ALTER TABLE projects ADD og_image VARCHAR(255)"
];

foreach ($queries as $q) {
    if ($conn->query($q) === TRUE) {
        echo "Success: $q\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
?>
