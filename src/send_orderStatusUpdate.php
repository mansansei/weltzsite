<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure you have PHPMailer installed via Composer

function send_orderStatusUpdate($toEmail, $referenceNum, $orderID, $newStatus)
{
    require 'weltz_dbconnect.php';
    $mail = new PHPMailer(true);

    try {
        // Fetch order items
        $orderItemsSQL = "SELECT p.productName, oi.orderItemQuantity, oi.orderItemTotal 
                          FROM order_items_tbl oi
                          JOIN products_tbl p ON oi.productID = p.productID
                          WHERE oi.orderID = '$orderID'";
        $result = $conn->query($orderItemsSQL);

        $itemsHTML = '';
        $totalOrderAmount = 0;
        while ($row = $result->fetch_assoc()) {
            $itemsHTML .= "
                <tr>
                    <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$row['productName']}</td>
                    <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: center;'>{$row['orderItemQuantity']}</td>
                    <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>$" . number_format($row['orderItemTotal'], 2) . "</td>
                </tr>";
            $totalOrderAmount += $row['orderItemTotal'];
        }

        // Status message
        $subject = '';
        $statusMessage = '';
        switch ($newStatus) {
            case 2:
                $subject = 'Your Order is Ready for Pickup!';
                $statusMessage = "Your order is now ready for pickup. Please visit our store and present your invoice.";
                break;
            case 4:
                $subject = 'Your Order Has Been Picked Up';
                $statusMessage = "Your order has been successfully picked up. Thank you for choosing Weltz Industrial!";
                break;
            default:
                return;
        }

        // Email body
        $emailBody = "
        <div style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 12px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>
            <div style='text-align: center;'>
                <img src='https://i.imgur.com/htCZgAe.png' alt='Weltz Industrial Logo' style='max-width: 120px; margin-bottom: 20px;'>
                <h1 style='color: #fc0001; margin: 0; font-size: 22px;'>Order Update: #$referenceNum</h1>
            </div>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>Hi there, dear customer</p>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>$statusMessage</p>

            <h2 style='color: #fc0001; font-size: 18px; margin-top: 30px;'>Order Summary</h2>
            <table style='width: 100%; border-collapse: collapse; margin-top: 10px;'>
                <thead>
                    <tr style='background-color: #fc0001; color: #fff;'>
                        <th style='padding: 10px; text-align: left;'>Product Name</th>
                        <th style='padding: 10px; text-align: center;'>Quantity</th>
                        <th style='padding: 10px; text-align: right;'>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    $itemsHTML
                </tbody>
            </table>

            <p style='text-align: right; font-size: 16px; font-weight: bold; margin-top: 20px;'>Total: $" . number_format($totalOrderAmount, 2) . "</p>

            <p style='color: #666; font-size: 14px; line-height: 1.5; margin-top: 30px;'>
                If you have any questions, feel free to contact our support team.<br>
                <strong>Weltz Industrial Phils INC.</strong>
            </p>

            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #aaa; font-size: 12px; text-align: center;'>
                &copy; " . date('Y') . " Weltz Industrial Phils INC. All rights reserved.<br>
                This is an automated message, please do not reply.
            </p>
        </div>";

        // SMTP config
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'weltzphils@gmail.com';
        $mail->Password = 'kkizzhibilqjhuyg';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('weltzphils@gmail.com', 'Weltz Industrial Phils INC.');
        $mail->addAddress($toEmail);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $emailBody;

        $mail->send();
    } catch (Exception $e) {
        error_log("Order Status Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
