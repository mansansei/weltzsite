<div class="row mb-4 border-bottom border-danger">
    <div class="col-md-9">
        <h1 class="fs-1">All Orders</h1>
    </div>
</div>

<div class="container mt-4">
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="processing-tab" data-bs-toggle="tab" data-bs-target="#processing" type="button" role="tab">Processing</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="to-pick-up-tab" data-bs-toggle="tab" data-bs-target="#to-pick-up" type="button" role="tab">To Pick Up</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="picked-up-tab" data-bs-toggle="tab" data-bs-target="#picked-up" type="button" role="tab">Picked Up</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">Cancelled</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <!-- Processing Tab -->
        <div class="tab-pane fade show active" id="processing" role="tabpanel">
            <div class="cart-header bg-danger text-white mb-3">
                <div class="row align-items-center p-3">
                    <div class="col-lg-6">
                        <p class="fs-5 mb-0">Product</p>
                    </div>
                    <div class="col-lg-2 text-center">
                        <p class="fs-5 mb-0">Unit Price</p>
                    </div>
                    <div class="col-lg-2 text-center">
                        <p class="fs-5 mb-0">Quantity</p>
                    </div>
                    <div class="col-lg-2 text-center">
                        <p class="fs-5 mb-0">Total</p>
                    </div>
                </div>
            </div>
            <?php
            require 'weltz_dbconnect.php'; // Ensure you have a database connection file

            $statusID = 1; // Processing status

            $query = "
            SELECT o.orderID, o.referenceNum, o.totalAmount, m.mopName, oi.productID, 
                oi.orderItemQuantity, oi.orderItemTotal, p.productName, cat.categoryName, p.productIMG, o.createdAt, u.userFname, u.userLname
            FROM orders_tbl o
            JOIN order_items_tbl oi ON o.orderID = oi.orderID
            JOIN products_tbl p ON oi.productID = p.productID
            JOIN modes_of_payment_tbl m ON o.mopID = m.mopID
            JOIN categories_tbl cat ON p.categoryID = cat.categoryID 
            JOIN users_tbl u ON o.userID = u.userID
            WHERE o.statusID = ?
            ";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $statusID);
            $stmt->execute();
            $result = $stmt->get_result();

            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[$row['orderID']]['referenceNum'] = $row['referenceNum'];
                $orders[$row['orderID']]['totalAmount'] = $row['totalAmount'];
                $orders[$row['orderID']]['mopName'] = $row['mopName'];
                $orders[$row['orderID']]['createdAt'] = date("F j, Y, g:i a", strtotime($row['createdAt']));
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
                <p class="text-center">No orders are being processed.</p>
            <?php else: ?>
                <?php foreach ($orders as $orderID => $order): ?>
                    <div class="order-details bg-light mb-5" id="order-<?= htmlspecialchars($order['referenceNum']) ?>">
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="order-item row align-items-center p-3 m-0 border-bottom border-dark">
                                <div class="col-lg-6 d-flex">
                                    <img src="<?= htmlspecialchars($item['imageURL']) ?>" alt="Product Image" class="me-3" style="width: 100px;">
                                    <div class="d-flex flex-column justify-content-center">
                                        <span><?= htmlspecialchars($item['productName']) ?></span>
                                        <span class="text-secondary">Category: <?= htmlspecialchars($item['category']) ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <span class="unit-price">PHP <?= $item['unitPrice'] ?></span>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <span class="quantity"><?= $item['quantity'] ?></span>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <span class="total-price">PHP <?= $item['totalPrice'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="order-footer row align-items-center p-3 m-0">
                            <div class="row align-items-center mb-3">
                                <div class="col-lg-4">
                                    <h5 class="refNum">Reference No. #<?= htmlspecialchars($order['referenceNum']) ?></h5>
                                </div>
                                <div class="col-lg-4">
                                    <span class="mop">Mode of Payment: <?= htmlspecialchars($order['mopName']) ?></span>
                                </div>
                                <div class="col-lg-4 text-end">
                                    <span class="order-total"><strong>Order Total: PHP <?= number_format($order['totalAmount'], 2) ?></strong></span>
                                </div>
                            </div>
                            <div class="row p-1 m-0 d-flex justify-content-end">
                                <div class="col-lg-6">
                                    <span class="ordered-at">Ordered at: <?= htmlspecialchars($order['createdAt']) ?></span>
                                    <span class="user-name">By: <?= htmlspecialchars($order['userFname'] . ' ' . $order['userLname']) ?></span>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <button class="btn btn-warning edit-order-btn" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-order-id="<?= $orderID ?>">Edit Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- To Pick Up Tab -->
<div class="tab-pane fade" id="to-pick-up" role="tabpanel">
    <div class="cart-header bg-danger text-white mb-3">
        <div class="row align-items-center p-3">
            <div class="col-lg-6">
                <p class="fs-5 mb-0">Product</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Unit Price</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Quantity</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Total</p>
            </div>
        </div>
    </div>
    <?php
    $statusID = 2; // To Pick Up status

    $query = "
    SELECT o.orderID, o.referenceNum, o.totalAmount, m.mopName, oi.productID, 
        oi.orderItemQuantity, oi.orderItemTotal, p.productName, cat.categoryName, p.productIMG, o.createdAt, u.userFname, u.userLname
    FROM orders_tbl o
    JOIN order_items_tbl oi ON o.orderID = oi.orderID
    JOIN products_tbl p ON oi.productID = p.productID
    JOIN modes_of_payment_tbl m ON o.mopID = m.mopID
    JOIN categories_tbl cat ON p.categoryID = cat.categoryID 
    JOIN users_tbl u ON o.userID = u.userID
    WHERE o.statusID = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $statusID);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[$row['orderID']]['referenceNum'] = $row['referenceNum'];
        $orders[$row['orderID']]['totalAmount'] = $row['totalAmount'];
        $orders[$row['orderID']]['mopName'] = $row['mopName'];
        $orders[$row['orderID']]['createdAt'] = date("F j, Y, g:i a", strtotime($row['createdAt']));
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
        <p class="text-center">No orders are ready to pick up.</p>
    <?php else: ?>
        <?php foreach ($orders as $orderID => $order): ?>
            <div class="order-details bg-light mb-5" id="order-<?= $orderID ?>">
                <?php foreach ($order['items'] as $item): ?>
                    <div class="order-item row align-items-center p-3 m-0 border-bottom border-dark">
                        <div class="col-lg-6 d-flex">
                            <img src="<?= htmlspecialchars($item['imageURL']) ?>" alt="Product Image" class="me-3" style="width: 100px;">
                            <div class="d-flex flex-column justify-content-center">
                                <span><?= htmlspecialchars($item['productName']) ?></span>
                                <span class="text-secondary">Category: <?= htmlspecialchars($item['category']) ?></span>
                            </div>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="unit-price">PHP <?= $item['unitPrice'] ?></span>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="quantity"><?= $item['quantity'] ?></span>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="total-price">PHP <?= $item['totalPrice'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="order-footer row align-items-center p-3 m-0">
                    <div class="row align-items-center mb-3">
                        <div class="col-lg-4">
                            <h5 class="refNum">Reference No. #<?= htmlspecialchars($order['referenceNum']) ?></h5>
                        </div>
                        <div class="col-lg-4">
                            <span class="mop">Mode of Payment: <?= htmlspecialchars($order['mopName']) ?></span>
                        </div>
                        <div class="col-lg-4 text-end">
                            <span class="order-total"><strong>Order Total: PHP <?= number_format($order['totalAmount'], 2) ?></strong></span>
                        </div>
                    </div>
                    <div class="row p-1 m-0 d-flex justify-content-end">
                        <div class="col-lg-6">
                            <span class="ordered-at">Ordered at: <?= htmlspecialchars($order['createdAt']) ?></span>
                            <span class="user-name">By: <?= htmlspecialchars($order['userFname'] . ' ' . $order['userLname']) ?></span>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button class="btn btn-warning edit-order-btn" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-order-id="<?= $orderID ?>">Edit Order</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Picked Up Tab -->
<div class="tab-pane fade" id="picked-up" role="tabpanel">
    <div class="cart-header bg-danger text-white mb-3">
        <div class="row align-items-center p-3">
            <div class="col-lg-6">
                <p class="fs-5 mb-0">Product</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Unit Price</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Quantity</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Total</p>
            </div>
        </div>
    </div>
    <?php
    $statusID = 4; // Picked Up status

    $query = "
    SELECT o.orderID, o.referenceNum, o.totalAmount, m.mopName, oi.productID, 
        oi.orderItemQuantity, oi.orderItemTotal, p.productName, cat.categoryName, p.productIMG, o.createdAt, u.userFname, u.userLname
    FROM orders_tbl o
    JOIN order_items_tbl oi ON o.orderID = oi.orderID
    JOIN products_tbl p ON oi.productID = p.productID
    JOIN modes_of_payment_tbl m ON o.mopID = m.mopID
    JOIN categories_tbl cat ON p.categoryID = cat.categoryID 
    JOIN users_tbl u ON o.userID = u.userID
    WHERE o.statusID = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $statusID);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[$row['orderID']]['referenceNum'] = $row['referenceNum'];
        $orders[$row['orderID']]['totalAmount'] = $row['totalAmount'];
        $orders[$row['orderID']]['mopName'] = $row['mopName'];
        $orders[$row['orderID']]['createdAt'] = date("F j, Y, g:i a", strtotime($row['createdAt']));
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
                    <div class="order-item row align-items-center p-3 m-0 border-bottom border-dark">
                        <div class="col-lg-6 d-flex">
                            <img src="<?= htmlspecialchars($item['imageURL']) ?>" alt="Product Image" class="me-3" style="width: 100px;">
                            <div class="d-flex flex-column justify-content-center">
                                <span><?= htmlspecialchars($item['productName']) ?></span>
                                <span class="text-secondary">Category: <?= htmlspecialchars($item['category']) ?></span>
                            </div>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="unit-price">PHP <?= $item['unitPrice'] ?></span>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="quantity"><?= $item['quantity'] ?></span>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="total-price">PHP <?= $item['totalPrice'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="order-footer row align-items-center p-3 m-0">
                    <div class="row align-items-center mb-3">
                        <div class="col-lg-4">
                            <h5 class="refNum">Reference No. #<?= htmlspecialchars($order['referenceNum']) ?></h5>
                        </div>
                        <div class="col-lg-4">
                            <span class="mop">Mode of Payment: <?= htmlspecialchars($order['mopName']) ?></span>
                        </div>
                        <div class="col-lg-4 text-end">
                            <span class="order-total"><strong>Order Total: PHP <?= number_format($order['totalAmount'], 2) ?></strong></span>
                        </div>
                    </div>
                    <div class="row p-1 m-0 d-flex justify-content-end">
                        <div class="col-lg-6">
                            <span class="ordered-at">Ordered at: <?= htmlspecialchars($order['createdAt']) ?></span>
                            <span class="user-name">By: <?= htmlspecialchars($order['userFname'] . ' ' . $order['userLname']) ?></span>
                        </div>
                        <div class="col-lg-6 text-end">
                            <span class="badge bg-success fs-5">Picked Up</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Cancelled Tab -->
<div class="tab-pane fade" id="cancelled" role="tabpanel">
    <div class="cart-header bg-danger text-white mb-3">
        <div class="row align-items-center p-3">
            <div class="col-lg-6">
                <p class="fs-5 mb-0">Product</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Unit Price</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Quantity</p>
            </div>
            <div class="col-lg-2 text-center">
                <p class="fs-5 mb-0">Total</p>
            </div>
        </div>
    </div>
    <?php
    $statusID = 3; // Cancelled status

    $query = "
    SELECT o.orderID, o.referenceNum, o.totalAmount, m.mopName, oi.productID, 
        oi.orderItemQuantity, oi.orderItemTotal, p.productName, cat.categoryName, p.productIMG, o.createdAt, u.userFname, u.userLname
    FROM orders_tbl o
    JOIN order_items_tbl oi ON o.orderID = oi.orderID
    JOIN products_tbl p ON oi.productID = p.productID
    JOIN modes_of_payment_tbl m ON o.mopID = m.mopID
    JOIN categories_tbl cat ON p.categoryID = cat.categoryID 
    JOIN users_tbl u ON o.userID = u.userID
    WHERE o.statusID = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $statusID);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[$row['orderID']]['referenceNum'] = $row['referenceNum'];
        $orders[$row['orderID']]['totalAmount'] = $row['totalAmount'];
        $orders[$row['orderID']]['mopName'] = $row['mopName'];
        $orders[$row['orderID']]['createdAt'] = date("F j, Y, g:i a", strtotime($row['createdAt']));
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
        <p class="text-center">No orders have been cancelled.</p>
    <?php else: ?>
        <?php foreach ($orders as $orderID => $order): ?>
            <div class="order-details bg-light mb-5" id="order-<?= $orderID ?>">
                <?php foreach ($order['items'] as $item): ?>
                    <div class="order-item row align-items-center p-3 m-0 border-bottom border-dark">
                        <div class="col-lg-6 d-flex">
                            <img src="<?= htmlspecialchars($item['imageURL']) ?>" alt="Product Image" class="me-3" style="width: 100px;">
                            <div class="d-flex flex-column justify-content-center">
                                <span><?= htmlspecialchars($item['productName']) ?></span>
                                <span class="text-secondary">Category: <?= htmlspecialchars($item['category']) ?></span>
                            </div>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="unit-price">PHP <?= $item['unitPrice'] ?></span>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="quantity"><?= $item['quantity'] ?></span>
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="total-price">PHP <?= $item['totalPrice'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="order-footer row align-items-center p-3 m-0">
                    <div class="row align-items-center mb-3">
                        <div class="col-lg-4">
                            <h5 class="refNum">Reference No. #<?= htmlspecialchars($order['referenceNum']) ?></h5>
                        </div>
                        <div class="col-lg-4">
                            <span class="mop">Mode of Payment: <?= htmlspecialchars($order['mopName']) ?></span>
                        </div>
                        <div class="col-lg-4 text-end">
                            <span class="order-total"><strong>Order Total: PHP <?= number_format($order['totalAmount'], 2) ?></strong></span>
                        </div>
                    </div>
                    <div class="row p-1 m-0 d-flex justify-content-end">
                        <div class="col-lg-6">
                            <span class="ordered-at">Ordered at: <?= htmlspecialchars($order['createdAt']) ?></span>
                            <span class="user-name">By: <?= htmlspecialchars($order['userFname'] . ' ' . $order['userLname']) ?></span>
                        </div>
                        <div class="col-lg-6 text-end">
                            <span class="badge bg-danger fs-5">Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
    </div>

    <!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editOrderModalLabel">Edit Order Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="orderStatus" class="form-label">Order Status</label>
                            <select class="form-select" id="orderStatus" name="orderStatus">
                                <option value="1">Processing</option>
                                <option value="2">To Pick Up</option>
                                <option value="4">Picked Up</option>
                                <option value="3">Cancelled</option>
                            </select>
                            <label class="error-message" for="orderStatus"></label>
                        </div>
                    </div>
                    <input type="hidden" id="orderID" name="orderID">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-warning" id="confirmEditOrder">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>