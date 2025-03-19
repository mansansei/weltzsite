<?php
require_once 'weltz_dbconnect.php';

$ordersSQL =
    "SELECT 
            ci.*, 
            c.*, 
            p.productName, 
            CONCAT(u.userFname, ' ', u.userLname) AS userFullName, 
            cat.categoryName 
        FROM 
            cart_items_tbl AS ci
        JOIN 
            carts_tbl AS c ON ci.cartID = c.cartID
        JOIN 
            products_tbl AS p ON ci.productID = p.productID
        JOIN 
            users_tbl AS u ON c.userID = u.userID
        JOIN 
            categories_tbl AS cat ON p.categoryID = cat.categoryID
    ";

$ordersSQLResult = $conn->query($ordersSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <h1>Cart Items Table</h1>
</div>

<div class="table-container container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Cart Item ID</th>
                <th>Cart ID</th>
                <th>Cart Owner</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total</th>
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
                        <td><?php echo $row['cartItemID'] ?></td>
                        <td><?php echo $row['cartID'] ?></td>
                        <td><?php echo $row['userFullName'] ?></td>
                        <td><?php echo $row['productName'] ?></td>
                        <td><?php echo $row['cartItemQuantity'] ?></td>
                        <td><?php echo $row['cartItemTotal'] ?></td>
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