<?php
require_once 'weltz_dbconnect.php';

$productsSQL =
    "SELECT
        p.productID, 
        COALESCE(CONCAT(u.userFname, ' ', u.userLname), 'Deleted User') AS userFullName,
        p.productIMG,
        p.productName,
        c.categoryName,
        p.productDesc, 
        p.productSpecs, 
        p.productPrice,
        p.inStock,
        p.prodSold, 
        s.statusID, 
        s.statusName, 
        p.createdAt,
        p.updatedAt
    FROM 
        products_tbl p
    LEFT JOIN 
        users_tbl u ON p.userID = u.userID
    JOIN 
        categories_tbl c ON p.categoryID = c.categoryID
    JOIN
        statuses_tbl s ON p.statusID = s.statusID";

$productsSQLResult = $conn->query($productsSQL);

$categoriesSQL = "SELECT * from categories_tbl";
$categoriesSQLResult = $conn->query($categoriesSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <?php if ($_SESSION['role'] == 3): // Show Add button only to Super Admin 
    ?>
        <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#addNewProdModal">
            <i class="fa-solid fa-box-open"></i> Add a New Product
        </button>
    <?php endif; ?>
    <h1>Products Table</h1>
</div>

<div class="table-container container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Uploader</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Specifications</th>
                <th>Unit Price</th>
                <th>Units in Stock</th>
                <th>Products Sold</th>
                <th>Status</th>
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
                        <td style="max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row['productDesc'] ?></td>
                        <td style="max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row['productSpecs'] ?></td>
                        <td><?php echo $row['productPrice'] ?></td>
                        <td><?php echo $row['inStock'] ?></td>
                        <td><?php echo $row['prodSold'] ?></td>
                        <td><?php echo $row['statusName'] ?></td>
                        <td><?php echo  $row['createdAt'] ?></td>
                        <td><?php echo  $row['updatedAt'] ?></td>
                        <td>
                            <div class='d-grid gap-2'>
                                <?php if ($_SESSION['role'] == 3): // Super Admin 
                                ?>
                                    <?php if ($row['statusID'] == 5): ?>
                                        <button class='editProdBtn btn btn-warning' data-bs-toggle="modal" data-bs-target="#editProdModal">Edit</button>
                                        <button class='delProdBtn btn btn-danger' data-bs-toggle="modal" data-bs-target="#deleteProdModal">Delete</button>
                                    <?php elseif ($row['statusID'] == 6): ?>
                                        <button class='editProdBtn btn btn-warning' data-bs-toggle="modal" data-bs-target="#editProdModal">Edit</button>
                                        <button class='restoreProdBtn btn btn-success' data-bs-toggle="modal" data-bs-target="#restoreProdModal">Restore</button>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted text-center small">Action only available to Super Admin</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<h1 class='text-center'>No products found</h1>";
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
                            <img id="addProdIMGPreview" src="#" alt="Image Preview" style="display:none; max-width: 100%; height: auto;">
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
                                    <option value="" selected>Choose the Category</option>
                                    <?php
                                    if ($categoriesSQLResult->num_rows > 0) {
                                        while ($row = $categoriesSQLResult->fetch_assoc()) {

                                    ?><option value="<?php echo $row['categoryID'] ?>"><?php echo $row['categoryName'] ?></option><?php
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                    ?><option disabled>No categories available.</option><?php
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
                                <label for="prodSpecs" class="form-label">Specification (separate by line)</label>
                                <textarea class="form-control" name="prodSpecs"></textarea>
                                <label class="error-message" for="prodSpecs"></label>
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

<!-- Edit Product Modal -->
<div class="modal fade" id="editProdModal" tabindex="-1" aria-labelledby="editProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editProdModalLabel">Editing Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="signupform" id="editProductForm" method="POST">
                    <div class="row mb-2">
                        <div class="col">
                            <label for="editProdIMG" class="form-label">Product Image</label>
                            <input class="form-control" type="file" id="editProdIMG" name="editProdIMG" accept="images/*">
                            <label class="error-message" for="editProdIMG"></label>
                            <img id="editProdIMGPreview" src="#" alt="Image Preview" style="display:none; max-width: 100%; height: auto;">
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <label for="editProdName" class="form-label">Product Name</label>
                                <input class="form-control" type="text" id="editProdName" name="editProdName">
                                <label class="error-message" for="editProdName"></label>
                            </div>
                            <div class="mb-2">
                                <label for="editProdCategory" class="form-label">Category</label>
                                <select class="form-select" id="editProdCategory" name="editProdCategory">
                                    <option value="" selected>Choose the Category</option>
                                    <?php
                                    // Reset the result pointer to ensure the categories are fetched correctly
                                    $categoriesSQLResult->data_seek(0);

                                    if ($categoriesSQLResult->num_rows > 0) {
                                        while ($catRow = $categoriesSQLResult->fetch_assoc()) {
                                    ?><option value="<?php echo $catRow['categoryID'] ?>"><?php echo $catRow['categoryName'] ?></option><?php
                                                                                                                                    }
                                                                                                                                } else {
                                                                                                                                        ?><option disabled>No categories available.</option><?php
                                                                                                                                                                                                        }
                                                                                                                                                                                                            ?>
                                </select>
                                <label class="error-message" for="editProdCategory"></label>
                            </div>
                            <div class="mb-2">
                                <label for="editProdDesc" class="form-label">Description</label>
                                <textarea class="form-control" id="editProdDesc" name="editProdDesc"></textarea>
                                <label class="error-message" for="editProdDesc"></label>
                            </div>
                            <div class="mb-2">
                                <label for="editprodSpecs" class="form-label">Specification (separate by line)</label>
                                <textarea class="form-control" id="editprodSpecs" name="editprodSpecs"></textarea>
                                <label class="error-message" for="editprodSpecs"></label>
                            </div>
                            <div class="mb-2">
                                <label for="editProdPrice" class="form-label">Unit Price</label>
                                <input class="form-control" type="number" id="editProdPrice" name="editProdPrice">
                                <label class="error-message" for="editProdPrice"></label>
                            </div>
                            <div class="mb-2">
                                <label for="editProdStock" class="form-label">Units in Stock</label>
                                <input class="form-control" type="number" id="editProdStock" name="editProdStock">
                                <label class="error-message" for="editProdStock"></label>
                            </div>
                        </div>
                    </div>
                    <div class='d-grid gap-2 mb-3'>
                        <input type="hidden" id="editProdID" name="editProdID">
                        <input type="hidden" id="action" name="action" value="updateProduct">
                        <button type="submit" name="editProdSubmit" class='btn btn-warning'>Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Products Modal -->
<div class="modal fade" id="deleteProdModal" tabindex="-1" aria-labelledby="deleteProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteProdForm" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteProdModalLabel">Delete Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-3">Are you sure you want to delete this product?</p>
                    <p class="fs-5 text-danger m-0">This action is will archive the product. You may retrieve it later.</p>
                    <input type="hidden" id="deleteProdID" name="productID">
                    <input type="hidden" id="action" name="action" value="deleteProduct">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Restore Products Modal -->
<div class="modal fade" id="restoreProdModal" tabindex="-1" aria-labelledby="restoreProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="restoreProdForm" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="restoreProdModalLabel">Delete Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-3">Would you like to restore this product?</p>
                    <p class="fs-5 text-success m-0">This action will make it visible again to your customers.</p>
                    <input type="hidden" id="restoreProdID" name="productID">
                    <input type="hidden" id="action" name="action" value="restoreProduct">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$conn->close();
?>