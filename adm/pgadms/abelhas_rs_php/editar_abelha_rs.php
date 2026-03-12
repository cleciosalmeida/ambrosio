<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if (!isset($_GET['idabelhas_rs'])) {
    echo "ID inválido.";
    exit();
}

$id = intval($_GET['idabelhas_rs']);

// Conexão
$conn = new mysqli("", "", "", "", ); 
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM abelhas_rs WHERE idabelhas_rs = $idabelhas_rs";
$resultado = $conn->query($sql);

if ($resultado->num_rows === 0) {
    echo "Abelha não encontrada.";
    exit();
}

$abelhas_rs = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Abelha</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../../img/iconeeditar.png"> 
</head>
<body>
    <div class="card">
        <h2>Editar Abelha</h2>
        <form action="atualizar_abelha_rs.php" method="POST" enctype="multipart/form-data" class="form-card">
            <input type="hidden" name="idabelhas_rs" value="<?= $abelhas_rs['idabelhas_rs'] ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome_abelhas_rs" name="nome_abelhas_rs" value="<?= htmlspecialchars($abelha_rs['nome_abelhas_rs']) ?>" required>

            <label for="nomecientifico_abelhas_rs">Nome científico:</label>
            <input type="text" id="nomecientifico_abelhas_rs" name="nomecientifico_abelhas_rs" value="<?= htmlspecialchars($abelha_rs['nomecientifico_abelhas_rs']) ?>" required>

            <label for="dados_abelhas_rs">Informações:</label>
            <textarea id="dados_abelhas_rs" name="dados_abelhas_rs" rows="4"><?= htmlspecialchars($abelha_rs['dados_abelhas_rs']) ?></textarea>

            <?php if (!empty($abelha_rs['img_abelha_rs'])): ?>
                <p>Imagem atual: <img src="../../uploads/<?= htmlspecialchars($abelha_rs['img_abelha_rs']) ?>" width="100"></p>
            <?php endif; ?>

            <label for="imagem">Nova imagem (opcional):</label>
            <input type="file" id="imagem" name="img_abelha_rs" accept="image/*">

            <div class="botoes-formulario">
                <button type="submit">Atualizar</button>
                <a href="index_abelha.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
