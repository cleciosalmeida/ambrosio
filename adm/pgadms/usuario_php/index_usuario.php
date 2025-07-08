<?php
// index.php
session_start();

// Proteção de sessão
if (!isset($_SESSION['usuario'])) {
    header("Location: ../admin.html");
    exit();
}

// Conexão com banco
//$host = "";
//$usuario = "";
//$senha = "";
//$banco = "";
//$porta = ;

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$resultado = $conn->query("SELECT * FROM usuario");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Usuários</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="card">
        <h2>Usuários</h2>
        <button onclick="abrirFormulario()">Novo usuário</button>
    </div>

    <!-- Tabela com usuários -->
    <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Login</th>
                <th>Senha</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while($linha = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $linha['idusuario'] ?></td>
                <td><?= htmlspecialchars($linha['nome']) ?></td>
                <td><?= htmlspecialchars($linha['login']) ?></td>
                <td><?= htmlspecialchars($linha['senha']) ?></td>
                <td>
                    <form method="POST" action="excluir_usuario.php" onsubmit="return confirm('Deseja excluir este usuário?')">
                        <input type="hidden" name="idusuario" value="<?= $linha['idusuario'] ?>">
                        <button type="submit" class="delete">Excluir</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Formulário de cadastro -->
    <div id="formularioCadastro" class="modal" style="display: none;">
        <form id="formCadastro" class="form-card" action="inserir_usuario.php" method="POST">
            <h3>Cadastrar novo usuário</h3>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="login">Login:</label>
            <input type="text" id="login" name="login" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirmarSenha">Confirmar senha:</label>
            <input type="password" id="confirmarSenha" name="confirmarSenha" required>

            <div class="botoes-formulario">
                <button type="submit">Cadastrar</button>
                <button type="button" onclick="fecharFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <script src="../script.js"></script>
    <br>
    <a href="../painel.php" class="sublinado">Voltar<a>
</body>
</html>
