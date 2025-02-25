<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Weltz INC</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="loginPage">
    <section class="logincontainer">

        <div class="logowrapper">
            <div class="logo">
                <img class="logo__image" src="images/logo.png" alt="Logo">
            </div>
        </div>

        <div class="formwrapper">

            <div class="logintitle">
                <h1>Login</h1>
            </div>

            <form class="loginform" method="POST">
                <input class="input1" type="text" name="uEmail" placeholder="Email Address">
                <input class="input2" type="password" name="uPass" placeholder="Password">

                <button type="submit">Login</button>
            </form>

            <div class="signuphere">
            <a href="#">Forgot Password</a>
            <p>Haven't registered? <a href="Signup.php">Sign up here</a></p>
            </div>

        </div>

    </section>
</body>
</html>

<?php

require_once "weltz_dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['email'] = $_POST['uEmail'];
    $email = $_POST['uEmail'];
    $password = $_POST['uPass'];
    $hashed_password = md5($password);

    if (strlen($email) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email must be 50 characters or less and a valid email address.'); window.history.back();</script>";
        exit();
    }

    if (strlen($password) < 8 || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*]/', $password)) {
        echo "<script>alert('Password must be at least 8 characters long and contain at least 1 digit (0-9) and 1 special character (!@#$%^&*).'); window.history.back();</script>";
        exit();
    }

    $loginsql = "SELECT * FROM users WHERE userEmail = '$email' AND userPass = '$hashed_password'";

    $loginresult =$conn->query($loginsql);

    if($loginresult->num_rows == 1){
        $fielddata = $loginresult->fetch_assoc();
        $role = $fielddata['roleID'];
        
        if ($role == 1) {
            header("location: Homepage.php");
        }else if ($role == 2){
            header("location: Signup.php");
        }
    } else {
        ?>
        <script>
            Swal.fire({
            position: "center",
            icon: "error",
            title: "Invalid Login",
            showConfirmButton: false,
            timer: 1500
            });

        </script>

        <?php
    }
}

?>