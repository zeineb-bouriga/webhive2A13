<?php
class TopicC
{
    function addTopic($topic)
    {
        $sql = "INSERT INTO topics (topicTitle, topicContent, author, creationDate, lastUpdated, tags, likes, views, commentsCount, status,image) 
        VALUES (:topicTitle, :topicContent, :author, :creationDate, :lastUpdated, :tags, :likes, :views, :commentsCount, :status,:image)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'topicTitle' => $topic->getTopicTitle(),
                'topicContent' => $topic->getTopicContent(),
                'author' => $topic->getAuthor(),
                'creationDate' => date("Y-m-d H:i:s"),
                'lastUpdated' => date("Y-m-d H:i:s"),
                'tags' => $topic->getTags(),
                'likes' => 0,
                'views' => 0,
                'commentsCount' => 0,
                'status' => 'inactive',
                'image' => $topic->getImage()

            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateTopic($topic)
    {
        $sql = "UPDATE topics SET topicTitle = :topicTitle, topicContent = :topicContent, lastUpdated = :lastUpdated, tags = :tags, image = :image,status =:status WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'topicTitle' => $topic->getTopicTitle(),
                'topicContent' => $topic->getTopicContent(),
                'lastUpdated' => date("Y-m-d H:i:s"),
                'tags' => $topic->getTags(),
                'image' => $topic->getImage(),
                'status' => 'inactive',
                'id' => $topic->getTopicID()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

   

    function displayTopics($check)
    {
        if ($check == "user"){
            $sql = "SELECT * FROM topics ";
        }else {
            $sql = "SELECT * FROM topics";
        }
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getTopicById($topicId)
    {
        $db = config::getConnexion();
        // Prepare SQL statement
        $stmt = $db->prepare("SELECT * FROM topics WHERE id = :id");

        // Bind parameters
        $stmt->bindParam(':id', $topicId);

        // Execute query
        $stmt->execute();

        // Fetch the topic data
        $topic = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close connection
        $db = null;

        return $topic;
    }

   
    

    public function getTopicsByAuthor($authorId) {
        $db = config::getConnexion();

        $sql = "SELECT * FROM topics WHERE author = :author_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":author_id", $authorId);
        $stmt->execute();
        $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $topics;
    }

    function deleteTopic($id)
    {

        $sql = "DELETE FROM topics WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);
        try {
            $req->execute();
            echo "Supprimees avec succees ! ";

        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function incrementCommentsCount($topicId) {
        $db = config::getConnexion();

        // Prepare SQL statement to update views count
        $stmt = $db->prepare("UPDATE topics SET commentsCount = commentsCount + 1 WHERE id = :id");

        // Bind parameters
        $stmt->bindParam(':id', $topicId);

        // Execute update query
        $stmt->execute();

        // Close connection
        $db = null;
    }

    public function descrementCommentsCount($topicId) {
        $db = config::getConnexion();

        // Prepare SQL statement to update views count
        $stmt = $db->prepare("UPDATE topics SET commentsCount = commentsCount - 1 WHERE id = :id");

        // Bind parameters
        $stmt->bindParam(':id', $topicId);

        // Execute update query
        $stmt->execute();

        // Close connection
        $db = null;
    }
}

?>