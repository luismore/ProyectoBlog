<?php
session_start();
require '../config/config.php';
require '../models/Post.php';


$postModel = new Post($pdo);


if (isset($_GET['id'])) {
    $postId = intval($_GET['id']);
    $post = $postModel->getPostById($postId);


    if (!$post) {
        die("Post no encontrado.");
    }
} else {
    die("ID de post no proporcionado.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title) || empty($content)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $postModel->updatePost($postId, $title, $content);
        header("Location: post_detail.php?id=$postId");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Post</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Editar Post</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="edit_post.php?id=<?php echo $postId; ?>" method="POST">
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        <br>
        <label for="content">Contenido:</label>
        <textarea name="content" id="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        <br>
        <button type="submit">Actualizar Post</button>
    </form>

    <a href="post_detail.php?id=<?php echo $postId; ?>">Cancelar</a>
</body>
</html>