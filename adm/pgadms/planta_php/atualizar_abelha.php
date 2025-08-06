<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../admin.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['idplantas']);

    // Dados do formulário
    $nome_popular = $_POST['nome_popular_planta'] ?? '';
    $nome_cientifico = $_POST['nome_cientifico_planta'] ?? '';
    $floracao = $_POST['estacao_floracao'] ?? '';
    $dados = $_POST['dados_planta'] ?? '';
    $resina = $_POST['resina_planta'] ?? '';
    $nectar = $_POST['nectar_planta'] ?? '';
    $polen = $_POST['polen_planta'] ?? '';
    $img_nome = '';

    // Conexão com banco de dados
    $conn = new mysqli("", "", "", "", ); 
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Busca imagem atual
    $queryImagem = "SELECT img_planta FROM plantas WHERE idplantas = $id";
    $resultado = $conn->query($queryImagem);
    if ($resultado && $resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $img_atual = $linha['img_planta'];
    } else {
        echo "Registro não encontrado.";
        exit();
    }

    // Upload de nova imagem (se houver)
    if (isset($_FILES['img_planta']) && $_FILES['img_planta']['error'] === UPLOAD_ERR_OK) {
        $img_tmp = $_FILES['img_planta']['tmp_name'];
        $img_nome_original = basename($_FILES['img_planta']['name']);
        $extensao = strtolower(pathinfo($img_nome_original, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extensao, $permitidas)) {
            echo "<script>alert('Formato de imagem não permitido.'); window.history.back();</script>";
            exit();
        }

        $img_nome = uniqid('planta_') . '.' . $extensao;
        $caminho_destino = "../../uploads/" . $img_nome;

        if (!move_uploaded_file($img_tmp, $caminho_destino)) {
            echo "<script>alert('Erro ao salvar a nova imagem.'); window.history.back();</script>";
            exit();
        }
    } else {
        // Mantém imagem anterior
        $img_nome = $img_atual;
    }

    // Evita SQL Injection
    $nome_popular = $conn->real_escape_string($nome_popular);
    $nome_cientifico = $conn->real_escape_string($nome_cientifico);
    $floracao = $conn->real_escape_string($floracao);
    $dados = $conn->real_escape_string($dados);
    $resina = $conn->real_escape_string($resina);
    $nectar = $conn->real_escape_string($nectar);
    $polen = $conn->real_escape_string($polen);
    $img_nome = $conn->real_escape_string($img_nome);

    // Atualização
    $sql = "UPDATE plantas SET 
                nome_popular_planta = '$nome_popular',
                nome_cientifico_planta = '$nome_cientifico',
                estacao_floracao = '$floracao',
                dados_planta = '$dados',
                resina_planta = '$resina',
                nectar_planta = '$nectar',
                polen_planta = '$polen',
                img_planta = '$img_nome'
            WHERE idplantas = $id";

    if ($conn->query($sql)) {
        header("Location: index_planta.php");
        exit();
    } else {
        echo "<script>alert('Erro ao atualizar: " . $conn->error . "'); window.history.back();</script>";
    }

    $conn->close();
}
?>
