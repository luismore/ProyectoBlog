<?php
require '../config/config.php';
require '../models/Post.php';


$postModel = new Post($pdo);


$posts = $postModel->getAllPosts();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Blog</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenido a Mi Blog</h1>
        <nav>
            <ul>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="register.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Entradas Recientes</h2>
        <?php if (count($posts) > 0): ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <h3><a href="post_detail.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                        <p><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></p>
                        <p><small>Publicado el <?php echo $post['created_at']; ?></small></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay entradas disponibles en este momento.</p>
        <?php endif; ?>
    </main>
</body>
</html>