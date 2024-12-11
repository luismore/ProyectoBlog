<?php
session_start();
require '../config/config.php';
require '../models/Post.php';
require '../models/Comment.php';


$postModel = new Post($pdo);
$commentModel = new Comment($pdo);


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$postId = (int)$_GET['id'];


$post = $postModel->getPostById($postId);


if (!$post) {
    header("Location: index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $commentContent = trim($_POST['comment']);
    
    if (!empty($commentContent)) {
        $commentModel->addComment($postId, $_SESSION['user_id'], $commentContent);
    }
}


$comments = $commentModel->getCommentsByPostId($postId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <p><strong>Publicado por:</strong> <?php echo htmlspecialchars($post['author']); ?></p>
    <p><strong>Categoría:</strong> <?php echo htmlspecialchars($post['category_id']); ?></p>

    <h2>Comentarios</h2>
    <form action="post_detail.php?id=<?php echo $postId; ?>" method="post">
        <textarea name="comment" required></textarea>
        <button type="submit">Agregar Comentario</button>
    </form>

    <ul>
        <?php foreach ($comments as $comment): ?>
            <li>
                <strong><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="dashboard.php">Volver a la lista de entradas</a>
</body>
</html>