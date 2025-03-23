<?php

if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {
?>
    <section class="usettings">
        <div class="usidebarwrapper">
            <!-- User Info Box -->
            <div class="uboxwrapper">
                <div class="ubox1">
                    <img src="../images/logo.png" alt="User Logo">
                    <div class="ubox1info">
                        <h1><?php echo $_SESSION['username'] ?></h1>
                        <p><?php echo $_SESSION['email'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="nav-buttons mt-4">
                <a href="?page=userProfile&tab=userProfile" class="nav-button fs-5" id="profileLink">
                    <i class="fa-solid fa-user fa-fw"></i> Profile
                </a>
                <a href="?page=userProfile&tab=userOrders" class="nav-button fs-5" id="ordersLink">
                    <i class="fa-solid fa-receipt fa-fw"></i> Orders
                </a>
            </div>

            <!-- Logout Button -->
            <div class="logout-button mt-4">
                <form id="logoutUserForm" method="POST">
                    <input type="hidden" id="action" name="action" value="logoutUser">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-user-plus"></i> Logout
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        <div class="ucontent p-5">
            <?php
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'userProfile';


            switch ($tab) {
                case 'userOrders':
                    include 'userOrders.php';
                    break;
                case 'userProfile':
                default:
                    include 'userProfilePage.php';
                    break;
            }            

            ?>
        </div>
    </section>
<?php
} else {
?>
    <div class="container vh-100">
        <div class="row my-5">
            <h1 class="text-center">Please login to view your profile.</h1>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-auto">
                <a href="Login.php" class="btn btn-danger">Login</a>
            </div>
        </div>
    </div>


<?php
}
