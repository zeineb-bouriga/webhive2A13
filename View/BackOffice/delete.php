

<?php
include '../../controller/ReclamationController.php';
$travelOfferC = new ReclamationController();
$travelOfferC->deleteReclamation($_GET["idreclamation"]);
header('Location:index.php');
