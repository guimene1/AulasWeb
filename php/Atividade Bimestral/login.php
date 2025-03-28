<?php
require 'Autenticacao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if ($autenticado->login($nome, $senha)) {
        header("Location: index.php");
        exit();
    } else {
        $erro = "Nome de usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WalkinGear-Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="container">
        <h1>Login</h1>
        
        <form method="POST" action="" class="form-login">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            
            <button type="submit" class="btn">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a>.</p>
    </main>
</body>
</html>