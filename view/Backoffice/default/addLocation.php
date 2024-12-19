<?php

include '../../../Controller/LocationController.php';

$error = "";
$location = null;
$locationController = new LocationController();

    if (
        isset($_POST["address"]) &&
        isset($_POST["latitude"]) &&
        isset($_POST["longitude"])
    ) {
        if (
            !empty($_POST["address"]) &&
            !empty($_POST["latitude"]) &&
            !empty($_POST["longitude"])
        ) {
            // Create a new Location object
            $location = new DeliveryLocation (
                null, // Assuming ID is auto-generated
                $_POST['address'],
                (float)$_POST['latitude'],
                (float)$_POST['longitude'],
                null // Timestamp is auto-generated
            );

            // Add the location to the database
            $locationController->addLocation($location);

            // Redirect to the location list page or another relevant page
            header('Location:LocationList.php');
        } else {
            $error = "All fields are required.";
        }
    } else {
        $error = "Form submission is invalid.";
    }


?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark">

    
<!-- Mirrored from coderthemes.com/ubold/layouts/default/maps-google.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 13 Jul 2024 16:39:09 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Google Maps</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

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
    <a href="index.html" class="logo-light">
        <img src="assets/images/logo.png" alt="logo" class="logo-lg">
        <img src="assets/images/logo.png" alt="small logo" class="logo-sm">
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo-dark">
        <img src="assets/images/logo.png" alt="dark logo" class="logo-lg">
        <img src="assets/images/logo.png" alt="small logo" class="logo-sm">
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
                                <span class="menu-text"> Locations </span>
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
                    <img src="assets/images/logo-light.png" alt="logo" class="logo-lg">
                    <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                </a>

                <!-- Brand Logo Dark -->
                <a href="index.html" class="logo-dark">
                    <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg">
                    <img src="assets/images/logo-sm.png" alt="small logo" class="logo-sm">
                </a>
            </div>

            
        </div>

        <ul class="topbar-menu d-flex align-items-center">
            <!-- Fullscreen Button -->
            <li class="d-none d-md-inline-block">
                <a class="nav-link waves-effect waves-light" href="#" data-toggle="fullscreen">
                    <i class="fe-maximize font-22"></i>
                </a>
            </li>
            

            <!-- Language flag dropdown  -->
            <li class="dropdown d-none d-md-inline-block">
                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/flags/us.jpg" alt="user-image" class="me-0 me-sm-1" height="18">
                </a>
            </li>


            <!-- Light/Darj Mode Toggle Button -->
            <li class="d-none d-sm-inline-block">
                <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                    <i class="ri-moon-line font-22"></i>
                </div>
            </li>

            <!-- User Dropdown -->
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                    <span class="ms-1 d-none d-md-inline-block">
                        Geneva <i class="mdi mdi-chevron-down"></i>
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
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->


        <form action="addLocation.php" method="POST" enctype="multipart/form-data">
  <div class="location-post">
       

    <!-- Champ de recherche pour le lieu -->
    <div class="event-header" id="eventLocationInput">
        <label for="locationSearch">Rechercher un lieu :</label>
        <input type="text" id="locationSearch" name="locationName" placeholder="Rechercher un lieu" required>
    </div>

    <!-- Carte avec Leaflet -->
    <div id="map" style="height: 400px; width: 100%;"></div>


    <!-- Champs cachés pour les coordonnées -->
    <input type="hidden" id="latitude" name="latitude">
    <input type="hidden" id="longitude" name="longitude">
    <input type="hidden" id="address" name="address">

    <div class="publish-button">
        <button type="submit">Ajouter le lieu</button>
    </div>
  </div>
</form>

<!-- Leaflet.js et OpenStreetMap -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

  let map;
let marker;

function initMap() {
    map = L.map('map').setView([36.8065, 10.1815], 10); // Default: Tunis, Tunisia

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add a draggable marker
    marker = L.marker([36.8065, 10.1815], { draggable: true }).addTo(map)
        .bindPopup("Déplacez-moi !")
        .openPopup();

    // Update coordinates and address when dragging the marker
    marker.on('dragend', function(event) {
    const position = event.target.getLatLng();
    document.getElementById('latitude').value = position.lat;
    document.getElementById('longitude').value = position.lng;

    // Fetch address using reverse geocoding
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.lat}&lon=${position.lng}`)
        .then(response => response.json())
        .then(data => {
            const address = data.display_name || "Address not found";
            document.getElementById('address').value = address;
        })
        .catch(error => console.error('Error fetching reverse geocoding:', error));
});


    // Handle location search
    document.getElementById('locationSearch').addEventListener('input', function(e) {
        let searchQuery = e.target.value;
        if (searchQuery.length >= 3) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${searchQuery}`)

                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = data[0].lat;
                        const lon = data[0].lon;
                        const address = data[0].display_name;

                        // Update map and marker
                        map.setView([lat, lon], 13);
                        marker.setLatLng([lat, lon]);

                        // Update hidden fields
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                        document.getElementById('address').value = address;
                    }
                });
        }
    });
}

window.onload = initMap;

</script>

        </div>

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

        <!-- Plugins js -->
        <script src="../assets/libs/morris.js06/morris.min.js"></script>
        <script src="../assets/libs/raphael/raphael.min.js"></script>

        <!-- Dashboard init-->
        <script src="assets/js/pages/dashboard-4.init.js"></script>

        </body>


</html>
