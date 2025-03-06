<?php
session_start();

require "weltz_dbconnect.php";

if(isset($_GET['otp'])) {
    $otp = $_GET['otp'];
    $verify_otp = "SELECT otp FROM users_tbl WHERE otp='$otp' LIMIT 1";
    $verify_results = $conn-> query($verify_otp);

    if(mysqli_num_rows($verify_results) > 0) {

        $row = mysqli_fetch_array($verify_results);
        
        if($row['status'] == 0){
            $clicked_otp = $row['otp'];
            $update_sql = "UPDATE users_tbl SET status='Verified' WHERE otp='$clicked_otp' LIMIT 1";
            $update_results = $conn-> query($update_sql);

            if ($update_results) {
                $_SESSION['status'] = "Verifiied Successfully, Please Login.";
                header('location: Login.php');
                exit(0);
            } else {
                $_SESSION['status'] = "Verification Failed.";
                header('location: Login.php');
                exit(0);
            }
            
        } else {
            $_SESSION['status'] = "Already Verified. Please Login";
            header('location: Login.php');
            exit(0);
        }
        
    } else {
        $_SESSION['status'] = "Invalid OTP";
        header('location: Login.php');
        exit(0);
    }

} else {
    $_SESSION['status'] = "Verifiied Successfully, Please Login.";
    header('location: Login.php');
    exit(0);
}


?>
