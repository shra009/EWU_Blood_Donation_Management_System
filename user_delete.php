<?php
include 'db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Optional: prevent admin from deleting themselves (if you have login)
    // session_start();
    // if ($user_id == $_SESSION['user_id']) { die("Cannot delete yourself!"); }

    $delete = mysqli_query($conn, "DELETE FROM Users WHERE user_id=$user_id");

    if ($delete) {
        header("Location: user_list.php"); // redirect after deletion
        exit;
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}
?>
