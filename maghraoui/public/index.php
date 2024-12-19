<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../controllers/ArticleController.php';
require_once __DIR__ . '/../controllers/CommentController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Determine controller and action from URL parameters
$controllerName = $_GET['controller'] ?? 'Article';  // Default to ArticleController
$action = $_GET['action'] ?? 'index';                // Default action is 'index'
$id = $_GET['id'] ?? null;                           // Optional ID parameter
$userId = $_GET['user_id'] ?? null;                  // Optional user_id parameter

// Format the controller name and instantiate it dynamically
$controllerClass = ucfirst(strtolower($controllerName)) . 'Controller';

// Check if the controller class exists
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    // Handle actions
    switch ($action) {
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->store();
            } else {
                $controller->create();
            }
            break;

        case 'edit':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->update($id);
            } else {
                $controller->edit($id);
            }
            break;

        case 'delete':
            $controller->delete($id);
            break;

        case 'gallery':
            $controller->gallery();  // Call gallery method for displaying articles
            break;

        case 'like':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->like();  // This will call the like method in CommentController
            }
            break;

        case 'store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->store(); // Call store method in CommentController to add a comment
            }
            break;

        case 'getComments':
            if ($id && $userId) {  // Ensure both article ID and user ID are provided
                $controller->userCommentsForArticle($id, $userId);  // Call the controller method
            } else {
                echo "Error: Article ID or User ID is missing.";
            }
            break;

        default:
            // Handle default action or pass parameters dynamically
            if (method_exists($controller, $action)) {
                if ($id) {
                    $controller->$action($id, $userId);  // Pass both article ID and user ID to method
                } else {
                    $controller->$action($userId);  // Pass user ID only if no article ID
                }
            } else {
                echo "Error: Action '$action' not found in $controllerClass.";
            }
            break;
    }
} else {
    // Handle error when the controller is not found
    echo "Error: Controller '$controllerClass' not found.";
}
?>
