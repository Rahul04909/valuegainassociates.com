<?php
require_once 'database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $project_id = !empty($_POST['project_id']) ? (int)$_POST['project_id'] : null;
    $message = $_POST['message'] ?? '';

    if (!empty($name) && !empty($phone)) {
        $stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, project_id, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $email, $phone, $project_id, $message);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Your enquiry has been submitted successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
    }
    exit;
}
?>
