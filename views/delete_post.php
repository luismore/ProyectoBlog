<?php
session_start();
require '../config/config.php';
require '../models/Post.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$postModel = new Post($pdo);


if (isset($_GET['id'])) {
    $postId = (int)$_GET['id'];



    if ($postModel->deletePost($postId, $_SESSION['user_id'])) {

        header("Location: dashboard.php?success=Entrada eliminada con éxito.");
        exit();
    } else {

        header("Location: dashboard.php?error=Error al eliminar la entrada.");
        exit();
    }
} else {

    header("Location: dashboard.php?error=ID de entrada no proporcionado.");
    exit();
}
?>