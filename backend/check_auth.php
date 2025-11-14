<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: passkey.html');
    exit;
}

// Check if the session has expired (30 minutes).
$session_duration = 30 * 60; // 30 minutes in seconds
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > $session_duration)) {
    session_unset();
    session_destroy();
    header('Location: passkey.html?expired=1');
    exit;
}
?>