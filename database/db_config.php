<?php
$servername = "localhost";
$username = "sbsmarti_value";
$password = "Rd14072003@./";
$dbname = "sbsmarti_value";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
