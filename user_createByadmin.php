<?php
session_start();
include 'db.php';

// Protect page: only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$message = "";

if (isset($_POST['create_user'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $des_id = $_POST['des_id'];
    $role_id = $_POST['role_id'];
    $blood_group_id = $_POST['blood_group_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = $_POST['password']; // simple plain text

    // Insert user
    $query = "INSERT INTO Users (name,email,phone,des_id,role_id,blood_group_id,dob,gender,password)
              VALUES ('$name','$email','$phone',$des_id,$role_id,$blood_group_id,'$dob','$gender','$password')";

    if (mysqli_query($conn, $query)) {
        $message = "User created successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User - Admin</title>
</head>
<body>
<h2>Create New User (Admin Panel)</h2>

<form method="post">
    Name:<br>
    <input type="text" name="name" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    Phone:<br>
    <input type="text" name="phone"><br><br>

    Designation:<br>
    <select name="des_id" required>
        <?php
        $des = mysqli_query($conn, "SELECT * FROM designation");
        while ($d = mysqli_fetch_assoc($des)) {
            echo "<option value='{$d['des_id']}'>{$d['des_name']}</option>";
        }
        ?>
    </select><br><br>

    Role:<br>
    <select name="role_id" required>
        <?php
        $roles = mysqli_query($conn, "SELECT * FROM Role");
        while ($r = mysqli_fetch_assoc($roles)) {
            echo "<option value='{$r['role_id']}'>{$r['role_name']}</option>";
        }
        ?>
    </select><br><br>

    Blood Group:<br>
    <select name="blood_group_id">
        <option value="">Select</option>
        <?php
        $bgs = mysqli_query($conn, "SELECT * FROM Blood_Group");
        while ($bg = mysqli_fetch_assoc($bgs)) {
            echo "<option value='{$bg['blood_group_id']}'>{$bg['blood_group']}</option>";
        }
        ?>
    </select><br><br>

    Date of Birth:<br>
    <input type="date" name="dob"><br><br>

    Gender:<br>
    <select name="gender">
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br><br>

    Password:<br>
    <input type="text" name="password" required><br><br>

    <input type="submit" name="create_user" value="Create User">
</form>

<p style="color:green;"><?php echo $message; ?></p>

<p><a href="admin_dashboard.php">Back to Admin Dashboard</a></p>
</body>
</html>
