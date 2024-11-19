<?php

require_once __DIR__ . '/../../../Controller/UserController.php';

$error = "";

if (isset($_GET['error']))
    $error = $_GET['error'];

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password']) && isset($_POST['role'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!empty($name) && !empty($email) && !empty($password) && !empty($role) && !empty($phone)) {
        $userC = new UserController();
        $success = $userC->signUp($name, $email, $password, $role, $phone);
        if ($success)
            header("location: auth-login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en" data-topbar-color="dark">

<head>
    <meta charset="utf-8" />
    <title>Register & Signup | Ubold - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico">

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
                            <a href="index.html" class="logo logo-dark text-center">
                                <span class="logo-lg">
                                    <img src="../assets/images/logo-dark.png" alt="" height="22">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light text-center">
                                <span class="logo-lg">
                                    <img src="../assets/images/logo-light.png" alt="" height="22">
                                </span>
                            </a>
                        </div>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Sign Up</h4>
                    <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute</p>

                    <!-- form -->
                    <form id="register-form" action="auth-register.php" method="post">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input class="form-control" type="text" id="fullname" placeholder="Enter your name" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input class="form-control" type="text" id="phone" placeholder="Enter your phone" name="phone">
                        </div>

                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="text" id="emailaddress" placeholder="Enter your email"
                                name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter your password"
                                name="password">

                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role">
                                <option value="" selected>Select Role</option>
                                <option value="ADMIN">Admin</option>
                                <option value="CLIENT">Client</option>
                                <option value="FARMER">Farmer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signup" name="checkbox_signup">
                                <label class="form-check-label" for="checkbox-signup">I accept <a
                                        href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                            </div>
                        </div>

                        <?php if ($error) : ?>
                            <!-- error message -->
                            <div class="text-center">
                                <div class="alert alert-danger  fade show d-inline-block" role="alert">
                                    <?= $error ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="text-center d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit"> Sign Up</button>
                        </div>
                        <!-- social-->
                        <div class="text-center mt-4">
                            <p class="text-muted font-16">Sign in with</p>
                            <ul class="social-list list-inline mt-3 mb-0">
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
                        <p class="text-muted">Already have account? <a href="auth-login.php" class="text-muted ms-1"><b>Log
                                    In</b></a></p>
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>

        <div class="col-md-6 d-none d-md-block auth-fluid-right text-center"
            style="background: url('../assets/images/login.jpg') no-repeat center center;
            background-size: cover; position: relative;filter: blur(2px);">
        </div>

        <!-- end Auth fluid right content -->
    </div>
    <script src="../assets/js/pages/authentication.init.js"></script>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script>
        $(document).ready(function() {
            $("#register-form").validate({
                errorClass: "error-message",
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 8,
                        maxlength: 15 // Adjust based on your needs
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/ // At least 1 uppercase, 1 lowercase, 1 digit, 1 special character
                    },
                    role: {
                        required: true
                    },
                    checkbox_signup: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Your name must consist of at least 2 characters"
                    },
                    phone: {
                        required: "Please enter your phone number",
                        digits: "Phone number must contain only digits",
                        minlength: "Phone number must be at least 10 digits long",
                        maxlength: "Phone number must not exceed 15 digits"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 6 characters long",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character"
                    },
                    role: {
                        required: "Please select a role"
                    },
                    checkbox_signup: {
                        required: "You must accept the Terms and Conditions"
                    }
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

</html>