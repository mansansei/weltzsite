<?php

session_start();

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

// Login validation function
function loginUser()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $conn = dbConnect();

    $email = $_POST['uEmail'];
    $password = $_POST['uPass'];
    $hashed_password = md5($password);

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

    $loginsql = "SELECT * FROM users_tbl WHERE userEmail=?";
    $stmt = $conn->prepare($loginsql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $loginresult = $stmt->get_result();
    $logindata = $loginresult->fetch_assoc();
    $stmt->close();

    if ($logindata && $email == $logindata['userEmail'] && $hashed_password == $logindata['userPass']) {

      // Set session variables
      $_SESSION['username'] = $logindata['userFname'] . " " . $logindata['userLname'];
      $_SESSION['userID'] = $logindata['userID'];
      $_SESSION['isLoggedIn'] = true;

      $role = $logindata['roleID'];

      // Log the successful login attempt
      createAuditLog($conn, $logindata['userID'], 'LOGIN', 'users_tbl', $logindata['userID'], null, json_encode(['status' => 'success']));

      $response = ['success' => true, 'message' => 'Login successful'];

      if ($role == 1) {
        $response['redirect'] = 'Home.php';
      } else if ($role == 2) {
        $response['redirect'] = 'adminIndex.php';
      }

      echo json_encode($response);
    } else {
      // Log the failed login attempt
      createAuditLog($conn, $logindata['userID'], 'LOGIN', 'users_tbl', $logindata['userID'], json_encode(['email' => $email]), json_encode(['status' => 'failed']));

      echo json_encode(['success' => false, 'message' => 'Email or Password is wrong']);
    }
  }
}

// Logout validation function
function logoutUser()
{
  // Retrieve the user ID from the session
  $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

  // If user ID is available, create an audit log entry for the logout action
  if ($userID) {
    $conn = dbConnect();
    createAuditLog($conn, $userID, 'LOGOUT', 'users_tbl', $userID, null, json_encode(['status' => 'logged out']));
  }

  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Prepare the response
  $response = ['success' => true, 'message' => 'Logout successful'];
  $response['redirect'] = 'Login.php';

  // Return the response as JSON
  echo json_encode($response);
}

// Add to Cart function
function addToCart()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    // Open db connection
    $conn = dbConnect();

    // Initialize variables
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $totalPrice = $_POST['totalPrice'];

    // Validation
    if (empty($productID) || !is_numeric($productID)) {
      echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
      exit;
    }

    if (empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid quantity.']);
      exit;
    }

    if (empty($totalPrice) || !is_numeric($totalPrice) || $totalPrice <= 0) {
      echo json_encode(['success' => false, 'message' => 'Invalid total price.']);
      exit;
    }

    // Get the cartID of the currently logged in user
    $selectCartSQL = "SELECT cartID FROM carts_tbl WHERE userID = '$userID' LIMIT 1";
    $cartResult = $conn->query($selectCartSQL);

    if ($cartResult->num_rows > 0) {
      $cartRow = $cartResult->fetch_assoc();
      $cartID = $cartRow['cartID'];
    } else {
      echo json_encode(['success' => false, 'message' => 'Cart not found for the current user.']);
      exit;
    }

    // Check if the product already exists in the cart
    $selectCartItemSQL = "SELECT * FROM cart_items_tbl WHERE cartID = '$cartID' AND productID = '$productID' LIMIT 1";
    $cartItemResult = $conn->query($selectCartItemSQL);

    if ($cartItemResult->num_rows > 0) {
      // Update the existing cart item
      $cartItemRow = $cartItemResult->fetch_assoc();
      $newQuantity = $cartItemRow['cartItemQuantity'] + $quantity;
      $newTotalPrice = $cartItemRow['cartItemTotal'] + $totalPrice;

      $updateCartItemSQL = "UPDATE cart_items_tbl SET cartItemQuantity = '$newQuantity', cartItemTotal = '$newTotalPrice' WHERE cartID = '$cartID' AND productID = '$productID'";

      if ($conn->query($updateCartItemSQL) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Cart item updated successfully.']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
    } else {
      // Insert a new cart item
      $insertsql = "INSERT INTO cart_items_tbl (cartID, productID, cartItemQuantity, cartItemTotal) VALUES ('$cartID', '$productID', '$quantity', '$totalPrice')";

      if ($conn->query($insertsql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Item added to cart successfully.']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
    }

    $conn->close();
  }
}

// Function for registering a new admin
function regAdmin()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userUpdaterID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

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
      createAuditLog($conn, $userUpdaterID, 'CREATE', 'users_tbl', $newUserID, NULL, $newValues);

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

    $userUpdaterID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

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
        createAuditLog($conn, $userUpdaterID, 'UPDATE', 'users_tbl', $userID, json_encode($oldValues), json_encode($newValues));

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

    $userUpdaterID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

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
      createAuditLog($conn, $userUpdaterID, 'DELETE', 'users_tbl', $userID, $oldValues, null);

      echo json_encode(['success' => true, 'message' => 'User deleted successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $stmt->close();
  }
}

// Function to add product
function addProduct()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    // Open db connection
    $conn = dbConnect();

    // Initialize variables
    $productName = $_POST['prodName'];
    $productIMG = $_FILES['prodIMG'];
    $categoryID = $_POST['prodCategory'];
    $productDesc = $_POST['prodDesc'];
    $productPrice = $_POST['prodPrice'];
    $inStock = $_POST['prodStock'];

    // Validation
    if (empty($productName) || strlen($productName) > 100) {
      echo json_encode(['success' => false, 'message' => 'Product name must be 100 characters or less.']);
      exit;
    } else {
      $productName = htmlspecialchars($productName);
    }

    if (empty($categoryID)) {
      echo json_encode(['success' => false, 'message' => 'Please select a category.']);
      exit;
    }

    if (empty($productDesc) || strlen($productDesc) > 500) {
      echo json_encode(['success' => false, 'message' => 'Description must be 500 characters or less.']);
      exit;
    } else {
      $productDesc = htmlspecialchars($productDesc);
    }

    if (empty($productPrice) || !is_numeric($productPrice) || $productPrice <= 0) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid price.']);
      exit;
    }

    if (empty($inStock) || !is_numeric($inStock) || $inStock < 0) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid stock quantity.']);
      exit;
    }

    if ($productIMG['error'] !== UPLOAD_ERR_OK) {
      echo json_encode(['success' => false, 'message' => 'Error uploading image.']);
      exit;
    }

    // Save the image file
    $targetDir = "../images/products/";
    $imageFileType = strtolower(pathinfo($productIMG['name'], PATHINFO_EXTENSION));
    $originalFileName = pathinfo($productIMG['name'], PATHINFO_FILENAME);
    $targetFile = $targetDir . $originalFileName . '_' . uniqid() . '.' . $imageFileType;

    if (!move_uploaded_file($productIMG['tmp_name'], $targetFile)) {
      echo json_encode(['success' => false, 'message' => 'Error saving image file.']);
      exit;
    }

    $productIMGPath = htmlspecialchars($targetFile);

    $currentDateTime = date('Y-m-d H:i:s');

    $insertsql = "INSERT INTO products_tbl (userID, productName, productIMG, categoryID, productDesc, productPrice, inStock, createdAt, updatedAt)
                      VALUES ('$userID', '$productName', '$productIMGPath', '$categoryID', '$productDesc', '$productPrice', '$inStock', '$currentDateTime', '$currentDateTime')";

    if ($conn->query($insertsql) === TRUE) {

      // Get the ID of the newly created product
      $newProductID = $conn->insert_id;

      // Create audit log entry
      $newValues = json_encode(['userID' => $userID, 'productName' => $productName, 'productIMG' => $productIMGPath, 'categoryID' => $categoryID, 'productDesc' => $productDesc, 'productPrice' => $productPrice, 'inStock' => $inStock]);
      createAuditLog($conn, $userID, 'CREATE', 'products_tbl', $newProductID, NULL, $newValues);

      echo json_encode(['success' => true, 'message' => 'Product added successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
  }
}

// Function to update product details
function updateProduct()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    // Open db connection
    $conn = dbConnect();

    // Set variables
    $productID = $_POST['editProdID'];
    $productName = $_POST['editProdName'];
    $productIMG = isset($_FILES['editProdIMG']) ? $_FILES['editProdIMG'] : null;
    $categoryID = (int)$_POST['editProdCategory'];
    $productDesc = $_POST['editProdDesc'];
    $productPrice = (float)$_POST['editProdPrice'];
    $inStock = (int)$_POST['editProdStock'];
    $updatedAt = date('Y-m-d H:i:s');

    // Retrieve current product data
    $currentDataSQL = "SELECT productName, productIMG, categoryID, productDesc, productPrice, inStock FROM products_tbl WHERE productID=?";
    $stmt = $conn->prepare($currentDataSQL);
    $stmt->bind_param("i", $productID);
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
    if ($productName !== $currentData['productName'] && !empty($productName)) {
      $updateFields[] = "productName=?";
      $updateValues[] = $productName;
      $oldValues['productName'] = $currentData['productName'];
      $newValues['productName'] = $productName;
    }
    if ($categoryID !== (int)$currentData['categoryID'] && !empty($categoryID)) {
      $updateFields[] = "categoryID=?";
      $updateValues[] = $categoryID;
      $oldValues['categoryID'] = (int)$currentData['categoryID'];
      $newValues['categoryID'] = $categoryID;
    }
    if ($productDesc !== $currentData['productDesc'] && !empty($productDesc)) {
      $updateFields[] = "productDesc=?";
      $updateValues[] = $productDesc;
      $oldValues['productDesc'] = $currentData['productDesc'];
      $newValues['productDesc'] = $productDesc;
    }
    if ($productPrice !== (float)$currentData['productPrice'] && !empty($productPrice)) {
      $updateFields[] = "productPrice=?";
      $updateValues[] = $productPrice;
      $oldValues['productPrice'] = (float)$currentData['productPrice'];
      $newValues['productPrice'] = $productPrice;
    }
    if ($inStock !== (int)$currentData['inStock'] && !empty($inStock)) {
      $updateFields[] = "inStock=?";
      $updateValues[] = $inStock;
      $oldValues['inStock'] = (int)$currentData['inStock'];
      $newValues['inStock'] = $inStock;
    }

    if ($productIMG && $productIMG['error'] === UPLOAD_ERR_OK) {
      // Save the image file
      $targetDir = "../images/products/";
      $imageFileType = strtolower(pathinfo($productIMG['name'], PATHINFO_EXTENSION));
      $originalFileName = pathinfo($productIMG['name'], PATHINFO_FILENAME);
      $targetFile = $targetDir . $originalFileName . '_' . uniqid() . '.' . $imageFileType;

      if (move_uploaded_file($productIMG['tmp_name'], $targetFile)) {
        $productIMGPath = htmlspecialchars($targetFile);
        $updateFields[] = "productIMG=?";
        $updateValues[] = $productIMGPath;
        $oldValues['productIMG'] = $currentData['productIMG'];
        $newValues['productIMG'] = $productIMGPath;
      } else {
        echo json_encode(['success' => false, 'message' => 'Error saving image file.']);
        exit;
      }
    }

    if (!empty($updateFields)) {
      $updateFields[] = "updatedAt=?";
      $updateValues[] = $updatedAt;
      $updateValues[] = $productID;

      // Insert product detail changes
      $updateSQL = "UPDATE products_tbl SET " . implode(", ", $updateFields) . " WHERE productID=?";
      $stmt = $conn->prepare($updateSQL);
      $stmt->bind_param(str_repeat('s', count($updateValues) - 1) . 'i', ...$updateValues);

      if ($stmt->execute()) {
        // Log the changes
        createAuditLog($conn, $userID, 'UPDATE', 'products_tbl', $productID, json_encode($oldValues), json_encode($newValues));

        echo json_encode(['success' => true, 'message' => 'Product details updated successfully.']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
      $stmt->close();
    } else {
      echo json_encode(['success' => false, 'message' => 'No data to update.']);
    }
  }
}

// Function to delete a product
function deleteProduct()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userUpdaterID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    $conn = dbConnect();

    $productID = $_POST['productID'];

    // Retrieve current product data before deletion
    $currentDataSQL = "SELECT productID, productName, productIMG, categoryID, productDesc, productPrice, inStock FROM products_tbl WHERE productID=?";
    $stmt = $conn->prepare($currentDataSQL);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentData = $result->fetch_assoc();
    $stmt->close();

    // Convert current data to JSON for logging
    $oldValues = json_encode($currentData);

    // Delete product record
    $deleteSQL = "DELETE FROM products_tbl WHERE productID=?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $productID);

    if ($stmt->execute()) {
      // Log the deletion
      createAuditLog($conn, $userUpdaterID, 'DELETE', 'products_tbl', $productID, $oldValues, null);

      echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $stmt->close();
  }
}
