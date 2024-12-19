<?php
ob_start();
include '../../../controller/DeliveryController.php';


if (isset($_GET["delivery_id"]) && is_numeric($_GET["delivery_id"])) {
    $userid = intval($_GET["delivery_id"]);

    // Initialize the controller
    $userC = new DeliveryController();

    // Call the deleteDelivery method
    $userC->deleteDelivery($userid);

    // Redirect to the offer list page on successful deletion
    header('Location: DeliveryList.php');
    exit;
}
ob_end_flush();
