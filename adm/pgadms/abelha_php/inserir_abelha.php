<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $nome_cientifico = $_POST['nome_cientifico'] ?? '';
    $dados = $_POST['dados_complementares'] ?? '';
    $img_abelha = '';

    // Validações de tamanho
    if (strlen($nome) > 100 || strlen($nome_cientifico) > 100 || strlen($dados) > 1000) {
        echo "<script>alert('Algum campo ultrapassou o limite de caracteres.'); window.history.back();</script>";
        exit();
    }

    // Upload de imagem
    if (isset($_FILES['img_abelha']) && $_FILES['img_abelha']['error'] === UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['img_abelha']['tmp_name'];
        $img_nome_original = basename($_FILES['img_abelha']['name']);
        $extensao = strtolower(pathinfo($img_nome_original, PATHINFO_EXTENSION));

        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extensao, $permitidas)) {
            echo "<script>alert('Formato de imagem não permitido. Use JPG, PNG ou GIF.'); window.history.back();</script>";
            exit();
        }

        // Renomeia a imagem com base em timestamp para evitar duplicatas
        $img_abelha = uniqid('abelha_') . "." . $extensao;
        $caminho_destino = "../../uploads/" . $img_abelha;

        if (!move_uploaded_file($img_tmp, $caminho_destino)) {
            echo "<script>alert('Erro ao salvar a imagem.'); window.history.back();</script>";
            exit();
        }
    }

    // Conexão com banco
    $conn = new mysqli("");
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    // Evita SQL Injection
    $nome = $conn->real_escape_string($nome);
    $nome_cientifico = $conn->real_escape_string($nome_cientifico);
    
    $dados = $conn->real_escape_string($dados);
    
    $img_abelha = $conn->real_escape_string($img_abelha);

    $sql = "INSERT INTO plantas (nome, nome_cientifico, dados_complementares, img_abelha)
            VALUES ('$nome', '$nome_cientifico', '$dados','$img_abelha')";

    if ($conn->query($sql)) {
        header("Location: index_abelha.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar abelha: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
