<?php
require 'admin.php';
require '..\autenticacao.php';

$autenticado->protegerPagina();
$usuario_nome = $_SESSION['usuario_nome'];
$admin = new admin($usuario_nome);
$admin->verificarAdm();


?>

<!DOCTYPE html>

<html lang="en">
<link rel="stylesheet" href="..\style.css">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aba do Admin</title>
</head>

<body>
    <h2>Área do admin</h2>
    <p><a href="adicionarJogo.php">Adicionar Jogos</a></p>
    <p><a href="listarJogo.php">Editar Jogos</a></p>
    <p><a href="..\index.php">Voltar</a></p>
</body>

</html>