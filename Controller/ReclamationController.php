<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Reclamation.php'); // Updated to use Reclamation model

class ReclamationController
{
    public function countReclamation() {
        $sql = "SELECT COUNT(*) as total FROM reclamation"; // Use alias for clarity
        $db = config::getConnexion(); // Make sure to assign the connection to a variable
        try {
            $query = $db->query($sql);
            $result = $query->fetch(); // Fetch the result
            return $result['total']; // Return the total count
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }    
    public function listReclamations()
    {
        $sql = "SELECT * FROM reclamation"; // Updated table name
        $db = config::getConnexion();
           try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteReclamation($id)
    {
        $sql = "DELETE FROM reclamation WHERE idreclamation = :id"; // Updated to use idreclamation
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addReclamation($reclamation)
    {
        var_dump($reclamation);
        $sql = "INSERT INTO reclamation (nom, prenom, email) VALUES (:nom, :prenom, :email)"; // Updated SQL
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $reclamation->getNom(),
                'prenom' => $reclamation->getPrenom(),
                'email' => $reclamation->getEmail(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateReclamation($reclamation, $idreclamation)
    {
        var_dump($reclamation);
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE reclamation SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email
                WHERE idreclamation = :idreclamation' // Updated to use idreclamation
            );

            $query->execute([
                'idreclamation' => $idreclamation,
                'nom' => $reclamation->getNom(),
                'prenom' => $reclamation->getPrenom(),
                'email' => $reclamation->getEmail()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }

    public function showReclamation($idreclamation)
    {
        $sql = "SELECT * from reclamation WHERE idreclamation = $idreclamation"; // Updated to use idreclamation
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $reclamation = $query->fetch();
            return $reclamation;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // New methods for managing messages

    public function listMessages($idreclamation)
    {
        $sql = "SELECT * FROM message WHERE idreclamation = :idreclamation"; // Updated to use idreclamation
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
    public function deleteMessage($idmessage)
    {
        $sql = "DELETE FROM message WHERE idmessage = :id"; // Updated to use idmessage
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $idmessage);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
}
?>