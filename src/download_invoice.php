<?php

require 'weltz_dbconnect.php';
require '../vendor/autoload.php'; // Load TCPDF

if (!isset($_GET['referenceNum'])) {
    die('Reference number missing.');
}

$referenceNum = $_GET['referenceNum'];

// Fetch order details, including customer name from users_tbl
$orderSQL = "SELECT o.createdAt, COALESCE(CONCAT(u.userFname, ' ', u.userLname), 'Deleted User') AS userFullName  
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

$orderDate = date("F j, Y, g:i A", strtotime($order['createdAt']));
$customerName = $order['userFullName'];

// Fetch order items
$orderItemsSQL = "SELECT p.productName, oi.orderItemQuantity, oi.orderItemTotal 
                  FROM order_items_tbl oi
                  JOIN products_tbl p ON oi.productID = p.productID
                  JOIN orders_tbl o ON oi.orderID = o.orderID
                  WHERE o.referenceNum = ?";
$stmt = $conn->prepare($orderItemsSQL);
$stmt->bind_param("s", $referenceNum);
$stmt->execute();
$orderItems = $stmt->get_result();

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Weltz Industrial Phils INC.');
$pdf->SetTitle("Invoice #$referenceNum");

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Company Logo (Replace with actual path)
$logo = '../assets/weltz_logo.png'; // Adjust the path to your actual logo
$pdf->Image($logo, 15, 10, 40, 20);

// Header Section
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(190, 10, 'Weltz Industrial Phils INC.', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(190, 8, 'Vista Verde Executive Village Cainta Rizal Philippines 1900 Cainta, Philippines', 0, 1, 'C');
$pdf->Cell(190, 8, 'Email: weltzphils@gmail.com | Phone: +63 960 275 8956', 0, 1, 'C');

// Space before invoice title
$pdf->Ln(10);

// Invoice Title
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(190, 10, "INVOICE #$referenceNum", 0, 1, 'C');
$pdf->Ln(3);

// Order Information
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(100, 7, "Customer: $customerName", 0, 1);
$pdf->Cell(100, 7, "Order Date: $orderDate", 0, 1);
$pdf->Ln(5);

// Table Headers
$pdf->SetFillColor(252, 0, 1); // Red Background
$pdf->SetTextColor(255, 255, 255); // White Text
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(100, 8, 'Product Name', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Quantity', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Total Price', 1, 1, 'C', true);

// Reset text color
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 11);

$totalAmount = 0;
$fill = false; // Alternating row colors

while ($row = $orderItems->fetch_assoc()) {
    $pdf->SetFillColor(240, 240, 240); // Light gray background for alternate rows
    $pdf->Cell(100, 8, $row['productName'], 1, 0, 'L', $fill);
    $pdf->Cell(30, 8, $row['orderItemQuantity'], 1, 0, 'C', $fill);
    $pdf->Cell(40, 8, "PHP " . number_format($row['orderItemTotal'], 2), 1, 1, 'R', $fill);
    $fill = !$fill;
    $totalAmount += $row['orderItemTotal'];
}

// Total Amount
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(252, 0, 1); // Red Background
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(130, 10, 'Grand Total:', 1, 0, 'R', true);
$pdf->Cell(40, 10, "PHP " . number_format($totalAmount, 2), 1, 1, 'R', true);

// Output PDF
$pdf->Output("Invoice_$referenceNum.pdf", 'D');

?>
