<?php
require_once 'weltz_dbconnect.php';
?>

<style>
    /* Overlay for out-of-stock products */
    .out-of-stock-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.5rem;
        font-weight: bold;
        text-transform: uppercase;
        pointer-events: auto;
    }

    /* Prevent interactions on out-of-stock products */
    .out-of-stock {
        position: relative;
        pointer-events: none;
    }
</style>

<div class="container-fluid p-5 min-vh-100">
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
                            <label for="<?php echo $key['categoryID'] ?>"><?php echo htmlspecialchars($key['categoryName']) ?></label>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>

        <div class="col-md-9">
            <div class="row">
                <?php
                // Fetch products including those with 0 stock
                $selectSQL = "
                    SELECT 
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
                        categories_tbl c ON p.categoryID = c.categoryID
                    ORDER BY p.productID ASC";

                $result = $conn->query($selectSQL);

                if ($result->num_rows === 0) {
                    echo '<div class="col-12 text-center fs-1"><p>No products found.</p></div>';
                } else {
                    foreach ($result as $key) {
                        $outOfStock = $key['inStock'] == 0; // Check if product is out of stock
                ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm <?php echo $outOfStock ? 'out-of-stock' : ''; ?>">
                                <img src="<?php echo htmlspecialchars($key['productIMG']) ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($key['productName']) ?>">
                                <div class="card-body d-flex flex-column">
                                    <h1 class="card-title fs-5"><?php echo htmlspecialchars($key['productName']) ?></h1>
                                    <p class="card-text fs-5"><?php echo htmlspecialchars($key['categoryName']) ?></p>
                                    <p class="card-text fs-5 mb-3">In Stock: <?php echo $key['inStock'] ?></p>
                                    <p class="card-text fs-5 mb-3">PHP <?php echo number_format($key['productPrice'], 2) ?></p>
                                    <div class="d-grid gap-2 mt-auto">
                                        <a href="?page=viewProduct&productID=<?php echo $key['productID']; ?>" class="btn btn-danger <?php echo $outOfStock ? 'disabled' : ''; ?>">View Product</a>
                                    </div>
                                </div>
                                <?php if ($outOfStock) { ?>
                                    <div class="out-of-stock-overlay">Out of Stock</div>
                                <?php } ?>
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
