<?php

require 'weltz_dbconnect.php';

if (!isset($_GET['referenceNum'])) {
    die('Reference number missing.');
}

$referenceNum = $_GET['referenceNum'];

// Fetch order details, including customer name from users_tbl
$orderSQL = "SELECT o.orderID, o.createdAt, COALESCE(CONCAT(u.userFname, ' ', u.userLname), 'Deleted User') AS userFullName 
             FROM orders_tbl o 
             JOIN users_tbl u ON o.userID = u.userID 
             WHERE o.referenceNum = ?";
$stmt = $conn->prepare($orderSQL);
$stmt->bind_param("s", $referenceNum);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Ensure order exists
if (!$order) {
    die('Order not found.');
}

$orderID = $order['orderID'];

// Fetch order items
$orderItemsSQL = "SELECT p.productName, oi.orderItemQuantity, oi.orderItemTotal 
                  FROM order_items_tbl oi
                  JOIN products_tbl p ON oi.productID = p.productID
                  WHERE oi.orderID = ?";
$stmt = $conn->prepare($orderItemsSQL);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$orderItems = $stmt->get_result();

$totalOrderAmount = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= htmlspecialchars($referenceNum) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .invoice-container { max-width: 700px; background: white; padding: 20px; margin: auto; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .header { background-color: #fc0001; color: white; padding: 15px; text-align: center; font-size: 22px; font-weight: bold; border-radius: 10px 10px 0 0; }
        .details { margin-top: 20px; padding: 10px; }
        .order-table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        .order-table th, .order-table td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        .order-table th { background-color: #fc0001; color: white; text-align: center; }
        .order-summary { font-size: 18px; font-weight: bold; text-align: right; padding: 15px; background: #eee; border-radius: 0 0 10px 10px; }
        .download-btn { display: block; text-align: center; background: #fc0001; color: white; padding: 12px; text-decoration: none; border-radius: 5px; font-size: 18px; margin-top: 20px; width: 200px; margin: auto; }
    </style>
</head>
<body>

<div class="invoice-container">
    <div class="header">Invoice #<?= htmlspecialchars($referenceNum) ?></div>
    
    <div class="details">
        <p><strong>Customer Name:</strong> <?= htmlspecialchars($order['userFullName']) ?></p>
        <p><strong>Order Date:</strong> <?= htmlspecialchars(date("F j, Y, g:i A", strtotime($order['createdAt']))) ?></p>
    </div>
    
    <table class="order-table">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        <?php while ($row = $orderItems->fetch_assoc()) : ?>
            <tr>
                <td><?= htmlspecialchars($row['productName']) ?></td>
                <td style="text-align:center;"><?= htmlspecialchars($row['orderItemQuantity']) ?></td>
                <td style="text-align:right;">PHP <?= number_format($row['orderItemTotal'], 2) ?></td>
            </tr>
            <?php $totalOrderAmount += $row['orderItemTotal']; ?>
        <?php endwhile; ?>
    </table>

    <p class="order-summary">Total Order Amount: PHP <?= number_format($totalOrderAmount, 2) ?></p>

    <a href="download_invoice.php?referenceNum=<?= urlencode($referenceNum) ?>" class="download-btn">Download Invoice</a>

</div>

</body>
</html>
