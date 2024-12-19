<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/DeliveryLocation.php');

class LocationController
{
    public function listLocations()
    {
        $sql = "SELECT * FROM delivery_location";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteLocation($location_id)
    {
        $sql = "DELETE FROM delivery_location WHERE location_id = :location_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            if ($query->execute(['location_id' => $location_id])) {
                echo "Record with ID $location_id deleted successfully.";
            } 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
    function addLocation($location) {
        var_dump($location);
        $sql = "INSERT INTO delivery_location  
            VALUES (NULL, :address, :latitude, :longitude, NOW())"; // Insert current timestamp
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'address'=> $location->getAddress(),
                'latitude' => $location->getLatitude(),
                'longitude' => $location->getLongitude()
            ]);
            echo "Location added successfully!";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    

    function updateLocation($location, $location_id) {
        var_dump($location);
        try {
            $db = config::getConnexion();
    
            $query = $db->prepare(
                'UPDATE delivery_location  SET 
                    address = :address,
                    latitude = :latitude,
                    longitude = :longitude,
                    timestamp = NOW() -- Automatically updates the timestamp
                 WHERE location_id = :location_id'
            );
    
            // Ensure the correct methods are called
            $query->execute([
                'location_id' => $location_id,
                'address' => $location->getAddress(), 
                'latitude' => $location->getLatitude(),
                'longitude' => $location->getLongitude()
            ]);
    
            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    

    function showLocation($location_id) {
    $sql = "SELECT * FROM delivery_location  WHERE location_id = :location_id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['location_id' => $location_id]);

        $location = $query->fetch();
        return $location;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

}
