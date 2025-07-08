<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_popular = $_POST['nome_popular_planta'] ?? '';
    $nome_cientifico = $_POST['nome_cientifico_planta'] ?? '';
    $ocorrencia = $_POST['ocorrencia'] ?? '';
    $dados = $_POST['dados_planta'] ?? '';
    $img_nome = '';

    // Validações de tamanho
    if (strlen($nome_popular) > 100 || strlen($nome_cientifico) > 100 || strlen($ocorrencia) > 1000) {
        echo "<script>alert('Algum campo ultrapassou o limite de caracteres.'); window.history.back();</script>";
        exit();
    }

    // Upload de imagem
    if (isset($_FILES['img_planta']) && $_FILES['img_planta']['error'] === UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['img_planta']['tmp_name'];
        $img_nome_original = basename($_FILES['img_planta']['name']);
        $extensao = strtolower(pathinfo($img_nome_original, PATHINFO_EXTENSION));

        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extensao, $permitidas)) {
            echo "<script>alert('Formato de imagem não permitido. Use JPG, PNG ou GIF.'); window.history.back();</script>";
            exit();
        }

        // Renomeia a imagem com base em timestamp para evitar duplicatas
        $img_nome = uniqid('planta_') . "." . $extensao;
        $caminho_destino = "../../uploads/" . $img_nome;

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
    $nome_popular = $conn->real_escape_string($nome_popular);
    $nome_cientifico = $conn->real_escape_string($nome_cientifico);
    $ocorrencia = $conn->real_escape_string($ocorrencia);
    $dados = $conn->real_escape_string($dados);
    $img_nome = $conn->real_escape_string($img_nome);

    $sql = "INSERT INTO plantas (nome_popular_planta, nome_cientifico_planta, ocorrencia, dados_planta, img_planta)
            VALUES ('$nome_popular', '$nome_cientifico', '$ocorrencia', '$dados', '$img_nome')";

    if ($conn->query($sql)) {
        header("Location: index_planta.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar planta: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
