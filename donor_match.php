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

// Get request details
$req = mysqli_query($conn, "
    SELECT r.*, bg.blood_group, u.name AS requester
    FROM Blood_Request r
    JOIN Blood_Group bg ON r.blood_group_id = bg.blood_group_id
    JOIN Users u ON r.user_id = u.user_id
    WHERE r.request_id = $request_id
");

if (mysqli_num_rows($req) == 0) {
    echo "Request not found.";
    exit;
}

$request = mysqli_fetch_assoc($req);
$needed_group = $request['blood_group'];


// --- BLOOD COMPATIBILITY RULES ---
$compatible = [
    'A+'  => ["A+", "A-", "O+", "O-"],
    'A-'  => ["A-", "O-"],
    'B+'  => ["B+", "B-", "O+", "O-"],
    'B-'  => ["B-", "O-"],
    'AB+' => ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"],
    'AB-' => ["A-", "B-", "AB-", "O-"],
    'O+'  => ["O+", "O-"],
    'O-'  => ["O-"]
];

$allowed_groups = "'" . implode("','", $compatible[$needed_group]) . "'";

// Get matching donors
$donors = mysqli_query($conn, "
    SELECT u.user_id, u.name, u.phone, bg.blood_group
    FROM Users u
    JOIN Blood_Group bg ON u.blood_group_id = bg.blood_group_id
    WHERE bg.blood_group IN ($allowed_groups)
      AND u.user_id != {$request['user_id']}
");
?>

<h2>Donor Match Result</h2>

<p><b>Request ID:</b> <?= $request['request_id'] ?></p>
<p><b>Requested By:</b> <?= $request['requester'] ?></p>
<p><b>Blood Needed:</b> <?= $request['blood_group'] ?></p>

<h3>Compatible Donors:</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Blood Group</th>
        <th>Phone</th>
    </tr>

<?php
if (mysqli_num_rows($donors) == 0) {
    echo "<tr><td colspan='3'>No compatible donors found.</td></tr>";
} else {
    while ($d = mysqli_fetch_assoc($donors)) {
        echo "<tr>";
        echo "<td>{$d['name']}</td>";
        echo "<td>{$d['blood_group']}</td>";
        echo "<td>{$d['phone']}</td>";
        echo "</tr>";
    }
}
?>
</table>

<br>
<a href="request_list.php">Back to Request List</a>
