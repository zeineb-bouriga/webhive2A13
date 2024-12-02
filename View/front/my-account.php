<?php

session_start();

include_once('../../Controller/UserController.php');

if (!isset($_SESSION["name"]) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header('location: ../back/auth/auth-login.php');
}
$userC = new UserController();

$passError = "";
$isPasswordChanged = false;
$isProfileUpdated = false; // Flag for profile update success


// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
        // Récupérer les données du formulaire
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);

        $user = $userC->findByEmail($_SESSION['email']);

        $userC->updateProfile($user['id'], $name, $email, $user['role'], $phone);
        $isProfileUpdated = true; // Set success flag

        $updatedUser =  $userC->findByEmail($email);
        if ($updatedUser) {
            $_SESSION['name'] = $updatedUser['name'];
            $_SESSION['email'] = $updatedUser['email'];
            $_SESSION['phone'] = $updatedUser['phone'];
        }
    }

    if (isset($_POST['newPass']) && isset($_POST['confPass'])) {
        $user = $userC->findByEmail($_SESSION['email']);

        $newPass = trim($_POST['newPass']);
        $confPass = trim($_POST['confPass']);
        if ($newPass != $confPass) {
            $passError = 'Password does no match';
        }

        try {
            $userC->updatePassword($user['id'], $confPass);
            $isPasswordChanged = true;
        } catch (Exception $e) {
            $passError = $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>


    <!-- Header -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.html"><img src="images/logo.png" class="logo" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="shop.html">Shop</a></li>
                        <li class="nav-item"><a class="nav-link active" href="profile.html">My Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="../back/auth/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Profile Section -->
    <div class="container my-5">
        <div class="row">
            <!-- Profile Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="./images/pff.jpg" class="img-fluid rounded-circle mb-3" alt="User Avatar">
                        <h4><?= $_SESSION['name'] ?></h4>
                        <p class="text-muted"><?= $_SESSION['email'] ?></p>
                    </div>
                    
                </div>
            </div>

            <!-- Profile Content -->
            <div class="col-lg-9 col-md-8">

                <!-- Success Alert for Profile Update -->
                <?php if ($isProfileUpdated): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Profile updated successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Personal Information -->
                <div id="personal-info" class="card mb-4">
                    <div class="card-header">
                        <h5>Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="fullName">Full Name</label>

                                <input type="text" id="fullName" name="name" class="form-control" value=<?= $_SESSION['name'] ?>>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value=<?= $_SESSION['email'] ?>>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" role="role" class="form-control" value=<?= $_SESSION['phone'] ?>>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Success Alert for Password Update -->
                <?php if ($isPasswordChanged): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Password updated successfully!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <!-- Settings -->
                <div id="settings" class="card">
                    <div class="card-header">
                        <h5>Settings</h5>
                    </div>

                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="password">Change Password</label>
                                <input type="password" name="newPass" id="password" class="form-control" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="confPass" id="confirmPassword" class="form-control" placeholder="Confirm Password">
                            </div>
                            <?php if ($passError) : ?>
                                <!-- error message -->
                                <div class="text-center">
                                    <div class="alert alert-danger  fade show d-inline-block" role="alert">
                                        <?= $passError ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4">
        <p>&copy; 2024 Your Website Name. All Rights Reserved.</p>
    </footer>

    <!-- Scripts -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>