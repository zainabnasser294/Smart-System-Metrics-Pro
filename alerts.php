<?php
include 'config/db.php'; 
include 'includes/header.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$device_id = isset($_GET['id']) ? $_GET['id'] : 0;


$cpu = 0; $ram = 0;
try {
   
    $metrics_stmt = $pdo->prepare("SELECT * FROM metrics WHERE device_id = ? ORDER BY id DESC LIMIT 1");
    $metrics_stmt->execute([$device_id]);
    $latest_data = $metrics_stmt->fetch();
    
    if ($latest_data) {
        
        $cpu = isset($latest_data['cpu_usage']) ? $latest_data['cpu_usage'] : ($latest_data['cpu'] ?? 0);
        $ram = isset($latest_data['ram_usage']) ? $latest_data['ram_usage'] : ($latest_data['ram'] ?? 0);
    }
} catch (Exception $e) {
   
}
?>

<style>
    .status-box { border-radius: 15px; padding: 40px; margin-bottom: 30px; text-align: center; }
    .status-safe { background: #e6fffa; border: 2px solid #38a169; color: #2f855a; }
    .status-danger { background: #fff5f5; border: 2px solid #e53e3e; color: #c53030; }
    .metric-card { background: white; border-radius: 12px; padding: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .percentage { font-size: 2rem; font-weight: bold; }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-brain text-info"></i> NBI Behavior Analysis</h2>
        <span class="badge bg-dark">Device ID: <?php echo $device_id; ?></span>
    </div>

    <div class="row mb-5">
        <div class="col-md-6">
            <div class="metric-card text-center">
                <div class="text-muted small uppercase">Current CPU Load</div>
                <div class="percentage <?php echo ($cpu > 80) ? 'text-danger' : 'text-success'; ?>"><?php echo $cpu; ?>%</div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar <?php echo ($cpu > 80) ? 'bg-danger' : 'bg-success'; ?>" style="width: <?php echo $cpu; ?>%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="metric-card text-center">
                <div class="text-muted small uppercase">Current RAM Usage</div>
                <div class="percentage <?php echo ($ram > 90) ? 'text-danger' : 'text-success'; ?>"><?php echo $ram; ?>%</div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar <?php echo ($ram > 90) ? 'bg-danger' : 'bg-success'; ?>" style="width: <?php echo $ram; ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <?php
    
    $stmt = $pdo->prepare("SELECT * FROM nbi_alerts WHERE device_id = ? ORDER BY id DESC");
    $stmt->execute([$device_id]);
    $alerts = $stmt->fetchAll();

    if (count($alerts) > 0): ?>
        <div class="status-box status-danger shadow-sm">
            <i class="fas fa-exclamation-triangle fa-4x mb-3"></i>
            <h3>Anomaly Detected!</h3>
            <p>System behavior is outside normal parameters.</p>
        </div>
        <?php else: ?>
        <div class="status-box status-safe shadow-sm">
            <i class="fas fa-check-circle fa-4x mb-3"></i>
            <h3>System Behavior is Normal</h3>
            <p class="mb-0">NBI Intelligence confirms all network activities are safe.</p>
        </div>
    <?php endif; ?>
</div>