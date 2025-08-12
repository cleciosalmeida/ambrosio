<?php
session_start();

// Proteção de sessão
//if (!isset($_SESSION['usuario'])) {
  //  header("Location: ../../admin.html");
    //exit();
//}

// Conexão com o banco
$host = "";
$usuario = "";
$senha = "";
$banco = "";
$porta = ;

$conn = new mysqli($host, $usuario, $senha, $banco, $porta);
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

// Verifica se o ID foi passado corretamente
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit();
}

$id = (int) $_GET['id'];
$sql = "SELECT * FROM plantas WHERE idplantas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Planta não encontrada.";
    exit();
}

$planta = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
  <link rel="stylesheet" href="../../css/style_pasto.css" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($planta['nome_popular_planta']) ?></title>
  <link rel="shortcut icon" href="../../img/icone.ico" />
</head>
<body>
  CARECE ALTERAÇÃO
  <div class="container">
    <header class="header">
      <a href="../../index.html" name="Início">
        <img src="../../img/base.png" alt="logo-header" class="logoNavBar" />
      </a>
      <div class="headerBtnGroup">
        <a href="../../paginas/quemsomos.html"><button class="navBtn">O meliponário</button></a>
        <a href="../../paginas/prqambrosio.html"><button class="navBtn">Santo Ambrósio</button></a>
        <a href="../../paginas/asabelhas.html"><button class="navBtn">Nossas abelhas</button></a>
        <a href="../../paginas/contato.html"><button class="navBtn">Contato</button></a>
        <a href="../../adm/admin.html"><button class="navBtn">Admin</button></a>
      </div>
    </header>

      <section class="conteudo_mirim">
      <h1><?= htmlspecialchars($planta['nome_popular_planta']) ?> (<em><?= htmlspecialchars($planta['nome_cientifico_planta']) ?></em>)</h1>

      <?php if (!empty($planta['img_planta'])): ?>
        <img src="../adm/uploads/<?= htmlspecialchars($planta['img_planta']) ?>" alt="Imagem de <?= htmlspecialchars($planta['nome_popular_planta']) ?>" class="AbeCardImg" style="max-width: 300px; margin-top: 15px;">
      <?php endif; ?>

      <?php if (!empty($planta['estacao_floracao'])): ?>
        <h2>Floração</h2>
        <p><?= nl2br(htmlspecialchars($planta['estacao_floracao'])) ?></p>
      <?php endif; ?>

      <?php if (!empty($planta['dados_planta'])): ?>
        <h2>Informações sobre a planta</h2>
        <p><?= nl2br(htmlspecialchars($planta['dados_planta'])) ?></p>
      <?php endif; ?>
      
      <?php if (!empty($planta['resina_planta'])): ?>
        <h2>Resina</h2>
        <p><?= nl2br(htmlspecialchars($planta['resina_planta'])) ?></p>
      <?php endif; ?>

      <?php if (!empty($planta['nectar_planta'])): ?>
        <h2>Néctar</h2>
        <p><?= nl2br(htmlspecialchars($planta['nectar_planta'])) ?></p>
      <?php endif; ?>
    
      <?php if (!empty($planta['polen_planta'])): ?>
        <h2>Pólen</h2>
        <p><?= nl2br(htmlspecialchars($planta['polen_planta'])) ?></p>
      <?php endif; ?>

      <?php if (!empty($planta['abelha_planta'])): ?>
        <h2>Abelha</h2>
        <p><?= nl2br(htmlspecialchars($planta['abelha_planta'])) ?></p>
      <?php endif; ?>

    </section>
  </div>

  <footer class="footer">
    <img src="../../img/img1.jpg" alt="logo-footer" class="logoFooter" />
    <a href="#BackToTop" class="footerAnchor">Voltar ao topo</a>
  </footer>
</body>
</html>
