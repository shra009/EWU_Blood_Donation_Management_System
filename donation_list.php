<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please login first.";
    exit;
}
?>

<h2>Donation Records</h2>
<a href="dashboard.php">Back to Dashboard</a>
<a href="donation_create.php">Add Donation</a>
<br><br>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Donor</th>
    <th>Date</th>
    <th>Volume (ml)</th>
    <th>Event</th>
    <th>Remarks</th>
    <th>Actions</th>
</tr>

<?php
$sql = "
    SELECT d.*, u.name AS donor_name, e.event_name
    FROM Donation d
    JOIN Users u ON d.user_id = u.user_id
    LEFT JOIN Event e ON d.event_id = e.event_id
    where d.user_id=".$_SESSION['user_id']."
    ORDER BY d.donation_date DESC
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";

    echo "<td>{$row['donation_id']}</td>";
    echo "<td>{$row['donor_name']}</td>";
    echo "<td>{$row['donation_date']}</td>";
    echo "<td>{$row['volume_ml']}</td>";
    echo "<td>".($row['event_name'] ?? 'N/A')."</td>";
    echo "<td>{$row['remarks']}</td>";

    echo "<td>
            <a href='donation_edit.php?id={$row['donation_id']}'>Edit</a> |
            <a href='donation_delete.php?id={$row['donation_id']}' onclick=\"return confirm('Delete this donation?')\">Delete</a>
          </td>";

    echo "</tr>";
}
?>
</table>
