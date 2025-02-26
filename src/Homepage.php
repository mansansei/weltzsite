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
    <?php require_once 'cssLibraries.php' ?>
</head>
<body>

    <?php
        require_once 'Header.php';
    ?>

    <div class="landing container-fluid">
        <h1>WELTZ INDUSTRIAL PHILS INC.</h1>
        <p><strong>ORDER NOW</strong>, PICK UP LATER.</p>
        <p>STOCK UP ON <strong>SAFETY!</strong></p>
        <a href="#"><button>BROWSE PRODUCTS <i class="fa-solid fa-bag-shopping"></i></button></a>
    </div>

    <!-- HANGGANG DITO LNG YUNG LANDING PICTURE OR SOMETHIGN WELCOMING ETC -->

    <div class="featured container-fluid">

        <div class="featuredTitle text-center">
            <h1>FEATURED PRODUCTS</h1>
            <p>EXPLORE OUR BEST SELLING FIRE SAFETY SOLUTIONS</p>
            <p>TO KEEP YOUR HOME AND WORKPLACE PROTECTED.</p>
        </div>

        <div class="featureditemswrapper">
            <div class="scroll-container">
                <div class="row flex-nowrap">
                    <!-- <button class="scroll-left">←</button> -->
                    <div class="featuredItem p-4 shadow-sm col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="row">
                            <div class="featureditempic col-12">
                                <img src="../images/logo.png" alt="Item Pic">
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredItemName col-6">
                                <p>PRODUCT NAME</p>
                            </div>
                            <div class="featuredItemPrice col-6">
                                <p>Php00.00</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredViewProduct col-12">
                                <p><a href="#">View Product <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                    </div>

                    <div class="featuredItem p-4 shadow-sm col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="row">
                            <div class="featureditempic col-12">
                                <img src="../images/logo.png" alt="Item Pic">
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredItemName col-6">
                                <p>PRODUCT NAME</p>
                            </div>
                            <div class="featuredItemPrice col-6">
                                <p>Php00.00</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredViewProduct col-12">
                                <p><a href="#">View Product <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="featuredItem p-4 shadow-sm col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="row">
                            <div class="featureditempic col-12">
                                <img src="../images/logo.png" alt="Item Pic">
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredItemName col-6">
                                <p>PRODUCT NAME</p>
                            </div>
                            <div class="featuredItemPrice col-6">
                                <p>Php00.00</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredViewProduct col-12">
                                <p><a href="#">View Product <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                    </div>

                    <div class="featuredItem p-4 shadow-sm col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="row">
                            <div class="featureditempic col-12">
                                <img src="../images/logo.png" alt="Item Pic">
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredItemName col-6">
                                <p>PRODUCT NAME</p>
                            </div>
                            <div class="featuredItemPrice col-6">
                                <p>Php00.00</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredViewProduct col-12">
                                <p><a href="#">View Product <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                    </div>

                    <div class="featuredItem p-4 shadow-sm col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="row">
                            <div class="featureditempic col-12">
                                <img src="../images/logo.png" alt="Item Pic">
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredItemName col-6">
                                <p>PRODUCT NAME</p>
                            </div>
                            <div class="featuredItemPrice col-6">
                                <p>Php00.00</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="featuredViewProduct col-12">
                                <p><a href="#">View Product <i class="fa-solid fa-arrow-right"></i></a></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <button class="scroll-right">→</button> -->
                </div>
            </div>
        </div>

    </div>

    <!-- HANGGANG DITO LNG YUNG FEATURED -->
    <?php require_once 'cssLibrariesJS.php' ?>
    <script src="Homepage.js"></script>
</body>
</html>