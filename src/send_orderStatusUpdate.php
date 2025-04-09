<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure you have PHPMailer installed via Composer

function send_orderStatusUpdate($toEmail, $referenceNum, $orderID, $newStatus, $orderProof = '')
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
                $statusMessage = "Your order has been successfully picked up. Thank you for choosing Weltz Industrial! This will serve as an official online copy of your receipt.";
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

            <p style='text-align: right; font-size: 16px; font-weight: bold; margin-top: 20px;'>Total: $" . number_format($totalOrderAmount, 2) . "</p>";

        // Generate the Content-ID for embedded image
        $cid = 'orderproofimg';

        // Attach image and embed if exists
        if (!empty($orderProof) && file_exists($orderProof)) {
            $mail->addEmbeddedImage($orderProof, $cid);
            $mail->addAttachment($orderProof);

            $emailBody .= "
                <div style='margin-top: 30px;'>
                    <h2 style='color: #fc0001; font-size: 18px;'>Order Proof</h2>
                    <img src='cid:$cid' alt='Order Proof' style='max-width: 100%; border-radius: 8px; margin-top: 10px;'>
                </div>";
        }

        // Warranty Disclaimer (only if status is 4)
        if ($newStatus == 4) {
            $emailBody .= "
                <div style='margin-top: 40px;'>
                    <h2 style='color: #fc0001; font-size: 18px;'>Warranty Disclaimer</h2>
                    <p style='color: #333; font-size: 14px; line-height: 1.6;'>
                        This product is covered by a limited warranty for a period of six (6) months from the date of purchase. 
                        During this period, we guarantee that the product will be free from defects in material and workmanship under normal use and service.
                    </p>
                    <p style='color: #333; font-size: 14px; line-height: 1.6;'>
                        However, this warranty does not cover:
                        <ul style='padding-left: 20px; color: #333; font-size: 14px;'>
                            <li>Damage caused by misuse, abuse, accidents, or unauthorized modifications.</li>
                            <li>Normal wear and tear, including cosmetic damage.</li>
                            <li>Repairs or replacements performed by unauthorized service providers.</li>
                            <li>Issues resulting from failure to follow proper maintenance or usage guidelines.</li>
                        </ul>
                    </p>
                    <p style='color: #333; font-size: 14px; line-height: 1.6;'>
                        Our liability under this warranty is limited solely to repair or replacement of the defective product, at our discretion. 
                        We are not responsible for any indirect, incidental, or consequential damages arising from the use of this product.
                    </p>
                    <p style='color: #333; font-size: 14px; line-height: 1.6;'>
                        To make a warranty claim, the purchaser must provide proof of purchase and return the defective product within the warranty period. 
                        Warranty claims must be made in accordance with our service procedures.
                    </p>
                    <p style='color: #333; font-size: 14px; line-height: 1.6;'>
                        This warranty does not affect any statutory rights you may have under applicable laws.
                        <br>For assistance, please contact our customer support team.
                    </p>
                </div>";
        }

        // Footer
        $emailBody .= "
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

        // SMTP settings
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
