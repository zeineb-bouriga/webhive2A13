<?php

session_start();

include_once('../../../Controller/UserController.php');

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
<html lang="en" data-topbar-color="dark">


<!-- Mirrored from coderthemes.com/ubold/layouts/default/crm-contacts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jul 2024 16:37:05 GMT -->
<head>
    <meta charset="utf-8"/>
    <title>CRM Contacts | Ubold - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/logoo.ico">

    <!-- Theme Config Js -->
    <script src="../assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style"/>

    <!-- App css -->
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css"/>

    <!-- Icons css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css"/>

    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<!-- Begin page -->
<div id="wrapper">


    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar">
                <div class="topbar-menu d-flex align-items-center gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-box">
                        <!-- Brand Logo Light -->
                        <a href="index.html" class="logo-light">
                            <img src="../assets/images/logo-light.png" alt="logo" class="logo-lg">
                            <img src="../assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                        </a>

                        <!-- Brand Logo Dark -->
                        <a href="index.html" class="logo-dark">
                            <img src="../assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
                            <img src="../assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="dropdown d-none d-xl-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            Create New
                            <i class="mdi mdi-chevron-down ms-1"></i>
                        </a>
                        <div class="dropdown-menu">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="fe-briefcase me-1"></i>
                                <span>New Projects</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="fe-user me-1"></i>
                                <span>Create Users</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="fe-bar-chart-line- me-1"></i>
                                <span>Revenue Report</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="fe-settings me-1"></i>
                                <span>Settings</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="fe-headphones me-1"></i>
                                <span>Help & Support</span>
                            </a>

                        </div>
                    </div>

                    <!-- Mega Menu Dropdown -->
                    <div class="dropdown dropdown-mega d-none d-xl-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#"
                           role="button" aria-haspopup="false" aria-expanded="false">
                            Mega Menu
                            <i class="mdi mdi-chevron-down  ms-1"></i>
                        </a>
                        <div class="dropdown-menu dropdown-megamenu">
                            <div class="row">
                                <div class="col-sm-8">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5 class="text-dark mt-0">UI Components</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="widgets.html">Widgets</a>
                                                </li>
                                                <li>
                                                    <a href="extended-nestable.html">Nestable List</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Range Sliders</a>
                                                </li>
                                                <li>
                                                    <a href="pages-gallery.html">Masonry Items</a>
                                                </li>
                                                <li>
                                                    <a href="extended-sweet-alert.html">Sweet Alerts</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Treeview Page</a>
                                                </li>
                                                <li>
                                                    <a href="extended-tour.html">Tour Page</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="text-dark mt-0">Applications</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="ecommerce-products.html">eCommerce Pages</a>
                                                </li>
                                                <li>
                                                    <a href="crm-dashboard.html">CRM Pages</a>
                                                </li>
                                                <li>
                                                    <a href="email-inbox.html">Email</a>
                                                </li>
                                                <li>
                                                    <a href="apps-calendar.html">Calendar</a>
                                                </li>
                                                <li>
                                                    <a href="contacts-list.html">Team Contacts</a>
                                                </li>
                                                <li>
                                                    <a href="task-kanban-board.html">Task Board</a>
                                                </li>
                                                <li>
                                                    <a href="email-templates.html">Email Templates</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="text-dark mt-0">Extra Pages</h5>
                                            <ul class="list-unstyled megamenu-list">
                                                <li>
                                                    <a href="javascript:void(0);">Left Sidebar with User</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Menu Collapsed</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">Small Left Sidebar</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);">New Header Style</a>
                                                </li>
                                                <li>
                                                    <a href="pages-search-results.html">Search Result</a>
                                                </li>
                                                <li>
                                                    <a href="pages-gallery.html">Gallery Pages</a>
                                                </li>
                                                <li>
                                                    <a href="pages-coming-soon.html">Maintenance & Coming Soon</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-center mt-3">
                                        <h3 class="text-dark">Special Discount Sale!</h3>
                                        <h4>Save up to 70% off.</h4>
                                        <a href="https://1.envato.market/uboldadmin" target="_blank"
                                           class="btn btn-primary rounded-pill mt-3">Download Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="topbar-menu d-flex align-items-center">
                    <!-- Topbar Search Form -->
                    <li class="app-search dropdown me-3 d-none d-lg-block">
                        <form>
                            <input type="search" class="form-control rounded-pill" placeholder="Search..."
                                   id="top-search">
                            <span class="fe-search search-icon font-22"></span>
                        </form>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h5 class="text-overflow mb-2">Found 22 results</h5>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-home me-1"></i>
                                <span>Analytics Report</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-aperture me-1"></i>
                                <span>How can I help you?</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings me-1"></i>
                                <span>User profile settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-2 rounded-circle" src="../assets/images/users/user-2.jpg"
                                             alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 font-14">Erwin E. Brown</h5>
                                            <span class="font-12 mb-0">UI Designer</span>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-2 rounded-circle" src="../assets/images/users/user-5.jpg"
                                             alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 font-14">Jacob Deo</h5>
                                            <span class="font-12 mb-0">Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>

                    <!-- Fullscreen Button -->
                    <li class="d-none d-md-inline-block">
                        <a class="nav-link waves-effect waves-light" href="#" data-toggle="fullscreen">
                            <i class="fe-maximize font-22"></i>
                        </a>
                    </li>

                    <!-- Search Dropdown (for Mobile/Tablet) -->
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                           data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line font-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="search" class="form-control" placeholder="Search ..."
                                       aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <!-- App Dropdown -->
                    <li class="dropdown d-none d-md-inline-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                           data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-grid font-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">

                            <div class="p-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="../assets/images/brands/slack.png" alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="../assets/images/brands/github.png" alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="../assets/images/brands/dribbble.png" alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="../assets/images/brands/bitbucket.png" alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="../assets/images/brands/dropbox.png" alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="../assets/images/brands/g-suite.png" alt="G Suite">
                                            <span>G Suite</span>
                                        </a>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div>
                    </li>

                    <!-- Language flag dropdown  -->
                    <li class="dropdown d-none d-md-inline-block">
                        <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                           data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="../assets/images/flags/tun.jpg" alt="user-image" class="me-0 me-sm-1" height="18">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="../assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="../assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="../assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="../assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Russian</span>
                            </a>

                        </div>
                    </li>

                    <!-- Notofication dropdown -->
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none"
                           data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-bell font-22"></i>
                            <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 font-16 fw-semibold"> Notification</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                            <small>Clear All</small>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-1" style="max-height: 300px;" data-simplebar>

                                <h5 class="text-muted font-13 fw-normal mt-2">Today</h5>
                                <!-- item-->

                                <a href="javascript:void(0);"
                                   class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-1">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="mdi mdi-comment-account-outline"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Datacorp <small
                                                            class="fw-normal text-muted ms-1">1 min ago</small></h5>
                                                <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on
                                                    Admin</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                   class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-info">
                                                    <i class="mdi mdi-account-plus"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Admin <small
                                                            class="fw-normal text-muted ms-1">1 hours ago</small></h5>
                                                <small class="noti-item-subtitle text-muted">New user registered</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <h5 class="text-muted font-13 fw-normal mt-0">Yesterday</h5>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                   class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon">
                                                    <img src="../assets/images/users/avatar-2.jpg"
                                                         class="img-fluid rounded-circle" alt=""/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Cristina Pride <small
                                                            class="fw-normal text-muted ms-1">1 day ago</small></h5>
                                                <small class="noti-item-subtitle text-muted">Hi, How are you? What about
                                                    our next meeting</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <h5 class="text-muted font-13 fw-normal mt-0">30 Dec 2021</h5>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                   class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="mdi mdi-comment-account-outline"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Datacorp</h5>
                                                <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on
                                                    Admin</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                   class="dropdown-item p-0 notify-item card read-noti shadow-none mb-1">
                                    <div class="card-body">
                                        <span class="float-end noti-close-btn text-muted"><i class="mdi mdi-close"></i></span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon">
                                                    <img src="../assets/images/users/avatar-4.jpg"
                                                         class="img-fluid rounded-circle" alt=""/>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold font-14">Karen Robinson</h5>
                                                <small class="noti-item-subtitle text-muted">Wow ! this admin looks good
                                                    and awesome design</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="text-center">
                                    <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                                </div>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);"
                               class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                                View All
                            </a>

                        </div>
                    </li>

                    <!-- Light/Darj Mode Toggle Button -->
                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                            <i class="ri-moon-line font-22"></i>
                        </div>
                    </li>

                    <!-- User Dropdown -->
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                           data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="../assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                            <span class="ms-1 d-none d-md-inline-block">
                                        <?= $_SESSION['name'] ?> <i class="mdi mdi-chevron-down"></i>
                                    </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock"></i>
                                <span>Lock Screen</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="../auth/logout.php" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

                    <!-- Right Bar offcanvas button (Theme Customization Panel) -->
                    <li>
                        <a class="nav-link waves-effect waves-light" data-bs-toggle="offcanvas"
                           href="#theme-settings-offcanvas">
                            <i class="fe-settings font-22"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->
<!-- Profile Section -->
<div class="container my-5">
        <div class="row">
            <!-- Profile Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="../assets/images/pff.jpg" class="img-fluid rounded-circle mb-3" alt="User Avatar">
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
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>


<!-- Vendor js -->
<script src="../assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="../assets/js/app.min.js"></script>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>


<script>
    $(document).ready(function () {
        // Validation for Add User Form
        $("#create-user").validate({
            errorClass: "error-message",
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 15
                },
                password: {
                    required: true,
                    minlength: 6,
                    pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/
                },
                role: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter your phone number",
                    digits: "Phone number must contain only digits",
                    minlength: "Phone number must be at least 10 digits long",
                    maxlength: "Phone number must not exceed 15 digits"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Password must be at least 6 characters long",
                    pattern: "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character"
                },
                role: {
                    required: "Please select a role"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") === "checkbox") {
                    error.appendTo(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        // Validation for Update User Form
        $("#update-user").validate({
            errorClass: "error-message",
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 8,
                    maxlength: 15
                },
                password: {
                    required: true,
                    minlength: 6,
                    pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/
                },
                role: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter your phone number",
                    digits: "Phone number must contain only digits",
                    minlength: "Phone number must be at least 10 digits long",
                    maxlength: "Phone number must not exceed 15 digits"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Password must be at least 6 characters long",
                    pattern: "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character"
                },
                role: {
                    required: "Please select a role"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("type") === "checkbox") {
                    error.appendTo(element.parent().parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        var updateModal = document.getElementById('update-modal');
        updateModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var userId = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var email = button.getAttribute('data-email');
            var phone = button.getAttribute('data-phone');
            var role = button.getAttribute('data-role');

            var userIdInput = updateModal.querySelector('#user_id');
            var nameInput = updateModal.querySelector('#name');
            var emailInput = updateModal.querySelector('#email');
            var phoneInput = updateModal.querySelector('#phone');
            var roleInput = updateModal.querySelector('#role');

            userIdInput.value = userId;
            nameInput.value = name;
            emailInput.value = email;
            phoneInput.value = phone;
            roleInput.value = role;

        });
    });
</script>

</body>

<!-- Mirrored from coderthemes.com/ubold/layouts/default/crm-contacts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jul 2024 16:37:05 GMT -->
</html>
