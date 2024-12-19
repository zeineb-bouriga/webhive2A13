<?php
class CommentController {
    private $commentModel;
    private $articleModel;

    public function __construct() {
        $this->commentModel = new Comment();
        $this->articleModel = new Article();
    }

    // Increment the like count (reactC) for a specific comment
    public function like() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['comment_id'], $data['reaction'])) {
            $commentId = $data['comment_id'];
            $reaction = $data['reaction'];

            // Fetch current reactC value from the database for the comment
            $currentReactC = $this->commentModel->getReactC($commentId);

            // Handle like or dislike logic
            if ($reaction === 'like' && $currentReactC == 0) {
                $success = $this->commentModel->incrementReactC($commentId);
            } elseif ($reaction === 'dislike' && $currentReactC == 1) {
                $success = $this->commentModel->resetReactC($commentId);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid reaction or no change']);
                exit();
            }

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update reaction']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Missing comment ID or reaction']);
        }
    }

    // Register a new comment with session-based user_id
    public function registerComments() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start(); // Start session if not already started

            // Ensure user is logged in
            if (!isset($_SESSION['id'])) {
                echo json_encode(['success' => false, 'message' => 'User not logged in.']);
                return;
            }

            $rawData = file_get_contents('php://input');
            $data = json_decode($rawData, true);

            if (isset($data['article_id'], $data['comment_text'])) {
                $articleId = (int) $data['article_id'];
                $commentText = trim($data['comment_text']);
                $userId = $_SESSION['id'];

                if ($articleId > 0 && !empty($commentText)) {
                    $commentData = [
                        'article_id' => $articleId,
                        'user_id' => $userId,
                        'comment_text' => $commentText
                    ];

                    if ($this->commentModel->create($commentData)) {
                        echo json_encode(['success' => true, 'message' => 'Comment added successfully.']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to save the comment.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Missing required data.']);
            }
        }
    }

    // Store a new comment
    public function store() {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
            return;
        }

        $userId = $_SESSION['id'];
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['article_id'], $input['comment_text'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
            return;
        }

        $articleId = htmlspecialchars($input['article_id']);
        $commentText = htmlspecialchars($input['comment_text']);

        $commentData = [
            'article_id' => $articleId,
            'user_id' => $userId,
            'comment_text' => $commentText
        ];

        if ($this->commentModel->create($commentData)) {
            echo json_encode(['success' => true, 'message' => 'Comment added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save comment.']);
        }
    }

    // Display all comments for an article
    public function index($articleId) {
        $comments = $this->commentModel->all($articleId);
        $article = $this->articleModel->find($articleId);
        require_once __DIR__ . '/../views/comments/index.php';
    }

    // Show form to create a comment
    public function create($articleId) {
        $article = $this->articleModel->find($articleId);
        require_once __DIR__ . '/../views/articles/gallery.php';
    }

    // Update an existing comment
    public function update($id) {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
            return;
        }

        $data = [
            'comment_text' => $_POST['comment_text']
        ];

        if ($this->commentModel->update($id, $data)) {
            echo json_encode(['success' => true, 'message' => 'Comment updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update comment.']);
        }
    }
    // In your Comment Controller


    // Delete a comment
    public function delete($id) {
        session_start();

        if (!isset($_SESSION['id'])) {
            echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
            return;
        }

        if ($this->commentModel->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Comment deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete comment.']);
        }
    }

    public function userCommentsForArticle($articleId, $userId) {
        // Check if the user is logged in and has a valid user_id
        if (!$userId) {
            echo json_encode(['success' => false, 'message' => 'User ID is missing or not logged in.']);
            return;
        }
    
        // Fetch comments for the article and the specific user
        $comments = $this->commentModel->getCommentsByArticleAndUser($articleId, $userId);
    
        // Return comments as a JSON response
        echo json_encode($comments);
    }
    
    
    
    public function getComments($articleId) {
        // Assuming you have a method in your Comment model to fetch comments by article ID
        $comments = Comment::getCommentsByArticle($articleId);
        echo json_encode($comments);
    }
}
