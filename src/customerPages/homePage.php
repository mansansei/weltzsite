<div class="landing container-fluid m-0 p-0">
    <h1>WELTZ INDUSTRIAL PHILS INC.</h1>
    <p><strong>ORDER NOW</strong>, PICK UP LATER.</p>
    <p>STOCK UP ON <strong>SAFETY!</strong></p>
    <a href="?page=productsPage"><button>BROWSE PRODUCTS</button></a>
</div>

<div class="featured container-fluid m-0 p-0">

    <div class="featuredTitle text-center">
        <h1>FEATURED PRODUCTS</h1>
        <p>EXPLORE OUR BEST SELLING FIRE SAFETY SOLUTIONS</p>
        <p>TO KEEP YOUR HOME AND WORKPLACE PROTECTED.</p>
    </div>

    <?php
    require 'weltz_dbconnect.php'; // Include your database connection

    $selectSQL = "SELECT p.productID, p.productIMG, p.productName, c.categoryName, p.productDesc, p.productPrice, p.inStock, p.prodSold 
              FROM products_tbl p 
              JOIN categories_tbl c ON p.categoryID = c.categoryID 
              ORDER BY p.prodSold DESC LIMIT 6";

    $result = $conn->query($selectSQL);
    ?>

    <div class="featureditemswrapper">
        <div class="scroll-container">
            <div class="row flex-nowrap">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="featuredItem p-4 shadow-sm col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="row">
                                <div class="featureditempic col-12 mb-3">
                                    <img src="<?= htmlspecialchars($row['productIMG']) ?>" alt="<?= htmlspecialchars($row['productName']) ?>" class="rounded">
                                </div>
                            </div>
                            <div class="row">
                                <div class="featuredItemName col-6">
                                    <p><?= htmlspecialchars($row['productName']) ?></p>
                                </div>
                                <div class="featuredItemPrice col-6">
                                    <p>PHP <?= number_format($row['productPrice'], 2) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="featuredViewProduct col-12">
                                    <p><a href="?page=viewProduct&productID=<?= $row['productID'] ?>">View Product <i class="fa-solid fa-arrow-right"></i></a></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No featured products available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>

</div>

<section class="aboutus py-5" id="Aboutus">
    <div class="container-fluid">
        <div class="row align-items-stretch">
            <!-- About Us Description -->
            <div class="col-md-6 d-flex flex-column justify-content-between p-4">
                <div class="aboutusdesc">
                    <p class="lead mb-4">At Weltz Industrial Philippines Inc., we don't just sell fire protection supplies, we provide peace of mind.
                        Our top-of-the-line products are designed to safeguard your home, business, and loved ones from the unexpected.
                        With a commitment to quality and customer satisfaction, we offer a wide range of fire safety equipment that
                        meets the highest industry standards.
                    </p>
                </div>

                <div class="aboutusdesc">
                    <p class="lead mb-4">Choose Weltz Industrial Philippines Inc. for reliable, innovative, and cost-effective fire protection solutions.
                        Because when it comes to safety, you deserve nothing but the best.
                    </p>
                </div>

                <div class="aboutusdesc3">
                    <p class="lead fw-bold mb-0">Protect what matters most with Weltz Industrial Philippines Inc.</p>
                </div>
            </div>

            <!-- About Us Image -->
            <div class="col-md-6 d-flex justify-content-center align-items-center p-4">
                <div class="aboutusimg">
                    <img src="../images/aboutUsIMG.jpg" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HANGGANG DITO LNG YUNG ABOUT US -->

<section class="trustedpartners py-5">
    <div class="container">
        <!-- Trusted Partners Title -->
        <div class="tptitle text-center mb-5">
            <h1 class="display-4">Trusted Partners</h1>
        </div>

        <!-- Trusted Partners Wrapper -->
        <div class="tpwrapper d-flex justify-content-around overflow-auto p-4 gap-4">
            <img src="../images/aleumLogo.jpg" alt="partner" class="img-fluid rounded-circle shadow" style="height: 250px; width: 250px; object-fit: cover;">
            <img src="../images/horingLihLogo.png" alt="partner" class="img-fluid rounded-circle shadow" style="height: 250px; width: 250px; object-fit: cover;">
        </div>
    </div>
</section>

<!-- HANGGANG DITO LNG YUNG TRUSTED PARTNERS -->