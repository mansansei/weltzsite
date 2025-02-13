<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Signup.css">
</head>
<body>

<!-- Start of Sign Up Section -->
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
                <label for="policy">By checking this, you agree to our <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal">Privacy Policy</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a></label>
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

    <!-- Privacy Policy Modal -->
    <div class="modal fade" id="privacyPolicyModal" tabindex="-1" aria-labelledby="privacyPolicyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyPolicyModalLabel">Privacy Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>**THIS IS TEMPORARY**</p>
                    <!-- Your Privacy Policy content goes here -->
                    <h5>1. Introduction</h5>
                    <p>Welcome to [Your Website].
                        We value your privacy and are
                        committed to protecting your
                        personal data. This privacy
                        policy outlines how we collect,
                        use, store, and disclose your
                        information when you visit our
                        website and use our services.</p>

                    <h5>2. Information We Collect</h5>
                    <ul>
                        <li>Personal Information: When you place an order, we may collect personal information such as your name, email address, phone number, and delivery address.</li>
                        <li>Payment Information: We use secure third-party payment processors to handle payment transactions. We do not store your payment information on our servers.</li>
                        <li>Order Information: We collect details about the products or services you order, including any customization or preferences you specify.</li>
                        <li>Website Usage Information: We collect information about your interactions with our website, including IP address, browser type, and pages visited. This helps us improve our website and services.</li>
                    </ul>

                    <h5>3. How We Use Your Information</h5>
                    <ul>
                        <li>Order Fulfillment: To process and deliver your orders, including sending order confirmations and tracking information.</li>
                        <li>Customer Support: To provide customer support and address any inquiries or issues you may have.</li>
                        <li>Marketing: With your consent, to send you promotional offers, newsletters, and updates about our products and services.</li>
                        <li>Improvement: To analyze and improve our website, services, and user experience.</li>
                    </ul>

                    <h5>4. Information Sharing and Disclosure</h5>
                    <p>We do not sell or share your personal information with third parties, except in the following cases:</p>
                    <ul>
                        <li>Service Providers: We may share your information with third-party service providers who assist us with order fulfillment, payment processing, and marketing.</li>
                        <li>Legal Requirements: We may disclose your information if required by law or in response to legal processes.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms of Service Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Your Terms of Service content goes here -->
                    <p>**THIS IS TEMPORARY**</p>
                    <h5>Introduction</h5>
                    <p>Welcome to [Your Website]. These Terms of Service ("Terms") govern your use of our website and services. By accessing or using our website, you agree to be bound by these Terms. If you do not agree to these Terms, please do not use our website.</p>
                    
                    <h5>1. Use of Our Services</h5>
                    <p>Eligibility: You must be at least 18 years old to use our services. By using our website, you represent and warrant that you meet this age requirement.</p>
                    <p>Account Registration: To place orders, you may be required to create an account. You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account.</p>
                    <p>Prohibited Activities:</p>
                    <ul>
                        <li>You agree not to engage in any activities that violate applicable laws or regulations.</li>
                        <li>You agree not to infringe upon the rights of others.</li>
                        <li>You agree not to interfere with the proper functioning of our website.</li>
                    </ul>
                    
                    <h5>2. Orders and Payments</h5>
                    <p>Order Acceptance: All orders placed through our website are subject to acceptance. We reserve the right to refuse or cancel any order for any reason.</p>
                    <p>Payment: You agree to provide accurate and complete payment information. Payments are processed by secure third-party payment processors. We do not store your payment information on our servers.</p>
                    <p>Pricing and Availability: Prices and availability of products are subject to change without notice. We are not responsible for any errors in pricing or availability.</p>
                    
                    <h5>3. Shipping and Delivery</h5>
                    <p>Shipping: We will make every effort to ship your order promptly. However, we are not responsible for any delays or issues caused by shipping carriers or other factors beyond our control.</p>
                    <p>Delivery: Delivery times are estimates and not guaranteed. We are not liable for any delays in delivery.</p>
                    
                    <h5>4. Returns and Refunds</h5>
                    <p>Return Policy: We offer returns and refunds in accordance with our Return Policy, which is available on our website.</p>
                    <p>Refunds: Refunds will be processed within a reasonable time after receiving the returned items. We reserve the right to refuse refunds for items that do not meet our return criteria.</p>
                    
                    <h5>5. Intellectual Property</h5>
                    <p>Ownership: All content on our website, including text, graphics, logos, and images, is the property of [Your Website] or its licensors and is protected by intellectual property laws.</p>
                    <p>License: You are granted a limited, non-exclusive, non-transferable license to access and use our website for personal, non-commercial purposes.</p>
                    
                    <h5>6. Limitation of Liability</h5>
                    <p>Disclaimer: Our website and services are provided "as is" without warranties of any kind, whether express or implied.</p>
                    <p>Limitation: To the fullest extent permitted by law, we are not liable for any damages arising out of or in connection with your use of our website or services.</p>
                    
                    <h5>7. Indemnification</h5>
                    <p>You agree to indemnify and hold [Your Website] harmless from any claims, damages, losses, or expenses arising out of or related to your use of our website or violation of these Terms.</p>
                    
                    <h5>8. Changes to These Terms</h5>
                    <p>We may update these Terms from time to time. Any changes will be posted on this page with the updated date. Your continued use of our website after any changes constitutes your acceptance of the new Terms.</p>
                    
                    <h5>Contact Us</h5>
                    <p>If you have any questions or concerns about these Terms, please contact us us at [Contact Information].</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
        send_verification($firstname,$email,$otp);
        echo "<script>alert('Registration successful!'); window.location.href = 'Login.php';</script>";
        
        } else {
            //if not inserted
           echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
        }
}

?>