<?php

include '../../controller/ReclamationController.php';

$error = "";
$reclamation = null;

$reclamationController = new ReclamationController();

if (
    isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) &&
    isset($_POST["reason"]) && isset($_POST["details"])
) {
    if (
        !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) &&
        !empty($_POST["reason"]) && !empty($_POST["details"])
    ) {
        $notify = isset($_POST['notify']) ? true : false;
        $reclamation = new Reclamation(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['reason'],
            $_POST['details'],
            $notify
        );

        $reclamationController->addReclamation($reclamation);
        header('Location:../Backoffice/tables.php');
        exit(); // Ensure no further code is executed after redirect
    } else {
        $error = "Missing information";
    }
}

?>

<!doctype html>
<html class="no-js">
<head>
    <title>Connecty - Reclamation</title>
    <link rel="icon" href="../Frontoffice/assets/img/favicon2.jpg">
    <link rel="stylesheet" href="../Frontoffice/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Frontoffice/css/nice-select.css">
    <link rel="stylesheet" href="../Frontoffice/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Frontoffice/css/icofont.css">
    <link rel="stylesheet" href="../Frontoffice/css/slicknav.min.css">
    <link rel="stylesheet" href="../Frontoffice/css/owl-carousel.css">
    <link rel="stylesheet" href="../Frontoffice/css/datepicker.css">
    <link rel="stylesheet" href="../Frontoffice/css/animate.min.css">
    <link rel="stylesheet" href="../Frontoffice/css/magnific-popup.css">
    <link rel="stylesheet" href="../Frontoffice/css/normalize.css">
    <link rel="stylesheet" href="../Frontoffice/css/style.css">
    <link rel="stylesheet" href="../Frontoffice/css/responsive.css">
</head>
<body>

<!-- Header Area -->
<header class="header">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-5 col-12"></div>
                <div class="col-lg-6 col-md-7 col-12">
                    <ul class="top-contact">
                        <li><i class="fa fa-phone"></i>+216 12 345 678</li>
                        <li><i class="fa fa-envelope"></i><a href="mailto:support@yourmail.com">support@connecty.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-inner">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="logo">
                            <a><img src="../Frontoffice/assets/img/favicon3.jpg" alt="#"></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-9 col-12">
                        <div class="main-menu">
                            <nav class="navigation">
                                <ul class="nav menu">
                                    <li class="active"><a href="#">Home <i class="icofont-rounded-down"></i></a></li>
                                    <li><a href="#">Pages <i class="icofont-rounded-down"></i></a></li>
                                    <li><a href="#">Blogs <i class="icofont-rounded-down"></i></a></li>
                                    <li><a href="reclamation.php">Complaint</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header Area -->

<!-- Breadcrumbs -->
<div class="breadcrumbs overlay">
    <div class="container">
        <div class="bread-inner">
            <div class="row">
                <div class="col-12">
                    <h2>Complaint</h2>
                    <ul class="bread-list">
                        <li><a href="">Home</a></li>
                        <li><i class="icofont-simple-right"></i></li>
                        <li class="active"> Complaint</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Contact Us -->
<section class="contact-us section">
    <div class="container">
        <div class="inner">
            <div class="row"> 
                <div class="col-lg-12">
                    <div class="contact-us-form">
                        <h2>Complaint</h2>
                        
                        <!-- Form -->
                        <form id="myForm" class="form" method="POST" >
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nom">Nom:</label>
                                        <input type="text" name="nom" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="prenom">Prénom:</label>
                                        <input type="text" name="prenom" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email Address:</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reason">Reason for Complaint:</label>
                                        <select id="reason" name="reason" class="form-control" required>
                                            <option value="">--Select Reason--</option>
                                            <option value="Privacy Violation">Privacy Violation</option>
                                            <option value="Harassment or Bullying">Harassment or Bullying</option>
                                            <option value="Inappropriate Content">Inappropriate Content</option>
                                            <option value="Spam or Scams">Spam or Scams</option>
                                            <option value="Report Fake Account">Report Fake Account</option>
                                            <option value="Technical Issue">Technical Issue</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="details">Additional Details:</label>
                                        <textarea name="details" id="details" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="notify">
                                        <input name="notify" id="notify" type="checkbox"> Email notification
                                    </label>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn" type="submit">Send</button>
                                    </div>
                                    <div id="errorMessages" style="color: red;"><?php echo $error; ?></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us -->

<!-- jquery Min JS -->
<script src="../Frontoffice/js/jquery.min.js"></script>
<script src="../Frontoffice/js/jquery-migrate-3.0.0.js"></script>
<script src="../Frontoffice/js/jquery-ui.min.js"></script>
<script src="../Frontoffice/js/easing.js"></script>
<script src="../Frontoffice/js/colors.js"></script>
<script src="../Frontoffice/js/popper.min.js"></script>
<script src="../Frontoffice/js/jquery.nav.js"></script>
<script src="../Frontoffice/js/slicknav.min.js"></script>
<script src="../Frontoffice/js/jquery.scrollUp.min.js"></script>
<script src="../Frontoffice/js/niceselect.js"></script>
<script src="../Frontoffice/js/tilt.jquery.min.js"></script>
<script src="../Frontoffice/js/owl-carousel.js"></script>
<script src="../Frontoffice/js/jquery.counterup.min.js"></script>
<script src="../Frontoffice/js/steller.js"></script>
<script src="../Frontoffice/js/wow.min.js"></script>
<script src="../Frontoffice/js/jquery.magnific-popup.min.js"></script>
<script src="../Frontoffice/js/bootstrap.min.js"></script>
<script src="../Frontoffice/js/main.js"></script>
</body>
</html>
