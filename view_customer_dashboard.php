<?php
include 'config/db.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$target_user_id = $_GET['user_id'];


$customer = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$customer->execute([$target_user_id]);
$customer_data = $customer->fetch();


$devices = $pdo->prepare("SELECT * FROM devices WHERE user_id = ?");
$devices->execute([$target_user_id]);
$devices_list = $devices->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="admin_dashboard.php">Admin Panel</a></li>
            <li class="breadcrumb-item active">Monitoring: <?php echo $customer_data['username']; ?></li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4">
        <h3 class="fw-bold text-primary">
            <i class="fas fa-desktop me-2"></i> Dashboard for: <?php echo $customer_data['username']; ?>
        </h3>
        <p class="text-muted">You are now viewing the network status for this specific customer.</p>
    </div>

    <div class="row">
        <?php if (count($devices_list) > 0): ?>
            <?php foreach ($devices_list as $device): ?>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <h5 class="fw-bold"><?php echo $device['device_name']; ?></h5>
                        <p class="small text-muted">IP: <?php echo $device['ip_address']; ?></p>
                        <hr>
                        <a href="view_metrics.php?device_id=<?php echo $device['id']; ?>" class="btn btn-outline-primary btn-sm w-100">
                            View Live Metrics
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-ghost fa-3x text-muted mb-3"></i>
                <p class="text-muted">This customer has no registered devices yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>