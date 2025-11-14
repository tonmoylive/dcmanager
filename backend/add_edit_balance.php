<?php
include 'db.php';

$conn->query("SET time_zone = '+00:00'");

$customer_id = intval($_POST['customer_id']);
$amount = floatval($_POST['amount']);
$type = $_POST['balance_type'];
$action_type = $_POST['action_type']; // 'add' or 'edit'
$balance_id = isset($_POST['balance_id']) ? intval($_POST['balance_id']) : 0;

if ($action_type === 'edit' && $balance_id > 0) {
    // Update the existing transaction in the history
    $stmt = $conn->prepare("UPDATE balance_history SET amount = ?, balance_type = ?, timestamp = NOW() WHERE id = ?");
    $stmt->bind_param("dsi", $amount, $type, $balance_id);
    $stmt->execute();
} else {
    // Add a new transaction to the history
    $stmt = $conn->prepare("INSERT INTO balance_history (customer_id, balance_type, amount, action_type) VALUES (?, ?, ?, 'add')");
    $stmt->bind_param("isd", $customer_id, $type, $amount);
    $stmt->execute();
}

echo json_encode(['status' => 'success']);
?>