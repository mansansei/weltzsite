<div class="container-fluid p-5">
    <div class="row border-bottom border-danger mb-4">
        <div class="col-md-9">
            <h1>
                <?php
                if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
                    echo isset($_SESSION['username']) ? $_SESSION['username'] . "'s Cart" : "Customer's Cart";
                } else {
                    echo "Customer's Cart";
                }
                ?>
            </h1>
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

    <div class="container mt-5 h-75">
        <div class="cart-header bg-danger text-white mb-3">
            <div class="row align-items-center p-3">
                <div class="col-lg-1 text-center">
                    <input type="checkbox" class="form-check-input" id="checkAll">
                </div>
                <div class="col-lg-4">
                    <p class="fs-5 mb-0">Product</p>
                </div>
                <div class="col-lg-2 text-center">
                    <p class="fs-5 mb-0">Unit Price</p>
                </div>
                <div class="col-lg-2 text-center">
                    <p class="fs-5 mb-0">Quantity</p>
                </div>
                <div class="col-lg-2 text-center">
                    <p class="fs-5 mb-0">Total</p>
                </div>
                <div class="col-lg-1 text-center">
                    <p class="fs-5 mb-0">Action</p>
                </div>
            </div>
        </div>
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {

            include_once 'weltz_dbconnect.php';

            $userID = $_SESSION['userID'];

            // Retrieve the cartID for the logged-in user
            $cartQuery = $conn->prepare("SELECT cartID FROM carts_tbl WHERE userID = ?");
            $cartQuery->bind_param("i", $userID);
            $cartQuery->execute();
            $cartResult = $cartQuery->get_result();

            if ($cartResult->num_rows > 0) {
                $cartRow = $cartResult->fetch_assoc();
                $cartID = $cartRow['cartID'];

                // Retrieve the cart items
                $itemsQuery = $conn->prepare("SELECT ci.cartItemID, ci.productID, ci.cartItemQuantity, ci.cartItemTotal, p.productName, c.categoryName 
                                      FROM cart_items_tbl ci
                                      JOIN products_tbl p ON ci.productID = p.productID
                                      JOIN categories_tbl c ON p.categoryID = c.categoryID
                                      WHERE ci.cartID = ?");
                $itemsQuery->bind_param("i", $cartID);
                $itemsQuery->execute();
                $itemsResult = $itemsQuery->get_result();

                if ($itemsResult->num_rows > 0) {
                    while ($itemRow = $itemsResult->fetch_assoc()) {
                        // Display the cart item
        ?>
                        <div class="cart-item bg-light border-bottom border-gray" data-item-id="<?php echo $itemRow['cartItemID']; ?>" data-unit-price="<?php echo $itemRow['cartItemTotal'] / $itemRow['cartItemQuantity']; ?>">
                            <div class="row align-items-center p-3">
                                <div class="col-lg-1 d-flex justify-content-center">
                                    <input type="checkbox" class="form-check-input item-check">
                                </div>
                                <div class="col-lg-4 d-flex">
                                    <img src="https://via.placeholder.com/50" alt="Product Image" class="me-2">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span><?php echo htmlspecialchars($itemRow['productName']) ?></span>
                                        <span class="text-secondary">Category: <?php echo htmlspecialchars($itemRow['categoryName']) ?></span>
                                        <span class="text-secondary">Brand: ExampleBrand</span>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <span class="unit-price"><?php echo number_format($itemRow['cartItemTotal'] / $itemRow['cartItemQuantity'], 2) ?></span>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <div class="input-group input-group">
                                        <button type="button" class="btn btn-secondary decreaseQuantity">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="number" class="form-control text-center quantityInput" value="<?php echo intval($itemRow['cartItemQuantity']) ?>" min="1">
                                        <button type="button" class="btn btn-secondary increaseQuantity">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <span class="total-price"><?php echo number_format($itemRow['cartItemTotal'], 2) ?></span>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <button class="btn btn-danger" id="delCartItemBtn">Remove</button>
                                </div>
                            </div>
                        </div>
        <?php
                    }
                } else {
                    echo '<p class="text-center fs-1">No items in your cart.</p>';
                }
            } else {
                echo '<p class="text-center fs-1">No cart found for the user.</p>';
            }
        } else {
            echo '<p class="text-center fs-1">You need to log in to view your cart.</p>';
        }
        ?>
    </div>
    <div class="cartCheckout container bg-light text-end my-0 py-4">
        <div class="container">
            <strong><span id="totalText">Total (0): PHP 0.00</span></strong>
            <button class="btn btn-danger" id="checkoutButton">Checkout</button>
        </div>
    </div>
</div>