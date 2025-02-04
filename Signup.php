<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Signup.css">
</head>
<body>
    <section class="signup">
        <div class="logo-wrapper">
            <div class="logo">
                <img src="images/logo.png" alt="logo">
            </div>
        </div>
        <div class="form-wrapper">
            <div class="title">
                <h1>Sign Up</h1>
            </div>
            
            <form class="signupform" id="signupForm" method="POST">

                <div class="row1">
                <input type="text" name="uFname" placeholder="First Name" required>
                <input type="text" name="uLname" placeholder="Last Name" required>
                </div>

                <div class="row2">
                <input type="text" name="uAdd" placeholder="Address" required>
                </div>
                
                <div class="row2">
                <input type="tel" name="uPhone" placeholder="Phone No." required>
                </div>

                <div class="row2">
                <input type="email" name="uEmail" placeholder="Email Address" required>
                </div>

                <div class="row2">
                <input type="password" name="uPass" placeholder="Password" required>
                </div>

                <div class="signupcheckbox">
                <input type="checkbox" id="policy" name="policy" value="true" required>
                <label for="policy">By checking this, you agree to our <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a></label>
                </div>

                <div class="signupbutton">
                    <button type="submit" value="submit">Sign up</button>
                </div>
            </form>

            <div class="loginhere">
                <p>Already registered? <a href="Login.php">Login here</a></p>
            </div>

        </div>
    </section>
</body>
</html>

<?php

require_once "weltz_dbconnect.php";
include "send_verification.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['uFname'];
    $lastname = $_POST['uLname'];
    $address = $_POST['uAdd'];
    $phone = $_POST['uPhone'];
    $email = $_POST['uEmail'];
    $password = $_POST['uPass'];
    $role = 1;
    $otp = rand(000000,999999);
    $status = "Unverified";

    
    if (strlen($firstname) > 50) {
        echo "<script>alert('First name must be 50 characters or less.'); window.history.back();</script>";
        exit();
    }

    if (strlen($lastname) > 50) {
        echo "<script>alert('Last name must be 50 characters or less.'); window.history.back();</script>";
        exit();
    }

    if (strlen($address) > 100) {
        echo "<script>alert('Address must be 100 characters or less.'); window.history.back();</script>";
        exit();
    }

    if (!preg_match('/^\d{11}$/', $phone)) {
        echo "<script>alert('Phone number must be exactly 11 digits and contain only numbers.'); window.history.back();</script>";
        exit();
    }

    if (strlen($email) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email must be 50 characters or less and a valid email address.'); window.history.back();</script>";
        exit();
    }

    if (strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
        echo "<script>alert('Password must be at least 8 characters long and contain at least 1 digit (0-9) and 1 special character (!@#$%^&*).'); window.history.back();</script>";
        exit();
    }

    $emailCheckQuery = "SELECT * FROM users WHERE userEmail = '$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        echo "<script>alert('Email already exists. Please use a different email.'); window.history.back();</script>";
        exit();
    }

    $hashed_password = md5($password);

    $currentDateTime = date('Y-m-d H:i:s');

    $insertsql = "INSERT INTO users (userFname, userLname, userAdd, userPhone, userEmail, userPass, roleID, otp, status, createdAt, updatedAt, updID)
    VALUES ('$firstname', '$lastname', '$address', '$phone', '$email', '$hashed_password', '$role', '$otp', '$status', '$currentDateTime', '$currentDateTime', NULL)";

    $result = $conn->query($insertsql);

    if ($result == True) { 
        send_verification($fname,$email,$otp);
        echo "<script>alert('Registration successful!'); window.location.href = 'Login.php';</script>";
        
        } else {
            //if not inserted
           echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
        }
}

?>