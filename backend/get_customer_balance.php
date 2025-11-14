<?php
include 'db.php';

header('Content-Type: application/json');

$customer_id = intval($_GET['customer_id']);

// Calculate totals directly from the transaction history for accuracy
$query = "
    SELECT 
        COALESCE(SUM(CASE WHEN balance_type = 'debit' THEN amount ELSE 0 END), 0) as total_debit,
        COALESCE(SUM(CASE WHEN balance_type = 'credit' THEN amount ELSE 0 END), 0) as total_credit
    FROM 
        balance_history 
    WHERE 
        customer_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$debit = floatval($row['total_debit']);
$credit = floatval($row['total_credit']);
$due_balance = $debit - $credit;

echo json_encode([
    'debit' => $debit,
    'credit' => $credit,
    'due_balance' => $due_balance
]);
?>