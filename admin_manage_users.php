<?php
include 'config/db.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$users = $pdo->query("SELECT * FROM users WHERE role = 'customer' ORDER BY id DESC")->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white p-4">
            <h3 class="fw-bold mb-0 text-dark"><i class="fas fa-users-cog text-primary"></i> Customer Management</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Registration Date</th>
                            <th class="text-center">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="ps-4"><?php echo $user['id']; ?></td>
                            <td class="fw-bold"><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($user['created_at'] ?? 'now')); ?></td>
                            <td class="text-center">
                                <a href="view_customer_dashboard.php?user_id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-eye"></i> Monitor
                                </a>
                                <a href="user_details.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>