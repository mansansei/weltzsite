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
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5 rounded-4 shadow">
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

  <!-- Register Admin Modal -->
  <div class="modal fade" id="regNewAdmin" tabindex="-1" aria-labelledby="regNewAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="regNewAdminLabel">Register a New Admin</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="signupform" id="signupForm" method="POST" action="">
            <div class="row mb-4">
              <div class="col">
                <input class="form-control" type="text" name="uFname" placeholder="First Name" required>
              </div>
              <div class="col">
                <input class="form-control" type="text" name="uLname" placeholder="Last Name" required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col">
                <input class="form-control" type="text" name="uAdd" placeholder="Address" required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col">
                <input class="form-control" type="tel" name="uPhone" placeholder="Phone No." required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col">
                <input class="form-control" type="email" name="uEmail" placeholder="Email Address" required>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col">
                <input class="form-control" type="password" name="uPass" placeholder="Password" required>
              </div>
            </div>
            <div class='d-grid gap-2 mb-4'>
              <button type="button" id="registerAdminBtn" class='btn btn-success'>Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php

  require_once "weltz_dbconnect.php";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['uFname'];
    $lastname = $_POST['uLname'];
    $address = $_POST['uAdd'];
    $phone = $_POST['uPhone'];
    $email = $_POST['uEmail'];
    $password = $_POST['uPass'];
    $role = 2;
    $otp = 0;
    $status = "Verified";

    if (empty($firstname) || strlen($firstname) > 50 || !preg_match('/^[a-zA-Z]+$/', $firstname)) {
    ?>
      <script>
        Swal.fire({
          position: "center",
          icon: "error",
          text: "First name must be 50 characters or less and must not contain special characters or numbers.",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    <?php
      exit;
    } else {
      $firstname = htmlspecialchars($firstname);
    }

    if (empty($lastname) || strlen($lastname) > 50 || !preg_match('/^[a-zA-Z]+$/', $lastname)) {
    ?>
      <script>
        Swal.fire({
          position: "center",
          icon: "error",
          text: "Last name must be 50 characters or less and must not contain special characters or numbers.",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    <?php
      exit;
    } else {
      $lastname = htmlspecialchars($lastname);
    }

    if (empty($address) || strlen($address) > 100 || !preg_match('/^[a-zA-Z]+$/', $address)) {
    ?>
      <script>
        Swal.fire({
          position: "center",
          icon: "error",
          text: "Address must be 100 characters or less and must not contain special characters.",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    <?php
      exit;
    } else {
      $address = htmlspecialchars($address);
    }

    if (empty($phone) || !preg_match('/^\d{11}$/', $phone)) {
    ?>
      <script>
        Swal.fire({
          position: "center",
          icon: "error",
          text: "Phone number must be exactly 11 digits and contain only numbers.",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    <?php
      exit;
    } else {
      $phone = htmlspecialchars($phone);
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ?>
      <script>
        Swal.fire({
          position: "center",
          icon: "error",
          text: "Email must be a valid email address.",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    <?php
      exit;
    } else {
      $email = htmlspecialchars($email);
    }

    if (empty($password) || strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
    ?>
      <script>
        Swal.fire({
          position: "center",
          icon: "error",
          text: "Password must be at least 8 characters long and contain at least 1 digit (0-9) and 1 special character (!@#$%^&*).",
          showConfirmButton: false,
          timer: 3000
        });
      </script>
    <?php
      exit;
    } else {
      $password = htmlspecialchars($password);
    }

    $emailCheckQuery = "SELECT * FROM users_tbl WHERE userEmail = '$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
      echo "<script>alert('Email already exists. Please use a different email.'); window.history.back();</script>";
      exit();
    }

    $hashed_password = md5($password);

    $currentDateTime = date('Y-m-d H:i:s');

    $insertsql = "INSERT INTO users_tbl (userFname, userLname, userAdd, userPhone, userEmail, userPass, role, otp, status, createdAt, updatedAt, updID)
    VALUES ('$firstname', '$lastname', '$address', '$phone', '$email', '$hashed_password', '$role', '$otp', '$status', '$currentDateTime', '$currentDateTime', NULL)";
  }

  ?>
  <?php require_once 'cssLibrariesJS.php' ?>
</body>

</html>