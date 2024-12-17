<?php 

echo "HELLO";

require_once __DIR__ . '/../../../Controller/UserController.php';

$userController = new UserController();

// Ban user with ID 5 for 7 days
if ($userController->banUser($_GET['id'], "+7 days")) {
    echo "User banned successfully.";
} else {
    echo "Failed to ban user.";
}

header(header: "Location: ../user/index.php");

