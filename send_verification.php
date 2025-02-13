<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


function send_verification($firstname,$email,$otp) {

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'mertisepic031@gmail.com';                 // SMTP username
        $mail->Password = 'awjdrpvnfrrozhsv';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    
        //Recipients
        $mail->setFrom( 'mertiscool031@gmail.com', 'Weltz Industrial');
        $mail->addAddress($email);     // Add a recipient
        //Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = "Weltz Industrial OTP Verification Code";
        $mail->Body    = "<h1>Hello ".$firstname."</h1>
        <br><p>You have registered an account on our website!
        <br>Please click the link below to complete your verification:</p>
        <br><br><h3><strong><i><a href='http://localhost/weltzsite/otpverify.php?otp=$otp'>Verify Your Account!</a></i></strong></h3>";

        $mail->send();
        ?>
            <script>
                alert("Verification Link Successfully Sent! Please check your email.")
            </script>
        <?php
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

?>