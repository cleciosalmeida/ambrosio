<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Redireciona para a página de login
    header('Location: ../admin.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
     <link rel="shortcut icon" href="../img/iconeadmin.png" />
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo">🐝 Admin</div>
        <nav>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Configurações</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Painel Administrativo</h1>

        <div class="card-grid">

            <div class="card">
                <h2>Artigos</h2>
                <button>Novo Artigo</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Produtos</h2>
                <button>Novo Produto</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Abelhas do Meliponário</h2>
                 <a href="../pgadms/abelhas_php/index_abelha.php" class="sublinhado"><button>Gerenciar abelhas</button></a>
                        </div>

            <div class="card">
                <h2>Colônias</h2>
                <button>Nova Colônia</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Plantas</h2>
               <a href="../pgadms/planta_php/index_planta.php" class="sublinhado"><button>Plantas</button></a>
            </div>

            <div class="card">
                <h2>Meliponários</h2>
                <button>Novo Meliponário</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Isqueiros</h2>
                <button>Nova Isca</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Gerenciar usuários</h2>
                <a href="../pgadms/usuario_php/index_usuario.php" class="sublinhado"><button>Usuários</button></a>
                
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Meliponário Santo Ambrósio - Painel Administrativo</p>
    </footer>
</body>
</html>
