<?php
$host = "sql101.infinityfree.com";
$db = "if0_39991955_store_db";
$user = "if0_39991955";
$pass = "Bryn9009";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
