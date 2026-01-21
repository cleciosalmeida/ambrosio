<?php
session_start();

// Proteção de sessão
//if (!isset($_SESSION['usuario'])) {
  //  header("Location: ../paginas/pasto.php");
    //exit();
//}

// Conexão com banco
$host = "127.0.0.1";
$usuario = "root";
$senha = "P@gujo310898";
$banco = "ambrosian";
$porta = 3306;

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Consulta às plantas
$resultado = $conn->query("SELECT * FROM abelhas ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Jataí</title>
  <link rel="stylesheet" href="../../css/style.css" />
  <link rel="shortcut icon" href="../../img/icone.ico" />
</head>
<body>
  <div class="container">
    <header class="header">
      <a href="../../index.html" name="Início">
        <img src="../../img/base.png" alt="logo-header" class="logoNavBar" />
      </a>
      <div class="headerBtnGroup">
        <a href="../../index.html"><button class="navBtn">O meliponário</button></a>
        <a href="../../paginas/prqambrosio.html"><button class="navBtn">Santo Ambrósio</button></a>
        <a href="../../paginas/asabelhas.php"><button class="navBtn">Nossas abelhas</button></a>
        <a href="../../paginas/contato.html"><button class="navBtn">Contato</button></a>
        <a href="/adm/admin.html"><button class="navBtn">Admin</button></a>
      </div>
    </header>

    <p class="textoExplicativo">
      Nossas jataís. 
    </p>

    <section class="gridAbelhas">
      <div class="PastoContent">
        <?php while ($linha = $resultado->fetch_assoc()): ?>
          <a href="detalhes_produto.php?id=<?= $linha['idproduto'] ?>" style="text-decoration: none; color: inherit;">
            <div class="PastoCard">
              <?php if (!empty($linha['img_produto'])): ?>
                 <img src="../adm/uploads/<?= htmlspecialchars($linha['img_produto']) ?>" alt="Imagem de <?= htmlspecialchars($linha['nome_produto']) ?>" class="AbeCardImg" />
              <?php else: ?>
                <img src="../img/semimagem.png" alt="Sem imagem" class="AbeCardImg" />
              <?php endif; ?>
              <p class="TituloCards"><?= htmlspecialchars($linha['nome_produto']) ?></p>
              <p class="mainCategoryCardDescription"><?= htmlspecialchars($linha['descricao_produto']) ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>
    </section>
  </div>
</body>
</html>
