<?php

require_once __DIR__ . '/../../../Controller/UserController.php';

session_start();

$error = "";
$timeleft = null;

if (isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['role']) && isset($_SESSION['phone'])) {
    header("location: ../user/index.php");
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $userC = new UserController();
        $res = $userC->signIn($email, $password);
        $success = $res['success'];

        if ($success) {
            $user = $res['user'];

            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['profilePicture'] = $user['profilePicture'];

            if (strtolower($user['role']) == 'admin' ||  strtolower($user['role']) == 'farmer')
                header("location: ../user/index.php");
            else
                header('location: ../../front/index.php');
        } else {
            $error = $res['message'];
            if (isset($res['timeLeft'])) {
                $timeleft = $res['timeLeft'];
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en" data-topbar-color="dark">

<head>
    <meta charset="utf-8" />
    <title>Log In | Ubold - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/logoo.ico">

    <!-- Theme Config Js -->
    <script src="../assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .auth-fluid-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            /* Adjust the opacity as needed */
            z-index: 1;
            /* Ensure the overlay sits above the background */
        }

        .auth-fluid-right {
            position: relative;
            /* Ensure the pseudo-element positions relative to this container */
            z-index: 0;
            /* Content inside remains above the overlay */
        }
    </style>
</head>

<body class="auth-fluid-pages pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="p-3">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <div class="auth-brand">
                            <a href="../index.php" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="../assets/images/logo.png" alt="" height="100">
                                </span>
                            </a>

                            <a href="../index.php" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="../assets/images/logo.png" alt="" height="100">
                                </span>
                            </a>
                        </div>
                    </div>
                    <!-- title-->
                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access account.</p>

                    <!-- form -->
                    <form id="login-form" action="auth-login.php" method="post">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="text" id="emailaddress"
                                placeholder="Enter your email" name="email">
                        </div>
                        <div class="mb-3">
                            <a href="../auth-recoverpw-2.html" class="text-muted float-end"><small>Forgot your
                                    password?</small></a>
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter your password"
                                name="password">

                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>


                        <?php if ($timeleft !== null) : ?>
                            <!-- Display time left message -->
                            <div class="text-center">
                                <div class="alert alert-warning fade show d-inline-block" role="alert">
                                    You are currently banned. Time remaining: <strong><?= htmlspecialchars($timeleft) ?></strong>
                                </div>
                            </div>
                        <?php elseif ($error) : ?>
                            <!-- Display generic error message -->
                            <div class="text-center">
                                <div class="alert alert-danger fade show d-inline-block" role="alert">
                                    <?= htmlspecialchars($error) ?>
                                </div>
                            </div>
                        <?php endif; ?>



                        <div class="text-center d-grid">
                            <button class="btn btn-primary" type="submit">Log In</button>
                        </div>

                        <!-- social-->
                        <div class="text-center mt-4">
                            <p class="text-muted font-16">Sign in with</p>
                            <ul class="social-list list-inline mt-3">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                            class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                            class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                            class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                            class="mdi mdi-github"></i></a>
                                </li>
                            </ul>
                        </div>
                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        <p class="text-muted">Don't have an account? <a href="auth-register.php" class="text-muted ms-1"><b>Sign
                                    Up</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="col-md-6 d-none d-md-block auth-fluid-right text-center"
            style="background: url('../assets/images/login.jpg') no-repeat center center;
            background-size: cover; position: relative;filter: blur(2px);">
        </div>

        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->

    <!-- Authentication js -->
    <script src="../assets/js/pages/authentication.init.js"></script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script>
        $(document).ready(function() {
            $("#login-form").validate({
                errorClass: "error-message",
                rules: {

                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/ // At least 1 uppercase, 1 lowercase, 1 digit, 1 special character
                    },

                },
                messages: {

                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 6 characters long",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character"
                    },

                },
                errorPlacement: function(error, element) {
                    if (element.attr("type") === "checkbox") {
                        error.appendTo(element.parent().parent());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
</body>

<!-- Mirrored from coderthemes.com/ubold/layouts/default/auth-login-2.php by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jul 2024 16:37:46 GMT -->

</html>