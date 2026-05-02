<?php 

session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
include 'includes/header.php'; 
include 'config/db.php'; 
?>

<div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2>Add New Device (Admin Base)</h2>
    <p>Register a new machine to start monitoring its behavior.</p>
    
    <form action="" method="POST">
        <label>Device Name:</label>
        <input type="text" name="device_name" style="width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px;" placeholder="e.g. Server_Alpha" required>
        
        <label>Device IP:</label>
        <input type="text" name="device_ip" style="width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px;" placeholder="e.g. 192.168.1.5" required>
        
        <button type="submit" name="add_device" style="background:#2ecc71; color:white; padding:12px; border:none; width:100%; cursor:pointer; font-weight:bold; border-radius:5px;">Register Device</button>
    </form>

    <?php
    if (isset($_POST['add_device'])) {
        $name = $_POST['device_name'];
        $ip = $_POST['device_ip'];
        $key = bin2hex(random_bytes(16)); 

        try {
            $sql = "INSERT INTO devices (device_name, device_ip, api_key) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$name, $ip, $key])) {
                echo "<div style='margin-top:20px; padding:15px; background:#d4edda; border-left:5px solid #28a745;'>";
                echo "<strong>Success!</strong> Device added.<br>";
                echo "API Key: <code style='background:#eee; padding:2px 5px;'>$key</code><br>";
                echo "</div>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</div>

<?php 

include 'includes/footer.php'; 
?>