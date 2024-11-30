<?php
include_once "../config.php"; 
include_once "TopicC.php"; 


$topicC = new TopicC();

if (isset($_POST['topic_id'])) {
    $topicC->deleteTopic($_POST['topic_id']);
    header('Location: ../View/Front Office/mytopics.php');


} else {
    echo 'Erreur : try again';
    echo $_POST['topic_id'];

}


if (isset($_POST['topic'])) {
    $topicC->deleteTopic($_POST['topic']);
    header('Location: ../View/Back Office/topics.php');


} else {
    echo 'Erreur : try again';
    echo $_POST['topic_id'];

}
?>