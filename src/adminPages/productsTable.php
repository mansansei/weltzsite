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
        p.updatedAt
    FROM 
        products_tbl p
    JOIN 
        users_tbl u ON p.userID = u.userID
    JOIN 
        categories_tbl c ON p.categoryID = c.categoryID
    ";

$productsSQLResult = $conn->query($productsSQL);

$categoriesSQL = "SELECT * from categories_tbl";
$categoriesSQLResult = $conn->query($categoriesSQL);

?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#addNewProdModal">
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

<!-- Add Product Modal -->
<div class="modal fade" id="addNewProdModal" tabindex="-1" aria-labelledby="addNewProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addNewProdModalLabel">Adding New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="signupform" id="addProductForm" method="POST">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="prodIMG" class="form-label">Product Image</label>
                            <input class="form-control" type="file" name="prodIMG" accept="images/*">
                            <label class="error-message" for="prodIMG"></label>
                            <img id="imagePreview" src="#" alt="Image Preview" style="display:none; max-width: 100%; height: auto;">
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <label for="prodName" class="form-label">Product Name</label>
                                <input class="form-control" type="text" name="prodName">
                                <label class="error-message" for="prodName"></label>
                            </div>
                            <div class="mb-2">
                                <label for="prodCategory" class="form-label">Category</label>
                                <select class="form-select" name="prodCategory">
                                    <option selected>Choose the Category</option>
                                    <?php
                                        if ($categoriesSQLResult->num_rows > 0) {
                                            while ($row = $categoriesSQLResult->fetch_assoc()) {
                                                
                                                ?><option value="<?php echo $row['categoryID'] ?>"><?php echo $row['categoryName'] ?></option><?php
                                            }
                                            ?></select><?php
                                        } else {
                                            echo 'No categories available.';
                                        }
                                    ?>
                                </select>
                                <label class="error-message" for="prodCategory"></label>
                            </div>
                            <div class="mb-2">
                                <label for="prodDesc" class="form-label">Description</label>
                                <textarea class="form-control" name="prodDesc"></textarea>
                                <label class="error-message" for="prodDesc"></label>
                            </div>
                            <div class="mb-2">
                                <label for="prodPrice" class="form-label">Unit Price</label>
                                <input class="form-control" type="number" name="prodPrice">
                                <label class="error-message" for="prodPrice"></label>
                            </div>
                            <div class="mb-2">
                                <label for="prodStock" class="form-label">Units in Stock</label>
                                <input class="form-control" type="number" name="prodStock">
                                <label class="error-message" for="prodStock"></label>
                            </div>
                        </div>
                    </div>
                    <div class='d-grid gap-2 mb-3'>
                        <input type="hidden" id="action" name="action" value="addProduct">
                        <button type="submit" name="addProdSubmit" class='btn btn-danger'>Add Product</button>
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