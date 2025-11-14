<?php
include 'db.php';

$customer_id = $_POST['customer_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];

$sql = "UPDATE customers SET name = ?, phone = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $name, $phone, $customer_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>