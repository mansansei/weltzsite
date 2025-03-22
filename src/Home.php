<?php

require 'weltz_dbconnect.php';

session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
    header('Location: Login.php');
    exit();
}

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
            <div class="alogowrapper col-6 col-sm-3 col-md-2 d-flex justify-content-center">
                <img src="../images/logo.png" alt="Logo" class="img-fluid">
            </div>
            <div class="col-6 col-sm-5 col-md-6 text-left">
                <h1 class="header-title">WELTZ INDUSTRIAL PHILS INC.</h1>
            </div>
            <div class="col-12 col-sm-4 col-md-4 text-right d-none d-sm-block d-md-block">
                <div class="d-flex justify-content-end">
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

    <header class="headerwrapper2 container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="links d-flex flex-wrap">
                    <a class="active" href="?page=homePage"><button>HOME</button></a>
                    <a class="active2" href="?page=homePage#Aboutus"><button>ABOUT US</button></a>
                    <a class="active3" href="?page=productsPage"><button>PRODUCTS</button></a>
                    <a class="active4" href="?page=contactPage"><button>CONTACT</button></a>
                    <a class="active5" href="?page=blogsPage"><button>BLOGS</button></a>
                </div>
            </div>
            <div class="col-12 col-md-4 text-right">
                <div class="icons d-flex justify-content-end">
                    <div class="icon">
                        <a class="svgg2" href="?page=cartPage">
                            <button class="butt1">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </a>
                    </div>
                    <?php

                    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
                    ?>
                        <div class="icon ml-3">
                            <a class="svgg2" href="?page=userProfile">
                                <button class="butt2">
                                    <i class="fa-solid fa-circle-user"></i>
                                </button>
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="icon ml-3">
                            <a class="svgg2" href="Login.php">
                                <button class="butt2">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </button>
                            </a>
                        </div>
                    <?php
                    }

                    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
                        $userID = $_SESSION['userID'];

                        $unreadSQL = "SELECT COUNT(*) AS unreadCount FROM notifs_tbl WHERE userID = '$userID' AND statusID = 9";
                        $unreadResult = $conn->query($unreadSQL);
                        $unreadCount = 0;

                        if ($unreadResult->num_rows > 0) {
                            $row = $unreadResult->fetch_assoc();
                            $unreadCount = $row['unreadCount'];
                        }
                    ?>
                        <div class="icon ml-3">
                            <a class="svgg2" href="?page=notifs">
                                <button class="butt3 position-relative">
                                    <i class="fa-solid fa-bell"></i>
                                    <?php if ($unreadCount > 0): ?>
                                        <span class="position-absolute top-1 start-75 translate-middle badge rounded-pill bg-danger fs-6">
                                            <?php echo $unreadCount; ?>
                                        </span>
                                    <?php endif; ?>
                                </button>
                            </a>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="icon ml-3">
                            <a class="svgg2" href="?page=notifs">
                                <button class="butt3 position-relative">
                                    <i class="fa-solid fa-bell"></i>
                                </button>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid m-0 p-0">
        <?php
        // Default page
        $page = 'homePage';

        // Check if 'page' parameter is set in the query string
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        // Include the corresponding page content
        switch ($page) {
            case 'aboutUsPage':
                include 'customerPages/homePage.php';
                break;
            case 'productsPage':
                include 'customerPages/productsPage.php';
                break;
            case 'contactPage':
                include 'customerPages/contactPage.php';
                break;
            case 'blogsPage':
                include 'customerPages/blogsPage.php';
                break;
            case 'cartPage':
                include 'customerPages/cartPage.php';
                break;
            case 'viewProduct':
                include 'customerPages/viewProduct.php';
                break;
            case 'OrderHistory':
                include 'customerPages/OrderHistory.php';
                break;
            case 'userProfile':
                include 'customerPages/userProfile.php';
                break;
            case 'notifs':
                include 'customerPages/notifsPage.php';
                break;
            case 'homePage':
            default:
                include 'customerPages/homePage.php';
                break;
        }
        ?>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-1">&copy; 2025 WELTZ INDUSTRIAL PHILS INC. All Rights Reserved.</p>
            <p>
                <a href="?page=homePage">Home</a> |
                <a href="?page=aboutUsPage">About Us</a> |
                <a href="?page=contactPage">Contact Us</a>
            </p>
        </div>
    </footer>

    <?php require_once 'cssLibrariesJS.php' ?>
</body>

</html>