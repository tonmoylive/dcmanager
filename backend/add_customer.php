<?php
include 'db.php';

$name = $_POST['name'];
$phone = $_POST['phone'];

$stmt = $conn->prepare("INSERT INTO customers (name, phone) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $phone);
$stmt->execute();

echo json_encode(['status' => 'success', 'id' => $stmt->insert_id]);
?>
