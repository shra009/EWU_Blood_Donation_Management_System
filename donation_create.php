<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

$message = "";

if (isset($_POST['submit'])) {

    $user_id = $_POST['user_id'];
    $donation_date = $_POST['donation_date'];
    $volume = $_POST['volume'];
    $event_id = !empty($_POST['event_id']) ? $_POST['event_id'] : "NULL";
    $remarks = $_POST['remarks'];

    $insert = "
        INSERT INTO Donation (user_id, donation_date, volume_ml, event_id, remarks)
        VALUES ('$user_id', '$donation_date', '$volume', $event_id, '$remarks')
    ";

    if (mysqli_query($conn, $insert)) {
        header("Location: donation_list.php");
        exit;
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<h2>Add Donation Record</h2>
<a href="donation_list.php">Back to Donation List</a>
<br><br>

<form method="post">

    Donor:<br>
    <select name="user_id" required>
        <?php
        $users = mysqli_query($conn, "SELECT user_id, name FROM Users ORDER BY name");
        while ($u = mysqli_fetch_assoc($users)) {
            echo "<option value='{$u['user_id']}'>{$u['name']}</option>";
        }
        ?>
    </select>
    <br><br>

    Donation Date:<br>
    <input type="date" name="donation_date" required><br><br>

    Volume (ml):<br>
    <input type="number" name="volume" required><br><br>

    Event (Optional):<br>
    <select name="event_id">
        <option value="">None</option>
        <?php
        $events = mysqli_query($conn, "SELECT event_id, event_name FROM Event ORDER BY event_name");
        while ($e = mysqli_fetch_assoc($events)) {
            echo "<option value='{$e['event_id']}'>{$e['event_name']}</option>";
        }
        ?>
    </select><br><br>

    Remarks:<br>
    <textarea name="remarks"></textarea><br><br>

    <input type="submit" name="submit" value="Add Donation">
</form>

<p style="color:red;"><?php echo $message; ?></p>
