<?php
include 'db.php';

$customer_id = intval($_GET['customer_id']);

$stmt = $conn->prepare("SELECT * FROM balance_history WHERE customer_id = ? ORDER BY timestamp DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
// The balance history date and time are always stored in GMT +06
date_default_timezone_set('Asia/Dhaka'); 

while ($row = $result->fetch_assoc()) {
    $date = new DateTime($row['timestamp']);
    $row['timestamp'] = $date->format('Y-m-d h:i A');
    $history[] = $row;
}
echo json_encode($history);
?>