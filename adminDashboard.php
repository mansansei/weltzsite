<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminDashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">Admin Panel</div>
            <nav>
                <ul>
                    <li class="active">Dashboard</li>
                    <li>Users</li>
                    <li>Products</li>
                    <li>Orders</li>
                    <li>Cart</li>
                    <li>Company Blogs</li>
                    <li>Update Logs</li>
                </ul>
            </nav>
            <div class="messages">Messages</div>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <header class="top-bar">
                <button class="register-btn">Register new admin</button>
                <div class="admin-info">Admin</div>
            </header>

            <!-- Stats Section -->
            <section class="stats">
                <div class="stat-box">
                    <span class="icon">💰</span>
                    <p>999<br>Product Sales</p>
                </div>
                <div class="stat-box">
                    <span class="icon">📦</span>
                    <p>999<br>Total Stock</p>
                </div>
                <div class="stat-box">
                    <span class="icon">👥</span>
                    <p>16<br>Total Users</p>
                </div>
                <div class="stat-box">
                    <span class="icon">🏆</span>
                    <p>1<br>Product1 Most Sales</p>
                </div>
            </section>

            <!-- Charts Section -->
            <section class="charts">
                <div class="chart">Profit Chart</div>
                <div class="chart">Order Ratio</div>
                <div class="chart">Events</div>
                <div class="chart">Site Visits</div>
            </section>
        </main>
    </div>
</body>
</html>
