<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idusuario'];

    $conn = new mysqli();
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    $id = (int) $id;
    $sql = "DELETE FROM usuario WHERE idusuario = $id";
    $conn->query($sql);

    $conn->close();
    header("Location: index_usuario.php");
}
