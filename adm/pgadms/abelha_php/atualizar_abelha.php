<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nome = $_POST['nome'] ?? '';
    $nome_cientifico = $_POST['nome_cientifico'] ?? '';
    $dados = $_POST['dados_complementares'] ?? '';
    $novaImagem = '';

    // Validações
    if (strlen($nome) > 100 || strlen($nome_cientifico) > 100 || strlen($dados) > 5000) {
        echo "<script>alert('Algum campo ultrapassou o limite de caracteres.'); window.history.back();</script>";
        exit();
    }

    // Upload da nova imagem (se enviada)
    if (isset($_FILES['img_abelha']) && $_FILES['img_abelha']['error'] === UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['img_abelha']['tmp_name'];
        $img_nome_original = basename($_FILES['img_abelha']['name']);
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

    $nome = $conn->real_escape_string($nome);
    $nome_cientifico = $conn->real_escape_string($nome_cientifico);
    $dados = $conn->real_escape_string($dados);

    // Atualiza com ou sem nova imagem
    if ($novaImagem) {
        $novaImagem = $conn->real_escape_string($novaImagem);
        $sql = "UPDATE abelhas SET nome='$nome', nome_cientifico='$nome_cientifico', dados_complementares='$dados', img_abelha='$novaImagem' WHERE id=$id";
    } else {
        $sql = "UPDATE abelhas SET nome='$nome', nome_cientifico='$nome_cientifico', dados_complementares='$dados' WHERE id=$id";
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
