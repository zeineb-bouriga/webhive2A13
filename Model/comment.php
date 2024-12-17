<?php
class Comment
{
    private $commentID;
    private $topicID;
    private $commentContent;
    private $author;
    private $creationDate;
    private $status;

    // Constructor
    function __construct($topicID, $content, $author)
    {
        $this->topicID = $topicID;
        $this->commentContent = $content;
        $this->author = $author;
    }



    // Getters
    function getCommentID()
    {
        return $this->commentID;
    }

    function getTopicID()
    {
        return $this->topicID;
    }

    function getCommentContent()
    {
        return $this->commentContent;
    }

    function getAuthor()
    {
        return $this->author;
    }

    function getCreationDate()
    {
        return $this->creationDate;
    }


    function getStatus()
    {
        return $this->status;
    }

    // Setters


    function setCommentID($commentID)
    {
        $this->commentID = $commentID;
    }
    function setCommentContent($content)
    {
        $this->commentContent = $content;
    }


    function setStatus($status)
    {
        $this->status = $status;
    }
}


?>