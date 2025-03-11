<?php
    require_once 'weltz_dbconnect.php';

    $sql = "SELECT users_tbl.userID, users_tbl.userFname, users_tbl.userLname, users_tbl.userAdd, users_tbl.userPhone, users_tbl.userEmail, users_tbl.userPass, roles_tbl.roleName AS role, users_tbl.createdAt, users_tbl.updatedAt, users_tbl.updID 
            FROM users_tbl 
            JOIN roles_tbl ON users_tbl.role = roles_tbl.roleID";
    $result = $conn->query($sql);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <button type="button" id="sidebarCollapse" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#regNewAdmin">
        <i class="fa-solid fa-user-plus"></i> Register New Admin
    </button>
    <h1>Users Table</h1>
</div>

<div class="container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['userID'] ?></td>
                        <td><?php echo  $row['userFname'] . " " . $row['userLname'] ?></td>
                        <td><?php echo  $row['userAdd'] ?></td>
                        <td><?php echo  $row['userPhone'] ?></td>
                        <td><?php echo  $row['userEmail'] ?></td>
                        <td>undisclosed</td>
                        <td><?php echo  $row['role'] ?></td>
                        <td><?php echo  $row['createdAt'] ?></td>
                        <td><?php echo  $row['updatedAt'] ?></td>
                        <td><?php echo  $row['updID'] ?></td>
                        <td>
                            <div class='d-grid gap-2'>
                                <button class='btn btn-warning'>Edit</button>
                                <button class='btn btn-danger'>Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan='11' class='text-center'>No users found</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
    $conn->close();
?>