<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Delivery.php');

class DeliveryController
{
    public function listDeliveries($field,$order)
    {
        $sql = "SELECT * FROM delivery order by $field $order ";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function listDeliveries1()
    {
        $sql = "SELECT * FROM delivery  ";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteDelivery($delivery_id)
    {
        $sql = "DELETE FROM delivery WHERE delivery_id = :delivery_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            if ($query->execute(['delivery_id' => $delivery_id])) {
                echo "Record with ID $delivery_id deleted successfully.";
            } else {
                echo "Deletion failed for ID $delivery_id.";
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
    function addDelivery($delivery)
    {   var_dump($offer);
        $sql = "INSERT INTO delivery  
        VALUES (NULL,:order_id, :delivery_address, :delivery_date, :delivery_status, :delivery_agent_id)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'order_id' => $delivery->getOrderId(),
                'delivery_address' => $delivery->getDeliveryAddress(),
                'delivery_date' => $delivery->getDeliveryDate()->format('Y-m-d'),
                'delivery_status' => $delivery->getDeliveryStatus(),
                'delivery_agent_id' => $delivery->getDeliveryAgentId()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateDelivery($delivery, $delivery_id)
    {var_dump($delivery);
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE delivery SET 
                    order_id = :order_id,
                    delivery_address = :delivery_address,
                    delivery_date = :delivery_date,
                    delivery_status = :delivery_status,
                    delivery_agent_id = :delivery_agent_id
                WHERE delivery_id = :delivery_id'
            );

            $query->execute([
                'delivery_id' => $delivery_id,
                'order_id' => $delivery->getOrderId(),
                'delivery_address' => $delivery->getDeliveryAddress(),
                'delivery_date' => $delivery->getDeliveryDate()->format('Y-m-d'),
                'delivery_status' => $delivery->getDeliveryStatus(),
                'delivery_agent_id' => $delivery->getDeliveryAgentId()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function showDelivery($delivery_id)
    {
        $sql = "SELECT * from delivery where delivery_id = $delivery_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();

            $delivery = $query->fetch();
            return $delivery;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function searchAddress($search) {
        try {
            $sql = config::getConnexion();
            $query = "SELECT * 
                      FROM delivery  
                      WHERE delivery_address LIKE :search ";

            $stmt = $sql->prepare($query);
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in searchTeacher method: " . $e->getMessage());
            return [];
        }
    }

}
