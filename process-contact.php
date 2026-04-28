<?php
require_once 'database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? 'Contact Page Enquiry';
    $message = $_POST['message'] ?? '';

    // We store contact page enquiries in the same enquiries table for unified management
    if (!empty($name) && !empty($phone)) {
        $full_message = "Subject: $subject\n\n$message";
        $project_id = null; // Contact page is general

        $stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, project_id, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $email, $phone, $project_id, $full_message);
        
        if ($stmt->execute()) {
            echo "<script>alert('Thank you! Your message has been sent successfully.'); window.location.href='contact.php';</script>";
        } else {
            echo "<script>alert('Error: Could not send message. Please try again.'); window.location.href='contact.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='contact.php';</script>";
    }
    exit;
}
?>
