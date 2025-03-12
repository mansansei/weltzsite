<?php

// Database connection
function dbConnect()
{
  return (mysqli_connect("localhost", "root", "", "weltz_db"));
}

// Determines which function to execute depending on 'action' parameter
if (isset($_POST['action'])) {
  $action = $_POST['action'];
  if (function_exists($action)) {
    $action();
  } else {
    print_r("Function does not exist.");
  }
} else {
  print_r("No action specified.");
}

// Function for registering a new admin
function regAdmin()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Open db connection
    $conn = dbConnect();

    // Initialize variables
    $firstname = $_POST['uFname'];
    $lastname = $_POST['uLname'];
    $address = $_POST['uAdd'];
    $phone = $_POST['uPhone'];
    $email = $_POST['uEmail'];
    $password = $_POST['uPass'];
    $role = 2;
    $otp = 0;
    $status = "Verified";

    // Validation
    if (empty($firstname) || strlen($firstname) > 50 || !preg_match('/^[a-zA-Z]+$/', $firstname)) {
      echo json_encode(['success' => false, 'message' => 'First name must be 50 characters or less and must not contain special characters or numbers.']);
      exit;
    } else {
      $firstname = htmlspecialchars($firstname);
    }

    if (empty($lastname) || strlen($lastname) > 50 || !preg_match('/^[a-zA-Z]+$/', $lastname)) {
      echo json_encode(['success' => false, 'message' => 'Last name must be 50 characters or less and must not contain special characters or numbers.']);
      exit;
    } else {
      $lastname = htmlspecialchars($lastname);
    }

    if (empty($address) || strlen($address) > 100) {
      echo json_encode(['success' => false, 'message' => 'Address must be 100 characters or less.']);
      exit;
    } else {
      $address = htmlspecialchars($address);
    }

    if (empty($phone) || !preg_match('/^\d{11}$/', $phone)) {
      echo json_encode(['success' => false, 'message' => 'Phone number must be exactly 11 digits and contain only numbers.']);
      exit;
    } else {
      $phone = htmlspecialchars($phone);
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['success' => false, 'message' => 'Email must be a valid email address.']);
      exit;
    } else {
      $email = htmlspecialchars($email);
    }

    if (empty($password) || strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
      echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long and contain at least 1 digit (0-9) and 1 special character (!@#$%^&*).']);
      exit;
    } else {
      $password = htmlspecialchars($password);
    }

    $emailCheckQuery = "SELECT * FROM users_tbl WHERE userEmail = '$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
      echo json_encode(['success' => false, 'message' => 'Email already exists. Please use a different email.']);
      exit;
    }

    $hashed_password = md5($password);
    $currentDateTime = date('Y-m-d H:i:s');

    $insertsql = "INSERT INTO users_tbl (userFname, userLname, userAdd, userPhone, userEmail, userPass, role, otp, status, createdAt, updatedAt, updID)
                  VALUES ('$firstname', '$lastname', '$address', '$phone', '$email', '$hashed_password', '$role', '$otp', '$status', '$currentDateTime', '$currentDateTime', NULL)";

    if ($conn->query($insertsql) === TRUE) {
      echo json_encode(['success' => true, 'message' => 'Admin registered successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
  }
}