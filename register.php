<?php 
include 'config/db.php'; 
$message = "";

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    try {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$user, $email, $pass])) {
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $message = "<div style='background: #fff5f5; color: #c0392b; padding: 12px; border-radius: 10px; margin-top: 20px; text-align: center; border: 1px solid #f8d7da;'>Error: Username or Email already exists.</div>";
    }
}

include 'includes/header.php'; 
?>

<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; background-color: #f8f9fa;">
    <div style="max-width: 400px; width: 100%; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="background: #eaf2f8; width: 70px; height: 70px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin: 0 auto 15px;">
                <i class="fas fa-user-plus" style="font-size: 30px; color: #3498db;"></i>
            </div>
            <h2 style="color: #2c3e50; font-weight: bold; margin: 0;">Create Account</h2>
        </div>

        <form action="register.php" method="POST" autocomplete="off">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Username</label>
                <input type="text" name="username" style="width:100%; padding:12px; border: 1px solid #dfe6e9; border-radius: 10px; outline: none;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Email Address</label>
                <input type="email" name="email" style="width:100%; padding:12px; border: 1px solid #dfe6e9; border-radius: 10px; outline: none;" required>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #34495e; font-weight: 500;">Password</label>
                <input type="password" name="password" style="width:100%; padding:12px; border: 1px solid #dfe6e9; border-radius: 10px; outline: none;" required>
            </div>

            <button type="submit" name="register" style="width:100%; padding:14px; background:#3498db; color:white; border:none; border-radius: 10px; cursor:pointer; font-size: 16px; font-weight: bold;">
                Register
            </button>
        </form>

        <?php echo $message; ?>

        <div style="text-align: center; margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
            <p style="color: #7f8c8d; font-size: 14px;">Already have an account? <a href="login.php" style="color: #3498db; text-decoration: none; font-weight: bold;">Sign In</a></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>