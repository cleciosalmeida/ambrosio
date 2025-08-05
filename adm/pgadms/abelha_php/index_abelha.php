<?php
// index.php
session_start();

// Proteção de sessão
if (!isset($_SESSION['usuario'])) {
    header("Location: ../admin.html");
    exit();
}

// Conexão com banco
$host = "";
$usuario = "";
$senha = "";
$banco = "";
$porta = ;

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Consulta à tabela abelhas
$resultado = $conn->query("SELECT * FROM abelhas");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Abelhas</title>
    <link rel="stylesheet" href="../styles.css">
     <link rel="shortcut icon" href="../../img/iconeadmin.png"> 
</head>
<body>
    <div class="card">
        <h2>Abelhas cadastradas</h2>
        <button onclick="abrirFormulario()">Nova abelha</button>
    </div>

    <!-- Tabela com abelha -->
    <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Popular</th>
                <th>Nome Científico</th>
                <th>Informações</th>
                <th>Imagem</th>
             
            </tr>
        </thead>
        <tbody>
            <?php while($linha = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $linha['id'] ?></td>
                <td><?= htmlspecialchars($linha['nome']) ?></td>
                <td><?= htmlspecialchars($linha['nome_cientifico']) ?></td>
                <td><?= htmlspecialchars($linha['dados_complementares']) ?></td>
                <td>
                   <?php if (!empty($linha['img_abelha'])): ?>
        <img src="../../uploads/<?= htmlspecialchars($linha['img_abelha']) ?>" alt="Imagem da abelha" width="100">

    <?php else: ?>
        Sem imagem
    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" action="excluir_abelha.php" onsubmit="return confirm('Deseja excluir esta abelha?')">
                        <input type="hidden" name="id" value="<?= $linha['id'] ?>">
                        <button type="submit" class="delete">Excluir</button>
                    </form>
                    <form method="GET" action="editar_abelha.php" style="margin-top: 5px;">
        <input type="hidden" name="id" value="<?= $linha['id'] ?>">
        <button type="submit" class="edit">Editar</button>
    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulário de cadastro -->
    <div id="formularioCadastro" class="modal" style="display: none;">
        <form id="formCadastro" class="form-card" action="inserir_abelha.php" method="POST" enctype="multipart/form-data">
            <h3>Cadastrar nova abelha</h3>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="nome_cientifico">Nome científico:</label>
            <input type="text" id="nome_cientifico" name="nome_cientifico" required>

            <label for="dados_complementares">Informações:</label>
            <textarea id="dados_complementares" name="dados_complementares" rows="4"></textarea>
            
            <label for="imagem">Imagem da abelha:</label>
            <input type="file" id="imagem" name="img_abelha" accept="image/*">

            <div class="botoes-formulario">
                <button type="submit">Cadastrar</button>
                <button type="button" onclick="fecharFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <script src="../script.js"></script>
    <br>
    <a href="../painel.php" class="sublinado">Voltar</a>
</body>
</html>
