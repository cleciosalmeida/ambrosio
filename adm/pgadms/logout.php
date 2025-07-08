<?php
session_start(); // Inicia a sessão
session_unset(); // Remove todas as variáveis de sessão
session_destroy(); // Destroi a sessão

// Redireciona para a página de login (ajuste o caminho conforme necessário)
header("Location: ../admin.html");
exit;
?>
