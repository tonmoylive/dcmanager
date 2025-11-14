<?php
include 'db.php';

$customer_id = intval($_POST['customer_id']);

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'error' => 'Database error: ' . $stmt->error]);
}
?>