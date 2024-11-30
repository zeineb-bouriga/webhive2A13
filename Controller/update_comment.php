<?php
// Include necessary files and configurations
include_once "../config.php";
include_once "CommentC.php"; 

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve comment ID and edited comment content from the request body
    $data = json_decode(file_get_contents("php://input"));
    $commentId = $data->commentId;
    $editedComment = $data->editedComment;

    // Create a new instance of the Comment controller
    $commentC = new CommentC();

    // Update the comment in the database
    $commentC->updateComment($commentId, $editedComment);

    // Return a success response
    echo json_encode(['success' => true]);
} else {
    // Return an error response
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>