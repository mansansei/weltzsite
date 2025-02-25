<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - Weltz INC</title>
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>
    
    <?php
        require_once 'Header.php';
    ?>

    <section class="landing">
        <h1>WELTZ INDUSTRIAL PHILS INC.</h1>
        <p><strong>ORDER NOW</strong>, PICK UP LATER.</p>
        <p>STOCK UP ON <strong>SAFETY!</strong></p>
        <a href="#"><button>BROWSE PRODUCTS</button></a>
    </section>

    <!-- HANGGANG DITO LNG YUNG LANDING PICTURE OR SOMETHIGN WELCOMING ETC -->

    <section class="featured">

        <div class="featuredname">
            <h1>FEATURED PRODUCTS</h1>
            <p>EXPLORE OUR BEST SELLING FIRE SAFETY SOLUTIONS</p>
            <p>TO KEEP YOUR HOME AND WORKPLACE PROTECTED.</p>
        </div>

        <div class="featureditemswrapper">

        <!-- <button class="scroll-left">←</button> -->

            <div class="featureditem">
                <div class="featureditempic">
                   <img src="../images/logo.png" alt="Item Pic">
                </div>
                <div class="featureditembox2">
                <div class="featureditemname">
                    <p>PRODUCT NAME</p>
                    <p class="p2"><a href="#">VIEW</a>➤</p>
                </div>
                <div class="featureditemprice">
                   <p>PHP00</p>
                </div>
                </div>
            </div>

            <div class="featureditem">
                <div class="featureditempic">
                    <img src="../images/logo.png" alt="Item Pic">
                </div>
                <div class="featureditembox2">
                <div class="featureditemname">
                <p>PRODUCT NAME</p>
                <p class="p2"><a href="#">VIEW</a>➤</p>
                </div>
                <div class="featureditemprice">
                <p>PHP00</p>
                </div>
                </div>
            </div>

            <div class="featureditem">
                <div class="featureditempic">
                    <img src="../images/logo.png" alt="Item Pic">
                </div>
                <div class="featureditembox2">
                <div class="featureditemname">
                <p>PRODUCT NAME</p>
                <p class="p2"><a href="#">VIEW</a>➤</p>
                </div>
                <div class="featureditemprice">
                <p>PHP00</p>
                </div>
                </div>
            </div>

            <div class="featureditem">
                <div class="featureditempic">
                    <img src="../images/logo.png" alt="Item Pic">
                </div>
                <div class="featureditembox2">
                <div class="featureditemname">
                <p>PRODUCT NAME</p>
                <p class="p2"><a href="#">VIEW</a>➤</p>
                </div>
                <div class="featureditemprice">
                <p>PHP00</p>
                </div>
                </div>
            </div>


            <!-- <button class="scroll-right">→</button> -->

        </div>

    </section>

    <!-- HANGGANG DITO LNG YUNG FEATURED -->
    <script src="Homepage.js"></script>
</body>
</html>