<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] == 'organizer') {
    header("Location: organizer_dashboard.php");
    exit;
}

if ($_SESSION['role'] == 'user') {
    header("Location: user_dashboard.php");
    exit;
}

if ($_SESSION['role'] == 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}
?>
