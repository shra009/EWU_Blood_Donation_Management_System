<?php
include 'db.php';

$message = "";

// Get the 'user' role ID (default for public registration)
$role_result = mysqli_query($conn, "SELECT role_id FROM Role WHERE role_name='user'");
$role_row = mysqli_fetch_assoc($role_result);
$role_id = $role_row['role_id'];

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $des_id = $_POST['des_id'];
    $blood_group_id = $_POST['blood_group_id'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $password = $_POST['password']; // plain text for simplicity

    // Insert user with fixed role = 'user'
    $query = "INSERT INTO Users (name,email,phone,des_id,role_id,blood_group_id,dob,gender,password)
              VALUES ('$name','$email','$phone',$des_id,$role_id,$blood_group_id,'$dob','$gender','$password')";

    if (mysqli_query($conn, $query)) {
        $message = "User registered successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
<h2>Register New User</h2>

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
    <input type="password" name="password" required><br><br>

    <input type="submit" name="register" value="Register User">
</form>

<p style="color:green;"><?php echo $message; ?></p>

<p><a href="login.php">Back to Login</a></p>
</body>
</html>
