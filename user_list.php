<?php
include 'db.php';

// Fetch all users with related info from dimension tables
$result = mysqli_query($conn,
    "SELECT u.user_id, u.name, u.email, u.phone, u.dob, u.gender,
            d.des_name, r.role_name, b.blood_group
     FROM Users u
     LEFT JOIN designation d ON u.des_id=d.des_id
     LEFT JOIN Role r ON u.role_id=r.role_id
     LEFT JOIN Blood_Group b ON u.blood_group_id=b.blood_group_id
     ORDER BY u.user_id ASC"
);
?>

<p><a href="admin_dashboard.php">Back to Dashboard</a></p>

<h2>All Users</h2>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Designation</th>
    <th>Role</th>
    <th>Blood Group</th>
    <th>DOB</th>
    <th>Gender</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['user_id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><?= $row['des_name'] ?></td>
    <td><?= $row['role_name'] ?></td>
    <td><?= $row['blood_group'] ?></td>
    <td><?= $row['dob'] ?></td>
    <td><?= $row['gender'] ?></td>
    <td>
        <a href="user_edit.php?id=<?= $row['user_id'] ?>">Edit</a> |
        <a href="user_delete.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

<p><a href="user_createByadmin.php">Create New User</a></p>
