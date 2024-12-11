<?php
class Post {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createPost($title, $content, $userId, $categoryId, $author) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (title, content, user_id, category_id, author) VALUES (:title, :content, :user_id, :category_id, :author)");
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':user_id' => $userId,
            ':category_id' => $categoryId,
            ':author' =>$author
        ]);
    }
    public function getPostById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPosts() {
        $stmt = $this->pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePost($id, $title, $content) {
        $stmt = $this->pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $id]);
    }

    public function deletePost($id) {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE post_id = :post_id");
        $stmt->execute(['post_id' => $id]);

        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
        
    }
    
}
?>