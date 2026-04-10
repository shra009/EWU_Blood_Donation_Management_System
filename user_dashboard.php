<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    echo "Access denied.";
    exit;
}
?>

<h2>User Dashboard</h2>

<ul>
    <li><a href="request_create.php">Create Blood Request</a></li>
    <li><a href="request_list.php">My Requests</a></li>
    <li><a href="donation_list.php">Manage Donation</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
