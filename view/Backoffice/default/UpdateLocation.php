<?php

include '../../../controller/LocationController.php';

$locationController = new LocationController();
$error = "";
$location = null;


if (isset($_GET['location_id'])) {
    $location= $locationController->showLocation($_GET['location_id']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location_id'], $_POST['address'], $_POST['latitude'], $_POST['longitude'])) {
    if (
        !empty($_POST['location_id']) &&
        !empty($_POST['address']) &&
        !empty($_POST['latitude']) &&
        !empty($_POST['longitude']) 
    ) {
        
        $location = new DeliveryLocation(
            $_POST['location_id'], // Use the provided location ID
            $_POST['address'],
            (float)$_POST['latitude'],
            (float)$_POST['longitude'],
            null // Timestamp is auto-generated
        );
        
 
        

        // Update the delivery in the database
        $locationController->updateLocation($location, $_POST['location_id']);

        // Redirect to delivery list after update
    header('Location:LocationList.php');
        exit;
    } else {
        $error = "All fields are required.";
    }
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
        <form action="UpdateLocation.php" method="POST" enctype="multipart/form-data">
  <div class="location-post">
       

    <!-- Champ de recherche pour le lieu -->
    <div class="event-header" id="eventLocationInput">
        <label for="locationSearch">Rechercher un lieu :</label>
        <input type="text" id="locationSearch" name="locationName" placeholder="Rechercher un lieu" required>
    </div>

    <!-- Carte avec Leaflet -->
    <div id="map" style="height: 400px; width: 100%;"></div>


    <!-- Champs cachés pour les coordonnées -->
    <input type="hidden" id="location_id" name="location_id" value="<?= htmlspecialchars($_GET['location_id'] ?? $_POST['location_id'] ?? '') ?>">
    <input type="hidden" id="latitude" name="latitude" value="<?= htmlspecialchars($location['latitude'] ?? '') ?>" required>
    <input type="hidden" id="longitude" name="longitude" value="<?= htmlspecialchars($location['longitude'] ?? '') ?>" required>
    <input type="hidden" id="address" name="address" value="<?= htmlspecialchars($location['address'] ?? '') ?>" required>

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
        </body>


</html>
