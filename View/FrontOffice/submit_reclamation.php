<?php
// Include the necessary files
include '../../controller/ReclamationController.php';

// Initialize an error variable
$error = "";
$reclamation = null;

// Create an instance of the ReclamationController
$reclamationController = new ReclamationController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (
        isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) &&
        !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"])
    ) {
        // Create a new reclamation object
        $notify = isset($_POST['notify']) ? true : false;
        $reclamation = new Reclamation(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            isset($_POST['reason']) ? $_POST['reason'] : '',
            isset($_POST['details']) ? $_POST['details'] : '',
            $notify
        );

        // Add the reclamation to the database
        if ($reclamationController->addReclamation($reclamation)) {
            // Successfully added, now display the approval message
            $successMessage = "Réclamation approuvée!";
        } else {
            $error = "Il y a eu une erreur lors de l'envoi de votre réclamation. Veuillez réessayer.";
        }
    } else {
        $error = "Informations manquantes. Veuillez remplir tous les champs.";
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Statut de Réclamation</title>
    <link rel="icon" href="../Frontoffice/assets/img/favicon2.jpg">
    <link rel="stylesheet" href="../Frontoffice/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Frontoffice/css/style.css"> <!-- Ensure this path is correct -->
</head>
<body>

<div class="container">
    <h2>Statut de la Réclamation</h2>
    
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
        <h3>Informations Soumises :</h3>
        <ul class="list-group">
            <li class="list-group-item"><strong>Nom:</strong> <?php echo htmlspecialchars($_POST['nom']); ?></li>
            <li class="list-group-item"><strong>Prénom:</strong> <?php echo htmlspecialchars($_POST['prenom']); ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></li>
            <?php if (isset($_POST['reason'])): ?>
                <li class="list-group-item"><strong>Raison:</strong> <?php echo htmlspecialchars($_POST['reason']); ?></li>
            <?php endif; ?>
            <?php if (isset($_POST['details'])): ?>
                <li class="list-group-item"><strong>Détails:</strong> <?php echo nl2br(htmlspecialchars($_POST['details'])); ?></li>
            <?php endif; ?>
            <li class="list-group-item"><strong>Notification par Email:</strong> <?php echo isset($_POST['notify']) ? 'Oui' : 'Non'; ?></li>
        </ul>
    <?php elseif ($error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <a href="reclamation.php" class="btn btn-primary">Soumettre une autre réclamation</a>
</div>

<script src="../Frontoffice/js/jquery.min.js"></script>
<script src="../Frontoffice/js/bootstrap.min.js"></script>
</body>
</html>