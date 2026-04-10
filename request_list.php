<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
?>

<h2>Blood Request List</h2>

<!-- Navigation -->
<a href="dashboard.php">Go back to Dashboard</a>
<a href="request_create.php">Create New Request</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Requester</th>
        <th>Blood Group</th>
        <th>Units Needed</th>
        <th>Urgency</th>
        <th>Needed Date</th>
        <th>Hospital</th>
        <th>Contact Phone</th>
        <th>Status</th>
        <th>Find Donors</th>
        <th>Actions</th>
    </tr>

<?php

// ROLE RULES:
// admin → sees all
// organizer → sees all
// user → sees only own


// FULL ACCESS: SHOW ALL REQUESTS
    $sql = "
        SELECT r.*,
               bg.blood_group,
               u.name AS requester_name
        FROM Blood_Request r
        JOIN Blood_Group bg ON r.blood_group_id = bg.blood_group_id
        JOIN Users u ON r.user_id = u.user_id
        ORDER BY r.request_id DESC
    ";    



$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";

    echo "<td>{$row['request_id']}</td>";
    echo "<td>{$row['requester_name']}</td>";
    echo "<td>{$row['blood_group']}</td>";
    echo "<td>{$row['units_needed']}</td>";
    echo "<td>{$row['urgency_level']}</td>";
    echo "<td>{$row['needed_date']}</td>";
    echo "<td>{$row['hospital_name']}</td>";
    echo "<td>{$row['contact_phone']}</td>";
    echo "<td>{$row['status']}</td>";

    // ⭐ FIND DONORS
    echo "<td><a href='donor_match.php?id={$row['request_id']}'>Find Donors</a></td>";

    // ⭐ ACTIONS
    echo "<td>";

    
   if ($_SESSION['role'] == 'admin' || $_SESSION['user_id'] == $row['user_id']) {

    echo "<a href='request_delete.php?id={$row['request_id']}'
          onclick=\"return confirm('Delete this request?')\">Delete</a>";

} else {
    echo "No action";
}

    echo "</td>";

    echo "</tr>";
}
?>
</table>
