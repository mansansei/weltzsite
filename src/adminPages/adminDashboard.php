<section class="mema">
    <div class="memabox1">
        <?php
        require 'weltz_dbconnect.php';

        try {
            
            $query = "SELECT SUM(totalAmount) AS totalSales FROM orders_tbl WHERE statusID = 4";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare the query: " . $conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Failed to execute the query: " . $stmt->error);
            }

            $row = $result->fetch_assoc();
            $totalSales = $row['totalSales'] ?? 0; 
            $stmt->close();
        } catch (Exception $e) {
            
            error_log("Error in memabox1: " . $e->getMessage());
            $totalSales = 0; 
        }
        ?>

        <div class="total-sales-box d-flex align-items-center bg-light p-2 rounded shadow-sm h-100">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-dollar-sign fa-3x text-danger"></i> 
            </div>
            <div>
                <p class="m-0 fs-3 fw-bold text-danger"><?= htmlspecialchars(number_format($totalSales, 2)) ?></p>
                <h3 class="m-0 fs-5 text-dark">Total Sales</h3>
            </div>
        </div>
    </div>

    
    <div class="memabox2">
        <?php
        require 'weltz_dbconnect.php';

        try {
            
            $query = "SELECT SUM(inStock) AS totalStock FROM products_tbl";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare the query: " . $conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Failed to execute the query: " . $stmt->error);
            }

            $row = $result->fetch_assoc();
            $totalStock = $row['totalStock'] ?? 0; 
            $stmt->close();
        } catch (Exception $e) {
            
            error_log("Error in memabox2: " . $e->getMessage());
            $totalStock = 0; 
        }
        ?>

        <div class="total-stock-box d-flex align-items-center bg-light p-2 rounded shadow-sm h-100">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-boxes fa-3x text-danger"></i> 
            </div>
            <div>
                <p class="m-0 fs-3 fw-bold text-danger"><?= htmlspecialchars($totalStock) ?></p>
                <h3 class="m-0 fs-5 text-dark">Total Stock</h3>
            </div>
        </div>
    </div>

    
    <div class="memabox3">
        <?php
        require 'weltz_dbconnect.php';

        try {
            
            $query = "SELECT COUNT(*) AS totalUsers FROM users_tbl WHERE roleID = 1";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare the query: " . $conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Failed to execute the query: " . $stmt->error);
            }

            $row = $result->fetch_assoc();
            $totalUsers = $row['totalUsers'] ?? 0;
            $stmt->close();
        } catch (Exception $e) {
            
            error_log("Error in memabox3: " . $e->getMessage());
            $totalUsers = 0; 
        }
        ?>

        <div class="total-users-box d-flex align-items-center bg-light p-2 rounded shadow-sm h-100 justify-content-start">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-users fa-3x text-danger"></i>
            </div>
            <div>
                <p class="m-0 fs-3 fw-bold text-danger"><?= htmlspecialchars($totalUsers) ?></p>
                <h3 class="m-0 fs-5 text-dark">Total Users</h3>
            </div>
        </div>
    </div>

    
    <div class="memabox4">
    <?php
    require 'weltz_dbconnect.php';

    try {
        // Step 1: Fetch all orderIDs with statusID = 4
        $query = "SELECT orderID FROM orders_tbl WHERE statusID = 4";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare the query: " . $conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Failed to execute the query: " . $stmt->error);
        }

        $orderIDs = [];
        while ($row = $result->fetch_assoc()) {
            $orderIDs[] = $row['orderID'];
        }
        $stmt->close();

        if (empty($orderIDs)) {
            throw new Exception("No orders found with statusID = 4.");
        }

        // Step 2: Find the productID with the highest orderItemQuantity for these orderIDs
        $orderIDsString = implode(",", $orderIDs); // Convert array to comma-separated string
        $query = "
            SELECT productID, SUM(orderItemQuantity) AS totalQuantity 
            FROM order_items_tbl 
            WHERE orderID IN ($orderIDsString) 
            GROUP BY productID 
            ORDER BY totalQuantity DESC 
            LIMIT 1";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare the query: " . $conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Failed to execute the query: " . $stmt->error);
        }

        $row = $result->fetch_assoc();
        if (!$row) {
            throw new Exception("No products found in order_items_tbl for the given orderIDs.");
        }

        $mostSoldProductID = $row['productID'];
        $stmt->close();

        // Step 3: Fetch product details (productIMG and productName) from products_tbl
        $query = "SELECT productIMG, productName FROM products_tbl WHERE productID = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Failed to prepare the query: " . $conn->error);
        }

        $stmt->bind_param("i", $mostSoldProductID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("Failed to execute the query: " . $stmt->error);
        }

        $row = $result->fetch_assoc();
        if (!$row) {
            throw new Exception("Product not found in products_tbl.");
        }

        $productIMG = $row['productIMG'];
        $productName = $row['productName'];
        $stmt->close();
    } catch (Exception $e) {
        
        error_log("Error in memabox4: " . $e->getMessage());
        $productIMG = "https://via.placeholder.com/150"; 
        $productName = "No Product Found";
    }
    ?>

    <div class="most-sales-box d-flex align-items-center bg-light p-2 rounded shadow-sm h-100">
        <div class="me-3 d-flex align-items-center justify-content-center">
            <img src="<?= htmlspecialchars($productIMG) ?>" alt="<?= htmlspecialchars($productName) ?>" class="img-fluid" style="max-width: 75px; border: 1px solid black; border-radius: 20px;">
        </div>
        <div>
            <p class="m-0 fs-5 text-dark"><?= htmlspecialchars($productName) ?></p>
            <h3 class="m-0 fs-5 text-dark">Most Sales</h3>
        </div>
    </div>
</div>

    
    <div class="memabox5">
        5    
    <div class="memabox6">
        6
    </div>

    
    <div class="memabox7">
        7
    </div>

   
    <div class="memabox8">
        8
    </div>

</section>