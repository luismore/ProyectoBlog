<?php
session_start();
require '../config/config.php';
require '../models/Post.php';
require '../models/Category.php';

$categoryModel = new Category($pdo);


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$title = '';
$content = '';
$categoryId = '';
$author = '';
$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $categoryId = $_POST['category_id'];
    $author = trim($_POST['author']);


    if (empty($title) || empty($content) || empty($categoryId) || empty($author)) {
        $error = "Todos los campos son obligatorios.";
    } else {

        $postModel = new Post($pdo);


        if ($postModel->createPost($title, $content, $_SESSION['user_id'], $categoryId, $author)) {
            $success = "Entrada creada con éxito.";

            $title = '';
            $content = '';
            $categoryId = '';
            $author = '';
        } else {
            $error = "Error al crear la entrada.";
        }
    }
}


$categories = $categoryModel->getAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Entrada</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Crear Nueva Entrada</h1>

    <?php if ($error): ?>
        <div style="color: red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color: green;"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form action="create_post.php" method="post">
        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div>
            <label for="content">Contenido:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <div>
            <label for="category_id">Categoría:</label>
            <select id="category_id" name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="author">Autor: <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
        </div>
        <br>
        <button type="submit">Crear Entrada</button>
    </form>

    <a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>