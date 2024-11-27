<?php
// get_messages.php

// Database connection
$servername = "your_server"; // Replace with your server name
$username = "your_username"; // Replace with your database username
$password = "your_password"; // Replace with your database password
$dbname = "your_database"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the reclamation ID from the request
$id_reclamation = $_GET['idreclamation'];

// Prepare and execute the query
$stmt = $conn->prepare("SELECT contenu_message, auteur FROM messages WHERE idreclamation = ?");
$stmt->bind_param("i", $id_reclamation);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are messages
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<strong>" . htmlspecialchars($row['auteur']) . ":</strong> " . htmlspecialchars($row['contenu_message']);
        echo "</div>";
    }
} else {
    echo "Aucun message trouvé.";
}

// Close connections
$stmt->close();
$conn->close();
?>