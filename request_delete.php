<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$request_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

/* 
   Only delete if the logged-in user is the owner of this request 
*/
$check = mysqli_query($conn, "
    SELECT * FROM Blood_Request 
    WHERE request_id = $request_id AND user_id = $user_id
");

if (mysqli_num_rows($check) == 0) {
    echo "You are not allowed to delete this request.";
    exit;
}

/* Delete the request */
$delete = mysqli_query($conn, "
    DELETE FROM Blood_Request 
    WHERE request_id = $request_id
");

if ($delete) {
    // Redirect back to the request list
    header("Location: request_list.php");
    exit;
} else {
    echo "Error deleting request: " . mysqli_error($conn);
}
?>
