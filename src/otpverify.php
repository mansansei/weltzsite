<?php
session_start();
require "weltz_dbconnect.php";

// Set header to return HTML (not JSON)
header("Content-Type: text/html");

$response = [];

if (isset($_GET['otp'])) {
    $otp = $_GET['otp'];

    // Use prepared statements to prevent SQL injection
    $verify_otp = $conn->prepare("SELECT otp, status FROM users_tbl WHERE otp = ? LIMIT 1");
    $verify_otp->bind_param("s", $otp);
    $verify_otp->execute();
    $result = $verify_otp->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['status'] === "Verified") {
            $response = [
                "status" => "error",
                "message" => "Account already verified. Please log in.",
                "redirect" => "signup.php"
            ];
        } else {
            $update_sql = $conn->prepare("UPDATE users_tbl SET status = 'Verified' WHERE otp = ? LIMIT 1");
            $update_sql->bind_param("s", $otp);

            if ($update_sql->execute()) {
                $response = [
                    "status" => "success",
                    "message" => "Verification successful! You may now login.",
                    "redirect" => "login.php"
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "Verification failed. Please try again.",
                    "redirect" => "signup.php"
                ];
            }
        }
    } else {
        $response = [
            "status" => "error",
            "message" => "Invalid OTP. Please check and try again.",
            "redirect" => "signup.php"
        ];
    }
} else {
    $response = [
        "status" => "error",
        "message" => "No OTP provided. Please check your email.",
        "redirect" => "signup.php"
    ];
}

// Output the JavaScript directly as an HTML response
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Verifying...</title>
    <script>
        sessionStorage.setItem('otp_message', JSON.stringify(" . json_encode($response) . "));
        window.location.href = '" . $response['redirect'] . "';
    </script>
</head>
<body>
</body>
</html>";
exit();
