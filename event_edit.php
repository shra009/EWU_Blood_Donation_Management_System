<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    echo "Invalid event ID.";
    exit;
}

$event_id = $_GET['id'];

/* Allow only admin + organizer */
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin','organizer'])) {
    echo "Access denied!";
    exit;
}

// Fetch event data
$sql = "SELECT * FROM Event WHERE event_id = $event_id";
$result = mysqli_query($conn, $sql);
$event = mysqli_fetch_assoc($result);

if (!$event) {
    echo "Event not found.";
    exit;
}
?>

<h2>Edit Event</h2>

<form method="post">
    Event Name: <input type="text" name="event_name" value="<?= $event['event_name'] ?>" required><br><br>
    Event Date: <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required><br><br>
    Location: <input type="text" name="location" value="<?= $event['location'] ?>" required><br><br>

    Description:<br>
    <textarea name="description"><?= $event['description'] ?></textarea><br><br>

    Organizer:
    <select name="organizer_id" required>
        <?php
        $users = mysqli_query($conn, "
            SELECT user_id, name FROM Users WHERE role_id IN (1,2)
        ");
        while ($u = mysqli_fetch_assoc($users)) {
            $selected = ($u['user_id'] == $event['organizer_id']) ? "selected" : "";
            echo "<option value='{$u['user_id']}' $selected>{$u['name']}</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="update" value="Update Event">
</form>

<br>
<a href="event_list.php">⬅ Back to Events</a> |
<a href="admin_dashboard.php">🏠 Back to Dashboard</a>

<?php
if (isset($_POST['update'])) {

    $sql = "UPDATE Event SET
            event_name='$_POST[event_name]',
            event_date='$_POST[event_date]',
            location='$_POST[location]',
            description='$_POST[description]',
            organizer_id='$_POST[organizer_id]'
            WHERE event_id=$event_id";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green;'>Event updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: ".mysqli_error($conn)."</p>";
    }
}
?>
