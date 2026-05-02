<?php
include 'config/db.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$query = "SELECT a.*, u.username, d.device_name 
          FROM nbi_alerts a
          JOIN devices d ON a.device_id = d.id
          JOIN users u ON d.user_id = u.id
          ORDER BY a.created_at DESC";

try {
    $alerts = $pdo->query($query)->fetchAll();
} catch (PDOException $e) {
    
    die("Database Error: " . $e->getMessage());
}

include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-danger">
            <i class="fas fa-exclamation-triangle"></i> Global NBI Security Alerts
        </h2>
        <span class="badge bg-danger p-2 pulse shadow-sm">Live Network Monitoring</span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Timestamp</th>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Threat Type</th>
                            <th>Severity</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($alerts)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-shield-check fa-3x mb-3 d-block opacity-25"></i>
                                    No security threats detected. System is secure.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($alerts as $alert): ?>
                            <tr>
                                <td class="ps-4 small text-secondary"><?php echo $alert['created_at']; ?></td>
                                <td class="fw-bold"><?php echo $alert['username']; ?></td>
                                <td><i class="fas fa-desktop me-1 text-primary"></i> <?php echo $alert['device_name']; ?></td>
                                <td>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3">
                                        <?php echo strtoupper($alert['alert_type']); ?>
                                    </span>
                                </td>
                                <td><span class="text-danger fw-bold"><i class="fas fa-bolt me-1"></i> Critical</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-dark rounded-pill px-3">Investigate</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
    .pulse { animation: pulse 2s infinite; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; }
</style>

<?php include 'includes/footer.php'; ?>