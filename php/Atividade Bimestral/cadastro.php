<?php
require 'Autenticacao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST,'nome', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST,'senha',FILTER_SANITIZE_STRING);
    $apelido = filter_input(INPUT_POST,'apelido',FILTER_SANITIZE_STRING);

    $autenticado->cadastrar($nome, $senha, $apelido);
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>WalkinGear-Cadastro</title>
</head>

<body>
    <h1>Cadastro de Usuário</h1>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="apelido">Apelido:</label>
        <input type="text" id="apelido" name="apelido" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
</body>

</html>