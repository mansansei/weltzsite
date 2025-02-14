<?php

include_once 'Header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Cart.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">

    <title>Cart</title>
</head>
<body>

    <section class="cart">
        <div class="carttitle">
        <h1>Customer's Cart</h1>
        </div>
        <div class="cartlink">
        <a href="./OrderHistory.php">Order History ➤</a>
        </div>
    </section>

    <!-- HANGGANG DITO LNG SA TITLE -->

    <section class="cart2">

        <div class="cartdesc">
            <div class="cartdesc1">
                <p>Product</p>
            </div>
            <div class="cartdesc2">
                <p>Unit Price</p>
                <p>Quantity</p>
                <p>Total Price</p>
                <p>Status</p>
                <p>Action</p>
            </div>
        </div>

        <div class="cartwrapper">

            <div class="cartitemwrapper">
                <div class="box1">
                <div class="cartitemimage">
                    <div class="nyerm">
                    <img src="../images/logo.png" alt="Product">
                    </div>
                </div>

                <div class="cartitemdesc">
                    <h1>ProductName</h1>
                    <p>ProductCategory</p>
                    <p>Brand</p>
                </div>
                </div>

                <div class="box2">
                    <p>00.00</p>
                    <p>00</p>
                    <p>00.00</p>
                    <p class="status">For Pick Up</p>
                    <a class="action" href="#">Cancel</a>
                </div>
            </div>

            <div class="cartitemwrapper">
                <div class="box1">
                <div class="cartitemimage">
                    <div class="nyerm">
                    <img src="../images/logo.png" alt="Product">
                    </div>
                </div>

                <div class="cartitemdesc">
                    <h1>ProductName</h1>
                    <p>ProductCategory</p>
                    <p>Brand</p>
                </div>
                </div>

                <div class="box2">
                    <p>00.00</p>
                    <p>00</p>
                    <p>00.00</p>
                    <p class="status">For Pick Up</p>
                    <a class="action" href="#">Cancel</a>
                </div>
            </div>

            <div class="cartitemwrapper">
                <div class="box1">
                <div class="cartitemimage">
                    <div class="nyerm">
                    <img src="../images/logo.png" alt="Product">
                    </div>
                </div>

                <div class="cartitemdesc">
                    <h1>ProductName</h1>
                    <p>ProductCategory</p>
                    <p>Brand</p>
                </div>
                </div>

                <div class="box2">
                    <p>00.00</p>
                    <p>00</p>
                    <p>00.00</p>
                    <p class="status">For Pick Up</p>
                    <a class="action" href="#">Cancel</a>
                </div>
            </div>

            <div class="cartitemwrapper">
                <div class="box1">
                <div class="cartitemimage">
                    <div class="nyerm">
                    <img src="../images/logo.png" alt="Product">
                    </div>
                </div>

                <div class="cartitemdesc">
                    <h1>ProductName</h1>
                    <p>ProductCategory</p>
                    <p>Brand</p>
                </div>
                </div>

                <div class="box2">
                    <p>00.00</p>
                    <p>00</p>
                    <p>00.00</p>
                    <p class="status">For Pick Up</p>
                    <a class="action" href="#">Cancel</a>
                </div>
            </div>

            <!-- copy paste lng to add more -->

        </div>

        <div class="return">
            <a href="./Products.php"><button>Return to shop</button></a>
        </div>
    </section>

