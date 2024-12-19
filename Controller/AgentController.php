<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/DeliveryAgent.php');

class DeliveryAgentController
{
    public function listAgents($field,$order)
    {
        $sql = "SELECT * FROM delivery_agent order by $field $order ";
        $db = config::getConnexion();
        try {
            $agents = $db->query($sql);
            return $agents;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteAgent(int $agent_id): void
    {
        $sql = "DELETE FROM delivery_agent WHERE agent_id = :agent_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['agent_id' => $agent_id]);
            echo "Agent with ID $agent_id deleted successfully.";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function addAgent($agent)
    {
        $sql = "INSERT INTO delivery_agent 
                VALUES (NULL,:full_name, :contact_number,:agent_status)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'full_name' => $agent->getFullName(),
                'contact_number' => $agent->getContactNumber(),
                'agent_status' => $agent->getAgentStatus() ? 1 : 0
            ]);
            echo "Agent added successfully.";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Update an existing delivery agent
    function updateAgent($agent, $agent_id)
    {
        var_dump($agent); // Debugging: Inspect the $agent object
    
        try {
            $db = config::getConnexion();
    
            $query = $db->prepare(
                'UPDATE delivery_agent SET 
                    full_name = :full_name,
                    contact_number = :contact_number,
                    agent_status = :agent_status
                WHERE agent_id = :agent_id'
            );
    
            $query->execute([
                'agent_id' => $agent_id,
                'full_name' => $agent->getFullName(),
                'contact_number' => $agent->getContactNumber(),
                'agent_status' => $agent->getAgentStatus()
            ]);
    
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    

    // Fetch a single delivery agent by ID
    public function showAgent(int $agent_id): ?DeliveryAgent
    {
        $sql = "SELECT * FROM delivery_agent WHERE agent_id = :agent_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['agent_id' => $agent_id]);

            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new DeliveryAgent(
                    $row['agent_id'],
                    $row['full_name'],
                    $row['contact_number'],
                    $row['agent_status']
                );
            }
            return null;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

}
