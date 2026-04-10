<?php
session_start();
include 'db.php';

/* Allow only admin and organizer */
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'organizer'])) {
    echo "Access denied. You are not authorized to create events.";
    exit;
}
?>

<form method="post">
    Event Name: <input type="text" name="event_name" required><br><br>
    Event Date: <input type="date" name="event_date" required><br><br>
    Location: <input type="text" name="location" required><br><br>

    Description:<br>
    <textarea name="description"></textarea><br><br>

    Organizer:
    <select name="organizer_id" required>
        <?php
        // Show only admin + organizer users
        $users = mysqli_query($conn,
            "SELECT user_id, name
             FROM Users
             WHERE role_id IN (1,2)"
        );
        while ($u = mysqli_fetch_assoc($users)) {
            echo "<option value='{$u['user_id']}'>{$u['name']}</option>";
        }
        ?>
    </select><br><br>

    <input type="submit" name="save" value="Create Event">
</form>

<?php
if (isset($_POST['save'])) {

    // Again enforce role (using correct SESSION variable)
    if (!in_array($_SESSION['role'], ['admin', 'organizer'])) {
        echo "Unauthorized action.";
        exit;
    }

    $sql = "INSERT INTO Event (event_name, event_date, location, description, organizer_id)
            VALUES (
                '$_POST[event_name]',
                '$_POST[event_date]',
                '$_POST[location]',
                '$_POST[description]',
                '$_POST[organizer_id]'
            )";

    if (mysqli_query($conn, $sql)) {
        echo "Event created successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
