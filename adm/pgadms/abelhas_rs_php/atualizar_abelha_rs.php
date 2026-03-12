<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idabelhas_rs = intval($_POST['idabelhas_rs']);
    $nome_abelhas_rs = $_POST['nome_abelhas_rs'] ?? '';
    $nomecientifico_abelhas_rs = $_POST['nomecientifico_abelhas_rs'] ?? '';
    $dados_abelhas_rs = $_POST['dados_abelhas_rs'] ?? '';
    $novaImagem = '';

    // Validações
    if (strlen($nome_abelhas_rs) > 100 || strlen( $nomecientifico_abelhas_rs) > 100 || strlen($dados) > 5000) {
        echo "<script>alert('Algum campo ultrapassou o limite de caracteres.'); window.history.back();</script>";
        exit();
    }

    // Upload da nova imagem (se enviada)
    if (isset($_FILES['img_abelha_rs']) && $_FILES['img_abelha_rs']['error'] === UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['img_abelha_rs']['tmp_name'];
        $img_nome_original = basename($_FILES['img_abelha_rs']['name']);
        $extensao = strtolower(pathinfo($img_nome_original, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extensao, $permitidas)) {
            echo "<script>alert('Formato de imagem não permitido.'); window.history.back();</script>";
            exit();
        }

        $novaImagem = uniqid('abelha_') . "." . $extensao;
        $caminho_destino = "../../uploads/" . $novaImagem;

        if (!move_uploaded_file($img_tmp, $caminho_destino)) {
            echo "<script>alert('Erro ao salvar a imagem.'); window.history.back();</script>";
            exit();
        }
    }

    // Conexão
    $conn = new mysqli("", "", "", "", ); 
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    $nome_abelhas_rs = $conn->real_escape_string($nome_abelhas_rs);
     $nomecientifico_abelhas_rs = $conn->real_escape_string( $nomecientifico_abelhas_rs);
    $dados_abelhas_rs = $conn->real_escape_string($dados_abelhas_rs);

    // Atualiza com ou sem nova imagem
    if ($novaImagem) {
        $novaImagem = $conn->real_escape_string($novaImagem);
        $sql = "UPDATE abelhas_rs SET nome_abelhas_rs='$nome_abelhas_rs', nomecientifico_abelhas_rs=' $nomecientifico_abelhas_rs', dados_abelhas_rs='$dados_abelhas_rs', img_abelha_rs='$novaImagem' WHERE idabelhas_rs=$idabelhas_rs";
    } else {
        $sql = "UPDATE abelhas_rs SET nome_abelhas_rs='$nome_abelhas_rs', nomecientifico_abelhas_rso=' $nomecientifico_abelhas_rs', dados_abelhas_rs='dados_abelhas_rs' WHERE idabelhas_rs=$idabelhas_rs";
    }

    if ($conn->query($sql)) {
        header("Location: index_abelha.php");
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar abelha: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
