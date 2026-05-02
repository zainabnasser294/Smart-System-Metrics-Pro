<?php 
session_start(); 
include 'config/db.php'; 

$error = "";

if (isset($_POST['login'])) {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
       
        if (password_verify($pass, $userData['password']) || $pass === $userData['password']) {
            
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['username'] = $userData['username'];
            $_SESSION['role'] = $userData['role']; 

            if ($userData['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid Password.";
        }
    } else {
        $error = "User not found.";
    }
}

include 'includes/header.php'; 
?>

<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; background-color: #f8f9fa;">
    <div style="max-width: 400px; width: 100%; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="background: #eafaf1; width: 70px; height: 70px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 15px;">
                <i class="fas fa-user-lock" style="font-size: 30px; color: #2ecc71;"></i>
            </div>
            <h2 style="color: #2c3e50; font-weight: bold; margin: 0;">Welcome Back</h2>
        </div>

        <form action="login.php" method="POST" autocomplete="off">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Username</label>
                <input type="text" name="username" style="width:100%; padding:12px; border: 1px solid #dfe6e9; border-radius: 10px; outline: none;" required>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Password</label>
                <input type="password" name="password" style="width:100%; padding:12px; border: 1px solid #dfe6e9; border-radius: 10px; outline: none;" required>
            </div>

            <button type="submit" name="login" style="width:100%; padding:14px; background:#2ecc71; color:white; border:none; border-radius: 10px; cursor:pointer; font-size: 16px; font-weight: bold;">
                Sign In
            </button>
        </form>

        <?php if ($error): ?>
            <div style="background: #fff5f5; color: #c0392b; padding: 12px; border-radius: 10px; margin-top: 20px; text-align: center; border: 1px solid #f8d7da;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
            <p style="color: #7f8c8d; font-size: 14px;">Don't have an account? <a href="register.php" style="color: #2ecc71; text-decoration: none; font-weight: bold;">Create New Account</a></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>