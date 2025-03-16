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

    <?php require_once 'cssLibraries.php' ?>
</head>

<body class="loginPage">

    <section class="col-lg-6"></section>

    <section class="login container-fluid col-sm-12 col-md-12 col-lg-6">
        <div class="form-wrapper container-fluid rounded-4 shadow p-4">
            <div class="logo-wrapper text-center mb-3">
                <div class="logo">
                    <img src="../images/logo.png" alt="Logo" class="img-fluid">
                </div>
            </div>
            <form class="loginform" id="loginForm" method="POST">
                <div class="title row mb-3">
                    <h1 class="text-center">Login</h1>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <input class="form-control" type="email" name="uEmail" placeholder="Email Address">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <input class="form-control" type="password" name="uPass" placeholder="Password">
                    </div>
                </div>
                <div class="loginButton mb-3 mt-3 text-center">
                    <input type="hidden" id="action" name="action" value="loginUser">
                    <button type="submit" class="btn btn-danger w-100 rounded-5">Login</button>
                </div>
                <div class="signuphere">
                    <a href="#">Forgot Password</a>
                    <p>Haven't registered? <a href="Signup.php">Sign up here</a></p>
                </div>
            </form>
        </div>
    </section>

    <?php require_once 'cssLibrariesJS.php' ?>
</body>

</html>