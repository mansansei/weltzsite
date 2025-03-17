<?php
require_once 'weltz_dbconnect.php';

$ordersSQL =
    "SELECT
        o.orderID, 
        CONCAT(u.userFname, ' ', u.userLname) AS userFullName, 
        p.productName, 
        o.orderQuantity, 
        o.orderTotal, 
        mop.mopName, 
        os.statusName, 
        o.createdAt, 
        o.updatedAt 
    FROM 
        orders_tbl o 
    JOIN 
        users_tbl u ON o.userID = u.userID 
    JOIN 
        products_tbl p ON o.productID = p.productID 
    JOIN 
        order_statuses_tbl os ON o.statusID = os.statusID 
    JOIN 
        modes_of_payment_tbl mop ON o.mopID = mop.mopID
    ";

$ordersSQLResult = $conn->query($ordersSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <h1>Orders Table</h1>
</div>

<div class="table-container container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Mode of Payment</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            if ($ordersSQLResult->num_rows > 0) {
                while ($row = $ordersSQLResult->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['orderID'] ?></td>
                        <td><?php echo $row['userFullName'] ?></td>
                        <td><?php echo $row['productName'] ?></td>
                        <td><?php echo $row['orderQuantity'] ?></td>
                        <td><?php echo $row['orderTotal'] ?></td>
                        <td><?php echo $row['mopName'] ?></td>
                        <td><?php echo $row['statusName'] ?></td>
                        <td><?php echo  $row['createdAt'] ?></td>
                        <td><?php echo  $row['updatedAt'] ?></td>
                        <!-- <td>
                            <div class='d-grid gap-2'>
                                <button class='btn btn-success'>Approve</button>
                                <button class='btn btn-danger'>Deny</button>
                            </div>
                        </td> -->
                    </tr>
                <?php
                }
            } else {
                ?>
                <h1 class="text-center">No orders found</h1>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>