<?php
session_start();
require_once __DIR__ . '/../../../tas/Controller/UserController.php';

include '../../../Controller/DeliveryController.php';

if (!isset($_SESSION['name']) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header("location: ../auth/auth-login.php");
}

if ($_SESSION['role'] === 'CLIENT') {
    header('location: ../../front/index.php');
}
$userC = new UserController();

$error = "";
$delivery= null;
$deliveryController = new DeliveryController();


    if (
        isset($_POST["order_id"]) &&
        isset($_POST["delivery_address"]) &&
        isset($_POST["delivery_date"]) &&
        isset($_POST["delivery_status"]) 
    ) {
        if (
            !empty($_POST["order_id"]) &&
            !empty($_POST["delivery_address"]) &&
            !empty($_POST["delivery_date"]) &&
            !empty($_POST["delivery_status"]) 
        
        ) {
            // Create a new Delivery object
            $delivery = new delivery(
                null, // Assuming ID is auto-generated
                (int)$_POST['order_id'],
                $_POST['delivery_address'],
                new DateTime($_POST['delivery_date']),
                $_POST['delivery_status'],
                (int)$_POST['delivery_agent_id']
            );

            // Add the delivery to the database
            $deliveryController->addDelivery($delivery);

            

            // Redirect to the delivery list page
            header('Location:DeliveryList.php');
            
        } else {
            $error = "All fields are required.";
        }
    } 


?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark">

    
<!-- Mirrored from coderthemes.com/ubold/layouts/default/project-create.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jul 2024 16:37:43 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Create Project | Ubold - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Plugins css -->
        <link href="../assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

        <!-- Theme Config Js -->
        <script src="assets/js/head.js"></script>

        <!-- Bootstrap css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- App css -->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <!-- Icons css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        
    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">


            <!-- ========== Menu ========== -->
            <div class="app-menu">

                 <!-- Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a href="index.php" class="logo-light">
                    <img src="assets/images/logo.png" alt="" height="75">
                </a>

                <!-- Brand Logo Dark -->
                <a href="index.php" class="logo-dark">
                    <img src="assets/images/logo.png" alt="" height="75">
                </a>
            </div>

                <!-- menu-left -->
                <div class="scrollbar">

                     <!-- User box -->
                <div class="user-box text-center">
                    <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                        class="rounded-circle avatar-md">
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown"><?= $_SESSION['name'] ?>
                            Kennedy</a>
                        <div class="dropdown-menu user-pro-dropdown">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user me-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings me-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-lock me-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="../auth/logout.php" class="dropdown-item notify-item">
                                <i class="fe-log-out me-1"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </div>
                    <p class="text-muted mb-0">Admin Head</p>
                </div>

                <!--- Menu -->
                <ul class="menu">

                    <li class="menu-title">Navigation</li>

                    <li class="menu-item">
                        <a href="#menuDashboards" data-bs-toggle="collapse" class="menu-link">
                            <span class="menu-icon"><i data-feather="airplay"></i></span>
                            <span class="menu-text"> Dashboards </span>
                        </a>
                    </li>

                    <li class="menu-title">Apps</li>

                    <li class="menu-item">
                        <a href="\REID (3 ENTITIES)\tas\View\back\user/index.php" class="menu-link">
                            <span class="menu-icon"><i data-feather="user"></i></span>
                            <span class="menu-text"> User </span>
                        </a>
                    </li>
                        <li class="menu-item">
                            <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
                                <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                <span class="menu-text"> Delivery </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="menuProjects">
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/DeliveryList.php" class="menu-link">
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/project-create.php" class="menu-link">
                                            <span class="menu-text">Create Delivey</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
                                <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                <span class="menu-text"> Delivery Agents </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="menuProjects">
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/DeliveryAgentList.php" class="menu-link">
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/creatAgent.php" class="menu-link">
                                            <span class="menu-text">Create</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
                                <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                <span class="menu-text"> Order </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="menuProjects">
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/LocationList.php" class="menu-link">
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/addLocation.php" class="menu-link">
                                            <span class="menu-text">Create</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
                                <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                <span class="menu-text">Reclamation </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="menuProjects">
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/tickets-list2.php" class="menu-link">
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
                                <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                <span class="menu-text">Forum </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="menuProjects">
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/topics.php" class="menu-link">
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="#menuProjects" data-bs-toggle="collapse" class="menu-link">
                                <span class="menu-icon"><i data-feather="briefcase"></i></span>
                                <span class="menu-text">Blog </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="menuProjects">
                                <ul class="sub-menu">
                                    <li class="menu-item">
                                        <a href="\REID (3 ENTITIES)\view\Backoffice\default/topics.php" class="menu-link">
                                            <span class="menu-text">List</span>
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>

                </ul>
                    <!--- End Menu -->
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- ========== Left menu End ========== -->
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
                                <img src="../assets/images/logo.png" alt="" height="75">
                            </a>

                                <!-- Brand Logo Dark -->
                                <a href="index.html" class="logo-dark">
                                    <img src="assets/images/logo.png" alt="dark logo" class="logo-lg">
                                    <img src="assets/images/logo.png" alt="small logo" class="logo-sm">
                                </a>
                            </div>
                           
                        </div>

                        <ul class="topbar-menu d-flex align-items-center">
                            <!-- Topbar Search Form -->

                            <!-- Fullscreen Button -->
                            <li class="d-none d-md-inline-block">
                                <a class="nav-link waves-effect waves-light" href="#" data-toggle="fullscreen">
                                    <i class="fe-maximize font-22"></i>
                                </a>
                            </li>

                            <!-- Search Dropdown (for Mobile/Tablet) -->
                            <li class="dropdown d-lg-none">
                                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="ri-search-line font-22"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                    <form class="p-3">
                                        <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    </form>
                                </div>
                            </li>


                            <!-- Language flag dropdown  -->
                            <li class="dropdown d-none d-md-inline-block">
                                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="assets/images/flags/tun.jpg" alt="user-image" class="me-0 me-sm-1" height="18">
                                </a>
                            </li>

                           
                           

                            <!-- User Dropdown -->
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light"
                                data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="\REID (3 ENTITIES)\tas\uploads/<?= $_SESSION['profilePicture'] ?>" alt="user-image" class="rounded-circle">
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
                                <a href="profile.php" dropdown-item notify-item">
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
                                <a class="nav-link waves-effect waves-light" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                                    <i class="fe-settings font-22"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ========== Topbar End ========== -->

                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">Create Delivery</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="" id="delivery-form">
                    <div class="mb-3">
                    <label for="order-id" class="form-label">Order ID</label>
<select id="order-id" name="order_id" class="form-control" required>
    <?php
    // Charger les commandes disponibles
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=webhive", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête pour sélectionner les commandes disponibles
        $stmt = $pdo->prepare("SELECT id FROM orders WHERE status = 'Pending'");
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($orders) === 0) {
            echo "<option value=''>No pending orders available</option>";
        } else {
            foreach ($orders as $order) {
                echo "<option value='{$order['id']}'>Order ID: {$order['id']}</option>";
            }
        }
    } catch (PDOException $e) {
        echo "<option value=''>Error: {$e->getMessage()}</option>";
    }
    ?>
</select>
</div>

                    <div class="mb-3">
                        <label for="delivery-address" class="form-label">Delivery Address</label>
                        <textarea id="delivery-address" name="delivery_address" class="form-control" rows="3" 
                            placeholder="Enter delivery address" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="delivery-date" class="form-label">Delivery Date</label>
                        <input type="date" id="delivery-date" name="delivery_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="delivery-status" class="form-label">Delivery Status</label>
                        <select id="delivery-status" name="delivery_status" class="form-control" data-toggle="select2" data-width="100%">
                            <option value="Pending">Pending</option>
                            <option value="In Transit">In Transit</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                    <label for="delivery-agent" class="form-label">Delivery Agent</label>
                    <select id="delivery-agent-id" name="delivery_agent_id" class="form-control">
    <?php
    // Charger les agents disponibles
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=webhive", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT agent_id, full_name FROM delivery_agent ");
        $stmt->execute();
        $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($agents) === 0) {
            echo "<option value=''>No agents available</option>";
        } else {
            foreach ($agents as $agent) {
                echo "<option value='{$agent['agent_id']}'>{$agent['full_name']} (ID: {$agent['agent_id']})</option>";
            }
        }
    } catch (PDOException $e) {
        echo "<option value=''>Error: {$e->getMessage()}</option>";
    }
    ?>
</select>
</div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Create Delivery</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>

<script>
    // Get references to elements
    const orderIdField = document.getElementById('order-id');
    const orderIdError = document.getElementById('order-id-error');
    const deliveryAgentField = document.getElementById('delivery-agent-id');
    const deliveryAgentError = document.getElementById('delivery-agent-id-error');

    // Add input validation for Order ID
    orderIdField.addEventListener('input', function () {
        if (/^\d*$/.test(this.value)) {
            orderIdError.style.display = 'none'; // Hide error message
        } else {
            orderIdError.style.display = 'block'; // Show error message
        }
    });

    // Add input validation for Delivery Agent ID
    deliveryAgentField.addEventListener('input', function () {
        if (/^\d*$/.test(this.value)) {
            deliveryAgentError.style.display = 'none'; // Hide error message
        } else {
            deliveryAgentError.style.display = 'block'; // Show error message
        }
    });

    // Prevent form submission if there are errors
    document.getElementById('delivery-form').addEventListener('submit', function (event) {
        if (!/^\d*$/.test(orderIdField.value)) {
            event.preventDefault();
            orderIdError.style.display = 'block';
        }
        if (!/^\d*$/.test(deliveryAgentField.value)) {
            event.preventDefault();
            deliveryAgentError.style.display = 'block';
        }
    });
</script>
<!-- end row-->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div><script>document.write(new Date().getFullYear())</script> © Ubold - <a href="https://coderthemes.com/" target="_blank">Coderthemes.com</a></div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-none d-md-flex gap-4 align-item-center justify-content-md-end footer-links">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

        <!-- plugin js -->
        <script src="../assets/libs/dropzone/min/dropzone.min.js"></script>
        <script src="../assets/libs/select2/js/select2.min.js"></script>
        <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>

        <!-- Init js-->
        <script src="assets/js/pages/create-project.init.js"></script>


    </body>

<!-- Mirrored from coderthemes.com/ubold/layouts/default/project-create.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jul 2024 16:37:44 GMT -->
</html>