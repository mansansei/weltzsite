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

// Create audit logs function
function createAuditLog($conn, $newUserID, $actionType, $tableName, $recordID, $oldValues, $newValues)
{
  // Prepare the SQL statement
  $stmt = $conn->prepare("INSERT INTO audit_logs (userID, actionType, tableName, recordID, oldValues, newValues, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?)");

  // Bind the parameters
  $currentDateTime = date('Y-m-d H:i:s');
  $stmt->bind_param("ississs", $newUserID, $actionType, $tableName, $recordID, $oldValues, $newValues, $currentDateTime);
  $stmt->execute();

  // Close the statement
  $stmt->close();
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

    $insertsql = "INSERT INTO users_tbl (userFname, userLname, userAdd, userPhone, userEmail, userPass, roleID, otp, status, createdAt, updatedAt)
                  VALUES ('$firstname', '$lastname', '$address', '$phone', '$email', '$hashed_password', '$role', '$otp', '$status', '$currentDateTime', '$currentDateTime')";

    if ($conn->query($insertsql) === TRUE) {

      // Get the ID of the newly created user
      $newUserID = $conn->insert_id;

      // Create audit log entry
      $newValues = json_encode(['userFname' => $firstname, 'userLname' => $lastname, 'userAdd' => $address, 'userPhone' => $phone, 'userEmail' => $email, 'roleID' => $role, 'otp' => $otp, 'status' => $status]);
      createAuditLog($conn, $newUserID, 'CREATE', 'users_tbl', $newUserID, NULL, $newValues);

      echo json_encode(['success' => true, 'message' => 'Admin registered successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
  }
}

// Function to update details
function updateUser()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Open db connection
    $conn = dbConnect();

    // Set variables
    $userID = $_POST['userID'];
    $userFname = $_POST['uFname'];
    $userLname = $_POST['uLname'];
    $userAdd = $_POST['uAdd'];
    $userPhone = $_POST['uPhone'];
    $userEmail = $_POST['uEmail'];
    $updatedAt = date('Y-m-d H:i:s');

    // Retrieve current user data
    $currentDataSQL = "SELECT userFname, userLname, userAdd, userPhone, userEmail FROM users_tbl WHERE userID=?";
    $stmt = $conn->prepare($currentDataSQL);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentData = $result->fetch_assoc();
    $stmt->close();

    // Initialize update fields and values
    $updateFields = [];
    $updateValues = [];
    $oldValues = [];
    $newValues = [];

    // Compare and create oldValues and newValues arrays
    if ($userFname !== $currentData['userFname'] && !empty($userFname)) {
      $updateFields[] = "userFname=?";
      $updateValues[] = $userFname;
      $oldValues['userFname'] = $currentData['userFname'];
      $newValues['userFname'] = $userFname;
    }
    if ($userLname !== $currentData['userLname'] && !empty($userLname)) {
      $updateFields[] = "userLname=?";
      $updateValues[] = $userLname;
      $oldValues['userLname'] = $currentData['userLname'];
      $newValues['userLname'] = $userLname;
    }
    if ($userAdd !== $currentData['userAdd'] && !empty($userAdd)) {
      $updateFields[] = "userAdd=?";
      $updateValues[] = $userAdd;
      $oldValues['userAdd'] = $currentData['userAdd'];
      $newValues['userAdd'] = $userAdd;
    }
    if ($userPhone !== $currentData['userPhone'] && !empty($userPhone)) {
      $updateFields[] = "userPhone=?";
      $updateValues[] = $userPhone;
      $oldValues['userPhone'] = $currentData['userPhone'];
      $newValues['userPhone'] = $userPhone;
    }
    if ($userEmail !== $currentData['userEmail'] && !empty($userEmail)) {
      $updateFields[] = "userEmail=?";
      $updateValues[] = $userEmail;
      $oldValues['userEmail'] = $currentData['userEmail'];
      $newValues['userEmail'] = $userEmail;
    }
    if (!empty($updateFields)) {
      $updateFields[] = "updatedAt=?";
      $updateValues[] = $updatedAt;
      $updateValues[] = $userID;

      // Insert user detail changes
      $updateSQL = "UPDATE users_tbl SET " . implode(", ", $updateFields) . " WHERE userID=?";
      $stmt = $conn->prepare($updateSQL);
      $stmt->bind_param(str_repeat('s', count($updateValues) - 1) . 'i', ...$updateValues);

      if ($stmt->execute()) {
        // Log the changes
        createAuditLog($conn, $userID, 'UPDATE', 'users_tbl', $userID, json_encode($oldValues), json_encode($newValues));

        echo json_encode(['success' => true, 'message' => 'User details updated successfully.']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
      $stmt->close();
    } else {
      echo json_encode(['success' => false, 'message' => 'No data to update.']);
    }
  }
}

// Function to delete a user
function deleteUser()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $conn = dbConnect();

    $userID = $_POST['userID'];

    // Retrieve current user data before deletion
    $currentDataSQL = "SELECT userFname, userLname, userAdd, userPhone, userEmail FROM users_tbl WHERE userID=?";
    $stmt = $conn->prepare($currentDataSQL);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentData = $result->fetch_assoc();
    $stmt->close();

    // Convert current data to JSON for logging
    $oldValues = json_encode($currentData);

    // Delete user record
    $deleteSQL = "DELETE FROM users_tbl WHERE userID=?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $userID);

    if ($stmt->execute()) {
      // Log the deletion
      createAuditLog($conn, $userID, 'DELETE', 'users_tbl', $userID, $oldValues, null);

      echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $stmt->close();

  }
}
