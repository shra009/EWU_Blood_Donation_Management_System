<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}
?>

<h2>Create Blood Request</h2>

<form method="post">

    Needed Date: <input type="date" name="needed_date" required><br><br>

    Urgency:
    <select name="urgency_level" required>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select><br><br>

    Blood Group:
    <select name="blood_group_id" required>
        <?php
        $bg = mysqli_query($conn, "SELECT * FROM Blood_Group");
        while ($row = mysqli_fetch_assoc($bg)) {
            echo "<option value='{$row['blood_group_id']}'>{$row['blood_group']}</option>";
        }
        ?>
    </select><br><br>

    Units Needed:
    <input type="number" name="units_needed" min="1" required><br><br>

    Contact Phone:
    <input type="text" name="contact_phone" required><br><br>

    Hospital Name:
    <input type="text" name="hospital_name" required><br><br>

    <input type="submit" name="save" value="Submit Request">
</form>

<?php
if (isset($_POST['save'])) {

    $sql = "
        INSERT INTO Blood_Request 
        (user_id, blood_group_id, urgency_level, needed_date, status, contact_phone, hospital_name, units_needed)
        VALUES (
            {$_SESSION['user_id']},
            {$_POST['blood_group_id']},
            '{$_POST['urgency_level']}',
            '{$_POST['needed_date']}',
            'pending',
            '{$_POST['contact_phone']}',
            '{$_POST['hospital_name']}',
            {$_POST['units_needed']}
        )
    ";

    if (mysqli_query($conn, $sql)) {
        echo "Blood request submitted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<br><br>
<a href="request_list.php">Back to Requests</a>
