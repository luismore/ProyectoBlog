<?php
require_once '../controllers/PostController.php';
$postController = new PostController();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$posts = $postController->getPosts($page, 10);


foreach ($posts as $post) {
    echo "<h2>{$post['title']}</h2>";
    echo "<p>{$post['content']}</p>";
}

$totalPosts = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
$totalPages = ceil($totalPosts / 10);

for ($i = 1; $i <= $totalPages; $i++) {
    echo "<a href='?page=$i'>$i</a> ";
}
?>