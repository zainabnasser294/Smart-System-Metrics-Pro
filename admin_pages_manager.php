<?php
include 'config/db.php';
session_start();

// التحقق من صلاحيات الأدمن
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// كود الحذف السريع في نفس الصفحة
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    if ($id != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: admin_manage_users.php?success=deleted");
        exit();
    }
}

// جلب كل المستخدمين (المحلل والزبون) لكي يظهروا في الجدول
$users = $pdo->query("SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC")->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white p-4">
            <h3 class="fw-bold mb-0 text-dark"><i class="fas fa-users-cog text-primary"></i> User Management</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td class="fw-bold"><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td>
                                <span class="badge <?php echo ($user['role'] === 'analyst') ? 'bg-info' : 'bg-secondary'; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="view_customer_dashboard.php?user_id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-eye"></i> Monitor
                                </a>
                                <!-- زر الحذف الذي سيحذف "شمسه" وأي حساب آخر فوراً -->
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