<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function forgotPasswordOTP($email, $otp)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'weltzphils@gmail.com';  // Your email
        $mail->Password = 'kkizzhibilqjhuyg';  // Your email password or App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('weltzphils@gmail.com', 'Weltz Industrial Phils INC.');
        $mail->addAddress($email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "Weltz Industrial Password Reset OTP";

        // Styled HTML Body
        $mail->Body = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #f9f9f9;'>
            <h2 style='color: #333; text-align: center;'>Weltz Industrial Password Reset</h2>
            <p style='color: #555; font-size: 16px;'>Hello,</p>
            <p style='color: #555; font-size: 16px;'>You requested to reset your password. Please use the following OTP to proceed with resetting your password:</p>
            <div style='text-align: center; margin: 20px;'>
                <h3 style='color: #fc0001;'>OTP: <strong>" . $otp . "</strong></h3>
            </div>
            <p style='color: #555; font-size: 14px; text-align: center;'>If you did not request this, please ignore this email.</p>
            <hr style='border: 0; height: 1px; background: #ddd; margin: 20px 0;'>
            <p style='color: #777; font-size: 12px; text-align: center;'>© " . date('Y') . " Weltz Industrial Phils INC. All rights reserved.</p>
        </div>";

        // Send Email
        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $mail->ErrorInfo]);
    }
}
