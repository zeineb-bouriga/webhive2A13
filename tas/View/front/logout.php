<?php
// Commence la session
session_start();

// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige vers la page de connexion (ou autre page)
header("Location: ../back/auth/auth-login.php");
exit;
?>
