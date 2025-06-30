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
        <div class="logo">🐝 Meliponário Admin</div>
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
                <h2>Espécies de Abelhas</h2>
                <button>Nova Abelha</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Colônias</h2>
                <button>Nova Colônia</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

            <div class="card">
                <h2>Plantas</h2>
                <button>Nova Planta</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
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
                <h2>Usuários</h2>
                <button onclick="cad_usuario.html">Novo usuário</button>
                <button>Editar</button>
                <button class="delete">Excluir</button>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Meliponário Santo Ambrósio - Painel Administrativo</p>
    </footer>
</body>
</html>
