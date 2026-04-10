<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid Request";
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM Donation WHERE donation_id = $id");

header("Location: donation_list.php");
exit;
