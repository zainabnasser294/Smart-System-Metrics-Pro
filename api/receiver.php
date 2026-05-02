<?php
header("Content-Type: application/json");
include '../config/db.php'; 


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


if (!$data || !isset($data['api_key'])) {
    echo json_encode(["status" => "error", "message" => "Invalid Data or Missing API Key"]);
    exit;
}

$api_key = $data['api_key'];


$sender_ip = $_SERVER['REMOTE_ADDR']; 


$stmt = $pdo->prepare("SELECT id FROM devices WHERE api_key = ?");
$stmt->execute([$api_key]);
$device = $stmt->fetch();

if ($device) {
    $device_id = $device['id'];
    $cpu = $data['cpu_usage'];
    $ram = $data['ram_usage'];
    
   
    $net_in = $data['bandwidth_usage'] ?? 0; 
    $net_out = $data['packet_count'] ?? 0;   

    
    $sql = "INSERT INTO metrics (device_id, cpu_usage, ram_usage, network_in, network_out) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$device_id, $cpu, $ram, $net_in, $net_out])) {
       
        echo json_encode([
            "status" => "success", 
            "message" => "Data recorded successfully",
            "detected_target_ip" => $sender_ip 
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save data to database"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Unauthorized: API Key not found"]);
}
?>