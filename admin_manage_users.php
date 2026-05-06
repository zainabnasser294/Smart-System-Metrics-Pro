<?php
include 'config/db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (isset($_GET['delete_id'])) {
    $id_to_delete = $_GET['delete_id'];
 
    if ($id_to_delete != $_SESSION['user_id']) {
        $delete_stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $delete_stmt->execute([$id_to_delete]);
       
        header("Location: admin_manage_users.php?msg=deleted");
        exit();
    }
}


$users = $pdo->query("SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC")->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            User deleted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white p-4">
            <h3 class="fw-bold mb-0 text-dark"><i class="fas fa-users-cog text-primary"></i> User Management</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
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
                            <td>
                                <span class="badge <?php echo ($user['role'] === 'analyst') ? 'bg-info' : 'bg-secondary'; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td><?php echo date('Y-m-d', strtotime($user['created_at'] ?? 'now')); ?></td>
                            <td class="text-center">
                                <a href="view_customer_dashboard.php?user_id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-eye"></i> Monitor
                                </a>
                               
                                <a href="admin_manage_users.php?delete_id=<?php echo $user['id']; ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i> Delete
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