<?php
include 'config/db.php';


$device_id = $_GET['id'] ?? 1;


$sql = "SELECT 
            cpu_usage, 
            ram_usage, 
            network_in AS bandwidth_usage, 
            network_out AS packet_count, 
            captured_at 
        FROM metrics 
        WHERE device_id = ? 
        ORDER BY id DESC 
        LIMIT 20";

$stmt = $pdo->prepare($sql);
$stmt->execute([$device_id]);


$results = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));


header('Content-Type: application/json');
echo json_encode($results);
?>