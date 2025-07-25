<?php
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

// Consulta às plantas
$resultado = $conn->query("SELECT * FROM plantas ORDER BY nome_popular_planta ASC");
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pasto meliponícola</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="shortcut icon" href="../img/icone.ico" />
</head>
<body>
  <div class="container">
    <header class="header">
      <a href="../index.html" name="Início">
        <img src="../img/base.png" alt="logo-header" class="logoNavBar" />
      </a>
      <div class="headerBtnGroup">
        <a href="../paginas/quemsomos.html"><button class="navBtn">O meliponário</button></a>
        <a href="../paginas/prqambrosio.html"><button class="navBtn">Santo Ambrósio</button></a>
        <a href="../paginas/asabelhas.html"><button class="navBtn">Nossas abelhas</button></a>
        <a href="../paginas/contato.html"><button class="navBtn">Contato</button></a>
        <a href="../adm/admin.html"><button class="navBtn">Admin</button></a>
      </div>
    </header>

    <p class="textoExplicativo">
      A página dedicada ao catálogo de plantas do Meliponário St. Ambrósio apresenta uma seleção detalhada do pasto meliponícola existente no meliponário, destacando as espécies vegetais que fornecem recursos essenciais, como néctar, pólen e resina, para as abelhas nativas. Cada planta catalogada é acompanhada de informações sobre sua importância ecológica, período de floração e benefícios específicos para as abelhas sem ferrão. Essa página tem como objetivo enriquecer o conhecimento dos visitantes sobre as interações entre as abelhas e a flora local, além de incentivar práticas sustentáveis que promovam a conservação do ambiente e da biodiversidade.
    </p>

    <section class="gridAbelhas">
      <div class="PastoContent">
        <?php while ($linha = $resultado->fetch_assoc()): ?>
          <a href="detalhes_planta.php?id=<?= $linha['idplantas'] ?>" style="text-decoration: none; color: inherit;">
            <div class="PastoCard">
              <?php if (!empty($linha['img_planta'])): ?>
                 <img src="../adm/uploads/<?= htmlspecialchars($linha['img_planta']) ?>" alt="Imagem de <?= htmlspecialchars($linha['nome_popular_planta']) ?>" class="AbeCardImg" />
              <?php else: ?>
                <img src="../img/semimagem.png" alt="Sem imagem" class="AbeCardImg" />
              <?php endif; ?>
              <p class="TituloCards"><?= htmlspecialchars($linha['nome_popular_planta']) ?></p>
              <p class="mainCategoryCardDescription"><?= htmlspecialchars($linha['nome_cientifico_planta']) ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>
    </section>
  </div>
</body>
</html>
