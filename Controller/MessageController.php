<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Message.php'); // Assuming you have a Message model

class MessageController
{
    // List all messages for a specific reclamation
    public function listMessages($idreclamation)
    {
        $sql = "SELECT * FROM message WHERE idreclamation = :idreclamation"; // Using idreclamation
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':idreclamation', $idreclamation);
            $query->execute();
            return $query->fetchAll(); // Return all messages for the reclamation
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a new message
    public function addMessage($message)
    {
        $sql = "INSERT INTO message (idreclamation, contenu_message, auteur) VALUES (:idreclamation, :contenu_message, :auteur)"; // Updated SQL
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'idreclamation' => $message->getIdReclamation(),
                'contenu_message' => $message->getContenuMessage(),
                'auteur' => $message->getAuteur(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Delete a message by ID
    public function deleteMessage($idmessage)
    {
        $sql = "DELETE FROM message WHERE idmessage = :id"; // Using idmessage
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $idmessage);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Show a specific message by ID
    public function showMessage($id_rec)
    {
        $sql = "SELECT * FROM message WHERE idreclamation = :idmessage"; // Using idmessage
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':idmessage', $id_rec);
            $query->execute();

            $message = $query->fetch();
            return $message;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a message
    public function updateMessage($message, $idmessage)
    {
        $sql = "UPDATE message SET contenu_message = :contenu_message, auteur = :auteur WHERE idmessage = :idmessage"; // Using idmessage
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'idmessage' => $idmessage,
                'contenu_message' => $message->getContenuMessage(),
                'auteur' => $message->getAuteur()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }
}
?>