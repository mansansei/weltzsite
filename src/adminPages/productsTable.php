<?php
require_once 'weltz_dbconnect.php';

$productsSQL =
    "SELECT
        p.productID, 
        CONCAT(u.userFname, ' ', u.userLname) AS userFullName,
        p.productIMG,
        p.productName,
        c.categoryName,
        p.productDesc,
        p.productPrice,
        p.inStock,
        p.createdAt,
        p.updatedAt,
        p.updID 
    FROM 
        products_tbl p
    JOIN 
        users_tbl u ON p.userID = u.userID
    JOIN 
        categories_tbl c ON p.categoryID = c.categoryID
    ";

$productsSQLResult = $conn->query($productsSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#regNewAdmin">
        <i class="fa-solid fa-box-open"></i> Add a New Product
    </button>
    <h1>Products Table</h1>
</div>

<div class="container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Uploader</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Unit Price</th>
                <th>Units in Stock</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Update ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($productsSQLResult->num_rows > 0) {
                while ($row = $productsSQLResult->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['productID'] ?></td>
                        <td><?php echo $row['userFullName'] ?></td>
                        <td><img src="<?php echo $row['productIMG'] ?>" alt="<?php echo $row['productName'] ?>" style="width:100px"></td>
                        <td><?php echo $row['productName'] ?></td>
                        <td><?php echo $row['categoryName'] ?></td>
                        <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo $row['productDesc'] ?>
                        </td>
                        <td><?php echo $row['productPrice'] ?></td>
                        <td><?php echo $row['inStock'] ?></td>
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
                <h1 class="text-center">No products found</h1>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>