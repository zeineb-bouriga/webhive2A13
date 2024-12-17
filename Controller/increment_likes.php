<?php
// Include necessary files and configurations
include_once "../config.php"; // Assuming this file contains database connection configuration
include_once "TopicC.php"; // Assuming this file contains the Topic controller

    // Check if topic ID is provided in the POST data
    if (isset($_POST['topicId']) && !empty($_POST['topicId'])) {
        // Get the topic ID from the POST data
        $topicId = $_POST['topicId'];

        // Create a new instance of the Topic controller
        $topicC = new TopicC();

        // Increment likes count for the topic
        $topicC->incrementLikes($topicId); // Assuming a function incrementLikes() increments likes count in the database

        
    } else {
        echo "Error: Topic ID is missing";
    }

?>
