<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/maghraoui/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Article Manager</title>
</head>
<body>
    <header>
        <h1>Article Manager</h1>
    </header>

    <div class="container">
        <a href="/maghraoui/public/index.php?action=create" class="btn">Create Article</a>
        <a href="http://localhost/REID/tas/View/back/user/index.php" class="btn">Dashboard</a>
        <a href="/REID/maghraoui/public/index.php?action=gallery" class="btn">Display for User</a>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td><?= htmlspecialchars($article['description']) ?></td>
                        <td>
                            <?php if (!empty($article['articlePicture'])): ?>
                                <img src="/maghraoui/public/uploads/<?= htmlspecialchars($article['articlePicture']) ?>" alt="Article Picture" width="50">
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="/maghraoui/public/index.php?action=edit&id=<?= $article['id'] ?>" class="edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/maghraoui/public/index.php?action=delete&id=<?= $article['id'] ?>" 
                               onclick="return confirm('Delete this article?')" 
                               class="delete-btn">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 