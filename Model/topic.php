<?php
class Topic
{
    private $topicID;
    private $topicTitle;
    private $topicContent;
    private $author;
    private $creationDate;
    private $lastUpdated;
    private $tags;
    private $likes;
    private $views;
    private $commentsCount;
    private $status;
    private $image;

    // Constructor
    function __construct($title, $content, $author, $tags,$img)
    {
        $this->topicTitle = $title;
        $this->topicContent = $content;
        $this->author = $author;
        $this->tags = $tags;
        $this->image = $img;
    }

    // Getters
    function getTopicID()
    {
        return $this->topicID;
    }

    function getTopicTitle()
    {
        return $this->topicTitle;
    }

    function getTopicContent()
    {
        return $this->topicContent;
    }

    function getAuthor()
    {
        return $this->author;
    }

    function getCreationDate()
    {
        return $this->creationDate;
    }

    function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    function getTags()
    {
        return $this->tags;
    }

    function getLikes()
    {
        return $this->likes;
    }

    function getViews()
    {
        return $this->views;
    }

    function getCommentsCount()
    {
        return $this->commentsCount;
    }

    function getStatus()
    {
        return $this->status;
    }

    function getImage()
    {
        return $this->image;
    }

    // Setters
    function setTopicID($id)
    {
        $this->topicID = $id;
    }

    function setTopicTitle($title)
    {
        $this->topicTitle = $title;
    }

    function setTopicContent($content)
    {
        $this->topicContent = $content;
    }

    function setLastUpdated($date)
    {
        $this->lastUpdated = $date;
    }

    function setLikes($likes)
    {
        $this->likes = $likes;
    }

    function setViews($views)
    {
        $this->views = $views;
    }

    function setCommentsCount($count)
    {
        $this->commentsCount = $count;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }
}


?>