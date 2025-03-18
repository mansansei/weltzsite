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
        <!-- Product Details Container -->
        <div class="productBox container border-dark-subtle mt-5 border rounded-5 shadow">
            <div class="row d-flex align-items-center">
                <div class="col-6 p-4 ">
                    <img src="<?php echo $product['productIMG'] ?>" alt="<?php echo $product['productName'] ?>" class="img-fluid shadow rounded-5">
                </div>
                <div class="col-6 p-5">
                    <h3 class="fs-2" id="productName"><?php echo $product['productName'] ?></h3>
                    <p class="fs-3" id="productCategory"><?php echo $product['categoryName'] ?></p>
                    <p class="fs-5" id="productDesc"><?php echo $product['productDesc'] ?></p>
                    <p class="fs-3">Stock: 0</p>
                    <p class="fs-3 fw-bold">Php <span id="productPrice"><?php echo $product['productPrice'] ?></span></p>
                    <div class="quantity-counter mb-5">
                        <p class="fs-3">Quantity</p>
                        <button type="button" class="btn btn-secondary inline-form-control fs-2" id="decreaseQuantity"><i class="fa-solid fa-minus"></i></button>
                        <input type="number" id="quantityInput" class="fs-2 form-control inline-form-control text-center" value="1" min="1">
                        <button type="button" class="btn btn-secondary inline-form-control fs-2" id="increaseQuantity"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <button type="button" class="btn btn-primary fs-2 mt-3" data-bs-toggle="modal" data-bs-target="#placeOrderModal">
                        Place Order
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
                <h1 class="modal-title fs-5" id="placeOrderModalLabel">Order Detais</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 p-4">
                        <img id="modalProductImage" src="" alt="" class="img-fluid shadow rounded-5">
                    </div>
                    <div class="col-6 p-5 text-end">
                        <h3 class="fs-2" id="modalProductName"></h3>
                        <p class="fs-3" id="modalProductCategory"></p>
                        <p class="fs-3">Price: Php <span id="modalProductPrice"></span></p>
                        <p class="fs-3">Quantity: <span id="modalQuantity"></span></p>
                        <p class="fs-3">Total Price: Php <span id="modalTotalPrice"></span></p>
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
<script>
    //Increase quantity counter function
    document.getElementById('increaseQuantity').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });

    //Decrease quantity counter function
    document.getElementById('decreaseQuantity').addEventListener('click', function() {
        var quantityInput = document.getElementById('quantityInput');
        if (parseInt(quantityInput.value) > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
        }
    });

    //Pass data of product details to order details
    document.querySelector('[data-bs-target="#placeOrderModal"]').addEventListener('click', function() {
        var productName = document.getElementById('productName').textContent;
        var productCategory = document.getElementById('productCategory').textContent;
        var productPrice = document.getElementById('productPrice').textContent;
        var quantity = document.getElementById('quantityInput').value;
        var totalPrice = (parseFloat(productPrice) * parseInt(quantity)).toFixed(2);

        document.getElementById('modalProductImage').src = "<?php echo $product['productIMG'] ?>";
        document.getElementById('modalProductImage').alt = productName;
        document.getElementById('modalProductName').textContent = productName;
        document.getElementById('modalProductCategory').textContent = productCategory;
        document.getElementById('modalProductPrice').textContent = productPrice;
        document.getElementById('modalQuantity').textContent = quantity;
        document.getElementById('modalTotalPrice').textContent = totalPrice;
    });

    //Dynamically change doc title with name of product
    document.addEventListener('DOMContentLoaded', function() {
        var productName = document.getElementById('productName').textContent;
        document.title = productName + " - Product Details";
    });
</script>