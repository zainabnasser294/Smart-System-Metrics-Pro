<?php
header("Content-Type: application/json");
include '../config/db.php'; 

// 1. استقبال البيانات الخام (JSON) القادمة من سكريبت البايثون
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// 2. التحقق من صحة البيانات ووجود الـ API Key
if (!$data || !isset($data['api_key'])) {
    echo json_encode(["status" => "error", "message" => "Invalid Data or Missing API Key"]);
    exit;
}

$api_key = $data['api_key'];
$sender_ip = $_SERVER['REMOTE_ADDR']; // تحديد IP الجهاز الذي أرسل البيانات

// 3. البحث عن الجهاز في قاعدة البيانات باستخدام الـ Key
$stmt = $pdo->prepare("SELECT id FROM devices WHERE api_key = ?");
$stmt->execute([$api_key]);
$device = $stmt->fetch();

if ($device) {
    $device_id = $device['id'];
    $cpu = $data['cpu_usage'];
    $ram = $data['ram_usage'];
    
    // سحب بيانات الشبكة (الباندويث وعدد الحزم)
    $net_in = $data['bandwidth_usage'] ?? 0; 
    $net_out = $data['packet_count'] ?? 0;   

    // 4. إدخال البيانات في جدول metrics لعرض الرسوم البيانية لاحقاً
    $sql = "INSERT INTO metrics (device_id, cpu_usage, ram_usage, network_in, network_out) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$device_id, $cpu, $ram, $net_in, $net_out])) {
        
        // 5. التحديث الأهم: تحويل حالة الجهاز إلى Online وتحديث وقت آخر ظهور والـ IP
        $update_sql = "UPDATE devices SET status = 'online', last_seen = NOW(), ip_address = ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([$sender_ip, $device_id]);

        echo json_encode([
            "status" => "success", 
            "message" => "Data recorded and status updated to Online",
            "detected_target_ip" => $sender_ip 
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save metrics"]);
    }
} else {
    // إذا كان الـ API Key المكتوب في البايثون غير موجود في جدول devices
    echo json_encode(["status" => "error", "message" => "Unauthorized: API Key not found in database"]);
}
?>