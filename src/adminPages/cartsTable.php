<?php
require_once 'weltz_dbconnect.php';

$cartsSQL =
    "SELECT
        c.cartID, 
        CONCAT(u.userFname, ' ', u.userLname) AS userFullName,
        c.createdAt,
        c.updatedAt 
    FROM 
        carts_tbl c
    JOIN 
        users_tbl u ON c.userID = u.userID
    ";

$cartsSQLResult = $conn->query($cartsSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <h1>Carts Table</h1>
</div>

<div class="container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cart ID</th>
                <th>Cart of</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($cartsSQLResult->num_rows > 0) {
                while ($row = $cartsSQLResult->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['cartID'] ?></td>
                        <td><?php echo $row['userFullName'] ?></td>
                        <td><?php echo  $row['createdAt'] ?></td>
                        <td><?php echo  $row['updatedAt'] ?></td>
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
                <h1 class="text-center">No carts found</h1>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>