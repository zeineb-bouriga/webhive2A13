<?php
session_start();
require_once __DIR__ . '/../../../tas/Controller/UserController.php';


include '../../controller/MessageController.php';
if (!isset($_SESSION['name']) || !isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['phone'])) {
    header("location: ../auth/auth-login.php");
}

if ($_SESSION['role'] === 'CLIENT') {
    header('location: ../../front/index.php');
}
$userC = new UserController();


$error = "";

$message = null;
// create an instance of the controller
$messageController = new MessageController();

if (
    isset($_POST["contenu_message"]) && isset($_POST["auteur"]) && isset($_POST["idreclamation"])
) {
    if (
        !empty($_POST["contenu_message"]) && !empty($_POST["auteur"]) && !empty($_POST["idreclamation"])
    ) {
        $message = new Message(
            null,
            $_POST['idreclamation'],
            $_POST['contenu_message'],
            $_POST['auteur']
        );

        $messageController->updateMessage($message, $_GET['idmessage']);

        header('Location:index.php');
        exit();
    } else {
        $error = "Missing information";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Message</title>
    
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

    <h1>Modifier le Message</h1>
    <?php
        $message = $messageController->showMessage($_GET['idmessage']);
    ?>
    <form action="" method="POST"> 

        <label for="idreclamation">ID Réclamation :</label>
        <input type="text" id="idreclamation" name="idreclamation" value="<?php echo htmlspecialchars($message['idreclamation']); ?>" required>

        <label for="contenu_message">Contenu du Message :</label>
        <textarea id="contenu_message" name="contenu_message" required><?php echo htmlspecialchars($message['contenu_message']); ?></textarea>

        <label for="auteur">Auteur :</label>
        <input type="text" id="auteur" name="auteur" value="<?php echo htmlspecialchars($message['auteur']); ?>" required>

        <button type="submit">Mettre à jour le message</button>
    </form>

</body>
</html>