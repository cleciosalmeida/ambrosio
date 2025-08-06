<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if (!isset($_GET['idplantas'])) {
    echo "ID inválido.";
    exit();
}

$idplantas = intval($_GET['idplantas']);

// Conexão
$conn = new mysqli("", "", "", "", ); 
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM plantas WHERE idplantas = $idplantas";
$resultado = $conn->query($sql);

if ($resultado->num_rows === 0) {
    echo "Planta não encontrada.";
    exit();
}

$plantas = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar planta</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../../img/iconeeditar.png"> 
</head>
<body>
    <div class="card">
        <h2>Editar planta</h2>
        <form action="atualizar_planta.php" method="POST" enctype="multipart/form-data" class="form-card">
            <input type="hidden" name="idplantas" value="<?= $plantas['idplantas'] ?>">

            <label for="nome_popular_planta">Nome popular:</label>
            <input type="text" id="nome_popular_planta" name="nome_popular_planta" value="<?= htmlspecialchars($plantas['nome_popular_planta']) ?>" required>

            <label for="nome_cientifico">Nome científico:</label>
            <input type="text" id="nome_cientifico" name="nome_cientifico_planta" value="<?= htmlspecialchars($plantas['nome_cientifico_planta']) ?>" required>

            <label for="estacao_floracao">Floração:</label>
            <input type="text" id="estacao_floracao" name="estacao_floracao" value="<?= htmlspecialchars($plantas['estacao_floracao']) ?>" required>

            <label for="dados">Dados da planta:</label>
            <textarea id="dados" name="dados_planta" rows="4" required><?= htmlspecialchars($plantas['dados_planta']) ?></textarea>
            
            <label for="resina">Resina:</label>
            <textarea id="resina" name="resina_planta" rows="4" required><?= htmlspecialchars($plantas['resina_planta']) ?></textarea>
            
            <label for="nectar">Néctar:</label>
            <textarea id="nectar" name="nectar_planta" rows="4" required><?= htmlspecialchars($plantas['nectar_planta']) ?></textarea>

            <label for="polen">Pólen:</label>
            <textarea id="polen" name="polen_planta" rows="4" required><?= htmlspecialchars($plantas['polen_planta']) ?></textarea>
           
            <?php if (!empty($plantas['img_planta'])): ?>
            <p>Imagem atual: <img src="../../uploads/<?= htmlspecialchars($plantas['img_planta']) ?>" width="100"></p>
            <?php endif; ?>

            <label for="imagem">Nova imagem (opcional):</label>
            <input type="file" id="imagem" name="img_planta" accept="image/*">

            <div class="botoes-formulario">
                <button type="submit">Atualizar</button>
                <a href="index_planta.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
