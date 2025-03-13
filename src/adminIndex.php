<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Weltz INC</title>
  <link rel="stylesheet" href="styles.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="adminPages/adminDashboard.css">
  <?php require_once 'cssLibraries.php' ?>

  <title>Admin Dashboard</title>
</head>

<body class="adminPanel">
  <nav id="sidebar" class="bg-light p-4 shadow rounded-end-5">
    <div class="sidebar-header mb-5 mt-3">
      <h1>Admin Panel</h1>
    </div>

    <div class="mb-4">
      <div class="sidebar-header">
        <h3><i class="fa-solid fa-house"></i> Home</h3>
      </div>
      <ul class="list-unstyled components">
        <li>
          <a class="fs-5" href="?page=dashboard"><i class="fa-solid fa-border-all"></i> Dashboard</a>
        </li>
      </ul>
    </div>

    <div>
      <div class="sidebar-header">
        <h3><i class="fa-solid fa-database"></i> Database</h3>
      </div>
      <ul class="list-unstyled components">
        <li>
          <a class="fs-5" href="?page=users"><i class="fa-solid fa-users"></i> Users</a>
        </li>
        <li>
          <a class="fs-5" href="?page=products"><i class="fa-solid fa-box-open"></i> Products</a>
        </li>
        <li>
          <a class="fs-5" href="?page=orders"><i class="fa-solid fa-receipt"></i> Orders</a>
        </li>
        <li>
          <a class="fs-5" href="?page=carts"><i class="fa-solid fa-cart-shopping"></i> Carts</a>
        </li>
        <li>
          <a class="fs-5" href="?page=blogs"><i class="fa-solid fa-pen-to-square"></i> Company Blogs</a>
        </li>
        <li>
          <a class="fs-5" href="?page=logs"><i class="fa-solid fa-arrows-rotate"></i> Update Logs</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid" id="adminContent">
    <nav id="adminHeader" class="navbar navbar-expand-lg navbar-light bg-light mb-5 rounded-4 shadow">
      <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#regNewAdmin">
          <i class="fa-solid fa-user-plus"></i> Register New Admin
        </button>
        <h2 class="ml-3">Admin <i class="fa-solid fa-user-tie"></i></h2>
      </div>
    </nav>
    <div class="container-fluid">
      <?php
      // Default page
      $page = 'dashboard';

      // Check if 'page' parameter is set in the query string
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      }

      // Include the corresponding page content
      switch ($page) {
        case 'users':
          include 'adminPages/usersTable.php';
          break;
        case 'products':
          include 'adminPages/productsTable.php';
          break;
        case 'orders':
          include 'adminPages/ordersTable.php';
          break;
        case 'carts':
          include 'adminPages/cartsTable.php';
          break;
        case 'blogs':
          include 'adminPages/blogsTable.php';
          break;
        case 'logs':
          include 'adminPages/logsTable.php';
          break;
        case 'dashboard':
        default:
          include 'adminPages/adminDashboard.php';
          break;
      }
      ?>
    </div>
  </div>
  <?php require_once 'cssLibrariesJS.php' ?>
</body>
</html>