<?php
class Comment {
    private $conn;
    private $table = 'commentsa';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    // In Comment model
public function updateReactC($commentId, $newReactC) {
    $query = "UPDATE " . $this->table . " SET reactC = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([$newReactC, $commentId]);
}


    // Fetch all comments for a specific article
    public function all($articleId) {
        $query = "SELECT * FROM " . $this->table . " WHERE article_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch a specific comment by ID
    public function find($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

      // Create a new comment
public function create($data) {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user ID exists in session
    if (!isset($_SESSION['id'])) {
        throw new Exception("User not logged in");
    }

    // Get user ID from session
    $userId = $_SESSION['id'];

    // Prepare query
    $query = "INSERT INTO " . $this->table . " (article_id, user_id, comment_text) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($query);

    // Execute query with article_id, user_id, and comment_text
    return $stmt->execute([$data['article_id'], $userId, $data['comment_text']]);
}

    

    // Update a comment
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " SET comment_text = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$data['comment_text'], $id]);
    }

    // Delete a comment
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }

    // In the Comment Model
public function getReactC($commentId) {
    $query = "SELECT reactC FROM " . $this->table . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$commentId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['reactC'];
}
// In the Comment Model
// Increment the reactC value (set to 1 for like)
public function incrementReactC($commentId) {
    $query = "UPDATE " . $this->table . " SET reactC = 1 WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([$commentId]);
}

// Reset the reactC value (set to 0 for dislike)
public function resetReactC($commentId) {
    $query = "UPDATE " . $this->table . " SET reactC = 0 WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([$commentId]);
}
    public static function getCommentsByArticle($articleId) {
        $db = Database::getInstance()->getConnection();   
        $query = "SELECT * FROM comments WHERE article_id = :article_id ORDER BY created_at DESC";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCommentsByArticleAndUser($articleId, $userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE article_id = ? AND user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$articleId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}




?>