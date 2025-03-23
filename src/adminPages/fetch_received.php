<?php
$conn = new mysqli("localhost", "root", "", "weltz_db") or die(json_encode(["error" => $conn->connect_error]));

$statusID = 4; // Picked Up status
$conditions = ["o.statusID = ?"];
$params = [$statusID];
$types = "i";

// Check if search query is submitted
if (isset($_POST['searchSubmit']) && !empty($_POST['productSearch'])) {
    $searchInput = '%' . $_POST['productSearch'] . '%';
    $conditions[] = "(o.referenceNum LIKE ?)";
    $params[] = $searchInput;
    $types .= "s";
}

// Construct dynamic WHERE clause
$whereClause = implode(" AND ", $conditions);

$query = 
    "SELECT o.orderID, o.referenceNum, o.totalAmount, m.mopName, oi.productID, 
        oi.orderItemQuantity, oi.orderItemTotal, p.productName, cat.categoryName, p.productIMG, 
        o.createdAt, o.receivedAt, u.userFname, u.userLname
    FROM orders_tbl o
    JOIN order_items_tbl oi ON o.orderID = oi.orderID
    JOIN products_tbl p ON oi.productID = p.productID
    JOIN modes_of_payment_tbl m ON o.mopID = m.mopID
    JOIN categories_tbl cat ON p.categoryID = cat.categoryID 
    JOIN users_tbl u ON o.userID = u.userID
    WHERE $whereClause
    ORDER BY o.receivedAt DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['orderID']]['referenceNum'] = $row['referenceNum'];
    $orders[$row['orderID']]['totalAmount'] = $row['totalAmount'];
    $orders[$row['orderID']]['mopName'] = $row['mopName'];
    $orders[$row['orderID']]['createdAt'] = date("F j, Y, g:i a", strtotime($row['createdAt']));
    $orders[$row['orderID']]['receivedAt'] = date("F j, Y, g:i a", strtotime($row['receivedAt']));
    $orders[$row['orderID']]['userFname'] = $row['userFname'];
    $orders[$row['orderID']]['userLname'] = $row['userLname'];
    $orders[$row['orderID']]['items'][] = [
        'productName' => $row['productName'],
        'category' => $row['categoryName'],
        'imageURL' => $row['productIMG'] ?? 'https://via.placeholder.com/50',
        'unitPrice' => number_format($row['orderItemTotal'] / $row['orderItemQuantity'], 2),
        'quantity' => $row['orderItemQuantity'],
        'totalPrice' => number_format($row['orderItemTotal'], 2)
    ];
}
$stmt->close();
if (empty($orders)): ?>
    <p class="text-center">No orders have been picked up.</p>
<?php else: ?>
    <?php foreach ($orders as $orderID => $order): ?>
        <div class="order-details bg-light mb-5" id="order-<?= $orderID ?>">
            <?php foreach ($order['items'] as $item): ?>
                <div class="order-item row align-items-center p-3 m-0 border-bottom border-gray">
                    <div class="col-lg-6 d-flex">
                        <img src="<?= htmlspecialchars($item['imageURL']) ?>" alt="Product Image" class="me-3" style="width: 100px;">
                        <div class="d-flex flex-column justify-content-center">
                            <p><?= htmlspecialchars($item['productName']) ?></p>
                            <p class="text-secondary">Category: <?= htmlspecialchars($item['category']) ?></p>
                        </div>
                    </div>
                    <div class="col-lg-2 text-center">
                        <p class="unit-price">PHP <?= $item['unitPrice'] ?></p>
                    </div>
                    <div class="col-lg-2 text-center">
                        <p class="quantity"><?= $item['quantity'] ?></p>
                    </div>
                    <div class="col-lg-2 text-center">
                        <p class="total-price">PHP <?= $item['totalPrice'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="order-footer row align-items-center p-3 m-0 border-top border-dark">
                <div class="row align-items-center mb-3">
                    <div class="col-lg-4">
                        <h5 class="refNum">Reference No. #<?= htmlspecialchars($order['referenceNum']) ?></h5>
                        <p class="ordered-at">Ordered at: <?= htmlspecialchars($order['createdAt']) ?></p>
                        <p class="received-at">Order Received: <?= htmlspecialchars($order['receivedAt']) ?></p>
                    </div>
                    <div class="col-lg-4 text-center">
                        <p class="mop">Mode of Payment: <?= htmlspecialchars($order['mopName']) ?></p>
                    </div>
                    <div class="col-lg-4 text-end">
                        <p class="order-total"><strong>Order Total: PHP <?= number_format($order['totalAmount'], 2) ?></strong></p>
                    </div>
                </div>
                <div class="row p-1 m-0 d-flex justify-content-end">
                    <div class="col-lg-6">
                        <p class="user-name">By: <?= htmlspecialchars($order['userFname'] . ' ' . $order['userLname']) ?></p>
                    </div>
                    <div class="col-lg-6 text-end">
                        <p class="badge bg-success fs-5">Picked Up</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>