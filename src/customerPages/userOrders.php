<section class="usettings">
    <div class="usidebarwrapper">
        <!-- User Info Box -->
        <div class="uboxwrapper">
            <div class="ubox1">
                <img src="../images/logo.png" alt="User Logo">
                <div class="ubox1info">
                    <h1>Fname Lname</h1>
                    <p>customer@example.com</p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="nav-buttons mt-4">
            <a href="?page=userSettingsPage" class="nav-button fs-5" id="profileLink">
                <i class="fa-solid fa-user fa-fw"></i> Profile
            </a>
            <a href="?page=userSettings" class="nav-button fs-5" id="settingsLink">
                <i class="fa-solid fa-gear fa-fw"></i> Settings
            </a>
            <a href="?page=userOrders" class="nav-button fs-5 usersettingsactive" id="ordersLink">
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
    <div class="ucontent">

    </div>
</section>