<?php
include 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];


$total_devices = $pdo->prepare("SELECT COUNT(*) FROM devices WHERE user_id = ?");
$total_devices->execute([$user_id]);
$devices_count = $total_devices->fetchColumn();

$online_devices = $pdo->prepare("SELECT COUNT(*) FROM devices WHERE user_id = ? AND status = 'online'");
$online_devices->execute([$user_id]);
$online_count = $online_devices->fetchColumn();

$total_alerts = $pdo->prepare("SELECT COUNT(*) FROM nbi_alerts a JOIN devices d ON a.device_id = d.id WHERE d.user_id = ?");
$total_alerts->execute([$user_id]);
$alerts_count = $total_alerts->fetchColumn();

include 'includes/header.php'; 
?>

<style>
    
    body, html { margin: 0; padding: 0; overflow-x: hidden; }
    
   
    .wrapper { display: flex; align-items: stretch; width: 100%; }
    
    .sidebar-custom {
        min-width: 260px;
        max-width: 260px;
        background: #1a202c;
        min-height: 100vh;
        transition: all 0.3s;
    }

    .main-content {
        width: 100%;
        background: #f4f7f6;
        min-height: 100vh;
        padding: 0; 
    }

    .nav-link-custom {
        color: rgba(255,255,255,0.7);
        padding: 15px 25px;
        display: block;
        text-decoration: none;
        transition: 0.3s;
    }

    .nav-link-custom:hover, .nav-link-custom.active {
        background: #2d3748;
        color: #fff;
        border-left: 4px solid #3182ce;
    }
</style>

<div class="wrapper">
    <nav class="sidebar-custom shadow-lg">
        <div class="p-4">
            <h4 class="text-white fw-bold mb-4"><i class="fas fa-shield-alt text-info me-2"></i>NBI Control</h4>
            <div class="mt-4">
                <a href="dashboard.php" class="nav-link-custom active"><i class="fas fa-home me-2"></i> Dashboard</a>
                <a href="manage_devices.php" class="nav-link-custom"><i class="fas fa-laptop me-2"></i> My Devices</a>
                <a href="alerts.php" class="nav-link-custom"><i class="fas fa-bell me-2"></i> Alerts</a>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="bg-white p-4 shadow-sm d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Welcome back, <?php echo $username; ?>!</h4>
            <span class="text-muted small"><i class="far fa-calendar-alt me-1"></i> <?php echo date('l, d M Y'); ?></span>
        </div>

        <div class="container-fluid px-5">
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle p-3 rounded-3 me-3"><i class="fas fa-network-wired text-primary fa-lg"></i></div>
                            <div><p class="text-muted mb-0 small">Devices</p><h4 class="fw-bold mb-0"><?php echo $devices_count; ?></h4></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-success-subtle p-3 rounded-3 me-3"><i class="fas fa-check-circle text-success fa-lg"></i></div>
                            <div><p class="text-muted mb-0 small">Active</p><h4 class="fw-bold mb-0"><?php echo $online_count; ?></h4></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning-subtle p-3 rounded-3 me-3"><i class="fas fa-exclamation-triangle text-warning fa-lg"></i></div>
                            <div><p class="text-muted mb-0 small">Alerts</p><h4 class="fw-bold mb-0"><?php echo $alerts_count; ?></h4></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">Network Devices Status</h5>
                </div>
                <div class="table-responsive p-4">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-secondary small">
                                <th>DEVICE NAME</th>
                                <th>IP ADDRESS</th>
                                <th>STATUS</th>
                                <th class="text-center">MONITORING</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM devices WHERE user_id = ?");
                            $stmt->execute([$user_id]);
                            while ($device = $stmt->fetch()) {
                                $status_badge = ($device['status'] == 'online') ? 'bg-success' : 'bg-danger';
                                $ip = !empty($device['ip_address']) ? $device['ip_address'] : '127.0.0.1';
                                echo "<tr>
                                    <td><span class='fw-bold'>{$device['device_name']}</span></td>
                                    <td><code class='text-primary px-2 bg-light rounded'>$ip</code></td>
                                    <td><span class='badge rounded-pill $status_badge px-3'>{$device['status']}</span></td>
                                    <td class='text-center'>
                                        <a href='view_metrics.php?id={$device['id']}' class='btn btn-sm btn-outline-primary rounded-pill'><i class='fas fa-chart-line'></i></a>
                                    </td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>