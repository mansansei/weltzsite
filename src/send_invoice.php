<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function send_invoice($toEmail, $referenceNum, $orderID)
{
    require 'weltz_dbconnect.php';

    $mail = new PHPMailer(true);
    
    try {
        // Retrieve order details
        $orderItemsSQL = "SELECT p.productName, oi.orderItemQuantity, oi.orderItemTotal 
                          FROM order_items_tbl oi
                          JOIN products_tbl p ON oi.productID = p.productID
                          WHERE oi.orderID = '$orderID'";
        $result = $conn->query($orderItemsSQL);

        $itemsHTML = '';
        $totalOrderAmount = 0;
        while ($row = $result->fetch_assoc()) {
            $itemsHTML .= "<tr>
                                <td style='padding:10px; border-bottom:1px solid #ddd;'>{$row['productName']}</td>
                                <td style='padding:10px; border-bottom:1px solid #ddd; text-align:center;'>{$row['orderItemQuantity']}</td>
                                <td style='padding:10px; border-bottom:1px solid #ddd; text-align:right;'>$" . number_format($row['orderItemTotal'], 2) . "</td>
                           </tr>";
            $totalOrderAmount += $row['orderItemTotal'];
        }

        // Email content
        $emailBody = "
            <html>
            <head>
                <style>
                    .email-container { font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; background: #f9f9f9; border-radius: 10px; }
                    .header { background-color: #fc0001; color: white; padding: 15px; text-align: center; font-size: 22px; font-weight: bold; border-radius: 10px 10px 0 0; }
                    .order-details { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
                    .order-details th, .order-details td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
                    .order-details th { background-color: #fc0001; color: white; text-align: center; }
                    .order-summary { font-size: 18px; font-weight: bold; text-align: right; padding: 15px; background: #eee; border-radius: 0 0 10px 10px; }
                    .cta-button { display: block; text-align: center; background: #fc0001; color: white; padding: 12px; text-decoration: none; border-radius: 5px; font-size: 18px; margin: 20px auto; width: 200px; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>Invoice for Order #$referenceNum</div>
                    <p>Dear Customer,</p>
                    <p>Thank you for your order! Below is your order summary:</p>
                    
                    <table class='order-details'>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                        $itemsHTML
                    </table>
                    
                    <p class='order-summary'>Total Order Amount: $" . number_format($totalOrderAmount, 2) . "</p>
                    
                    <p>Please have the payment ready and present the order reference number or this invoice upon pickup.</p>
                    <a href='http://localhost/weltzsite/src/invoice.php?referenceNum=$referenceNum' class='cta-button'>View Invoice</a>
                    <p>If you have any questions, feel free to contact us.</p>
                    <p>Best regards,<br><strong>Weltz Group</strong></p>
                </div>
            </body>
            </html>
        ";

        // PHPMailer setup
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'weltzphils@gmail.com'; // Replace with your email
        $mail->Password = 'kkizzhibilqjhuyg'; // Replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email headers
        $mail->setFrom('weltzphils@gmail.com', 'Weltz Industrial Phils INC.');
        $mail->addAddress($toEmail);
        $mail->Subject = "Invoice for Your Order #$referenceNum";
        $mail->isHTML(true);
        $mail->Body = $emailBody;

        $mail->send();
    } catch (Exception $e) {
        error_log("Invoice Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

?>
