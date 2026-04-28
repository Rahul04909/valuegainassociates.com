<?php
require_once 'database/db_config.php';

$queries = [
    "ALTER TABLE projects ADD enable_brochure TINYINT(1) DEFAULT 0",
    "ALTER TABLE projects ADD brochure_file VARCHAR(255)"
];

foreach ($queries as $q) {
    if ($conn->query($q) === TRUE) {
        echo "Success: $q\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
?>
