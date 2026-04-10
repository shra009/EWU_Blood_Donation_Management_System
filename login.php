<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT u.user_id, u.name, u.password, r.role_name
              FROM Users u
              JOIN Role r ON u.role_id = r.role_id
              WHERE u.email='$email' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) { // plain-text match
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role_name'];

            // 👉 ALWAYS redirect to dashboard.php
            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Blood Donation Management System</h2>
<h3>Login</h3>

<form method="post">
    Email:<br>
    <input type="email" name="email" required><br><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" name="login" value="Login">
</form>
<a href="registration.php">Register here</a></li>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
