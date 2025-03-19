<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-header, .cart-item {
            display: flex;
            align-items: center;
        }
        .cart-header > div, .cart-item > div {
            padding: 10px;
        }
        .cart-header .product, .cart-item .product {
            flex: 2;
        }
        .cart-header .unit-price, .cart-item .unit-price,
        .cart-header .quantity, .cart-item .quantity,
        .cart-header .total-price, .cart-item .total-price,
        .cart-header .action, .cart-item .action {
            flex: 1;
            text-align: center;
        }
        .cart-item .product img {
            max-width: 50px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="cart-header bg-primary text-white">
        <div class="checkmark"><input type="checkbox" id="checkAll"></div>
        <div class="product">Product</div>
        <div class="unit-price">Unit Price</div>
        <div class="quantity">Quantity</div>
        <div class="total-price">Total Price</div>
        <div class="action">Action</div>
    </div>
    <div class="cart-item">
        <div class="checkmark"><input type="checkbox" class="item-check"></div>
        <div class="product">
            <img src="https://via.placeholder.com/50" alt="Product Image">
            <span>Product Name</span>
        </div>
        <div class="unit-price">$10.00</div>
        <div class="quantity"><input type="number" value="1" class="form-control"></div>
        <div class="total-price">$10.00</div>
        <div class="action"><button class="btn btn-danger">Remove</button></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#checkAll').click(function () {
            $('.item-check').prop('checked', this.checked);
        });
        $('.item-check').click(function () {
            if ($('.item-check:checked').length == $('.item-check').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    });
</script>

</body>
</html>