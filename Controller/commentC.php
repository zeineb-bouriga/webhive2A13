<?php

class CommentC
{
    public function addComment($comment)
    {
        $sql = "INSERT INTO comments (topicID, commentContent, author, creationDate, status) 
                VALUES (:topicID, :commentContent, :author, :creationDate, :status)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'topicID' => $comment->getTopicID(),
                'commentContent' => $comment->getCommentContent(),
                'author' => $comment->getAuthor(),
                'creationDate' => date("Y-m-d H:i:s"),
                'status' => 'active'
            ]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateComment($commentId, $editedComment)
    {
        $sql = "UPDATE comments SET commentContent = :commentContent, status = :status WHERE commentID = :commentID";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'commentContent' => $editedComment,
                'status' => 'active', 
                'commentID' => $commentId
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function getCommentsByTopic($topicID)
    {
        $db = config::getConnexion();
        $sql = "SELECT * FROM comments WHERE topicID = :topicID AND status = 'active'";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":topicID", $topicID);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }

    public function deleteComment($commentID)
    {
        $sql = "DELETE FROM comments WHERE commentID = :commentID";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':commentID', $commentID);
        try {
            $req->execute();
            echo "Comment deleted successfully!";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>