<?php
// Include the necessary files
include '../../controller/ReclamationController.php';

// Initialize variables
$error = "";
$successMessage = "";
$reclamationController = new ReclamationController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (
        isset($_POST["nom"], $_POST["prenom"], $_POST["email"]) &&
        !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"])
    ) {
        // Prepare data for reclamation
        $notify = isset($_POST['notify']) ? true : false;
        $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
        $details = isset($_POST['details']) ? $_POST['details'] : '';

        // Create Reclamation object
        $reclamation = new Reclamation(
            null,
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $reason,
            $details,
            $notify
        );

        $idReclamation = $reclamationController->addReclamation($reclamation);
        
        if ($idReclamation) {
            if (isset($_POST['message']) && !empty($_POST['message'])) {
                $message = new Message(
                    null,
                    $idReclamation,
                    $_POST['message'],
                    $_POST['nom'] 
                );
                $reclamationController->addMessage($message);
            }

            $successMessage = "Réclamation envoyée avec succès!";
        } else {
            $error = "Une erreur est survenue lors de l'envoi de votre réclamation.";
        }
    } else {
        $error = "Tous les champs obligatoires doivent être remplis.";
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