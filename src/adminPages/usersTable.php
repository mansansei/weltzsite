<?php
require_once 'weltz_dbconnect.php';

$usersSQL = "SELECT users_tbl.userID, users_tbl.userFname, users_tbl.userLname, users_tbl.userAdd, users_tbl.userPhone, users_tbl.userEmail, users_tbl.userPass, roles_tbl.roleName AS role, users_tbl.createdAt, users_tbl.updatedAt, users_tbl.updID 
            FROM users_tbl 
            JOIN roles_tbl ON users_tbl.roleID = roles_tbl.roleID";
$usersSQLResult = $conn->query($usersSQL);
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
            if ($usersSQLResult->num_rows > 0) {
                while ($row = $usersSQLResult->fetch_assoc()) {
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
                <h1 class="text-center">No users found</h1>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Register Admin Modal -->
<div class="modal fade" id="regNewAdmin" tabindex="-1" aria-labelledby="regNewAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="regNewAdminLabel">Register a New Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="signupform" id="adminSignupForm" method="POST">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uFname" class="form-label">First Name</label>
                            <input class="form-control" type="text" name="uFname">
                            <label class="error-message" for="uFname"></label>
                        </div>
                        <div class="col">
                            <label for="uLname" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="uLname">
                            <label class="error-message" for="uLname"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uAdd" class="form-label">Address</label>
                            <input class="form-control" type="text" name="uAdd">
                            <label class="error-message" for="uAdd"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uPhone" class="form-label">Contact No.</label>
                            <input class="form-control" type="tel" name="uPhone">
                            <label class="error-message" for="uPhone"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uEmail" class="form-label">Email Address</label>
                            <input class="form-control" type="email" name="uEmail">
                            <label class="error-message" for="uEmail"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="uPass" class="form-label">Password</label>
                            <input class="form-control" type="password" name="uPass">
                            <label class="error-message" for="uPass"></label>
                        </div>
                    </div>
                    <div class='d-grid gap-2 mb-3'>
                        <input type="hidden" id="action" name="action" value="regAdmin">
                        <button type="submit" name="adminRegSubmit" class='btn btn-danger'>Register</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
?>