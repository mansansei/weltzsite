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
  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
  }

  $conn = dbConnect();
  $email = isset($_POST['uEmail']) ? trim($_POST['uEmail']) : '';
  $password = isset($_POST['uPass']) ? trim($_POST['uPass']) : '';

  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email must be a valid email address.']);
    exit;
  }

  if (empty($password) || strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long and contain at least 1 digit and 1 special character (!@#$%^&*).']);
    exit;
  }

  // Lockout Check
  if (isset($_SESSION['lockout_until']) && $_SESSION['lockout_until'] > time()) {
    echo json_encode(['success' => false, 'message' => 'Too many failed login attempts. Please try again later.']);
    exit;
  }

  // Fetch user data
  $stmt = $conn->prepare("SELECT * FROM users_tbl WHERE userEmail=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $loginresult = $stmt->get_result();
  $logindata = $loginresult->fetch_assoc();
  $stmt->close();

  if ($logindata) {
    $failedAttempts = $logindata['failedAttempts'];
    $lockedUntil = $logindata['lockedUntil'];

    // Check if account is locked
    if ($lockedUntil && strtotime($lockedUntil) > time()) {
      echo json_encode(['success' => false, 'message' => 'Too many failed login attempts. Please try again later.']);
      exit;
    }

    if (password_verify($password, $logindata['userPass'])) {
      // Reset failed attempts
      $stmt = $conn->prepare("UPDATE users_tbl SET failedAttempts = 0, lockedUntil = NULL WHERE userEmail = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->close();

      // Set session data
      $_SESSION['username'] = $logindata['userFname'] . " " . $logindata['userLname'];
      $_SESSION['userID'] = $logindata['userID'];
      $_SESSION['email'] = $logindata['userEmail'];
      $_SESSION['role'] = $logindata['roleID'];
      $_SESSION['isLoggedIn'] = true;

      createAuditLog($conn, $logindata['userID'], 'LOGIN', 'users_tbl', $logindata['userID'], null, json_encode(['status' => 'success']));

      echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'redirect' => ($logindata['roleID'] == 1) ? 'Home.php' : 'adminIndex.php'
      ]);
      exit;
    } else {
      // Handle failed password attempts
      $failedAttempts++;
      if ($failedAttempts >= 3) {
        $lockoutTime = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        $stmt = $conn->prepare("UPDATE users_tbl SET failedAttempts = ?, lockedUntil = ? WHERE userEmail = ?");
        $stmt->bind_param("iss", $failedAttempts, $lockoutTime, $email);
      } else {
        $stmt = $conn->prepare("UPDATE users_tbl SET failedAttempts = ? WHERE userEmail = ?");
        $stmt->bind_param("is", $failedAttempts, $email);
      }
      $stmt->execute();
      $stmt->close();

      createAuditLog($conn, $logindata['userID'], 'LOGIN', 'users_tbl', $logindata['userID'], json_encode(['email' => $email]), json_encode(['status' => 'failed']));

      echo json_encode(['success' => false, 'message' => 'Email or Password is incorrect. ' . $failedAttempts . ' out of 3 failed attempts']);
      exit;
    }
  } else {
    // Handle non-existent users
    if (!isset($_SESSION['failed_attempts'])) {
      $_SESSION['failed_attempts'] = 0;
    }

    $_SESSION['failed_attempts']++;

    if ($_SESSION['failed_attempts'] >= 3) {
      $_SESSION['lockout_until'] = time() + (5 * 60);
      echo json_encode(['success' => false, 'message' => 'Too many failed login attempts. Please try again in 5 minutes']);
      exit;
    }

    createAuditLog($conn, null, 'LOGIN', 'users_tbl', null, json_encode(['email' => $email]), json_encode(['status' => 'failed']));

    echo json_encode(['success' => false, 'message' => 'Email or Password is incorrect.']);
    exit;
  }
}

// Logout validation function
function logoutUser()
{
  header('Content-Type: application/json'); // Ensure JSON response

  // Retrieve the user ID from the session
  $userID = $_SESSION['userID'] ?? null;

  // If user ID exists, log the logout event
  if ($userID) {
    $conn = dbConnect();
    createAuditLog($conn, $userID, 'LOGOUT', 'users_tbl', $userID, null, json_encode(['status' => 'logged out']));
  }

  // Unset and destroy the session
  session_unset();
  session_destroy();

  // Send JSON response
  echo json_encode([
    'success' => true,
    'message' => 'Logout successful',
    'redirect' => 'Login.php'
  ]);
  exit;
}


// Add to Cart function
function addToCart()
{
  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
  }

  // Check if user is logged in
  if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
  }

  $userID = $_SESSION['userID'];

  // Open database connection
  $conn = dbConnect();

  // Get and sanitize POST data
  $productID = isset($_POST['productID']) ? trim($_POST['productID']) : null;
  $quantity = isset($_POST['quantity']) ? trim($_POST['quantity']) : null;
  $totalPrice = isset($_POST['totalPrice']) ? trim($_POST['totalPrice']) : null;
  $status = 5; // Active cart item

  // Input validation
  if (empty($productID) || !is_numeric($productID)) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
  }

  if (empty($quantity) || !is_numeric($quantity) || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid quantity']);
    exit;
  }

  if (empty($totalPrice) || !is_numeric($totalPrice) || $totalPrice <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid total price']);
    exit;
  }

  // Check stock before adding to cart
  $stmt = $conn->prepare("SELECT inStock FROM products_tbl WHERE productID = ? LIMIT 1");
  $stmt->bind_param("i", $productID);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();
  $stmt->close();

  if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
  }

  if ($product['inStock'] == 0) {
    echo json_encode(['success' => false, 'message' => 'This product is out of stock']);
    exit;
  }

  if ($quantity > $product['inStock']) {
    echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
    exit;
  }

  // Get the cartID for the logged-in user
  $cartID = null;
  $stmt = $conn->prepare("SELECT cartID FROM carts_tbl WHERE userID = ? LIMIT 1");
  $stmt->bind_param("i", $userID);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $cartID = $row['cartID'];
  }
  $stmt->close();

  if (!$cartID) {
    echo json_encode(['success' => false, 'message' => 'Cart not found for the current user']);
    exit;
  }

  // Check if the product already exists in the cart
  $stmt = $conn->prepare("SELECT cartItemID, cartItemQuantity, cartItemTotal FROM cart_items_tbl WHERE cartID = ? AND productID = ? LIMIT 1");
  $stmt->bind_param("ii", $cartID, $productID);
  $stmt->execute();
  $cartItemResult = $stmt->get_result();
  $cartItem = $cartItemResult->fetch_assoc();
  $stmt->close();

  if ($cartItem) {
    // Update existing cart item
    $newQuantity = $cartItem['cartItemQuantity'] + $quantity;
    $newTotalPrice = $cartItem['cartItemTotal'] + $totalPrice;

    // ✅ Ensure new quantity does not exceed available stock
    if ($newQuantity > $product['inStock']) {
      echo json_encode(['success' => false, 'message' => 'Not enough stock available']);
      exit;
    }

    $updatedAt = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE cart_items_tbl SET cartItemQuantity = ?, cartItemTotal = ?, updatedAt = ? WHERE cartID = ? AND productID = ?");
    $stmt->bind_param("idsii", $newQuantity, $newTotalPrice, $updatedAt, $cartID, $productID);
    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
      // Log the update
      createAuditLog($conn, $userID, 'UPDATE', 'cart_items_tbl', $cartItem['cartItemID'], json_encode(['cartItemQuantity' => $cartItem['cartItemQuantity'], 'cartItemTotal' => $cartItem['cartItemTotal']]), json_encode(['cartItemQuantity' => $newQuantity, 'cartItemTotal' => $newTotalPrice]));

      echo json_encode(['success' => true, 'message' => 'Cart item updated successfully']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error updating cart item']);
    }
  } else {
    // Insert new cart item
    $stmt = $conn->prepare("INSERT INTO cart_items_tbl (cartID, productID, cartItemQuantity, cartItemTotal, statusID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidi", $cartID, $productID, $quantity, $totalPrice, $status);
    $success = $stmt->execute();
    $newCartItemID = $stmt->insert_id;
    $stmt->close();

    if ($success) {
      // Log the new cart item
      createAuditLog($conn, $userID, 'CREATE', 'cart_items_tbl', $newCartItemID, null, json_encode(['cartID' => $cartID, 'productID' => $productID, 'cartItemQuantity' => $quantity, 'cartItemTotal' => $totalPrice]));

      echo json_encode(['success' => true, 'message' => 'Item added to cart successfully']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error adding item to cart']);
    }
  }

  $conn->close();
  exit;
}

// Update Cart Item Quantity function
function updateCartItemQuantity()
{
  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
  }

  // Check if user is logged in
  if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
  }

  $userID = $_SESSION['userID'];

  // Open database connection
  $conn = dbConnect();

  // Get and sanitize POST data
  $cartItemID = isset($_POST['cartItemID']) ? trim($_POST['cartItemID']) : null;
  $newQuantity = isset($_POST['newQuantity']) ? trim($_POST['newQuantity']) : null;
  $newTotalPrice = isset($_POST['newTotalPrice']) ? trim($_POST['newTotalPrice']) : null;

  // Input validation
  if (empty($cartItemID) || !is_numeric($cartItemID)) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart item ID']);
    exit;
  }

  if (empty($newQuantity) || !is_numeric($newQuantity) || $newQuantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid quantity']);
    exit;
  }

  if (empty($newTotalPrice) || !is_numeric($newTotalPrice) || $newTotalPrice <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid total price']);
    exit;
  }

  // Check if the cart item exists
  $stmt = $conn->prepare("SELECT cartItemQuantity, cartItemTotal FROM cart_items_tbl WHERE cartItemID = ? LIMIT 1");
  $stmt->bind_param("i", $cartItemID);
  $stmt->execute();
  $result = $stmt->get_result();
  $cartItem = $result->fetch_assoc();
  $stmt->close();

  if (!$cartItem) {
    echo json_encode(['success' => false, 'message' => 'Cart item not found']);
    exit;
  }

  // Prepare the update query
  $updatedAt = date('Y-m-d H:i:s');
  $stmt = $conn->prepare("UPDATE cart_items_tbl SET cartItemQuantity = ?, cartItemTotal = ?, updatedAt = ? WHERE cartItemID = ?");
  $stmt->bind_param("idsi", $newQuantity, $newTotalPrice, $updatedAt, $cartItemID);
  $success = $stmt->execute();
  $stmt->close();

  if ($success) {
    // Log the update
    createAuditLog($conn, $userID, 'UPDATE', 'cart_items_tbl', $cartItemID, json_encode(['cartItemQuantity' => $cartItem['cartItemQuantity'], 'cartItemTotal' => $cartItem['cartItemTotal']]), json_encode(['cartItemQuantity' => $newQuantity, 'cartItemTotal' => $newTotalPrice]));

    echo json_encode(['success' => true, 'message' => 'Cart item quantity updated successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error updating cart item']);
  }

  $conn->close();
  exit;
}


// Delete cart item function
function deleteCartItem()
{
  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
  }

  // Check if user is logged in
  if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
  }

  $userUpdaterID = $_SESSION['userID'];

  // Validate input
  $cartItemID = isset($_POST['cartItemID']) ? trim($_POST['cartItemID']) : null;

  if (empty($cartItemID) || !is_numeric($cartItemID)) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart item ID']);
    exit;
  }

  // Open database connection
  $conn = dbConnect();

  // Retrieve current cart item data before deletion
  $stmt = $conn->prepare("SELECT cartID, productID, cartItemQuantity, cartItemTotal FROM cart_items_tbl WHERE cartItemID=? LIMIT 1");
  $stmt->bind_param("i", $cartItemID);
  $stmt->execute();
  $result = $stmt->get_result();
  $currentData = $result->fetch_assoc();
  $stmt->close();

  if (!$currentData) {
    echo json_encode(['success' => false, 'message' => 'Cart item not found']);
    exit;
  }

  // Convert current data to JSON for logging
  $oldValues = json_encode($currentData);

  // Delete cart item record
  $stmt = $conn->prepare("DELETE FROM cart_items_tbl WHERE cartItemID=?");
  $stmt->bind_param("i", $cartItemID);
  $success = $stmt->execute();
  $stmt->close();

  if ($success) {
    // Log the deletion
    createAuditLog($conn, $userUpdaterID, 'DELETE', 'cart_items_tbl', $cartItemID, $oldValues, null);
    echo json_encode(['success' => true, 'message' => 'Cart item deleted successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Error deleting cart item']);
  }

  $conn->close();
  exit;
}


// Place Order function
function placeOrder()
{

  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
  }

  require 'send_invoice.php';

  $conn = dbConnect();
  $userID = $_SESSION['userID'] ?? null;
  $cartItems = $_POST['cartItems'] ?? [];
  $totalAmount = $_POST['totalAmount'] ?? null;
  $mopID = $_POST['mopID'] ?? null;

  // Validate input data
  if (empty($cartItems)) {
    response(false, 'No items in the cart.');
  }
  if (empty($totalAmount) || !is_numeric($totalAmount) || $totalAmount <= 0) {
    response(false, 'Invalid total amount.');
  }
  if (empty($mopID) || !is_numeric($mopID)) {
    response(false, 'Invalid payment method.');
  }

  // Retrieve the user's cart
  $stmt = $conn->prepare("SELECT cartID FROM carts_tbl WHERE userID = ? LIMIT 1");
  $stmt->bind_param("i", $userID);
  $stmt->execute();
  $cartResult = $stmt->get_result();
  if ($cartResult->num_rows === 0) {
    response(false, 'Cart not found for the current user.');
  }
  $cartID = $cartResult->fetch_assoc()['cartID'];
  $stmt->close();

  // Insert order
  $referenceNum = generateRefNum();
  $statusID = 1;
  $stmt = $conn->prepare("INSERT INTO orders_tbl (referenceNum, userID, totalAmount, mopID, statusID) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("siddi", $referenceNum, $userID, $totalAmount, $mopID, $statusID);
  if (!$stmt->execute()) {
    response(false, 'Error creating order: ' . $conn->error);
  }
  $orderID = $stmt->insert_id;
  createAuditLog($conn, $userID, 'CREATE', 'orders_tbl', $orderID, null, json_encode(['referenceNum' => $referenceNum, 'totalAmount' => $totalAmount, 'mopID' => $mopID]));
  $stmt->close();

  // Insert order items and update stock
  foreach ($cartItems as $item) {
    $productID = $item['productID'];
    $quantity = $item['quantity'];
    $total = floatval($item['total']);

    $stmt = $conn->prepare("INSERT INTO order_items_tbl (orderID, productID, orderItemQuantity, orderItemTotal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $orderID, $productID, $quantity, $total);
    $stmt->execute();
    $stmt->close();

    createAuditLog($conn, $userID, 'CREATE', 'order_items_tbl', $orderID, null, json_encode(['productID' => $productID, 'quantity' => $quantity, 'total' => $total]));

    // Update product stock
    $stmt = $conn->prepare("UPDATE products_tbl SET inStock = inStock - ?, prodSold = prodSold + ? WHERE productID = ?");
    $stmt->bind_param("iii", $quantity, $quantity, $productID);
    $stmt->execute();
    $stmt->close();

    // Mark ordered items in the cart
    $stmt = $conn->prepare("UPDATE cart_items_tbl SET statusID = 6 WHERE cartID = ? AND productID = ?");
    $stmt->bind_param("ii", $cartID, $productID);
    $stmt->execute();
    $stmt->close();
  }

  // Remove only ordered items from the cart
  $stmt = $conn->prepare("DELETE FROM cart_items_tbl WHERE cartID = ? AND statusID = 6");
  $stmt->bind_param("i", $cartID);
  $stmt->execute();
  $stmt->close();
  createAuditLog($conn, $userID, 'DELETE', 'cart_items_tbl', $cartID, null, 'Removed items that were ordered');

  // Send notification
  $notifName = "Order Placed";
  $notifMessage = "Your order #$referenceNum has been successfully placed.";
  $statusUnread = 9;
  $orderNotif = "Order";
  $stmt = $conn->prepare("INSERT INTO notifs_tbl (userID, notifName, notifMessage, statusID, notifType) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("issis", $userID, $notifName, $notifMessage, $statusUnread, $orderNotif);
  $stmt->execute();
  $stmt->close();
  createAuditLog($conn, $userID, 'CREATE', 'notifs_tbl', $conn->insert_id, null, json_encode(['notifName' => $notifName, 'notifMessage' => $notifMessage, 'statusID' => $statusUnread]));

  // Retrieve user email and send invoice
  $stmt = $conn->prepare("SELECT userEmail FROM users_tbl WHERE userID = ?");
  $stmt->bind_param("i", $userID);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $email = $result->fetch_assoc()['userEmail'];
    send_invoice($email, $referenceNum, $orderID);
  }
  $stmt->close();

  $conn->close();
  response(true, 'Order placed successfully. Check your email for the invoice.');
}

function markAsRead()
{
  header('Content-Type: application/json'); // Ensure JSON response

  if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
  }

  if (!isset($_POST['notifID'])) {
    echo json_encode(['success' => false, 'message' => 'Missing notification ID.']);
    exit;
  }

  $conn = dbConnect(); // Ensure connection is established
  if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
  }

  $userID = $_SESSION['userID'];
  $notifID = intval($_POST['notifID']); // Sanitize input

  $updateSQL = "UPDATE notifs_tbl SET statusID = 8 WHERE notifID = ? AND userID = ?";
  $stmt = $conn->prepare($updateSQL);

  if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
    exit;
  }

  $stmt->bind_param("ii", $notifID, $userID);

  if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Notification marked as read.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to update notification status.']);
  }

  $stmt->close();
  $conn->close();
  exit; // Ensure script stops execution
}



function response($success, $message)
{
  echo json_encode(['success' => $success, 'message' => $message]);
  exit;
}

// Function for registering customer
function regCustomer()
{
  header('Content-Type: application/json'); // Ensure JSON response
  error_reporting(0);
  ini_set('display_errors', 0);

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
  }

  include_once 'send_verification.php';

  // Open database connection
  $conn = dbConnect();
  if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
  }

  // Initialize variables
  $firstname = htmlspecialchars(trim($_POST['uFname'] ?? ''));
  $lastname = htmlspecialchars(trim($_POST['uLname'] ?? ''));
  $address = htmlspecialchars(trim($_POST['uAdd'] ?? ''));
  $phone = htmlspecialchars(trim($_POST['uPhone'] ?? ''));
  $email = htmlspecialchars(trim($_POST['uEmail'] ?? ''));
  $password = trim($_POST['uPass'] ?? '');
  $role = 1; // Role for customer
  $otp = rand(100000, 999999); // Generate OTP for verification
  $status = "Unverified"; // Initial status for customer
  $currentDateTime = date('Y-m-d H:i:s');

  // Validation
  if (!preg_match('/^[a-zA-Z]{1,50}$/', $firstname)) {
    echo json_encode(['success' => false, 'message' => 'Invalid first name.']);
    exit;
  }
  if (!preg_match('/^[a-zA-Z]{1,50}$/', $lastname)) {
    echo json_encode(['success' => false, 'message' => 'Invalid last name.']);
    exit;
  }
  if (empty($address) || strlen($address) > 100) {
    echo json_encode(['success' => false, 'message' => 'Invalid address.']);
    exit;
  }
  if (!preg_match('/^\d{11}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Invalid phone number.']);
    exit;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
  }
  if (strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Weak password.']);
    exit;
  }

  // Check if email already exists
  $stmt = $conn->prepare("SELECT 1 FROM users_tbl WHERE userEmail = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists.']);
    exit;
  }
  $stmt->close();

  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert user into users_tbl
  $stmt = $conn->prepare("INSERT INTO users_tbl (userFname, userLname, userAdd, userPhone, userEmail, userPass, roleID, otp, status, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssissiisss", $firstname, $lastname, $address, $phone, $email, $hashed_password, $role, $otp, $status, $currentDateTime, $currentDateTime);

  if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'User registration failed: ' . $stmt->error]);
    exit;
  }

  $userID = $stmt->insert_id;
  $stmt->close();

  // Create audit log
  createAuditLog($conn, $userID, 'CREATE', 'users_tbl', $userID, null, json_encode(compact('firstname', 'lastname', 'address', 'phone', 'email', 'role', 'otp', 'status', 'currentDateTime')));

  // Create user cart
  $stmt = $conn->prepare("INSERT INTO carts_tbl (userID) VALUES (?)");
  $stmt->bind_param("i", $userID);
  if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Cart creation failed: ' . $stmt->error]);
    exit;
  }

  $cartID = $stmt->insert_id;
  createAuditLog($conn, $userID, 'CREATE', 'carts_tbl', $cartID, null, json_encode(['cartID' => $cartID, 'userID' => $userID]));
  $stmt->close();

  // Send verification email
  send_verification($firstname, $email, $otp);

  // Close connection and return success response
  $conn->close();
  echo json_encode(['success' => true, 'message' => 'Registration successful. Verification email sent.']);
}

// Function for registering a new admin
function regAdmin()
{
  header('Content-Type: application/json'); // Ensure JSON response
  error_reporting(0);
  ini_set('display_errors', 0);

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
  }

  session_start();
  $userUpdaterID = $_SESSION['userID'] ?? null;

  // Open database connection
  $conn = dbConnect();

  // Retrieve and sanitize input
  $firstname = htmlspecialchars(trim($_POST['uFname'] ?? ''));
  $lastname = htmlspecialchars(trim($_POST['uLname'] ?? ''));
  $address = htmlspecialchars(trim($_POST['uAdd'] ?? ''));
  $phone = htmlspecialchars(trim($_POST['uPhone'] ?? ''));
  $email = htmlspecialchars(trim($_POST['uEmail'] ?? ''));
  $password = htmlspecialchars(trim($_POST['uPass'] ?? ''));

  $role = 2;
  $otp = 0;
  $status = "Verified";

  // Validation
  if (!preg_match('/^[a-zA-Z]{1,50}$/', $firstname)) {
    echo json_encode(['success' => false, 'message' => 'Invalid first name.']);
    exit;
  }
  if (!preg_match('/^[a-zA-Z]{1,50}$/', $lastname)) {
    echo json_encode(['success' => false, 'message' => 'Invalid last name.']);
    exit;
  }
  if (strlen($address) > 100 || empty($address)) {
    echo json_encode(['success' => false, 'message' => 'Invalid address.']);
    exit;
  }
  if (!preg_match('/^\d{11}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Invalid phone number.']);
    exit;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email.']);
    exit;
  }
  if (strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Password requirements not met.']);
    exit;
  }

  // Check if email already exists
  $stmt = $conn->prepare("SELECT 1 FROM users_tbl WHERE userEmail = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists.']);
    exit;
  }
  $stmt->close();

  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $currentDateTime = date('Y-m-d H:i:s');

  // Insert user data
  $stmt = $conn->prepare("INSERT INTO users_tbl (userFname, userLname, userAdd, userPhone, userEmail, userPass, roleID, otp, status, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssssissss", $firstname, $lastname, $address, $phone, $email, $hashed_password, $role, $otp, $status, $currentDateTime, $currentDateTime);

  if ($stmt->execute()) {
    $newUserID = $stmt->insert_id;

    // Create audit log
    $newValues = json_encode(['userFname' => $firstname, 'userLname' => $lastname, 'userAdd' => $address, 'userPhone' => $phone, 'userEmail' => $email, 'roleID' => $role, 'otp' => $otp, 'status' => $status]);
    createAuditLog($conn, $userUpdaterID, 'CREATE', 'users_tbl', $newUserID, NULL, $newValues);

    echo json_encode(['success' => true, 'message' => 'Admin registered successfully.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
  }

  $stmt->close();
  $conn->close();
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
  header('Content-Type: application/json'); // Ensure JSON response
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $userUpdaterID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

    $conn = dbConnect();
    if (!$conn) {
      echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
      exit;
    }

    if (!isset($_POST['userID']) || !is_numeric($_POST['userID'])) {
      echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
      exit;
    }

    $userID = intval($_POST['userID']);

    // Retrieve current user data before deletion
    $currentDataSQL = "SELECT userFname, userLname, userAdd, userPhone, userEmail FROM users_tbl WHERE userID=?";
    $stmt = $conn->prepare($currentDataSQL);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentData = $result->fetch_assoc();
    $stmt->close();

    if (!$currentData) {
      echo json_encode(['success' => false, 'message' => 'User not found.']);
      exit;
    }

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
      echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
  } else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
  }
}


// Function to add product
function addProduct()
{
  header('Content-Type: application/json'); // Ensure JSON response
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

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

    $insertsql = "INSERT INTO products_tbl (userID, productName, productIMG, categoryID, productDesc, productPrice, inStock, prodSold, createdAt, updatedAt)
                      VALUES ('$userID', '$productName', '$productIMGPath', '$categoryID', '$productDesc', '$productPrice', '$inStock', 0, '$currentDateTime', '$currentDateTime')";

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

// Function to cancel an order
function cancelOrder()
{
  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
  }


  if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
  }

  $userID = $_SESSION['userID'];


  $conn = dbConnect();

  // Get and sanitize POST data
  $orderID = isset($_POST['orderID']) ? trim($_POST['orderID']) : null;

  // Input validation
  if (empty($orderID) || !is_numeric($orderID)) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit;
  }

  // Check if the order belongs to the logged-in user
  $stmt = $conn->prepare("SELECT orderID FROM orders_tbl WHERE orderID = ? AND userID = ? LIMIT 1");
  $stmt->bind_param("ii", $orderID, $userID);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Order not found or does not belong to you']);
    exit;
  }
  $stmt->close();

  // Update the order status to "Cancelled" (assuming statusID 4 is for "Cancelled")
  $statusID = 3; // Status ID for "Cancelled"
  $stmt = $conn->prepare("UPDATE orders_tbl SET statusID = ? WHERE orderID = ?");
  $stmt->bind_param("ii", $statusID, $orderID);
  $success = $stmt->execute();
  $stmt->close();

  if ($success) {
    // Log the order cancellation
    createAuditLog($conn, $userID, 'UPDATE', 'orders_tbl', $orderID, json_encode(['statusID' => 'Previous Status']), json_encode(['statusID' => $statusID]));

    echo json_encode(['success' => true, 'message' => 'Order cancelled successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel the order']);
  }

  $conn->close();
  exit;
}

// Function to update an order's status
function updateOrderStatus()
{
  header('Content-Type: application/json'); // Ensure JSON response

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
  }

  // Check if the user is logged in (if needed)
  if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
  }

  // Get and sanitize POST data
  $orderID = isset($_POST['orderID']) ? trim($_POST['orderID']) : null;
  $newStatus = isset($_POST['newStatus']) ? trim($_POST['newStatus']) : null;

  // Input validation
  if (empty($orderID) || !is_numeric($orderID)) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit;
  }
  if (empty($newStatus) || !is_numeric($newStatus)) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
  }

  // Connect to the database
  $conn = dbConnect();

  // Check if the order exists and get the userID and referenceNum
  $stmt = $conn->prepare("SELECT userID, referenceNum FROM orders_tbl WHERE orderID = ? LIMIT 1");
  $stmt->bind_param("i", $orderID);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
    exit;
  }

  $orderData = $result->fetch_assoc();
  $userID = $orderData['userID'];
  $referenceNum = $orderData['referenceNum'];
  $stmt->close();

  // Update the order status
  $stmt = $conn->prepare("UPDATE orders_tbl SET statusID = ? WHERE orderID = ?");
  $stmt->bind_param("ii", $newStatus, $orderID);
  $success = $stmt->execute();
  $stmt->close();

  if ($success) {
    // Log the order status update (optional)
    createAuditLog($conn, $_SESSION['userID'], 'UPDATE', 'orders_tbl', $orderID, json_encode(['statusID' => 'Previous Status']), json_encode(['statusID' => $newStatus]));

    // Send notification to the user based on the new status
    $notifName = "";
    $notifMessage = "";
    $statusUnread = 9; // Assuming 9 is the status ID for unread notifications
    $orderNotif = "Order";

    switch ($newStatus) {
      case 2: // To Pick Up
        $notifName = "Order Ready for Pickup";
        $notifMessage = "Your order #$referenceNum is now ready for pickup.";
        break;
      case 4: // Picked Up
        $notifName = "Order Picked Up";
        $notifMessage = "Your order #$referenceNum has been successfully picked up.";
        break;
      default:
        // No notification for other statuses
        break;
    }

    if (!empty($notifName)) {
      // Insert the notification into the database
      $stmt = $conn->prepare("INSERT INTO notifs_tbl (userID, notifName, notifMessage, statusID, notifType) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issis", $userID, $notifName, $notifMessage, $statusUnread, $orderNotif);
      $stmt->execute();
      $stmt->close();

      // Log the notification creation (optional)
      createAuditLog($conn, $userID, 'CREATE', 'notifs_tbl', $conn->insert_id, null, json_encode(['notifName' => $notifName, 'notifMessage' => $notifMessage, 'statusID' => $statusUnread]));
    }

    // Retrieve user email and send invoice (if needed)
    if ($newStatus == 4) { // Only send an email for "Picked Up" status
      $stmt = $conn->prepare("SELECT userEmail FROM users_tbl WHERE userID = ?");
      $stmt->bind_param("i", $userID);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        $email = $result->fetch_assoc()['userEmail'];
        send_invoice($email, $referenceNum, $orderID); // Assuming send_invoice() is defined
      }
      $stmt->close();
    }

    echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Failed to update the order status']);
  }

  $conn->close();
  exit;
}
