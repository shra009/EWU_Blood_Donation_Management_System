<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<h1>Admin Dashboard</h1>
<a href="logout.php">Logout</a>
<hr>

<h2>System Overview</h2>

<?php

// Total Users
$q1  = "SELECT COUNT(*) AS total FROM Users";
$r1  = mysqli_query($conn, $q1);
$row1 = mysqli_fetch_assoc($r1);
$total_users = $row1['total'];

// Total Events
$q2  = "SELECT COUNT(*) AS total FROM Event";
$r2  = mysqli_query($conn, $q2);
$row2 = mysqli_fetch_assoc($r2);
$total_events = $row2['total'];

// Total Donations
$q3  = "SELECT COUNT(*) AS total FROM Donation";
$r3  = mysqli_query($conn, $q3);
$row3 = mysqli_fetch_assoc($r3);
$total_donations = $row3['total'];

// Total Blood Requests
$q4  = "SELECT COUNT(*) AS total FROM Blood_Request";
$r4  = mysqli_query($conn, $q4);
$row4 = mysqli_fetch_assoc($r4);
$total_requests = $row4['total'];



$eligible_donors = mysqli_fetch_row(mysqli_query($conn,
    "SELECT COUNT(DISTINCT user_id) 
     FROM Eligibility 
     WHERE eligibility_flag='eligible'"
))[0];

$pending_requests = mysqli_fetch_row(mysqli_query($conn,
    "SELECT COUNT(*) 
     FROM Blood_Request 
     WHERE status='pending'"
))[0];
?>

<table border="1">
<tr><td>Total Users</td><td><?= $total_users ?></td></tr>
<tr><td>Total Events</td><td><?= $total_events ?></td></tr>
<tr><td>Total Donations</td><td><?= $total_donations ?></td></tr>
<tr><td>Total Blood Requests</td><td><?= $total_requests ?></td></tr>
<tr><td>Eligible Donors</td><td><?= $eligible_donors ?></td></tr>
<tr><td>Pending Requests</td><td><?= $pending_requests ?></td></tr>
</table>

<hr>

<h2>Recent Donations</h2>

<table border="1">
<tr>
    <th>Donor</th>
    <th>Date</th>
    <th>Volume</th>
</tr>

<?php
$recent = mysqli_query($conn,
    "SELECT d.donation_date, d.volume_ml, u.name
     FROM Donation d
     JOIN Users u ON d.user_id = u.user_id
     ORDER BY d.donation_date DESC
     LIMIT 5"
);

while ($r = mysqli_fetch_assoc($recent)) {
    echo "<tr>
            <td>{$r['name']}</td>
            <td>{$r['donation_date']}</td>
            <td>{$r['volume_ml']} ml</td>
        </tr>";
}
?>
</table>

<hr>

<h2>High Urgency Requests</h2>

<table border="1">
<tr>
    <th>Requester</th>
    <th>Blood Group</th>
    <th>Needed Date</th>
    <th>Status</th>
</tr>

<?php
$req = mysqli_query($conn,
    "SELECT u.name, bg.blood_group, r.needed_date, r.status
     FROM Blood_Request r
     JOIN Users u ON r.user_id=u.user_id
     JOIN Blood_Group bg ON r.blood_group_id=bg.blood_group_id
     WHERE r.urgency_level='high'
     ORDER BY r.needed_date ASC"
);

while ($r = mysqli_fetch_assoc($req)) {
    echo "<tr>
            <td>{$r['name']}</td>
            <td>{$r['blood_group']}</td>
            <td>{$r['needed_date']}</td>
            <td>{$r['status']}</td>
    </tr>";
}
?>
</table>

<hr>

<h2>Event-wise Donation Summary</h2>

<form method="get">
    Select Event:
    <select name="event_id">
        <option value="">All</option>
        <?php
        $ev = mysqli_query($conn, "SELECT event_id, event_name FROM Event");
        while ($e = mysqli_fetch_assoc($ev)) {
            $sel = (isset($_GET['event_id']) && $_GET['event_id']==$e['event_id']) ? "selected" : "";
            echo "<option value='{$e['event_id']}' $sel>{$e['event_name']}</option>";
        }
        ?>
    </select>
    <input type="submit" value="Filter">
</form>

<br>

<?php
$where = "";
if (!empty($_GET['event_id'])) $where="WHERE d.event_id=".intval($_GET['event_id']);

$res = mysqli_query($conn,
    "SELECT e.event_name, COUNT(d.donation_id) AS total
     FROM Donation d
     JOIN Event e ON d.event_id=e.event_id
     $where
     GROUP BY e.event_id"
);
?>

<table border="1">
<tr><th>Event</th><th>Total Donations</th></tr>

<?php
if (mysqli_num_rows($res)) {
    while ($r=mysqli_fetch_assoc($res)) {
        echo "<tr><td>{$r['event_name']}</td><td>{$r['total']}</td></tr>";
    }
} else {
    echo "<tr><td colspan='2'>No donations found</td></tr>";
}
?>
</table>

<hr>

<h2>Quick Navigation</h2>

<ul>
    <li><a href="user_list.php">Manage Users</a></li>
    <li><a href="event_list.php">Manage Events</a></li>
    <li><a href="screening_list.php">Health Screening</a></li>
    <li><a href="eligibility_list.php">Eligibility</a></li>
    <li><a href="donation_list.php">Donations</a></li>
    <li><a href="request_list.php">Blood Requests</a></li>
    
</ul>
