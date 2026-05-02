<?php
include 'config/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role != 'admin'")->fetchColumn();
$total_devices = $pdo->query("SELECT COUNT(*) FROM devices")->fetchColumn();
$total_alerts = $pdo->query("SELECT COUNT(*) FROM nbi_alerts")->fetchColumn();


$users_list = $pdo->query("SELECT u.id, u.username, u.email, u.role, COUNT(d.id) as device_count 
                           FROM users u 
                           LEFT JOIN devices d ON u.id = d.user_id 
                           WHERE u.id != {$_SESSION['user_id']} 
                           GROUP BY u.id 
                           ORDER BY u.id DESC")->fetchAll();


$live_metrics = $pdo->query("SELECT m.*, d.device_name 
                              FROM metrics m 
                              JOIN devices d ON m.device_id = d.id 
                              ORDER BY m.captured_at DESC LIMIT 10")->fetchAll();
?>

<?php include 'includes/header.php'; ?>


<div class="container-fluid py-4">
    
   
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-user-shield text-primary"></i> Master Admin Control Center</h2>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-2"></i> Add New Customer
        </button>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> Operation completed successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
   
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex justify-content-between">
                    <div><h5>Total Customers</h5><h3 class="fw-bold"><?php echo $total_users; ?></h3></div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex justify-content-between">
                    <div><h5>Registered Devices</h5><h3 class="fw-bold"><?php echo $total_devices; ?></h3></div>
                    <i class="fas fa-microchip fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white border-0 shadow-sm p-3 rounded-4">
                <div class="d-flex justify-content-between">
                    <div><h5>Global NBI Threats</h5><h3 class="fw-bold"><?php echo $total_alerts; ?></h3></div>
                    <i class="fas fa-biohazard fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="fas fa-chart-line text-primary"></i> Global Traffic Analytics (Real-Time)</h5>
            <div style="height: 300px;"><canvas id="globalTrafficChart"></canvas></div>
        </div>
    </div>

  
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-dark text-white p-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-list-ol me-2"></i> Live System Metrics & AI Status</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>Timestamp</th>
                        <th>Device Name</th>
                        <th>CPU Usage</th>
                        <th>RAM Usage</th>
                        <th>AI NBI Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($live_metrics as $metric): ?>
                    <tr>
                        <td class="small text-muted"><?php echo $metric['captured_at']; ?></td>
                        <td class="fw-bold"><?php echo $metric['device_name']; ?></td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: <?php echo $metric['cpu_usage']; ?>%"></div>
                            </div>
                            <small><?php echo $metric['cpu_usage']; ?>%</small>
                        </td>
                        <td>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" style="width: <?php echo $metric['ram_usage']; ?>%"></div>
                            </div>
                            <small><?php echo $metric['ram_usage']; ?>%</small>
                        </td>
                        <td>
                            <?php if ($metric['cpu_usage'] > 80 || $metric['ram_usage'] > 85): ?>
                                <span class="badge bg-danger">Not Normal</span>
                            <?php else: ?>
                                <span class="badge bg-success">Normal</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

   
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-0">Customer Management Database</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Username</th>
                        <th>Email Address</th>
                        <th>Devices</th>
                        <th>Role</th>
                        <th class="text-center">System Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users_list as $user): ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><span class="badge bg-secondary rounded-pill"><?php echo $user['device_count']; ?> Units</span></td>
                        <td><span class="badge bg-light text-dark border px-3 small">Customer</span></td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                <a href="view_customer_dashboard.php?user_id=<?php echo $user['id']; ?>" class="btn btn-sm btn-white text-warning border-end px-3">
                                    <i class="fas fa-eye"></i> View Live
                                </a>
                                <a href="user_details.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-white text-primary border-end px-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="admin_actions.php?action=delete&id=<?php echo $user['id']; ?>" 
                                   class="btn btn-sm btn-white text-danger px-3" 
                                   onclick="return confirm('Are you sure?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 


<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <form action="admin_actions.php?action=add_user" method="POST">
        <div class="modal-header border-0 p-4">
            <h5 class="fw-bold mb-0">Register New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control rounded-3" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Email</label>
                <input type="email" name="email" class="form-control rounded-3" required>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control rounded-3" required>
            </div>
        </div>
        <div class="modal-footer border-0 p-4 pt-0">
            <button type="submit" class="btn btn-primary w-100 rounded-3 p-2 fw-bold">Create Account</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('globalTrafficChart').getContext('2d');
    let chart;

    function updateChart() {
      
        fetch('get_live_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(m => m.captured_at.split(' ')[1]); 
                const trafficData = data.map(m => m.bandwidth_usage);

                if (chart) {
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = trafficData;
                    chart.update();
                } else {
                    chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Global Traffic (Network In)',
                                data: trafficData,
                                borderColor: '#0d6efd',
                                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });
                }
            });
    }

    
    setInterval(updateChart, 5000);
    updateChart();
});
</script>

<?php include 'includes/footer.php'; ?>