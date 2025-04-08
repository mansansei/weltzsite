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
        $mail->Body = "
        <div style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 12px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>
            <div style='text-align: center;'>
                <img src='https://i.imgur.com/htCZgAe.png' alt='Weltz Industrial Logo' style='max-width: 120px; margin-bottom: 20px;'>
                <h1 style='color: #fc0001; margin: 0; font-size: 24px;'>Password Reset Request</h1>
            </div>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>Hello, dear customer</p>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>You requested to reset your password for your account with <strong>Weltz Industrial Phils INC.</strong> Please use the following OTP to proceed:</p>
            <div style='text-align: center; margin: 30px 0;'>
                <h2 style='color: #fc0001;'>OTP: <strong>" . $otp . "</strong></h2>
            </div>
            <p style='color: #666; font-size: 14px; line-height: 1.5; text-align: center;'>If you did not request this, please ignore this email.</p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #aaa; font-size: 12px; text-align: center;'>&copy; " . date('Y') . " Weltz Industrial Phils INC. All rights reserved.<br>This is an automated message, please do not reply.</p>
        </div>";

        // Send Email
        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $mail->ErrorInfo]);
    }
}
