<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Weltz INC</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">

    <?php require_once 'cssLibraries.php' ?>
    <style>
        body {
            background-image: url('../images/loginbg.jpg');
            /* Change the path as needed */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            /* Ensures it covers full height */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-shape-divider-bottom-1744015093 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .custom-shape-divider-bottom-1744015093 svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 300px;
        }

        .custom-shape-divider-bottom-1744015093 .shape-fill {
            fill: #FFFFFF;
        }

        .forgotPassword {
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="forgotPassword container py-5">
        <div class="container">
            <!-- Form Wrapper -->
            <div class="d-flex justify-content-center">
                <div class="form-wrapper rounded-4 shadow p-4 p-md-5 w-100" style="max-width: 500px;">
                    <form class="resetform" id="resetForm" method="POST">
                        <div class="logo-wrapper d-flex align-items-center justify-content-center mb-4 text-center">
                            <div class="row">
                                <div class="logo me-0">
                                    <img src="../images/logo.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
                                </div>
                            </div>
                            <div class="row">
                                <p class="mb-0 fs-3 fw-semibold">Password Reset</p>
                            </div>
                        </div>
                        <!-- Email Input with Send Button -->
                        <div class="mb-5">
                            <label for="email" class="form-label">Please enter your email to receive an OTP</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                <button class="btn btn-outline-danger" type="button" id="sendOtpBtn">Send</button>
                            </div>
                        </div>
                        <!-- OTP Input -->
                        <div class="mb-3">
                            <input type="number" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required>
                        </div>
                        <!-- New Password Input -->
                        <div class="mb-5">
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                        </div>
                        <div class="text-center mb-3">
                            <input type="hidden" id="action" name="action" value="resetPassword">
                            <button type="submit" class="btn btn-danger w-100 rounded-5">Reset Password</button>
                        </div>
                        <div class="text-center">
                            <a href="login.php" class="text-danger">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-shape-divider-bottom-1744015093">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M600,112.77C268.63,112.77,0,65.52,0,7.23V120H1200V7.23C1200,65.52,931.37,112.77,600,112.77Z" class="shape-fill"></path>
        </svg>
    </div>

    <?php require_once 'cssLibrariesJS.php' ?>
</body>

</html>