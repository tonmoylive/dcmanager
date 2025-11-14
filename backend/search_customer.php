<?php
include 'db.php';

$search = "%" . $_GET['q'] . "%";;
$stmt = $conn->prepare("SELECT * FROM customers WHERE name LIKE ? ORDER BY id DESC");
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$customers = [];
while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}
echo json_encode($customers);
?>
