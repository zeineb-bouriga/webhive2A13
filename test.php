<?php
// Afficher les erreurs (à utiliser uniquement en développement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Configuration de la base de données
    $host = 'localhost';
    $dbname = 'freshshop';
    $username = 'root';
    $password = '';

    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurer PDO pour qu'il lance des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion réussie à la base de données !";
    
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}