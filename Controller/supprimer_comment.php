<?php
include_once "../config.php"; 
include_once "CommentC.php"; 
include_once "TopicC.php"; 
$commentC = new CommentC();
$topicC = new TopicC();

if (isset($_POST['comment_id'])) {
    $topicId = $_POST['topic_id']; // Retrieve the topic ID
    $commentC->deleteComment($_POST['comment_id']);
    $topicC->descrementCommentsCount($topicId);
    header("Location: ../View/Front Office/topic.php?id=$topicId"); // Redirect back to the topic page with the topic ID
} else {
    echo 'Erreur : try again';
    echo $_POST['comment_id'];
}

if (isset($_POST['comment'])) {
    $topicId = $_POST['topic_id']; // Retrieve the topic ID
    $commentC->deleteComment($_POST['comment']);
    $topicC->descrementCommentsCount($topicId);
    header("Location: ../View/Back Office/comments.php?topic_id=$topicId"); // Redirect back to the topic page with the topic ID
} else {
    echo 'Erreur : try again';
    echo $_POST['comment'];
}
?>
