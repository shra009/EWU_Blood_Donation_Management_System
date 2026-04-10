<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'organizer'])) {
    echo "Access denied.";
    exit;
}

$event_id = $_GET['id'];

$sql = "DELETE FROM Event WHERE event_id = $event_id";

if (mysqli_query($conn, $sql)) {
    echo "Event deleted successfully.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>

<br><br>
<a href="event_list.php">Back to Events</a>
