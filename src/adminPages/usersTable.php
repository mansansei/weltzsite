<?php
require_once 'weltz_dbconnect.php';

$usersSQL = "SELECT users_tbl.userID, users_tbl.userFname, users_tbl.userLname, users_tbl.userAdd, users_tbl.userPhone, users_tbl.userEmail, users_tbl.userPass, roles_tbl.roleName AS role, users_tbl.createdAt, users_tbl.updatedAt 
            FROM users_tbl 
            JOIN roles_tbl ON users_tbl.roleID = roles_tbl.roleID";
$usersSQLResult = $conn->query($usersSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <?php if ($_SESSION['role'] == 3): // Show Add button only to Super Admin 
    ?>
        <button type="button" id="sidebarCollapse" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#regNewAdmin">
            <i class="fa-solid fa-user-plus"></i> Register New Admin
        </button>
    <?php endif; ?>
    <h1>Users Table</h1>
</div>

<div class="table-container container-fluid bg-light p-5 rounded shadow">
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
                        <td>
                            <div class='d-grid gap-2'>
                                <?php if ($_SESSION['role'] == 3): // Super Admin 
                                ?>
                                    <button class='editUserBtn btn btn-warning' data-bs-toggle="modal" data-bs-target="#editUser">Edit</button>
                                    <button class='delUserBtn btn btn-danger' data-bs-toggle="modal" data-bs-target="#deleteUserModal">Delete</button>
                                <?php else: ?>
                                    <span class="text-muted text-center small">Action only available to Super Admin</span>
                                <?php endif; ?>
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

<!-- Edit User Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="signupform" id="editUserForm" method="POST">
                    <input type="hidden" id="editUserID" name="userID">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uFname" class="form-label">First Name</label>
                            <input class="form-control" id="editUserFname" type="text" name="uFname">
                            <label class="error-message" for="uFname"></label>
                        </div>
                        <div class="col">
                            <label for="uLname" class="form-label">Last Name</label>
                            <input class="form-control" id="editUserLname" type="text" name="uLname">
                            <label class="error-message" for="uLname"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uAdd" class="form-label">Address</label>
                            <input class="form-control" id="editUserAdd" type="text" name="uAdd">
                            <label class="error-message" for="uAdd"></label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label for="uPhone" class="form-label">Contact No.</label>
                            <input class="form-control" id="editUserPhone" type="tel" name="uPhone">
                            <label class="error-message" for="uPhone"></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="uEmail" class="form-label">Email Address</label>
                            <input class="form-control" id="editUserEmail" type="email" name="uEmail">
                            <label class="error-message" for="uEmail"></label>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col">
                            <label for="uPass" class="form-label">Password</label>
                            <input class="form-control" id="editUserPass" type="password" name="uPass" disabled>
                            <label class="error-message" for="uPass"></label>
                        </div>
                    </div> -->
                    <div class='d-grid gap-2 mb-3'>
                        <input type="hidden" id="action" name="action" value="updateUser">
                        <button type="submit" name="adminRegSubmit" class='btn btn-warning'>Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteUserForm" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-3">Are you sure you want to delete this user?</p>
                    <p class="fs-5 text-danger m-0">This action is irreversable</p>
                    <input type="hidden" id="deleteUserID" name="userID">
                    <input type="hidden" id="action" name="action" value="deleteUser">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$conn->close();
?>