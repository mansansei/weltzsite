<?php

session_start();

// Database connection
function dbConnect()
{
  return (mysqli_connect("localhost", "root", "", "weltz_db"));
}

// Reference number generator
function generateRefNum($length = 11)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $referenceNumber = '';
  for ($i = 0; $i < $length; $i++) {
    $referenceNumber .= $characters[rand(0, $charactersLength - 1)];
  }
  return $referenceNumber;
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

// Check login status function
function checkLoginStatus()
{
  $response = array('loggedIn' => false);

  if (isset($_SESSION['userID'])) {
    $response['loggedIn'] = true;
  }

  echo json_encode($response);
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

    // Check if user exists and verify the password
    if ($logindata && password_verify($password, $logindata['userPass'])) {
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
      if ($logindata) {
        createAuditLog($conn, $logindata['userID'], 'LOGIN', 'users_tbl', $logindata['userID'], json_encode(['email' => $email]), json_encode(['status' => 'failed']));
      } else {
        // If user does not exist, log the attempt without userID
        createAuditLog($conn, null, 'LOGIN', 'users_tbl', null, json_encode(['email' => $email]), json_encode(['status' => 'failed']));
      }

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
    $status = 5; // Active

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
      $updatedAt = date('Y-m-d H:i:s');

      $updateCartItemSQL = "UPDATE cart_items_tbl SET cartItemQuantity = '$newQuantity', cartItemTotal = '$newTotalPrice', updatedAt = '$updatedAt' WHERE cartID = '$cartID' AND productID = '$productID'";

      if ($conn->query($updateCartItemSQL) === TRUE) {
        // Create audit log entry for UPDATE
        $newValues = json_encode(['cartItemQuantity' => $newQuantity, 'cartItemTotal' => $newTotalPrice]);
        $oldValues = json_encode(['cartItemQuantity' => $cartItemRow['cartItemQuantity'], 'cartItemTotal' => $cartItemRow['cartItemTotal']]);
        createAuditLog($conn, $userID, 'UPDATE', 'cart_items_tbl', $cartItemRow['cartItemID'], $oldValues, $newValues);

        echo json_encode(['success' => true, 'message' => 'Cart item updated successfully.']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
    } else {
      // Insert a new cart item
      $insertsql = "INSERT INTO cart_items_tbl (cartID, productID, cartItemQuantity, cartItemTotal, statusID) VALUES ('$cartID', '$productID', '$quantity', '$totalPrice', '$status')";

      if ($conn->query($insertsql) === TRUE) {
        // Create audit log entry for INSERT
        $newCartItemID = $conn->insert_id;
        $newValues = json_encode(['cartID' => $cartID, 'productID' => $productID, 'cartItemQuantity' => $quantity, 'cartItemTotal' => $totalPrice]);
        createAuditLog($conn, $userID, 'INSERT', 'cart_items_tbl', $newCartItemID, NULL, $newValues);

        echo json_encode(['success' => true, 'message' => 'Item added to cart successfully.']);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
      }
    }

    $conn->close();
  }
}

// Update Cart Item Quantity function
function updateCartItemQuantity()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Open db connection
    $conn = dbConnect();

    // Initialize variables
    $cartItemID = $_POST['cartItemID'];
    $newQuantity = $_POST['newQuantity'];
    $newTotalPrice = $_POST['newTotalPrice'];

    // Validation
    if (empty($cartItemID) || !is_numeric($cartItemID)) {
      echo json_encode(['success' => false, 'message' => 'Invalid cart item ID.']);
      exit;
    }

    if (empty($newQuantity) || !is_numeric($newQuantity) || $newQuantity <= 0) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid quantity.']);
      exit;
    }

    if (empty($newTotalPrice) || !is_numeric($newTotalPrice) || $newTotalPrice <= 0) {
      echo json_encode(['success' => false, 'message' => 'Invalid total price.']);
      exit;
    }

    // Update the cart item quantity and total price
    $updatedAt = date('Y-m-d H:i:s');
    $updateCartItemSQL = "UPDATE cart_items_tbl SET cartItemQuantity = '$newQuantity', cartItemTotal = '$newTotalPrice', updatedAt = '$updatedAt' WHERE cartItemID = '$cartItemID'";

    if ($conn->query($updateCartItemSQL) === TRUE) {
      echo json_encode(['success' => true, 'message' => 'Cart item quantity updated successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $conn->close();
  }
}

// Delete cart item function
function deleteCartItem()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userUpdaterID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    $conn = dbConnect();

    $cartItemID = $_POST['cartItemID'];

    // Retrieve current cart item data before deletion
    $currentDataSQL = "SELECT cartItemID, cartID, productID, cartItemQuantity, cartItemTotal FROM cart_items_tbl WHERE cartItemID=?";
    $stmt = $conn->prepare($currentDataSQL);
    $stmt->bind_param("i", $cartItemID);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentData = $result->fetch_assoc();
    $stmt->close();

    // Convert current data to JSON for logging
    $oldValues = json_encode($currentData);

    // Delete cart item record
    $deleteSQL = "DELETE FROM cart_items_tbl WHERE cartItemID=?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $cartItemID);

    if ($stmt->execute()) {
      // Log the deletion
      createAuditLog($conn, $userUpdaterID, 'DELETE', 'cart_items_tbl', $cartItemID, $oldValues, null);

      echo json_encode(['success' => true, 'message' => 'Cart item deleted successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    $stmt->close();
  }
}

// Place Order function
function placeOrder()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    // Open db connection
    $conn = dbConnect();

    // Initialize variables
    $cartItems = $_POST['cartItems'];
    $totalAmount = $_POST['totalAmount'];
    $mopID = $_POST['mopID'];

    // Validation
    if (empty($cartItems)) {
      echo json_encode(['success' => false, 'message' => 'No items in the cart.']);
      exit;
    }

    if (empty($totalAmount) || !is_numeric($totalAmount) || $totalAmount <= 0) {
      echo json_encode(['success' => false, 'message' => 'Invalid total amount.']);
      exit;
    }

    if (empty($mopID) || !is_numeric($mopID)) {
      echo json_encode(['success' => false, 'message' => 'Invalid payment method.']);
      exit;
    }

    // Step 2: Retrieve the cartID of the currently logged in user
    $selectCartSQL = "SELECT cartID FROM carts_tbl WHERE userID = '$userID' LIMIT 1";
    $cartResult = $conn->query($selectCartSQL);

    if ($cartResult->num_rows > 0) {
      $cartRow = $cartResult->fetch_assoc();
      $cartID = $cartRow['cartID'];
    } else {
      echo json_encode(['success' => false, 'message' => 'Cart not found for the current user.']);
      exit;
    }

    // Step 3: Create a new order in the orders_tbl
    $referenceNum = generateRefNum();
    $statusID = 1; // Assuming 1 is the status for a new order

    $insertOrderSQL = "INSERT INTO orders_tbl (referenceNum, userID, totalAmount, mopID, statusID) VALUES ('$referenceNum', '$userID', '$totalAmount', '$mopID', '$statusID')";

    if ($conn->query($insertOrderSQL) === TRUE) {
      $orderID = $conn->insert_id;

      // Audit log for Step 3
      createAuditLog($conn, $userID, 'INSERT', 'orders_tbl', $orderID, NULL, json_encode(['referenceNum' => $referenceNum, 'userID' => $userID, 'totalAmount' => $totalAmount, 'mopID' => $mopID, 'statusID' => $statusID]));

      // Step 4: Iteratively insert each cart item into the order_items_tbl
      foreach ($cartItems as $item) {
        $productID = $item['productID'];
        $quantity = $item['quantity'];
        $total = floatval($item['total']);

        $insertOrderItemSQL = "INSERT INTO order_items_tbl (orderID, productID, orderItemQuantity, orderItemTotal) VALUES ('$orderID', '$productID', '$quantity', '$total')";

        if ($conn->query($insertOrderItemSQL) === TRUE) {
          $orderItemID = $conn->insert_id;

          // Audit log for Step 4
          createAuditLog($conn, $userID, 'INSERT', 'order_items_tbl', $orderItemID, NULL, json_encode(['orderID' => $orderID, 'productID' => $productID, 'orderItemQuantity' => $quantity, 'orderItemTotal' => $total]));
        } else {
          echo json_encode(['success' => false, 'message' => 'Error inserting order items: ' . $conn->error]);
          exit;
        }

        // Step 5: Subtract the inStock in products_tbl based on the quantity of the product that was ordered
        // Retrieve old values before updating
        $selectProductSQL = "SELECT inStock, prodSold FROM products_tbl WHERE productID = '$productID'";
        $productResult = $conn->query($selectProductSQL);
        $productRow = $productResult->fetch_assoc();
        $oldInStock = $productRow['inStock'];
        $oldProdSold = $productRow['prodSold'];

        $updateProductStockSQL = "UPDATE products_tbl SET inStock = inStock - '$quantity', prodSold = prodSold + '$quantity' WHERE productID = '$productID'";

        if ($conn->query($updateProductStockSQL) === TRUE) {
          // Audit log for Step 5
          createAuditLog($conn, $userID, 'UPDATE', 'products_tbl', $productID, json_encode(['inStock' => $oldInStock, 'prodSold' => $oldProdSold]), json_encode(['inStock' => $oldInStock - $quantity, 'prodSold' => $oldProdSold + $quantity]));
        } else {
          echo json_encode(['success' => false, 'message' => 'Error updating product stock: ' . $conn->error]);
          exit;
        }
      }

      // Step 6: Update the statusID of all ordered items in cart_items_tbl to 6 (Removed)
      foreach ($cartItems as $item) {
        $productID = $item['productID'];

        // Update the statusID for each item in the cart
        $updateCartItemsSQL = "UPDATE cart_items_tbl SET statusID = 6 WHERE cartID = '$cartID' AND productID = '$productID'";

        if ($conn->query($updateCartItemsSQL) === FALSE) {
          echo json_encode(['success' => false, 'message' => 'Error updating cart items status: ' . $conn->error]);
          exit;
        }
      }

      // Step 7: Clear the items with removed status from the cart_items_tbl
      // Retrieve old values before deleting
      $selectCartItemsSQL = "SELECT * FROM cart_items_tbl WHERE cartID = '$cartID' AND statusID = 6";
      $cartItemsResult = $conn->query($selectCartItemsSQL);
      $cartItemsData = [];
      while ($row = $cartItemsResult->fetch_assoc()) {
        $cartItemsData[] = $row;
      }

      $deleteCartItemsSQL = "DELETE FROM cart_items_tbl WHERE cartID = '$cartID' AND statusID = 6";

      if ($conn->query($deleteCartItemsSQL) === TRUE) {
        // Audit log for Step 7
        foreach ($cartItemsData as $cartItem) {
          createAuditLog($conn, $userID, 'DELETE', 'cart_items_tbl', $cartItem['cartItemID'], json_encode($cartItem), NULL);
        }
      } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting cart items: ' . $conn->error]);
        exit;
      }

      echo json_encode(['success' => true, 'message' => 'Order placed successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error creating order: ' . $conn->error]);
    }

    $conn->close();
  }
}

// Function for registering customer
function regCustomer()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once 'send_verification.php';

    // Open db connection
    $conn = dbConnect();
    if (!$conn) {
      echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
      exit;
    }

    // Initialize variables
    $firstname = $_POST['uFname'];
    $lastname = $_POST['uLname'];
    $address = $_POST['uAdd'];
    $phone = $_POST['uPhone'];
    $email = $_POST['uEmail'];
    $password = $_POST['uPass'];
    $role = 1; // Role for customer
    $otp = rand(100000, 999999); // Generate OTP for verification
    $status = "Unverified"; // Initial status for customer

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

    // Check if email already exists using prepared statement
    $stmt = $conn->prepare("SELECT * FROM users_tbl WHERE userEmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailCheckResult = $stmt->get_result();

    if ($emailCheckResult->num_rows > 0) {
      echo json_encode(['success' => false, 'message' => 'Email already exists. Please use a different email.']);
      exit;
    }

    // Hash the password using password_hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Get current date and time
    $currentDateTime = date('Y-m-d H:i:s');

    // Insert query using prepared statement for users_tbl
    $stmt = $conn->prepare("INSERT INTO users_tbl (userFname, userLname, userAdd, userPhone, userEmail, userPass, roleID, otp, status, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissiisss", $firstname, $lastname, $address, $phone, $email, $hashed_password, $role, $otp, $status, $currentDateTime, $currentDateTime);

    if ($stmt->execute()) {
      // Get the last inserted user ID
      $userID = $conn->insert_id;

      // Create audit log for the new user
      $actionType = 'CREATE';
      $tableName = 'users_tbl';
      $recordID = $userID;
      $oldValues = null; // No old values for a new record
      $newValues = json_encode([
        'userFname' => $firstname,
        'userLname' => $lastname,
        'userAdd' => $address,
        'userPhone' => $phone,
        'userEmail' => $email,
        'roleID' => $role,
        'otp' => $otp,
        'status' => $status,
        'createdAt' => $currentDateTime,
        'updatedAt' => $currentDateTime
      ]);

      createAuditLog($conn, $userID, $actionType, $tableName, $recordID, $oldValues, $newValues);

      // Create a cart for the newly registered user
      $cartStmt = $conn->prepare("INSERT INTO carts_tbl (userID) VALUES (?)");
      $cartStmt->bind_param("i", $userID);

      if ($cartStmt->execute()) {
        // Create audit log for the cart creation
        $actionType = 'CREATE';
        $tableName = 'carts_tbl';
        $recordID = $conn->insert_id; // Get the last inserted cart ID
        $oldValues = null; // No old values for a new record
        $newValues = json_encode(['cartID' => $recordID, 'userID' => $userID]);

        createAuditLog($conn, $userID, $actionType, $tableName, $recordID, $oldValues, $newValues);
      } else {
        echo json_encode(['success' => false, 'message' => 'Error creating cart: ' . $cartStmt->error]);
        $cartStmt->close();
        $stmt->close();
        $conn->close();
        exit;
      }
      $cartStmt->close();

      // Send verification email
      send_verification($firstname, $email, $otp);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
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

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
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
