<div class="row mb-3">
    <div class="memabox1 col-lg-3">
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

        <div class="total-sales-box d-flex align-items-center rounded h-100 bg-light shadow-sm rounded px-3">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-dollar-sign fa-3x text-danger"></i>
            </div>
            <div>
                <p class="m-0 fs-3 fw-bold text-danger"><?= htmlspecialchars(number_format($totalSales, 2)) ?></p>
                <h3 class="m-0 fs-5 text-dark">Total Sales</h3>
            </div>
        </div>
    </div>

    <div class="memabox2 col-lg-3">
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

        <div class="total-stock-box d-flex align-items-center p-2 rounded h-100 bg-light shadow-sm rounded px-3">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-boxes fa-3x text-danger"></i>
            </div>
            <div>
                <p class="m-0 fs-3 fw-bold text-danger"><?= htmlspecialchars($totalStock) ?></p>
                <h3 class="m-0 fs-5 text-dark">Total Stock</h3>
            </div>
        </div>
    </div>

    <div class="memabox3 col-lg-3">
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

        <div class="total-users-box d-flex align-items-center p-2 rounded h-100 justify-content-start bg-light shadow-sm rounded px-3">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <i class="fas fa-users fa-3x text-danger"></i>
            </div>
            <div>
                <p class="m-0 fs-3 fw-bold text-danger"><?= htmlspecialchars($totalUsers) ?></p>
                <h3 class="m-0 fs-5 text-dark">Total Users</h3>
            </div>
        </div>
    </div>

    <div class="memabox4 col-lg-3">
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

        <div class="most-sales-box d-flex align-items-center p-2 rounded h-100 bg-light shadow-sm rounded px-3">
            <div class="me-3 d-flex align-items-center justify-content-center">
                <img src="<?= htmlspecialchars($productIMG) ?>" alt="<?= htmlspecialchars($productName) ?>" class="img-fluid" style="max-width: 75px; border: 1px solid black; border-radius: 20px;">
            </div>
            <div>
                <p class="m-0 fs-5 text-dark"><?= htmlspecialchars($productName) ?></p>
                <h3 class="m-0 fs-5 text-dark">Most Sales</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="memabox5 col-lg-7">
        <?php
        require 'weltz_dbconnect.php';

        try {
            // Initialize arrays to store data
            $months = [];
            $pickedUpCounts = [];
            $cancelledCounts = [];

            // Get the current year
            $currentYear = date('Y');

            // Create array with all months of the current year
            for ($monthNum = 1; $monthNum <= 12; $monthNum++) {
                // Format month number with leading zero if needed
                $formattedMonth = str_pad($monthNum, 2, '0', STR_PAD_LEFT);

                // Create date for this month
                $monthDate = "$currentYear-$formattedMonth-01";

                // Add month name to labels
                $months[] = date('M', strtotime($monthDate));

                // Start and end of month
                $startDate = "$currentYear-$formattedMonth-01";
                $endDate = date('Y-m-t', strtotime($startDate)); // Last day of month

                // Query for picked up orders (statusID = 4) based on updatedAt
                $query = "SELECT COUNT(*) as count FROM orders_tbl 
                 WHERE statusID = 4 
                 AND updatedAt BETWEEN ? AND ?";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Failed to prepare the picked up query: " . $conn->error);
                }

                $stmt->bind_param("ss", $startDate, $endDate);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    throw new Exception("Failed to execute the picked up query: " . $stmt->error);
                }

                $row = $result->fetch_assoc();
                $pickedUpCounts[] = intval($row['count'] ?? 0);
                $stmt->close();

                // Query for cancelled orders (statusID = 3) based on updatedAt
                $query = "SELECT COUNT(*) as count FROM orders_tbl 
                 WHERE statusID = 3 
                 AND updatedAt BETWEEN ? AND ?";
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Failed to prepare the cancelled query: " . $conn->error);
                }

                $stmt->bind_param("ss", $startDate, $endDate);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    throw new Exception("Failed to execute the cancelled query: " . $stmt->error);
                }

                $row = $result->fetch_assoc();
                $cancelledCounts[] = intval($row['count'] ?? 0);
                $stmt->close();
            }

            // Check if we have any data at all
            $hasData = false;
            foreach ($pickedUpCounts as $count) {
                if ($count > 0) {
                    $hasData = true;
                    break;
                }
            }
            if (!$hasData) {
                foreach ($cancelledCounts as $count) {
                    if ($count > 0) {
                        $hasData = true;
                        break;
                    }
                }
            }

            // Encode data for JavaScript
            $monthsJSON = json_encode($months);
            $pickedUpJSON = json_encode($pickedUpCounts);
            $cancelledJSON = json_encode($cancelledCounts);
        } catch (Exception $e) {
            error_log("Error in memabox5: " . $e->getMessage());
            // Initialize with empty arrays
            $months = [];
            $pickedUpCounts = [];
            $cancelledCounts = [];
            $hasData = false;

            $monthsJSON = json_encode($months);
            $pickedUpJSON = json_encode($pickedUpCounts);
            $cancelledJSON = json_encode($cancelledCounts);
        }
        ?>

        <div class="orders-status-box rounded h-100 d-flex flex-column bg-light shadow-sm rounded p-5">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="fs-5 text-dark m-0"><?= $currentYear ?> Orders Status</h3>
                <button id="downloadChartPDF" class="btn btn-sm btn-outline-secondary" <?= !$hasData ? 'disabled' : '' ?>>
                    <i class="fas fa-download"></i> Download PDF
                </button>
            </div>

            <?php if (!$hasData): ?>
                <div class="alert alert-info m-0">
                    No order data available for <?= $currentYear ?>
                </div>
            <?php else: ?>
                <div class="chart-container flex-grow-1" style="position: relative; min-height: 150px;">
                    <canvas id="ordersStatusChart"></canvas>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <div class="me-3">
                        <span class="badge bg-success">&nbsp;</span> Picked Up
                    </div>
                    <div>
                        <span class="badge bg-danger">&nbsp;</span> Cancelled
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Include jsPDF library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <!-- Include html2canvas for chart capture -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get data from PHP
                const months = <?= $monthsJSON ?>;
                const pickedUpData = <?= $pickedUpJSON ?>;
                const cancelledData = <?= $cancelledJSON ?>;
                const currentYear = '<?= $currentYear ?>';
                const hasData = <?= $hasData ? 'true' : 'false' ?>;

                // If no data, don't initialize chart
                if (!hasData) {
                    return;
                }

                const chartContainer = document.querySelector('.memabox5 .chart-container');
                const canvas = document.getElementById('ordersStatusChart');

                // Ensure Chart.js is loaded before initializing
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded. Please include Chart.js in your page.');
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'alert alert-danger';
                    errorMsg.textContent = 'Chart.js library is missing. Please include it in your page.';
                    chartContainer.appendChild(errorMsg);
                    return;
                }

                console.log('Chart Data:', {
                    months,
                    pickedUp: pickedUpData,
                    cancelled: cancelledData
                });

                // Make sure the chart container has appropriate size
                chartContainer.style.height = '150px';

                // Create the chart
                const chart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                                label: 'Picked Up',
                                data: pickedUpData,
                                borderColor: '#28a745',
                                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Cancelled',
                                data: cancelledData,
                                borderColor: '#dc3545',
                                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: currentYear
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            },
                            title: {
                                display: true,
                                text: 'Monthly Orders Status ' + currentYear
                            }
                        }
                    }
                });

                // Make chart responsive to window size changes
                window.addEventListener('resize', function() {
                    chart.resize();
                });

                // Replace the entire PDF Download functionality in your monthly chart with this completely revised version
                // PDF Download functionality
                document.getElementById('downloadChartPDF').addEventListener('click', function() {
                    // Check if jsPDF and html2canvas are loaded
                    if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined') {
                        alert('PDF export libraries not loaded. Please refresh the page and try again.');
                        return;
                    }

                    const {
                        jsPDF
                    } = jspdf;

                    // Create a new jsPDF instance with a larger page size, using A3 instead of A4
                    const pdf = new jsPDF({
                        orientation: 'landscape',
                        unit: 'mm',
                        format: 'a3' // 420mm x 297mm (larger than A4)
                    });

                    // Add title to PDF
                    pdf.setFontSize(18);
                    pdf.text('Monthly Orders Status Report - ' + currentYear, 15, 15);

                    // Add timestamp
                    pdf.setFontSize(10);
                    const today = new Date();
                    pdf.text('Generated on: ' + today.toLocaleString(), 15, 22);

                    // Capture the chart canvas
                    html2canvas(canvas).then(function(canvasImg) {
                        // Add the chart image to PDF (adjusted size for A3)
                        const imgData = canvasImg.toDataURL('image/png');
                        pdf.addImage(imgData, 'PNG', 15, 30, 390, 150);

                        // Add data table to PDF with improved spacing
                        pdf.setFontSize(14);
                        pdf.text('Monthly Data Summary', 15, 190);

                        // Create a more spacious table layout
                        // First row: Q1 and Q2
                        let startY = 200;

                        // First quarter (Jan-Mar)
                        pdf.setFontSize(12);
                        pdf.text('First Quarter (Jan-Mar)', 15, startY);

                        startY += 8;
                        pdf.setFontSize(10);
                        pdf.text('Month', 20, startY);
                        pdf.text('Picked Up', 60, startY);
                        pdf.text('Cancelled', 100, startY);

                        pdf.line(15, startY + 2, 140, startY + 2);

                        startY += 8;
                        for (let i = 0; i < 3; i++) {
                            pdf.text(months[i], 20, startY);
                            pdf.text(pickedUpData[i].toString(), 60, startY);
                            pdf.text(cancelledData[i].toString(), 100, startY);
                            startY += 7; // Increased spacing
                        }

                        // Second quarter (Apr-Jun)
                        let q2Y = 200;
                        pdf.setFontSize(12);
                        pdf.text('Second Quarter (Apr-Jun)', 150, q2Y);

                        q2Y += 8;
                        pdf.setFontSize(10);
                        pdf.text('Month', 155, q2Y);
                        pdf.text('Picked Up', 195, q2Y);
                        pdf.text('Cancelled', 235, q2Y);

                        pdf.line(150, q2Y + 2, 275, q2Y + 2);

                        q2Y += 8;
                        for (let i = 3; i < 6; i++) {
                            pdf.text(months[i], 155, q2Y);
                            pdf.text(pickedUpData[i].toString(), 195, q2Y);
                            pdf.text(cancelledData[i].toString(), 235, q2Y);
                            q2Y += 7; // Increased spacing
                        }

                        // Third quarter (Jul-Sep)
                        let q3Y = 200;
                        pdf.setFontSize(12);
                        pdf.text('Third Quarter (Jul-Sep)', 285, q3Y);

                        q3Y += 8;
                        pdf.setFontSize(10);
                        pdf.text('Month', 290, q3Y);
                        pdf.text('Picked Up', 330, q3Y);
                        pdf.text('Cancelled', 370, q3Y);

                        pdf.line(285, q3Y + 2, 410, q3Y + 2);

                        q3Y += 8;
                        for (let i = 6; i < 9; i++) {
                            pdf.text(months[i], 290, q3Y);
                            pdf.text(pickedUpData[i].toString(), 330, q3Y);
                            pdf.text(cancelledData[i].toString(), 370, q3Y);
                            q3Y += 7; // Increased spacing
                        }

                        // Fourth quarter (Oct-Dec)
                        let q4Y = 240; // Moved down for better spacing
                        pdf.setFontSize(12);
                        pdf.text('Fourth Quarter (Oct-Dec)', 15, q4Y);

                        q4Y += 8;
                        pdf.setFontSize(10);
                        pdf.text('Month', 20, q4Y);
                        pdf.text('Picked Up', 60, q4Y);
                        pdf.text('Cancelled', 100, q4Y);

                        pdf.line(15, q4Y + 2, 140, q4Y + 2);

                        q4Y += 8;
                        for (let i = 9; i < 12; i++) {
                            pdf.text(months[i], 20, q4Y);
                            pdf.text(pickedUpData[i].toString(), 60, q4Y);
                            pdf.text(cancelledData[i].toString(), 100, q4Y);
                            q4Y += 7; // Increased spacing
                        }

                        // Add summary statistics
                        let summaryY = 240;
                        pdf.setFontSize(12);
                        pdf.text('Annual Summary', 150, summaryY);

                        summaryY += 8;
                        pdf.setFontSize(10);

                        // Calculate totals
                        const totalPickedUp = pickedUpData.reduce((sum, value) => sum + value, 0);
                        const totalCancelled = cancelledData.reduce((sum, value) => sum + value, 0);
                        const totalOrders = totalPickedUp + totalCancelled;
                        const pickupRate = (totalPickedUp / totalOrders * 100).toFixed(1);

                        pdf.text('Total Orders: ' + totalOrders, 155, summaryY);
                        summaryY += 7;
                        pdf.text('Total Picked Up: ' + totalPickedUp + ' (' + pickupRate + '%)', 155, summaryY);
                        summaryY += 7;
                        pdf.text('Total Cancelled: ' + totalCancelled + ' (' + (100 - pickupRate).toFixed(1) + '%)', 155, summaryY);

                        // Save the PDF
                        pdf.save('monthly_orders_status_' + currentYear + '.pdf');
                    });
                });
            });
        </script>
    </div>

    <div class="memabox6 col-lg-5">
        <?php
        require 'weltz_dbconnect.php';

        try {
            // Initialize arrays for order statuses
            $statusLabels = ['To Pick Up', 'Cancelled', 'Picked Up'];
            $statusColors = ['#ffc107', '#dc3545', '#28a745']; // Yellow, Red, Green
            $statusCounts = [0, 0, 0];
            $statusIDs = [2, 3, 4]; // 2 = To Pick Up, 3 = Cancelled, 4 = Picked Up

            // Query for each status
            $query = "SELECT statusID, COUNT(*) as count FROM orders_tbl 
              WHERE statusID IN (2, 3, 4) 
              GROUP BY statusID";

            $result = $conn->query($query);

            if (!$result) {
                throw new Exception("Failed to execute the status query: " . $conn->error);
            }

            $totalOrders = 0;

            // Populate the counts array
            while ($row = $result->fetch_assoc()) {
                $statusIndex = array_search(intval($row['statusID']), $statusIDs);
                if ($statusIndex !== false) {
                    $statusCounts[$statusIndex] = intval($row['count']);
                    $totalOrders += intval($row['count']);
                }
            }

            // Calculate percentages
            $statusPercentages = [];
            foreach ($statusCounts as $count) {
                $percentage = ($totalOrders > 0) ? round(($count / $totalOrders) * 100, 1) : 0;
                $statusPercentages[] = $percentage;
            }

            // Check if we have any data
            $hasData = ($totalOrders > 0);

            // Prepare data for JavaScript
            $labelsJSON = json_encode($statusLabels);
            $countsJSON = json_encode($statusCounts);
            $colorsJSON = json_encode($statusColors);
            $percentagesJSON = json_encode($statusPercentages);
        } catch (Exception $e) {
            error_log("Error in memabox6: " . $e->getMessage());

            // Set default values in case of error
            $statusLabels = ['To Pick Up', 'Cancelled', 'Picked Up'];
            $statusColors = ['#ffc107', '#dc3545', '#28a745'];
            $statusCounts = [0, 0, 0];
            $statusPercentages = [0, 0, 0];
            $hasData = false;
            $totalOrders = 0;

            $labelsJSON = json_encode($statusLabels);
            $countsJSON = json_encode($statusCounts);
            $colorsJSON = json_encode($statusColors);
            $percentagesJSON = json_encode($statusPercentages);
        }
        ?>

        <div class="order-ratio-box rounded h-100 d-flex flex-column bg-light shadow-sm rounded p-5">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="fs-5 text-dark m-0">Order Ratio</h3>
                <button id="downloadPieChartPDF" class="btn btn-sm btn-outline-secondary" <?= !$hasData ? 'disabled' : '' ?>>
                    <i class="fas fa-download"></i> Download PDF
                </button>
            </div>

            <?php if (!$hasData): ?>
                <div class="alert alert-info m-0">
                    No order data available
                </div>
            <?php else: ?>
                <div class="chart-container flex-grow-1 d-flex justify-content-center align-items-center" style="position: relative; min-height: 220px;">
                    <canvas id="orderRatioChart"></canvas>
                </div>
            <?php endif; ?>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get data from PHP
                const labels = <?= $labelsJSON ?>;
                const counts = <?= $countsJSON ?>;
                const colors = <?= $colorsJSON ?>;
                const percentages = <?= $percentagesJSON ?>;
                const hasData = <?= $hasData ? 'true' : 'false' ?>;
                const totalOrders = <?= $totalOrders ?>;

                // If no data, don't initialize chart
                if (!hasData) {
                    return;
                }

                const chartContainer = document.querySelector('.order-ratio-box .chart-container');
                const canvas = document.getElementById('orderRatioChart');

                // Ensure Chart.js is loaded before initializing
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded. Please include Chart.js in your page.');
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'alert alert-danger';
                    errorMsg.textContent = 'Chart.js library is missing. Please include it in your page.';
                    chartContainer.appendChild(errorMsg);
                    return;
                }

                // Format labels to include percentages
                const formattedLabels = labels.map((label, index) => {
                    return `${label} (${percentages[index]}%)`;
                });

                // Create the pie chart
                const chart = new Chart(canvas, {
                    type: 'pie',
                    data: {
                        labels: formattedLabels,
                        datasets: [{
                            data: counts,
                            backgroundColor: colors,
                            borderWidth: 1,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 15,
                                    padding: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const percentage = percentages[context.dataIndex];
                                        return `${label}: ${value} orders (${percentage}%)`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Order Distribution'
                            }
                        }
                    }
                });

                // PDF Download functionality
                document.getElementById('downloadPieChartPDF').addEventListener('click', function() {
                    // Check if jsPDF and html2canvas are loaded
                    if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined') {
                        alert('PDF export libraries not loaded. Please refresh the page and try again.');
                        return;
                    }

                    const {
                        jsPDF
                    } = jspdf;

                    // Create a new jsPDF instance
                    const pdf = new jsPDF('portrait', 'mm', 'a4');

                    // Add title to PDF
                    pdf.setFontSize(18);
                    pdf.text('Order Ratio Report', 15, 15);

                    // Add timestamp
                    pdf.setFontSize(10);
                    const today = new Date();
                    pdf.text('Generated on: ' + today.toLocaleString(), 15, 22);

                    // Add total orders
                    pdf.setFontSize(12);
                    pdf.text(`Total Orders: ${totalOrders}`, 15, 30);

                    // Capture the chart canvas
                    html2canvas(canvas).then(function(canvasImg) {
                        // Add the chart image to PDF
                        const imgData = canvasImg.toDataURL('image/png');
                        pdf.addImage(imgData, 'PNG', 15, 35, 180, 180);

                        // Add data table to PDF - positioned to ensure it fits on the page
                        pdf.setFontSize(12);
                        pdf.text('Order Status Breakdown:', 15, 225);

                        // Table headers
                        pdf.setFontSize(10);
                        pdf.text('Status', 20, 235);
                        pdf.text('Count', 90, 235);
                        pdf.text('Percentage', 130, 235);

                        // Add a line under headers
                        pdf.line(20, 238, 170, 238);

                        // Table data
                        let y = 245;
                        for (let i = 0; i < labels.length; i++) {
                            pdf.text(labels[i], 20, y);
                            pdf.text(counts[i].toString(), 90, y);
                            pdf.text(percentages[i] + '%', 130, y);
                            y += 8; // Increased spacing to ensure no overlap
                        }

                        // Save the PDF
                        pdf.save('order_ratio_report.pdf');
                    });
                });
            });
        </script>
    </div>
</div>

<div class="row">
    <div class="memabox7 col-lg-4">
        <?php
        require 'weltz_dbconnect.php';

        try {
            // Updated arrays for action types, labels, and colors
            $actionLabels = ['Login', 'Logout', 'Create Customer', 'Create Admin', 'Create Product', 'Place Order', 'Update Order Status', 'Update Product Stock', 'Restore Stock'];
            $actionColors = ['#4e73df', '#f56b00', '#1cc88a', '#36b9cc', '#00FFFF', '#f1c40f', '#e74a3b', '#9b59b6', '#2ecc71']; // Blue, Orange, Green, Teal, Yellow, Red, Purple, Lime
            $actionCounts = array_fill(0, count($actionLabels), 0); // Initialize all counts to 0
            $actionTypes = ['LOGIN', 'LOGOUT', 'CREATE CUSTOMER', 'CREATE ADMIN', 'CREATE PRODUCT', 'PLACE ORDER', 'UPDATE ORDER STATUS', 'UPDATE PRODUCT STOCK', 'RESTORE STOCK'];

            // Updated query to fetch counts for all action types
            $query = "SELECT actionType, COUNT(*) as count FROM audit_logs 
                  WHERE actionType IN ('LOGIN', 'LOGOUT', 'CREATE CUSTOMER', 'CREATE ADMIN', 'CREATE PRODUCT', 'PLACE ORDER', 'UPDATE ORDER STATUS', 'UPDATE PRODUCT STOCK', 'RESTORE STOCK') 
                  GROUP BY actionType";

            $result = $conn->query($query);

            if (!$result) {
                throw new Exception("Failed to execute the audit logs query: " . $conn->error);
            }

            $totalActions = 0;

            // Populate the counts array
            while ($row = $result->fetch_assoc()) {
                $actionIndex = array_search($row['actionType'], $actionTypes);
                if ($actionIndex !== false) {
                    $actionCounts[$actionIndex] = intval($row['count']);
                    $totalActions += intval($row['count']);
                }
            }

            // Calculate percentages
            $actionPercentages = [];
            foreach ($actionCounts as $count) {
                $percentage = ($totalActions > 0) ? round(($count / $totalActions) * 100, 1) : 0;
                $actionPercentages[] = $percentage;
            }

            // Check if we have any data
            $hasData = ($totalActions > 0);

            // Prepare data for JavaScript
            $labelsJSON = json_encode($actionLabels);
            $countsJSON = json_encode($actionCounts);
            $colorsJSON = json_encode($actionColors);
            $percentagesJSON = json_encode($actionPercentages);
        } catch (Exception $e) {
            error_log("Error in memabox7: " . $e->getMessage());

            // Set default values in case of error
            $actionLabels = ['Login', 'Logout', 'Create Customer', 'Create Admin', 'Create Product', 'Place Order', 'Update Order Status', 'Update Product Stock', 'Restore Stock'];
            $actionColors = ['#4e73df', '#f56b00', '#1cc88a', '#36b9cc', '#00FFFF', '#f1c40f', '#e74a3b', '#9b59b6', '#2ecc71'];
            $actionCounts = array_fill(0, count($actionLabels), 0);
            $actionPercentages = array_fill(0, count($actionLabels), 0);
            $hasData = false;
            $totalActions = 0;

            $labelsJSON = json_encode($actionLabels);
            $countsJSON = json_encode($actionCounts);
            $colorsJSON = json_encode($actionColors);
            $percentagesJSON = json_encode($actionPercentages);
        }
        ?>

        <div class="audit-actions-box rounded h-100 d-flex flex-column bg-light shadow-sm rounded p-5">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="fs-5 text-dark m-0">Events</h3>
                <button id="downloadAuditChartPDF" class="btn btn-sm btn-outline-secondary" <?= !$hasData ? 'disabled' : '' ?>>
                    <i class="fas fa-download"></i> Download PDF
                </button>
            </div>

            <?php if (!$hasData): ?>
                <div class="alert alert-info m-0">
                    No user audit data available
                </div>
            <?php else: ?>
                <div class="chart-container flex-grow-1 d-flex justify-content-center align-items-center" style="position: relative; min-height: 220px;">
                    <canvas id="auditLogsChart"></canvas>
                </div>
            <?php endif; ?>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get data from PHP
                const labels = <?= $labelsJSON ?>;
                const counts = <?= $countsJSON ?>;
                const colors = <?= $colorsJSON ?>;
                const percentages = <?= $percentagesJSON ?>;
                const hasData = <?= $hasData ? 'true' : 'false' ?>;
                const totalActions = <?= $totalActions ?>;

                // If no data, don't initialize chart
                if (!hasData) {
                    return;
                }

                const chartContainer = document.querySelector('.audit-actions-box .chart-container');
                const canvas = document.getElementById('auditLogsChart');

                // Ensure Chart.js is loaded before initializing
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded. Please include Chart.js in your page.');
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'alert alert-danger';
                    errorMsg.textContent = 'Chart.js library is missing. Please include it in your page.';
                    chartContainer.appendChild(errorMsg);
                    return;
                }

                // Format labels to include percentages
                const formattedLabels = labels.map((label, index) => {
                    return `${label} (${percentages[index]}%)`;
                });

                // Create the pie chart
                const chart = new Chart(canvas, {
                    type: 'doughnut', // Using doughnut chart for variety
                    data: {
                        labels: formattedLabels,
                        datasets: [{
                            data: counts,
                            backgroundColor: colors,
                            borderWidth: 1,
                            borderColor: '#fff',
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%', // Doughnut hole size
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 15,
                                    padding: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const percentage = percentages[context.dataIndex];
                                        return `${label}: ${value} actions (${percentage}%)`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Events'
                            }
                        }
                    }
                });

                // Add center text with total count
                Chart.register({
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        if (chart.config.type === 'doughnut') {
                            // Get canvas context
                            const ctx = chart.ctx;

                            // Get chart area dimensions
                            const chartArea = chart.chartArea;
                            const centerX = (chartArea.left + chartArea.right) / 2;
                            const centerY = (chartArea.top + chartArea.bottom) / 2;

                            // Set text properties
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            // Draw total count
                            ctx.font = 'bold 16px Arial';
                            ctx.fillStyle = '#333';
                            ctx.fillText(totalActions, centerX, centerY - 10);

                            // Draw "Total" label
                            ctx.font = '12px Arial';
                            ctx.fillStyle = '#666';
                            ctx.fillText('Total', centerX, centerY + 10);
                        }
                    }
                });

                // PDF Download functionality
                document.getElementById('downloadAuditChartPDF').addEventListener('click', function() {
                    // Check if jsPDF and html2canvas are loaded
                    if (typeof html2canvas === 'undefined' || typeof jspdf === 'undefined') {
                        alert('PDF export libraries not loaded. Please refresh the page and try again.');
                        return;
                    }

                    const {
                        jsPDF
                    } = jspdf;
                    const pdf = new jsPDF('portrait', 'mm', 'a4');

                    // Add title
                    pdf.setFontSize(18);
                    pdf.text('User Audit Actions Report', 15, 15);

                    // Add timestamp
                    pdf.setFontSize(10);
                    const today = new Date();
                    pdf.text('Generated on: ' + today.toLocaleString(), 15, 22);

                    // Add total actions
                    pdf.setFontSize(12);
                    pdf.text(`Total User Actions: ${totalActions}`, 15, 30);

                    // Capture the chart canvas
                    html2canvas(canvas, {
                        scale: 2
                    }).then(function(canvasImg) {
                        const imgData = canvasImg.toDataURL('image/png');

                        // Maintain aspect ratio while adjusting the image size
                        const pdfWidth = 210 - 30; // A4 width minus margins (15mm each side)
                        const pdfHeight = 297 - 50; // A4 height minus margins (15mm top, 35mm bottom)

                        let imgWidth = pdfWidth; // Set image width to the available width
                        let imgHeight = (canvasImg.height / canvasImg.width) * imgWidth; // Calculate the height based on aspect ratio

                        // Ensure the image fits within the page (if it exceeds the page height, scale it down)
                        if (imgHeight > pdfHeight * 0.6) { // Adjust the max height of the image to 60% of the page
                            const scaleFactor = (pdfHeight * 0.6) / imgHeight;
                            imgHeight = pdfHeight * 0.6; // Set new height
                            imgWidth = imgWidth * scaleFactor; // Scale width accordingly
                        }

                        // Add the image to the PDF
                        pdf.addImage(imgData, 'PNG', 15, 35, imgWidth, imgHeight);

                        // Add data table to PDF
                        pdf.setFontSize(12);
                        pdf.text('Action Type Breakdown:', 15, 35 + imgHeight + 10);

                        // Table headers
                        pdf.setFontSize(10);
                        pdf.text('Action Type', 20, 35 + imgHeight + 20);
                        pdf.text('Count', 80, 35 + imgHeight + 20);
                        pdf.text('Percentage', 120, 35 + imgHeight + 20);

                        // Add a line under headers
                        pdf.line(20, 35 + imgHeight + 23, 160, 35 + imgHeight + 23);

                        // Table data
                        let y = 35 + imgHeight + 30;
                        for (let i = 0; i < labels.length; i++) {
                            pdf.text(labels[i], 20, y);
                            pdf.text(counts[i].toString(), 80, y);
                            pdf.text(percentages[i] + '%', 120, y);
                            y += 8;
                        }

                        // Save the PDF
                        pdf.save('user_audit_actions_report.pdf');
                    });
                });


            });
        </script>
    </div>

    <div class="memabox8 col-lg-8">
        <?php
        require_once 'weltz_dbconnect.php';

        // Query to get products with at least 30% of stock available
        $productsSQL =
            "SELECT
        productID, 
        productIMG,
        productName,
        inStock
        FROM 
            products_tbl
        WHERE
            inStock <= 30";

        $productsSQLResult = $conn->query($productsSQL);

        $categoriesSQL = "SELECT * from categories_tbl";
        $categoriesSQLResult = $conn->query($categoriesSQL);
        ?>
        <div class="table-container container-fluid bg-light p-5 rounded shadow">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h3 class="fs-5 text-dark m-0">Low Stocks</h3>
            </div>
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Units in Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($productsSQLResult->num_rows > 0) {
                        while ($row = $productsSQLResult->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['productID'] ?></td>
                                <td><img src="<?php echo $row['productIMG'] ?>" alt="<?php echo $row['productName'] ?>" style="width:100px"></td>
                                <td><?php echo $row['productName'] ?></td>
                                <td><?php echo $row['inStock'] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Initialize DataTable -->
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true
                });
            });
        </script>

    </div>

</div>