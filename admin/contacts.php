<?php
require_once 'includes/auth.php';
check_login();

require_once '../database/db_config.php';

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $_SESSION['success'] = "Contact request deleted.";
    header("Location: contacts.php");
    exit();
}

// Handle Status Change
if (isset($_GET['status_id']) && isset($_GET['status'])) {
    $sid = (int)$_GET['status_id'];
    $status = $_GET['status'];
    $stmt = $conn->prepare("UPDATE contacts SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $sid);
    $stmt->execute();
    $_SESSION['success'] = "Contact status updated.";
    header("Location: contacts.php");
    exit();
}

// Fetch all contacts
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
$contacts = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}

include 'header.php';
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Contact Requests</h3>
    </div>
    <div class="card-body">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>User Details</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($contacts) > 0): ?>
                        <?php foreach ($contacts as $con): ?>
                            <tr>
                                <td><?= $con['id'] ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($con['created_at'])) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($con['name']) ?></strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone-alt"></i> <?= htmlspecialchars($con['phone']) ?><br>
                                        <i class="fas fa-envelope"></i> <?= htmlspecialchars($con['email']) ?>
                                    </small>
                                </td>
                                <td><?= htmlspecialchars($con['subject']) ?></td>
                                <td><div style="max-width: 300px; font-size: 0.9rem;"><?= nl2br(htmlspecialchars($con['message'])) ?></div></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <?= $con['status'] ?>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="contacts.php?status_id=<?= $con['id'] ?>&status=New">New</a></li>
                                            <li><a class="dropdown-item" href="contacts.php?status_id=<?= $con['id'] ?>&status=Read">Read</a></li>
                                            <li><a class="dropdown-item" href="contacts.php?status_id=<?= $con['id'] ?>&status=Replied">Replied</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <a href="contacts.php?delete_id=<?= $con['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No contact requests found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
