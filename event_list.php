<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Dashboard link (based on role)
$dashboard = "dashboard.php";

?>

<a href="<?= $dashboard ?>">⬅ Back to Dashboard</a>
<br><br>

<h2>Event List</h2>

<!-- Create Event Button (only admin or organizer) -->
<?php if (in_array($_SESSION['role'], ['admin', 'organizer'])) { ?>
    <a href="event_create.php">Create New Event</a><br><br>
<?php } ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Event Name</th>
        <th>Date</th>
        <th>Location</th>
        <th>Organizer</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

<?php
$sql = "
    SELECT e.*, u.name AS organizer_name
    FROM Event e
    JOIN Users u ON e.organizer_id = u.user_id
    ORDER BY e.event_id DESC
";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['event_id']}</td>";
    echo "<td>{$row['event_name']}</td>";
    echo "<td>{$row['event_date']}</td>";
    echo "<td>{$row['location']}</td>";
    echo "<td>{$row['organizer_name']}</td>";
    echo "<td>{$row['description']}</td>";

    echo "<td>";
    if (in_array($_SESSION['role'], ['admin', 'organizer'])) {
        echo "<a href='event_edit.php?id={$row['event_id']}'>Edit</a> | ";
        echo "<a href='event_delete.php?id={$row['event_id']}' onclick=\"return confirm('Delete this event?')\">Delete</a>";
    } else {
        echo "View only";
    }
    echo "</td>";

    echo "</tr>";
}
?>
</table>
