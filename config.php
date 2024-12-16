<?php
// Paramètres de connexion à la base de données
$servername = "localhost"; // Replace with your server host (e.g., localhost)
$username = "root";        // Replace with your database username
$password = "";   
$database = "webhive"; 
try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Exit the script with an error message if the connection fails
    die("Database connection failed: " . $e->getMessage());
}
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
