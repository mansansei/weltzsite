<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Weltz INC</title>
    <link rel="stylesheet" href="OrderHistory.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>

    <?php
        require_once 'Header.php'
    ?>

    <section class="cart">
        <div class="carttitle">
            <h1>Order History</h1>
        </div>
    </section>

    <!-- HANGGANG DITO LNG SA TITLE -->

    <section class="cart2">

        <div class="cartdesc">
            <div class="cartdesc1">
                <p>Product</p>
            </div>
            <div class="cartdesc2">
                <p>Date</p>
                <p>Quantity</p>
                <p>Total Price</p>
                <p>Status</p>
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
                    <p class="status">Cancelled</p>
                </div>
            </div>

            <!-- copy paste lng to add more -->

        </div>

        <div class="return">
            <a href="./Cart.php"><button>Return to cart</button></a>
        </div>
    </section>
</body>
</html>
