<?php

require_once 'weltz_dbconnect.php';

if (isset($_GET['productID']) && $_GET['productID'] != NULL) {
    $productID = $_GET['productID'];
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
        categories_tbl c ON p.categoryID = c.categoryID
    WHERE 
        p.productID = ?";

    $stmt = $conn->prepare($selectSQL);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $outOfStock = $product['inStock'] == 0; // Check if product is out of stock
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
                font-size: 2rem;
                font-weight: bold;
                text-transform: uppercase;
                pointer-events: auto;
                border-radius: 10px;
            }

            /* Disable interactions for out-of-stock products */
            .out-of-stock {
                position: relative;
                pointer-events: none;
                opacity: 0.7;
            }
        </style>

        <!-- Product Name -->
        <div class="productBoxTitle container-fluid text-center text-white m-0 p-5">
            <h1 class="fs-1"><?php echo htmlspecialchars($product['productName']); ?></h1>
        </div>

        <!-- Product Details Container -->
        <div class="productBox container border-dark-subtle mt-5 mb-5 border rounded-5 shadow <?php echo $outOfStock ? 'out-of-stock' : ''; ?>">
            <div class="row d-flex align-items-center flex-column flex-md-row">
                <div class="col-12 col-md-6 p-5 order-md-1 order-1 position-relative">
                    <img src="<?php echo htmlspecialchars($product['productIMG']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>" id="productIMG" class="img-fluid shadow rounded-5">
                    <?php if ($outOfStock) { ?>
                        <div class="out-of-stock-overlay">Out of Stock</div>
                    <?php } ?>
                </div>
                <div class="col-12 col-md-6 p-5 order-md-2 order-2">
                    <div class="mb-3">
                        <h3 class="fs-2" id="productName"><?php echo htmlspecialchars($product['productName']); ?></h3>
                        <p class="fs-3" id="productCategory"><?php echo htmlspecialchars($product['categoryName']); ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-5" id="productDesc"><?php echo htmlspecialchars($product['productDesc']); ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-3">In Stock: <?php echo $product['inStock']; ?></p>
                        <p class="fs-3">Php <span id="productPrice"><?php echo number_format($product['productPrice'], 2); ?></span></p>
                    </div>
                    <div class="quantity-counter mb-5">
                        <p class="fs-3">Quantity</p>
                        <div class="input-group input-group-lg">
                            <button type="button" class="btn btn-secondary" id="decreaseQuantity" <?php echo $outOfStock ? 'disabled' : ''; ?>>
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="number" id="quantityInput" class="form-control text-center" value="1" min="1" <?php echo $outOfStock ? 'disabled' : ''; ?>>
                            <button type="button" class="btn btn-secondary" id="increaseQuantity" <?php echo $outOfStock ? 'disabled' : ''; ?>>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger fs-2 mt-3" id="addToCartBtn" data-product-id="<?php echo $product['productID']; ?>" <?php echo $outOfStock ? 'disabled' : ''; ?>>
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "<div class='text-center fs-3 mt-5'>Product not found.</div>";
    }
} else {
    echo "<div class='text-center fs-3 mt-5'>Invalid product ID.</div>";
}
?>

<!-- Reviews Section -->
<section class="reviewsec container py-5">
    <div class="reviewsectitle text-center mb-5">
        <h1>Reviews</h1>
    </div>

    <div class="reviewswrapper bg-light p-4 rounded shadow-sm mb-5 text-center">
        <p>No reviews yet...</p>
    </div>

    <div class="addreview p-4 rounded shadow-sm">
        <h2 class="font-weight-bold mb-3">Add a review</h2>
        <p class="note mb-3">(your email address will not be published)</p>
        <form>
            <div class="rating-wrapper mb-3">
                <label class="d-block mb-2">Your rating</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label for="star5" title="5 stars">&#9733;</label>

                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4" title="4 stars">&#9733;</label>

                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3" title="3 stars">&#9733;</label>

                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2" title="2 stars">&#9733;</label>

                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1" title="1 star">&#9733;</label>
                </div>
            </div>

            <div class="reviewdesc">
                <label for="review" class="review-label d-block mb-2">Review</label>
                <textarea id="review" class="review-textarea form-control mb-3" rows="4"></textarea>

                <button type="submit" class="submit-btn btn btn-danger">Submit</button>
            </div>
        </form>
    </div>
</section>