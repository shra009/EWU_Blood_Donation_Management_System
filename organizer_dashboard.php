<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer') {
    echo "Access denied.";
    exit;
}
?>

<h2>Organizer Dashboard</h2>

<ul>
    <li><a href="event_list.php">Manage Event </a></li>
    <li><a href="request_list.php">All Blood Requests</a></li>
    <li><a href="donation_list.php">Manage Donation</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
