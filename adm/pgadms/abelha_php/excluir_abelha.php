<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        echo "<script>alert('ID inválido.'); window.history.back();</script>";
        exit();
    }

    $conn = new mysqli("");
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    $id = (int) $id;

    // 1. Busca o nome da imagem (se houver)
    $queryImagem = "SELECT img_abelha FROM abelhas WHERE id = $id";
    $resultado = $conn->query($queryImagem);
    $imagem = null;

    if ($resultado && $resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $imagem = $linha['img_abelha'];
    }

    // 2. Exclui o registro do banco
    $sql = "DELETE FROM abelhas WHERE id = $id";
    if (!$conn->query($sql)) {
        echo "<script>alert('Erro ao excluir abelha: " . $conn->error . "'); window.history.back();</script>";
        exit();
    }

    // 3. Exclui a imagem (se existir)
    if (!empty($imagem)) {
        $caminhoImagem = "../uploads/" . $imagem;
        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem); // remove a imagem do servidor
        }
    }

    $conn->close();
    header("Location: index_abelha.php");
    exit();
}
?>
