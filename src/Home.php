<?php

require 'weltz_dbconnect.php';

session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
    header('Location: Login.php');
    exit();
}

// Default page
$page = $_GET['page'] ?? 'homePage';

// Define allowed pages
$allowedPages = [
    'aboutUsPage' => 'customerPages/aboutUsPage.php',
    'productsPage' => 'customerPages/productsPage.php',
    'contactPage' => 'customerPages/contactPage.php',
    'cartPage' => 'customerPages/cartPage.php',
    'viewProduct' => 'customerPages/viewProduct.php',
    'OrderHistory' => 'customerPages/OrderHistory.php',
    'userProfile' => 'customerPages/userProfile.php',
    'notifs' => 'customerPages/notifsPage.php',
    'homePage' => 'customerPages/homePage.php'
];

// If page is invalid, show 404 page directly
if (!array_key_exists($page, $allowedPages) || !file_exists($allowedPages[$page])) {
    http_response_code(404);
    include '404.php';
    exit();
}

// Otherwise, include the normal layout
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weltz INC</title>
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <?php require_once 'cssLibraries.php' ?>
</head>

<body>
    <header class="headerwrapper container-fluid">
        <div class="row align-items-center">
            <div class="alogowrapper col-lg-6 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
                <img src="../images/logo.png" alt="Logo" class="img-fluid">
                <h1 class="header-title">WELTZ INDUSTRIAL PHILS INC.</h1>
            </div>
            <div class="col-lg-6 text-center d-none d-sm-block d-md-block">
                <div class="d-flex justify-content-center">
                    <div class="contact-info">
                        <p><i class="fa-solid fa-envelope"></i> WELTZPHILS@GMAIL.COM</p>
                    </div>
                    <div class="contact-info ml-4">
                        <p><i class="fa-solid fa-location-dot"></i> CAINTA, RIZAL</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <header class="headerwrapper2 container-fluid p-0">
        <nav class="navbar navbar-expand-md navbar-dark m-0 p-0">
            <div class="container-fluid">
                <!-- Toggler Button -->
                <button class="navbar-toggler m-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLinks"
                    aria-controls="navbarLinks" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <!-- Menu links -->
        <!-- Added d-md-flex for desktop to make it visible -->
        <div class="collapse d-md-flex justify-content-center gap-5" id="navbarLinks">
            <div class="links d-flex flex-wrap">
                <a href="?page=homePage" class="<?= $page === 'homePage' ? 'nav-active' : '' ?>">
                    <button><i class="fa-solid fa-house"></i> HOME</button>
                </a>
                <a href="?page=homePage#Aboutus" class="<?= $page === 'homePage#Aboutus' ? 'nav-active' : '' ?>">
                    <button><i class="fa-solid fa-circle-info"></i> ABOUT US</button>
                </a>
                <a href="?page=productsPage" class="<?= $page === 'productsPage' ? 'nav-active' : '' ?>">
                    <button><i class="fa-solid fa-box-open"></i> PRODUCTS</button>
                </a>
                <a href="?page=contactPage" class="<?= $page === 'contactPage' ? 'nav-active' : '' ?>">
                    <button><i class="fa-solid fa-envelope"></i> CONTACT</button>
                </a>
            </div>
            <div class="icons d-flex align-items-center">
                <div class="icon ml-2">
                    <a class="svgg2" href="?page=cartPage">
                        <button class="butt1"><i class="fa-solid fa-cart-shopping"></i></button>
                    </a>
                </div>
                <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) { ?>
                    <div class="icon ml-2">
                        <a class="svgg2" href="?page=userProfile">
                            <button class="butt2"><i class="fa-solid fa-circle-user"></i></button>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="icon ml-2">
                        <a class="svgg2" href="Login.php">
                            <button class="butt2"><i class="fa-solid fa-right-to-bracket"></i></button>
                        </a>
                    </div>
                <?php }

                if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
                    $userID = $_SESSION['userID'];
                    $unreadSQL = "SELECT COUNT(*) AS unreadCount FROM notifs_tbl WHERE userID = '$userID' AND statusID = 9";
                    $unreadResult = $conn->query($unreadSQL);
                    $unreadCount = $unreadResult->fetch_assoc()['unreadCount'] ?? 0;
                ?>
                    <div class="icon ml-2">
                        <a class="svgg2" href="?page=notifs">
                            <button class="butt3 position-relative">
                                <i class="fa-solid fa-bell"></i>
                                <?php if ($unreadCount > 0): ?>
                                    <span class="position-absolute top-1 start-75 translate-middle badge rounded-pill bg-danger fs-6">
                                        <?= $unreadCount ?>
                                    </span>
                                <?php endif; ?>
                            </button>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="icon ml-2">
                        <a class="svgg2" href="?page=notifs">
                            <button class="butt3"><i class="fa-solid fa-bell"></i></button>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </header>



    <div class="container-fluid m-0 p-0">
        <?php include $allowedPages[$page]; ?>
    </div>

    <footer class="text-white text-center py-3" style="background-color: #231f20;">
        <div class="container">
            <p class="mb-1">&copy; 2025 WELTZ INDUSTRIAL PHILS INC. All Rights Reserved.</p>
            <p>
                <a href="?page=homePage">Home</a> |
                <a href="?page=aboutUsPage">About Us</a> |
                <a href="?page=contactPage">Contact Us</a>
            </p>
        </div>
    </footer>

    <a href="https://m.me/WeltzIndustrialPhilippines" target="_blank" class="floating-button">
        <i class="fa-brands fa-facebook-messenger"></i>
    </a>

    <?php require_once 'cssLibrariesJS.php' ?>
</body>

</html>