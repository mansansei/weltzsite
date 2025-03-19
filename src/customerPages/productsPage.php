<?php
require_once 'weltz_dbconnect.php';
?>

<div class="container-fluid p-5">
    <!-- Header with Title and Search Bar -->
    <div class="row mb-4 border-bottom border-danger">
        <div class="col-md-9">
            <h1 class="fs-1">Product Catalog</h1>
        </div>
        <div class="col-md-3">
            <form class="form-inline" method="POST">
                <div class="input-group">
                    <input class="form-control" type="search" name="productSearch" placeholder="Search products" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="submit" name="searchSubmit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Category Checkboxes -->
        <div class="col-md-3 p-2 bg-light p-3 rounded">
            <form method="POST">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Categories</h4>
                    <button class="btn btn-danger" type="submit" name="filterSubmit">Filter</button>
                </div>
                <div class="list-group">
                    <?php
                    $selectSQL = "SELECT * FROM categories_tbl";
                    $result = $conn->query($selectSQL);

                    foreach ($result as $key) {
                    ?>
                        <div class="list-group-item">
                            <input type="checkbox" id="<?php echo $key['categoryID'] ?>" name="categoryCheck[]" value="<?php echo $key['categoryID'] ?>">
                            <label for="<?php echo $key['categoryID'] ?>"><?php echo $key['categoryName'] ?></label>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>

        <!-- Product Cards -->
        <div class="col-md-9">
            <div class="row">
                <?php
                $selectSQL =
                    "SELECT
                p.productID, 
                p.productIMG, 
                p.productName, 
                c.categoryName, 
                p.productDesc, 
                p.productPrice, 
                p.inStock 
            FROM 
                products_tbl p
            JOIN 
                categories_tbl c ON p.categoryID = c.categoryID";

                // Check if the search input is clicked and not null, change $selectSQL syntax
                if (isset($_POST['searchSubmit']) && !empty($_POST['productSearch'])) {
                    $searchinput = $_POST['productSearch'];
                    $selectSQL .= " WHERE p.productName LIKE ? OR c.categoryName LIKE ?";
                    $stmt = $conn->prepare($selectSQL);
                    $searchTerm = '%' . $searchinput . '%';
                    $stmt->bind_param('ss', $searchTerm, $searchTerm);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } elseif (isset($_POST['filterSubmit']) && !empty($_POST['categoryCheck'])) {
                    $categoryIDs = implode(",", $_POST['categoryCheck']);
                    $selectSQL .= " WHERE p.categoryID IN ($categoryIDs)";
                    $result = $conn->query($selectSQL);
                } else {
                    $selectSQL .= " ORDER BY p.productID DESC";
                    $result = $conn->query($selectSQL);
                }

                // Check if no products are found
                if ($result->num_rows === 0) {
                    echo '<div class="col-12 text-center fs-1"><p>No products that are "' . htmlspecialchars($searchinput) . '"</p></div>';
                } else {
                    foreach ($result as $key) {
                ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?php echo $key['productIMG'] ?>" class="card-img-top img-fluid" alt="<?php echo $key['productName'] ?>">
                                <div class="card-body d-flex flex-column">
                                    <h1 class="card-title fs-5"><?php echo $key['productName'] ?></h1>
                                    <p class="card-text fs-5"><?php echo $key['categoryName'] ?></p>
                                    <p class="card-text fs-5 mb-3">In Stock: <?php echo $key['inStock'] ?></p>
                                    <p class="card-text fs-5 mb-3">PHP <?php echo $key['productPrice'] ?></p>
                                    <div class="d-grid gap-2 mt-auto">
                                        <a href="?page=viewProduct&productID=<?php echo $key['productID']; ?>" class="btn btn-danger">View Product</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>