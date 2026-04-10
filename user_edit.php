<?php
include 'db.php';

$id = $_GET['id'];

// Fetch user data with related dimension info
$user_result = mysqli_query($conn,
    "SELECT * FROM Users WHERE user_id=$id");
$user = mysqli_fetch_assoc($user_result);

$message = "";

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $des_id = $_POST['des_id'];
    $role_id = $_POST['role_id'];
    $blood_group_id = $_POST['blood_group_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $update = mysqli_query($conn,
        "UPDATE Users SET
            name='$name',
            email='$email',
            phone='$phone',
            des_id=$des_id,
            role_id=$role_id,
            blood_group_id=$blood_group_id,
            dob='$dob',
            gender='$gender'
         WHERE user_id=$id"
    );

    if ($update) {
        $message = "User updated successfully!";
        // Refresh data
        $user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM Users WHERE user_id=$id"));
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
<h2>Edit User</h2>

<p style="color:green;"><?php echo $message; ?></p>

<form method="post">
    Name:<br>
    <input type="text" name="name" value="<?= $user['name'] ?>" required><br><br>

    Email:<br>
    <input type="email" name="email" value="<?= $user['email'] ?>" required><br><br>

    Phone:<br>
    <input type="text" name="phone" value="<?= $user['phone'] ?>"><br><br>

    Designation:<br>
    <select name="des_id" required>
        <?php
        $des = mysqli_query($conn, "SELECT * FROM designation");
        while ($d = mysqli_fetch_assoc($des)) {
            $sel = ($d['des_id'] == $user['des_id']) ? "selected" : "";
            echo "<option value='{$d['des_id']}' $sel>{$d['des_name']}</option>";
        }
        ?>
    </select><br><br>

    Role:<br>
    <select name="role_id" required>
        <?php
        $roles = mysqli_query($conn, "SELECT * FROM Role");
        while ($r = mysqli_fetch_assoc($roles)) {
            $sel = ($r['role_id'] == $user['role_id']) ? "selected" : "";
            echo "<option value='{$r['role_id']}' $sel>{$r['role_name']}</option>";
        }
        ?>
    </select><br><br>

    Blood Group:<br>
    <select name="blood_group_id">
        <option value="">Select</option>
        <?php
        $bgs = mysqli_query($conn, "SELECT * FROM Blood_Group");
        while ($bg = mysqli_fetch_assoc($bgs)) {
            $sel = ($bg['blood_group_id'] == $user['blood_group_id']) ? "selected" : "";
            echo "<option value='{$bg['blood_group_id']}' $sel>{$bg['blood_group']}</option>";
        }
        ?>
    </select><br><br>

    Date of Birth:<br>
    <input type="date" name="dob" value="<?= $user['dob'] ?>"><br><br>

    Gender:<br>
    <select name="gender">
        <option value="">Select</option>
        <option value="Male" <?= ($user['gender']=='Male')?'selected':'' ?>>Male</option>
        <option value="Female" <?= ($user['gender']=='Female')?'selected':'' ?>>Female</option>
        <option value="Other" <?= ($user['gender']=='Other')?'selected':'' ?>>Other</option>
    </select><br><br>

    <input type="submit" name="update" value="Update User">
</form>

<p><a href="user_list.php">Back to User List</a></p>
</body>
</html>
