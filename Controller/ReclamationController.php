<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Reclamation.php');
include(__DIR__ . '/../Model/message.php');

class ReclamationController
{
    // Count the total number of reclamations
    public function countReclamation() {
        $sql = "SELECT COUNT(*) as total FROM reclamation";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            $result = $query->fetch();
            return $result['total'];
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // List all reclamations
    public function listReclamations() {
        $sql = "SELECT r.*, COUNT(m.idmessage) AS message_count 
                FROM reclamation r 
                LEFT JOIN message m ON r.idreclamation = m.idreclamation 
                GROUP BY r.idreclamation";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll(); // Fetch all results
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Add a new reclamation
    public function addReclamation($reclamation) {
        $sql = "INSERT INTO reclamation (nom, prenom, email) VALUES (:nom, :prenom, :email)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $reclamation->getNom(),
                'prenom' => $reclamation->getPrenom(),
                'email' => $reclamation->getEmail(),
            ]);
            
            // Return the ID of the last inserted row
            return $db->lastInsertId();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false; // Return false in case of an error
        }
    }
    

    // Update an existing reclamation
    public function updateReclamation($reclamation, $idReclamation) {
        $sql = "UPDATE reclamation 
                SET nom = :nom, prenom = :prenom, email = :email 
                WHERE idreclamation = :idreclamation";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'idreclamation' => $idReclamation,
                'nom' => $reclamation->getNom(),
                'prenom' => $reclamation->getPrenom(),
                'email' => $reclamation->getEmail(),
            ]);
            echo $query->rowCount() . " records UPDATED successfully<br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Delete a reclamation
    public function deleteReclamation($idReclamation) {
        $sql = "DELETE FROM reclamation WHERE idreclamation = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $idReclamation);
            $query->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // Show a specific reclamation
    public function showReclamation($idReclamation) {
        $sql = "SELECT r.*, m.contenu_message, m.auteur 
                FROM reclamation r 
                LEFT JOIN message m ON r.idreclamation = m.idreclamation 
                WHERE r.idreclamation = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $idReclamation);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // List all messages for a specific reclamation
    public function listMessages($idReclamation) {
        $sql = "SELECT contenu_message FROM message WHERE idreclamation = :idreclamation";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':idreclamation', $idReclamation);
            $query->execute();
            $messages = $query->fetchAll();
            
            // Ensure $messages is an array before applying implode
            if (count($messages) > 0) {
                // Map through messages to safely escape them
                $formattedMessages = array_map(function($msg) {
                    return htmlspecialchars($msg['contenu_message']);
                }, $messages);
                
                // Return the formatted messages as a string with <br> between each message
                return implode('<br>', $formattedMessages);
            }
            
            return 'No messages available'; // If no messages, return a fallback message
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    

    // Add a new message
    public function addMessage($message)
{
    $sql = "INSERT INTO message (idreclamation, contenu_message, auteur) VALUES (:idreclamation, :contenu_message, :auteur)";
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
    public function deleteMessage($idMessage) {
        $sql = "DELETE FROM message WHERE idmessage = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $idMessage);
            $query->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
}
?>
