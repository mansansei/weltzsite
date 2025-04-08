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
                <td style='padding: 12px; border-bottom: 1px solid #eee;'>{$row['productName']}</td>
                <td style='padding: 12px; text-align: center; border-bottom: 1px solid #eee;'>{$row['orderItemQuantity']}</td>
                <td style='padding: 12px; text-align: right; border-bottom: 1px solid #eee;'>$" . number_format($row['orderItemTotal'], 2) . "</td>
            </tr>";
            $totalOrderAmount += $row['orderItemTotal'];
        }

        // Styled HTML body
        $emailBody = "
        <div style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 12px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>
            <div style='text-align: center;'>
                <img src='https://i.imgur.com/htCZgAe.png' alt='Weltz Logo' style='max-width: 120px; margin-bottom: 20px;'>
                <h2 style='color: #fc0001; margin: 0; font-size: 22px;'>Invoice for Order #$referenceNum</h2>
            </div>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>Dear Customer,</p>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>Thank you for your order! Here’s your order summary:</p>

            <table style='width: 100%; border-collapse: collapse; margin-top: 20px; background: #f9f9f9;'>
                <thead>
                    <tr style='background-color: #fc0001; color: white;'>
                        <th style='padding: 12px; text-align: left;'>Product Name</th>
                        <th style='padding: 12px; text-align: center;'>Quantity</th>
                        <th style='padding: 12px; text-align: right;'>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    $itemsHTML
                </tbody>
            </table>

            <div style='margin-top: 20px; font-size: 16px; text-align: right; color: #333; font-weight: bold;'>
                Total Order Amount: $" . number_format($totalOrderAmount, 2) . "
            </div>

            <p style='color: #333; font-size: 15px; line-height: 1.6; margin-top: 20px;'>
                Please have the payment ready and present the order reference number or this invoice upon pickup.
            </p>

            <div style='text-align: center; margin: 30px 0;'>
                <a href='http://localhost/weltzsite/src/invoice.php?referenceNum=$referenceNum' 
                   style='background-color: #fc0001; color: white; padding: 14px 24px; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: bold; display: inline-block;'>View Invoice</a>
            </div>

            <p style='color: #666; font-size: 14px; line-height: 1.5;'>If you have any questions, feel free to contact us.</p>
            <p style='color: #333; font-weight: bold;'>Best regards,<br>Weltz Industrial Phils INC.</p>

            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>

            <p style='color: #aaa; font-size: 12px; text-align: center;'>
                &copy; " . date('Y') . " Weltz Industrial Phils INC. All rights reserved.<br>
                This is an automated message, please do not reply.
            </p>
        </div>";

        // PHPMailer setup
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'weltzphils@gmail.com';
        $mail->Password = 'kkizzhibilqjhuyg';
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
