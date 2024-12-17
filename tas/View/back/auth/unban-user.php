<?php 

echo "HELLO";

require_once __DIR__ . '/../../../Controller/UserController.php';

$userController = new UserController();

if ($userController->unbanUser($_GET['id'])) {
    echo "User unBanned successfully.";
    
} else {
    echo "Failed to ban user.";
}

header(header: "Location: ../user/index.php");

