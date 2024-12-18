<?php
class ArticleController {
    private $articleModel;
    private $basePath = '/maghraoui/public';
    private $uploadPath;

    public function __construct() {
        $this->articleModel = new Article();
        $this->uploadPath = dirname(__DIR__) . '/public/uploads/';
        
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index() {
        $articles = $this->articleModel->all();
        require_once __DIR__ . '/../views/articles/index.php';
    }

    public function gallery() {
        $articles = $this->articleModel->all();
        require_once __DIR__ . '/../views/articles/gallery.php';       
    }
    public function create() {
        require_once __DIR__ . '/../views/articles/create.php';
    }

    public function store() {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'articlePicture' => $_FILES['articlePicture']['name']
        ];

        if (!empty($_FILES['articlePicture']['tmp_name'])) {
            $targetFile = $this->uploadPath . $data['articlePicture'];
            
            if (move_uploaded_file($_FILES['articlePicture']['tmp_name'], $targetFile)) {
                $this->articleModel->create($data);
                header('Location: /maghraoui/public/index.php');
            } else {
                die('Failed to upload file');
            }
        } else {
            $this->articleModel->create($data);
            header('Location: /maghraoui/public/index.php');
        }
    }

    public function edit($id) {
        $article = $this->articleModel->find($id);
        require_once __DIR__ . '/../views/articles/edit.php';
    }

    public function update($id) {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'articlePicture' => $_FILES['articlePicture']['name'] ?? ''
        ];

        if (!empty($_FILES['articlePicture']['tmp_name'])) {
            $targetFile = $this->uploadPath . $data['articlePicture'];
            
            if (move_uploaded_file($_FILES['articlePicture']['tmp_name'], $targetFile)) {
                $this->articleModel->update($id, $data);
                header('Location: /maghraoui/public/index.php');
            } else {
                die('Failed to upload file');
            }
        } else {
            $data['articlePicture'] = $this->articleModel->find($id)['articlePicture'];
            $this->articleModel->update($id, $data);
            header('Location: /maghraoui/public/index.php');
        }
    }

    public function delete($id) {
        $article = $this->articleModel->find($id);
        if ($article && !empty($article['articlePicture'])) {
            $imagePath = $this->uploadPath . $article['articlePicture'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $this->articleModel->delete($id);
        header('Location: /maghraoui/public/index.php');
    }
    public function like() {
    header('Content-Type: application/json');

    // Get the raw POST data
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract article ID and action (like/unlike)
    $articleId = $data['article_id'] ?? null;
    $action = $data['action'] ?? null;

    if (!$articleId || !in_array($action, ['like', 'unlike'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
        return;
    }

    // Database connection
    $db = (new Database())->connect();

    // Perform the action: increase or decrease the like count
    if ($action === 'like') {
        $stmt = $db->prepare("UPDATE articles SET likes = likes + 1 WHERE id = :id");
    } else {
        $stmt = $db->prepare("UPDATE articles SET likes = GREATEST(0, likes - 1) WHERE id = :id");
    }

    $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
}

} 