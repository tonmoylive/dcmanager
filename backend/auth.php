<?php
session_start();

$correct_passkey = "123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_passkey = $_POST['passkey'];

    if ($user_passkey === $correct_passkey) {
        $_SESSION['loggedin'] = true;
        $_SESSION['login_time'] = time();
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../passkey.php?error=1");
        exit;
    }
}
?>