<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function send_verification($firstname, $email, $otp)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'weltzphils@gmail.com';
        $mail->Password = 'kkizzhibilqjhuyg';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('weltzphils@gmail.com', 'Weltz Industrial Phils INC.');
        $mail->addAddress($email);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "Weltz Industrial OTP Verification Code";

        // Styled HTML Body
        $mail->Body = "
        <div style='font-family: \"Segoe UI\", Tahoma, Geneva, Verdana, sans-serif; max-width: 600px; margin: auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 12px; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>
            <div style='text-align: center;'>
                <img src='https://i.imgur.com/htCZgAe.png' alt='Weltz Industrial Logo' style='max-width: 120px; margin-bottom: 20px;'>
                <h1 style='color: #fc0001; margin: 0; font-size: 24px;'>Verify Your Email</h1>
            </div>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>Hi <strong>" . htmlspecialchars($firstname) . "</strong>,</p>
            <p style='color: #333; font-size: 16px; line-height: 1.5;'>
                Thanks for signing up with <strong>Weltz Industrial Phils INC.</strong> To verify your email address and activate your account, please click the button below:
            </p>
            <div style='text-align: center; margin: 30px 0;'>
                <a href='http://localhost/weltzsite/src/otpverify.php?otp=$otp' style='background-color: #fc0001; color: #fff; padding: 14px 24px; border-radius: 6px; text-decoration: none; font-size: 16px; font-weight: bold; display: inline-block;'>Verify My Account</a>
            </div>
            <p style='color: #666; font-size: 14px; line-height: 1.5;'>
                If you didn’t request this email, you can safely ignore it.
            </p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #aaa; font-size: 12px; text-align: center;'>
                &copy; " . date('Y') . " Weltz Industrial Phils INC. All rights reserved.<br>
                This is an automated message, please do not reply.
            </p>
        </div>";

        // Send Email
        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $mail->ErrorInfo]);
    }
}
