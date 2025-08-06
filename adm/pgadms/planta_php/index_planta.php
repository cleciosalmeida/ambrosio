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

// Consulta à tabela plantas
$resultado = $conn->query("SELECT * FROM plantas");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Plantas</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../../img/iconeadmin.png"> 
</head>
<body>
    <div class="card">
        <h2>Plantas Cadastradas</h2>
        <button onclick="abrirFormulario()">Nova Planta</button>
    </div>

    <!-- Tabela com plantas -->
    <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Popular</th>
                <th>Nome Científico</th>
                <th>Estação de Floração</th>
                <th>Informações</th>
                <th>Resina</th>
                <th>Néctar</th>
                <th>Pólen</th>
                <th>Abelha</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($linha = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $linha['idplantas'] ?></td>
                <td><?= htmlspecialchars($linha['nome_popular_planta']) ?></td>
                <td><?= htmlspecialchars($linha['nome_cientifico_planta']) ?></td>
                <td><?= htmlspecialchars($linha['estacao_floracao']) ?></td>
                <td><?= htmlspecialchars($linha['dados_planta']) ?></td>
                <td><?= htmlspecialchars($linha['resina_planta']) ?></td>
                <td><?= htmlspecialchars($linha['nectar_planta']) ?></td>
                <td><?= htmlspecialchars($linha['polen_planta']) ?></td>
                <td><?= htmlspecialchars($linha['abelha_planta']) ?></td>
                <td>
                   <?php if (!empty($linha['img_planta'])): ?>
        <img src="../../uploads/<?= htmlspecialchars($linha['img_planta']) ?>" alt="Imagem da planta" width="100">

    <?php else: ?>
        Sem imagem
    <?php endif; ?>
                </td>
                <td>
                    <form method="POST" action="excluir_planta.php" onsubmit="return confirm('Deseja excluir esta planta?')">
                        <input type="hidden" name="idplantas" value="<?= $linha['idplantas'] ?>">
                        <button type="submit" class="delete">Excluir</button>
                    </form>
                         </form>
                    <form method="GET" action="editar_planta.php" style="margin-top: 5px;">
        <input type="hidden" name="idplantas" value="<?= $linha['idplantas'] ?>">
        <button type="submit" class="edit">Editar</button>
    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulário de cadastro -->
    <div id="formularioCadastro" class="modal" style="display: none;">
        <form id="formCadastro" class="form-card" action="inserir_planta.php" method="POST" enctype="multipart/form-data">
            <h3>Cadastrar nova planta</h3>

            <label for="nome_popular">Nome popular:</label>
            <input type="text" id="nome_popular" name="nome_popular_planta" required>

            <label for="nome_cientifico">Nome científico:</label>
            <input type="text" id="nome_cientifico" name="nome_cientifico_planta" required>

            <label for="estacao_floracao">Floração:</label>
            <input type="text" id="estacao" name="estacao_floracao">

            <label for="dados">Dados da planta:</label>
            <textarea id="dados" name="dados_planta" rows="4"></textarea>
            
            <label for="resina">Resina:</label>
            <textarea id="resina" name="resina_planta" rows="4"></textarea>
            
            <label for="nectar">Néctar:</label>
            <textarea id="nectar" name="nectar_planta" rows="4"></textarea>

            <label for="polen">Pólen:</label>
            <textarea id="polen" name="polen_planta" rows="4"></textarea>
           
            <label for="abelha">Abelhas:</label>
            <textarea id="abelha" name="abelha_planta" rows="4"></textarea>

            <label for="imagem">Imagem da planta:</label>
            <input type="file" id="imagem" name="img_planta" accept="image/*">

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
