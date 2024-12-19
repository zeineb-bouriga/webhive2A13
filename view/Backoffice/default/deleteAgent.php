<?php
ob_start();
include '../../../controller/AgentController.php';


if (isset($_GET["agent_id"]) && is_numeric($_GET["agent_id"])) {
    $userid = intval($_GET["agent_id"]);

    // Initialize the controller
    $userC = new DeliveryAgentController();

    // Call the deleteDelivery method
    $userC->deleteAgent($userid);

    // Redirect to the offer list page on successful deletion
    header('Location: DeliveryAgentList.php');
    exit;
}
ob_end_flush();
