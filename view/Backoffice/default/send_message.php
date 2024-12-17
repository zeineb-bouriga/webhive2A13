<?php
session_start();
require_once __DIR__ . '/../../../tas/Controller/UserController.php';


if (!isset($_SESSION['name']) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header("location: ../auth/auth-login.php");
}

if ($_SESSION['role'] === 'CLIENT') {
    header('location: ../../front/index.php');
}
$userC = new UserController();
// Database connection parameters
$servername = "localhost"; // or your server name
$username = "root"; // your database username
$password = ""; // your database password (leave empty if not set)
$dbname = "webhive"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required fields are set
    if (isset($_POST['id_reclamation'], $_POST['contenu_message'], $_POST['auteur'])) {
        // Get the data from the form
        $id_reclamation = $_POST['id_reclamation']; // Assuming this is passed from a form
        $contenu_message = $_POST['contenu_message']; // Assuming this is passed from a form
        $auteur = $_POST['auteur']; // Assuming this is passed from a form

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO message (idreclamation, contenu_message, auteur) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_reclamation, $contenu_message, $auteur);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Message sent successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}

// Close the connection
$conn->close();
?>