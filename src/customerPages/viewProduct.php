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
    productID = ?
    ";

    $stmt = $conn->prepare($selectSQL);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
?>
        <!-- Product Name -->
        <div class="productBoxTitle container-fluid text-center text-white m-0 p-5">
            <h1 class="fs-1"><?php echo $product['productName'] ?></h1>
        </div>

        <!-- Product Details Container -->
        <div class="productBox container border-dark-subtle mt-5 mb-5 border rounded-5 shadow">
            <div class="row d-flex align-items-center flex-column flex-md-row">
                <div class="col-12 col-md-6 p-5 order-md-1 order-1">
                    <img src="<?php echo $product['productIMG'] ?>" alt="<?php echo $product['productName'] ?>" id="productIMG" class="img-fluid shadow rounded-5">
                </div>
                <div class="col-12 col-md-6 p-5 order-md-2 order-2">
                    <div class="mb-3">
                        <h3 class="fs-2" id="productName"><?php echo $product['productName'] ?></h3>
                        <p class="fs-3" id="productCategory"><?php echo $product['categoryName'] ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-5" id="productDesc"><?php echo $product['productDesc'] ?></p>
                    </div>
                    <div class="mb-3">
                        <p class="fs-3">Stock: 0</p>
                        <p class="fs-3 fw-bold">Php <span id="productPrice"><?php echo $product['productPrice'] ?></span></p>
                    </div>
                    <div class="quantity-counter mb-5">
                        <p class="fs-3">Quantity</p>
                        <div class="input-group input-group-lg">
                            <button type="button" class="btn btn-secondary" id="decreaseQuantity">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="number" id="quantityInput" class="form-control text-center" value="1" min="1">
                            <button type="button" class="btn btn-secondary" id="increaseQuantity">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger fs-2 mt-3" data-bs-toggle="modal" data-bs-target="#placeOrderModal">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product ID.";
}
?>
<!-- Order Details Modal -->
<div class="modal fade" id="placeOrderModal" tabindex="-1" aria-labelledby="placeOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="placeOrderModalLabel">Add to Cart Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 p-4">
                        <img id="modalProductImage" src="" alt="" class="img-fluid shadow rounded-5">
                    </div>
                    <div class="col-6 p-5 text-end">
                        <div class="mb-3">
                            <h3 class="fs-2" id="modalProductName"></h3>
                            <p class="fs-3" id="modalProductCategory"></p>
                        </div>
                        <div class="mb-3">
                            <p class="fs-3">Price: Php <span id="modalProductPrice"></span></p>
                            <p class="fs-3">Quantity: <span id="modalQuantity"></span></p>
                            <p class="fs-3">Total Price: Php <span id="modalTotalPrice"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>