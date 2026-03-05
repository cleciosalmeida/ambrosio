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
    
    // Limites de caracteres
    $limites = [
        'nome' => 100,
        'nome_cientifico' => 100,
        'dados_complementares' => 5000
    ];
    
    $erros = [];

    // Validações de tamanho com mensagens específicas
    if (strlen($nome) > $limites['nome']) {
        $erros[] = "O campo Nome excede o limite de {$limites['nome']} caracteres.";
    }
    
    if (strlen($nome_cientifico) > $limites['nome_cientifico']) {
        $erros[] = "O campo Nome Científico excede o limite de {$limites['nome_cientifico']} caracteres.";
    }
    
    if (strlen($dados) > $limites['dados_complementares']) {
        $erros[] = "O campo Dados Complementares excede o limite de {$limites['dados_complementares']} caracteres.";
    }

    // Se houver erros de tamanho, exibe todos de uma vez
    if (!empty($erros)) {
        $mensagem = implode("\\n", $erros); // Usando \\n para JavaScript
        echo "<script>alert('$mensagem'); window.history.back();</script>";
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

        // Valida tamanho do arquivo (opcional - 5MB máximo)
        if ($_FILES['img_abelha']['size'] > 5 * 1024 * 1024) {
            echo "<script>alert('A imagem deve ter no máximo 5MB.'); window.history.back();</script>";
            exit();
        }

        // Renomeia a imagem com base em timestamp para evitar duplicatas
        $img_abelha = uniqid('abelha_') . "." . $extensao;
        $caminho_destino = "../../uploads/" . $img_abelha;

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
    $nome = $conn->real_escape_string($nome);
    $nome_cientifico = $conn->real_escape_string($nome_cientifico);
    $dados = $conn->real_escape_string($dados);
    $img_abelha = $conn->real_escape_string($img_abelha);

    $sql = "INSERT INTO abelhas (nome, nome_cientifico, dados_complementares, img_abelha)
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
