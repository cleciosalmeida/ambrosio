<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_abelhas_rs = $_POST['nome_abelhas_rs'] ?? '';
    $nomecientifico_abelhas_rs = $_POST['nomecientifico_abelhas_rs'] ?? '';
    $dados_abelhas_rs = $_POST['dados_abelhas_rs'] ?? '';
    $img_abelha_rs = '';
    
    // Limites de caracteres
    $limites = [
        'nome_abelhas_rs' => 100,
        'nomecientifico_abelhas_rs' => 100,
        'dados_abelhas_rs' => 5000
    ];
    
    $erros = [];

    // Validações de tamanho com mensagens específicas
    if (strlen($nome_abelhas_rs) > $limites['nome_abelhas_rs']) {
        $erros[] = "O campo Nome excede o limite de {$limites['nome_abelhas_rs']} caracteres.";
    }
    
    if (strlen($nomecientifico_abelhas_rs) > $limites['nomecientifico_abelhas_rs']) {
        $erros[] = "O campo Nome Científico excede o limite de {$limites['nomecientifico_abelhas_rs']} caracteres.";
    }
    
    if (strlen($dados_abelhas_rs) > $limites['dados_abelhas_rs']) {
        $erros[] = "O campo Dados Complementares excede o limite de {$limites['dados_abelhas_rs']} caracteres.";
    }

    // Se houver erros de tamanho, exibe todos de uma vez
    if (!empty($erros)) {
        $mensagem = implode("\\n", $erros); // Usando \\n para JavaScript
        echo "<script>alert('$mensagem'); window.history.back();</script>";
        exit();
    }

    // Upload de imagem
    if (isset($_FILES['img_abelha_rs']) && $_FILES['img_abelha_rs']['error'] === UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['img_abelha_rs']['tmp_name'];
        $img_nome_original = basename($_FILES['img_abelha_rs']['name']);
        $extensao = strtolower(pathinfo($img_nome_original, PATHINFO_EXTENSION));

        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extensao, $permitidas)) {
            echo "<script>alert('Formato de imagem não permitido. Use JPG, PNG ou GIF.'); window.history.back();</script>";
            exit();
        }

        // Valida tamanho do arquivo (opcional - 5MB máximo)
        if ($_FILES['img_abelha_rs']['size'] > 5 * 1024 * 1024) {
            echo "<script>alert('A imagem deve ter no máximo 5MB.'); window.history.back();</script>";
            exit();
        }

        // Renomeia a imagem com base em timestamp para evitar duplicatas
        $img_abelha_rs = uniqid('abelha_') . "." . $extensao;
        $caminho_destino = "../../uploads/" . $img_abelha_rs;

        if (!move_uploaded_file($img_tmp, $caminho_destino)) {
            echo "<script>alert('Erro ao salvar a imagem.'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Selecione uma imagem para a abelha.'); window.history.back();</script>";
        exit();
    }

    // Conexão com banco
    $conn = new mysqli("", "", "", "", );
    if ($conn->connect_error) {
        die("Erro: " . $conn->connect_error);
    }

    // Evita SQL Injection
    $nome_abelhas_rs = $conn->real_escape_string($nome_abelhas_rs);
    $nomecientifico_abelhas_rs = $conn->real_escape_string($nomecientifico_abelhas_rs);
    $dados_abelhas_rs = $conn->real_escape_string($dados_abelhas_rs);
    $img_abelha_rs = $conn->real_escape_string($img_abelha_rs);

    $sql = "INSERT INTO abelhas_rs (nome_abelhas_rs, nomecientifico_abelhas_rs, dados_abelhas_rs, img_abelha_rs)
            VALUES ('$nome_abelhas_rs', '$nomecientifico_abelhas_rs', '$dados_abelhas_rs','$img_abelha_rs')";

    if ($conn->query($sql)) {
        header("Location: index_abelha_rs.php");
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar abelha: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
