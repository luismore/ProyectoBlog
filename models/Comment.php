<?php
class Comment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addComment($postId, $userId, $content) {
        $stmt = $this->pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
        return $stmt->execute([$postId, $userId, $content]);
    }

    public function getCommentsByPostId($postId) {
        $stmt = $this->pdo->prepare("SELECT comments.content, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>