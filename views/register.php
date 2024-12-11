<?php
session_start();

require '../config/config.php';
require '../models/User.php';


$userModel = new User($pdo);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user';


    if (empty($email)) {
        $error = "El email es obligatorio.";
    } else {
        $existingUser  = $userModel->getUserByEmail($email);
        if ($existingUser ) {
            $error = "El email ya está en uso.";
        } else {
            if ($userModel->register($username, $email, $password, $role)) {
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Error al registrar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Registrarse</h1>
    </header>

    <main>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
    <div>
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Registrarse</button>
</form>

        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </main>


</body>
</html>