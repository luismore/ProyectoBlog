<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}


require_once '../models/Category.php';


$pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
$categoryModel = new Category($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['category_name'];
        $categoryModel->createCategory($name);
    } elseif (isset($_POST['edit'])) {
        $id = $_POST['category_id'];
        $newName = $_POST['new_category_name'];
        $categoryModel->updateCategory($id, $newName);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['category_id'];
        $categoryModel->deleteCategory($id);
    }
}


$categories = $categoryModel->getAllCategories();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Categorías</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Gestionar Categorías</h1>

    <h2>Crear Nueva Categoría</h2>
    <form method="POST">
        <input type="text" name="category_name" placeholder="Nombre de la categoría" required>
        <button type="submit" name="create">Crear</button>
    </form>

    <h2>Categorías Existentes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">
                            <input type="text" name="new_category_name" placeholder="Nuevo nombre" required>
                            <button type="submit" name="edit">Editar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">
                            <button type="submit" name="delete" onclick="return confirm('¿Estás seguro de que deseas borrar esta categoría?');">Borrar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Volver a la lista de entradas</a>
</body>
</html>