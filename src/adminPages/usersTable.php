<?php
    $con = mysqli_connect("localhost", "root", "", "weltz_db");

    $sql = "SELECT userID, userFname, userLname, userAdd, userPhone, userEmail, userPass, role, createdAt, updatedAt, updID FROM users_tbl";
    $result = $con->query($sql);
?>
    <div class="userstitle text-end mb-3">
        <h1>Users Table</h1>
    </div>

    <div class="container-fluid">
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
                        echo "<tr>";
                        echo "<td>" . $row['userID'] . "</td>";
                        echo "<td>" . $row['userFname'] . " " . $row['userLname'] . "</td>";
                        echo "<td>" . $row['userAdd'] . "</td>";
                        echo "<td>" . $row['userPhone'] . "</td>";
                        echo "<td>" . $row['userEmail'] . "</td>";
                        echo "<td>undisclosed</td>";
                        echo "<td>" . $row['role'] . "</td>";
                        echo "<td>" . $row['createdAt'] . "</td>";
                        echo "<td>" . $row['updatedAt'] . "</td>";
                        echo "<td>" . $row['updID'] . "</td>";
                        echo "<td>
                                <div class='d-grid gap-2'>
                                    <button class='btn btn-warning'>Edit</button>
                                    <button class='btn btn-danger'>Delete</button>
                                </div>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11' class='text-center'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
    $con->close();
?>