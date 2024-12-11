<?php
session_start();

require '../config/config.php';
require '../models/User.php';
require '../models/Post.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$userModel = new User($pdo);
$postModel = new Post($pdo);


$currentUser  = $userModel->getUserById($_SESSION['user_id']);


$posts = $postModel->getAllPosts();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($currentUser ['username']); ?></h1>
        <nav>
            <ul>
                <li><a href="logout.php">Cerrar Sesión</a></li>
                <li><a href="create_post.php">Crear Entrada</a></li>
                <?php if ($currentUser ['role'] === 'admin'): ?>
                    <li><a href="manage_categories.php">Gestionar Categorías</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Entradas del Blog</h2>
        <?php if (count($posts) > 0): ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <h3><a href="post_detail.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                        <p><?php echo htmlspecialchars($post['content']); ?></p>
                        <p><strong>Autor:</strong> <?php echo htmlspecialchars($post['author']); ?></p>
                        <p><a href="edit_post.php?id=<?php echo $post['id']; ?>">Editar</a> | <a href="delete_post.php?id=<?php echo $post['id']; ?>">Eliminar</a></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay entradas disponibles.</p>
        <?php endif; ?>
    </main>


</body>
</html>