<?php
require_once 'database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($phone)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        
        if ($stmt->execute()) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<body><script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent!',
                        text: 'Thank you for contacting us. We will get back to you soon.',
                        confirmButtonColor: '#24b64a'
                    }).then(() => {
                        window.location.href = 'contact.php';
                    });
                });
            </script></body>";
        } else {
            echo "<script>alert('Error: Could not send message. Please try again.'); window.location.href='contact.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='contact.php';</script>";
    }
    exit;
}
?>
