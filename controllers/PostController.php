<?php
require_once '../config/config.php';

class PostController {
    public function createPost($title, $content, $userId, $categoryId) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, user_id, category_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $content, $userId, $categoryId]);
    }

    public function getPosts($page = 1, $itemsPerPage = 10) {
        global $pdo;
        $offset = ($page - 1) * $itemsPerPage;
        $stmt = $pdo->prepare("SELECT * FROM posts LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}

?>