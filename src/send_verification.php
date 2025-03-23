<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function send_verification($firstname, $email, $otp) {
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
        $mail->Body = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: #f9f9f9;'>
            <h2 style='color: #333; text-align: center;'>Welcome to Weltz Industrial</h2>
            <p style='color: #555; font-size: 16px;'>Hello <strong>" . htmlspecialchars($firstname) . "</strong>,</p>
            <p style='color: #555; font-size: 16px;'>Thank you for registering on our platform. To complete your verification, please click the button below:</p>
            <div style='text-align: center; margin: 20px;'>
                <a href='http://localhost/weltzsite/src/otpverify.php?otp=$otp' style='background-color: #fc0001; color: white; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-size: 18px; display: inline-block;'>Verify Your Account</a>
            </div>
            <p style='color: #555; font-size: 14px; text-align: center;'>If you did not request this, please ignore this email.</p>
            <hr style='border: 0; height: 1px; background: #ddd; margin: 20px 0;'>
            <p style='color: #777; font-size: 12px; text-align: center;'>© " . date('Y') . " Weltz Industrial Phils INC. All rights reserved.</p>
        </div>";
    
        // Send Email
        $mail->send();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $mail->ErrorInfo]);
    }
}

?>
