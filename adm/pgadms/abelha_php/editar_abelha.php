<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID inválido.";
    exit();
}

$id = intval($_GET['id']);

// Conexão
$conn = new mysqli("", "", "", "", ); 
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM abelhas WHERE id = $id";
$resultado = $conn->query($sql);

if ($resultado->num_rows === 0) {
    echo "Abelha não encontrada.";
    exit();
}

$abelha = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Abelha</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="card">
        <h2>Editar Abelha</h2>
        <form action="atualizar_abelha.php" method="POST" enctype="multipart/form-data" class="form-card">
            <input type="hidden" name="id" value="<?= $abelha['id'] ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($abelha['nome']) ?>" required>

            <label for="nome_cientifico">Nome científico:</label>
            <input type="text" id="nome_cientifico" name="nome_cientifico" value="<?= htmlspecialchars($abelha['nome_cientifico']) ?>" required>

            <label for="dados_complementares">Informações:</label>
            <textarea id="dados_complementares" name="dados_complementares" rows="4"><?= htmlspecialchars($abelha['dados_complementares']) ?></textarea>

            <?php if (!empty($abelha['img_abelha'])): ?>
                <p>Imagem atual: <img src="../../uploads/<?= htmlspecialchars($abelha['img_abelha']) ?>" width="100"></p>
            <?php endif; ?>

            <label for="imagem">Nova imagem (opcional):</label>
            <input type="file" id="imagem" name="img_abelha" accept="image/*">

            <div class="botoes-formulario">
                <button type="submit">Atualizar</button>
                <a href="index_abelha.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
