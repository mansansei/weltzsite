<?php
session_start();

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header("Location: login.php");
    exit();
}

include_once 'weltz_dbconnect.php';

$cartItemIDs = isset($_GET['items']) ? explode(',', $_GET['items']) : [];

if (empty($cartItemIDs)) {
    echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'No items selected',
            text: 'No items selected for checkout',
            onClose: () => {
                window.location.href = 'cart.php';
            }
        });
    </script>";
    exit();
}

$placeholders = implode(',', array_fill(0, count($cartItemIDs), '?'));
$sql = "SELECT ci.cartItemID, ci.productID, ci.cartItemQuantity, ci.cartItemTotal, p.productName, c.categoryName 
        FROM cart_items_tbl ci
        JOIN products_tbl p ON ci.productID = p.productID
        JOIN categories_tbl c ON p.categoryID = c.categoryID
        WHERE ci.cartItemID IN ($placeholders)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('i', count($cartItemIDs)), ...$cartItemIDs);
$stmt->execute();
$result = $stmt->get_result();

// Retrieve modes of payment
$paymentSql = "SELECT mopID, mopName FROM modes_of_payment_tbl";
$paymentStmt = $conn->prepare($paymentSql);
$paymentStmt->execute();
$paymentResult = $paymentStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Weltz INC</title>
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&display=swap" rel="stylesheet">
    <?php require_once 'cssLibraries.php' ?>
</head>

<body class="bg-light">
    <header class="container bg-danger text-white py-2">
        <h5 class="text-center">Weltz Industrial INC. Phils</h5>
    </header>
    <div class="container mt-5 min-vh-100">
        <div class="row border-bottom border-danger mb-4">
            <div class="col-md-9">
                <h1>Checkout</h1>
            </div>
        </div>
        <div class="list-group">
            <?php
            $totalAmount = 0;
            while ($row = $result->fetch_assoc()) {
                $totalAmount += $row['cartItemTotal'];
            ?>
                <div class="itemsToOrder list-group-item" data-productid="<?php echo $row['productID']; ?>">
                    <div class="row">
                        <div class="col-md-8">
                            <h5><?php echo htmlspecialchars($row['productName']); ?></h5>
                            <p>Category: <?php echo htmlspecialchars($row['categoryName']); ?></p>
                            <p class="quantity">Quantity: <?php echo intval($row['cartItemQuantity']); ?></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="price">Price: PHP <?php echo number_format($row['cartItemTotal'], 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Payment Methods Section -->
        <div class="payment-methods mt-4">
            <h4>Payment Methods</h4>
            <ul class="list-group">
                <?php while ($paymentRow = $paymentResult->fetch_assoc()) { ?>
                    <li class="paymentMethod list-group-item">
                        <input type="radio" name="paymentMethod" value="<?php echo htmlspecialchars($paymentRow['mopID']); ?>" required>
                        <?php echo htmlspecialchars($paymentRow['mopName']); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="confirmCheckout mt-4 text-end mb-4" data-totalamount="<?php echo number_format($totalAmount, 2); ?>">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <a href="javascript:history.back()" class="btn btn-danger">Go Back to Cart</a>
                </div>
                <div class="col-6">
                    <p>Merchandise Subtotal: PHP <?php echo number_format($totalAmount, 2); ?></p>
                    <h4>Total Amount: PHP <?php echo number_format($totalAmount, 2); ?></h4>
                    <button class="btn btn-danger" id="confirmCheckout">Place Order</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="container bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-1">&copy; 2025 WELTZ INDUSTRIAL PHILS INC. All Rights Reserved.</p>
            <p>
                <a href="?page=homePage">Home</a> |
                <a href="?page=aboutUsPage">About Us</a> |
                <a href="?page=contactPage">Contact Us</a>
            </p>
        </div>
    </footer>
    <?php require_once 'cssLibrariesJS.php' ?>
</body>

</html>

<?php
$conn->close();
?>