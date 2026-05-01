<?php
$servername = "localhost";
$username = "mineib_i1_mineib";
$password = "Rd14072003@./";
$dbname = "mineib_i1_valuegain";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>