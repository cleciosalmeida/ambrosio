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
$sql = "SELECT * FROM abelhas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    echo "Abelha não encontrada.";
    exit();
}

$abelha = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-Br">
<head>
  <link rel="stylesheet" href="../../css/style_pasto.css" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($abelha['nome']) ?></title>
  <link rel="shortcut icon" href="../../img/icone.ico" />
</head>
<body>
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
      <h1><?= htmlspecialchars($abelha['nome']) ?> (<em><?= htmlspecialchars($abelha['nome_cientifico']) ?></em>)</h1>

      <?php if (!empty($abelha['abelha'])): ?>
        <img src="../adm/uploads/<?= htmlspecialchars($abelha['abelha']) ?>" alt="Imagem de <?= htmlspecialchars($abelha['nome']) ?>" class="AbeCardImg" style="max-width: 300px; margin-top: 15px;">
      <?php endif; ?>

      <?php if (!empty($abelha['dados_complementares'])): ?>
        <h2>Dados complementares</h2>
        <p><?= nl2br(htmlspecialchars($abelha['dados_complementares'])) ?></p>
      <?php endif; ?>

     </section>
  </div>

  <footer class="footer">
    <img src="../../img/img1.jpg" alt="logo-footer" class="logoFooter" />
    <a href="#BackToTop" class="footerAnchor">Voltar ao topo</a>
  </footer>
</body>
</html>
