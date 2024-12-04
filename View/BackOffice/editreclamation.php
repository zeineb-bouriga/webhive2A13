<?php

include '../../controller/ReclamationController.php';
include '../../controller/MessageController.php';

$error = "";

$reclamation= null;
// create an instance of the controller
$reclamationController = new ReclamationController();



        if (
            isset($_POST["nom"])  && $_POST["prenom"] && $_POST["email"]
        ) {
            if (
                !empty($_POST["nom"])  && !empty($_POST["prenom"]) && !empty($_POST["email"])   
            ) {
                $reclamation = new Reclamation(
                    null,
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['email']
                );
        
        $reclamationController->updateReclamation($reclamation, $_GET['idreclamation']);

       header('Location:index.php');
    } else
        $error = "Missing information";
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Réclamation</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

    <h1>Modifier la Réclamation</h1>
    <?php
        $reclamation = $reclamationController->showReclamation($_GET['idreclamation']);
    ?>
    <form action="" method="POST"> 

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="" required>

        <label for="email">Email :</label>
        <input type="text" id="email" name="email" value="" required>

        <button type="submit">Mettre à jour la réclamation</button>
    </form>

</body>
</html>