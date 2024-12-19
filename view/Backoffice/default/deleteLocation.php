<?php
ob_start();
include '../../../controller/LocationController.php';


if (isset($_GET["location_id"]) && is_numeric($_GET["location_id"])) {
    $userid = intval($_GET["location_id"]);

    // Initialize the controller
    $userC = new LocationController();

    // Call the deleteDelivery method
    $userC->deleteLocation($userid);

    // Redirect to the offer list page on successful deletion
    header('Location: LocationList.php');
    exit;
}
ob_end_flush();
