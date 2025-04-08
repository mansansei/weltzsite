<?php

session_start();

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true || !isset($_SESSION['role']) || $_SESSION['role'] != 2) {
  header('Location: Login.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Weltz INC</title>
  <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="styles.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="adminPages/adminDashboard.css">
  <?php require_once 'cssLibraries.php' ?>

  <title>Admin Dashboard</title>

  <style>
    /* Sidebar overlay on small screens */
    @media (max-width: 768px) {
      #sidebar {
        position: fixed;
        top: 0;
        left: -300px;
        width: 250px;
        height: 100%;
        background-color: #f8f9fa;
        transition: left 0.3s ease-in-out;
      }

      #sidebar.show {
        left: 0;
      }

      #adminContent {
        margin-left: 0;
        transition: margin-left 0.3s ease-in-out;
      }

      #adminHeader .hamburger-menu {
        display: block;
      }
    }

    /* Hide hamburger menu by default */
    .hamburger-menu {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }
  </style>

</head>

<body class="adminPanel">
  <nav id="sidebar" class="d-flex flex-column bg-light p-4 shadow rounded-end-5">
    <div class="sidebar-header mb-5 mt-3">
      <h1>Admin Panel</h1>
    </div>

    <div class="mb-4">
      <div class="sidebar-header">
        <h3><i class="fa-solid fa-house"></i> Home</h3>
      </div>
      <ul class="list-unstyled components">
        <li class="rounded">
          <a class="fs-5" href="?page=dashboard"><i class="fa-solid fa-border-all"></i> Dashboard</a>
        </li>
      </ul>
    </div>

    <div>
      <div class="sidebar-header">
        <h3><i class="fa-solid fa-database"></i> Database</h3>
      </div>
      <ul class="list-unstyled components">
        <li class="rounded">
          <a class="fs-5" href="?page=users"><i class="fa-solid fa-users"></i> Users</a>
        </li>
        <li class="rounded">
          <a class="fs-5" href="?page=products"><i class="fa-solid fa-box-open"></i> Products</a>
        </li>
        <li class="rounded">
          <a class="fs-5" href="?page=cartItems"><i class="fa-solid fa-receipt"></i> Cart Items</a>
        </li>
        <li class="rounded">
          <a class="fs-5" href="?page=carts"><i class="fa-solid fa-cart-shopping"></i> Carts</a>
        </li>
        <li class="rounded">
          <a class="fs-5" href="?page=orders"><i class="fa-solid fa-truck"></i> Orders</a>
        </li>
        <li class="rounded">
          <a class="fs-5" href="?page=logs"><i class="fa-solid fa-arrows-rotate"></i> Update Logs</a>
        </li>
      </ul>
    </div>
    <div class="mt-auto">
      <form id="logoutUserForm" method="POST">
        <input type="hidden" id="action" name="action" value="logoutUser">
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-danger">
            <i class="fa-solid fa-user-plus"></i> Logout
          </button>
        </div>
      </form>
    </div>
  </nav>

  <div class="container-fluid" id="adminContent">
    <nav id="adminHeader" class="navbar navbar-expand-lg navbar-light bg-light mb-5 rounded-4 shadow">
      <div class="container-fluid justify-content-between">
        <span class="hamburger-menu" id="hamburgerMenu"><i class="fa-solid fa-bars"></i></span>
        <h2 class="ml-3"><?php echo $_SESSION['username'] ?> <i class="fa-solid fa-user-tie"></i></h2>
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
        case 'cartItems':
          include 'adminPages/cartItemsTable.php';
          break;
        case 'carts':
          include 'adminPages/cartsTable.php';
          break;
        case 'orders':
          include 'adminPages/ordersTable.php';
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
  <script>
    $(document).ready(function() {
      // Toggle the sidebar visibility when clicking the hamburger menu
      $('#hamburgerMenu').click(function(event) {
        event.stopPropagation(); // Prevent the click from propagating to the document
        $('#sidebar').toggleClass('show');
        $('#adminContent').toggleClass('show');
      });

      // Close the sidebar when clicking outside of it
      $(document).click(function(event) {
        if (!$(event.target).closest('#sidebar, #hamburgerMenu').length) {
          $('#sidebar').removeClass('show');
          $('#adminContent').removeClass('show');
        }
      });
    });
  </script>
</body>

</html>