<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar = $_POST['confirmarSenha'] ?? '';

    // Limites de tamanho
    if (strlen($nome) > 100) {
        echo "<script>alert('O nome não pode ter mais de 100 caracteres.'); window.history.back();</script>";
        exit();
    }

    if (strlen($login) > 50) {
        echo "<script>alert('O login não pode ter mais de 50 caracteres.'); window.history.back();</script>";
        exit();
    }

    if (strlen($senha) > 255) {
        echo "<script>alert('A senha não pode ter mais de 255 caracteres.'); window.history.back();</script>";
        exit();
    }

    if ($senha !== $confirmar) {
        echo "<script>alert('As senhas não coincidem.'); window.history.back();</script>";
        exit();
    }

    // Conexão
    $conn = new mysqli("127.0.0.1", "root", "P@gujo310898", "ambrosian", 3306);
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    // Segurança mínima (use password_hash no futuro)
    $nome = $conn->real_escape_string($nome);
    $login = $conn->real_escape_string($login);
    $senha = $conn->real_escape_string($senha);

    $sql = "INSERT INTO usuario (nome, login, senha) VALUES ('$nome', '$login', '$senha')";
    if ($conn->query($sql)) {
        header("Location: index_usuario.php");
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
