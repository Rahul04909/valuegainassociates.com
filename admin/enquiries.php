<?php
require_once 'includes/auth.php';
check_login();

require_once '../database/db_config.php';

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $_SESSION['success'] = "Enquiry deleted successfully.";
    header("Location: enquiries.php");
    exit();
}

// Handle Status Change
if (isset($_GET['status_id']) && isset($_GET['status'])) {
    $sid = (int)$_GET['status_id'];
    $status = $_GET['status'];
    $stmt = $conn->prepare("UPDATE enquiries SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $sid);
    $stmt->execute();
    $_SESSION['success'] = "Enquiry status updated.";
    header("Location: enquiries.php");
    exit();
}

// Fetch all enquiries with project titles
$sql = "SELECT e.*, p.title as project_name 
        FROM enquiries e 
        LEFT JOIN projects p ON e.project_id = p.id 
        ORDER BY e.created_at DESC";
$result = $conn->query($sql);
$enquiries = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $enquiries[] = $row;
    }
}

include 'header.php';
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Manage Enquiries</h3>
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
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Project</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($enquiries) > 0): ?>
                        <?php foreach ($enquiries as $en): ?>
                            <tr>
                                <td><?= $en['id'] ?></td>
                                <td><?= date('d M Y, h:i A', strtotime($en['created_at'])) ?></td>
                                <td><strong><?= htmlspecialchars($en['name']) ?></strong></td>
                                <td>
                                    <div class="small">
                                        <i class="fas fa-phone-alt"></i> <?= htmlspecialchars($en['phone']) ?><br>
                                        <i class="fas fa-envelope"></i> <?= htmlspecialchars($en['email']) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($en['project_name']): ?>
                                        <span class="badge bg-primary"><?= htmlspecialchars($en['project_name']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">General Enquiry</span>
                                    <?php endif; ?>
                                </td>
                                <td><div style="max-width: 250px; font-size: 0.9rem;"><?= nl2br(htmlspecialchars($en['message'])) ?></div></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <?= $en['status'] ?>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="enquiries.php?status_id=<?= $en['id'] ?>&status=New">New</a></li>
                                            <li><a class="dropdown-item" href="enquiries.php?status_id=<?= $en['id'] ?>&status=Contacted">Contacted</a></li>
                                            <li><a class="dropdown-item" href="enquiries.php?status_id=<?= $en['id'] ?>&status=Closed">Closed</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <a href="enquiries.php?delete_id=<?= $en['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this enquiry?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No enquiries found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
