<?php
require '..\bd.php';
require '..\jogo.php';
require '..\autenticacao.php';
require 'admin.php';

$autenticado->protegerPagina();
$usuario_nome = $_SESSION['usuario_nome'];
$admin = new admin($usuario_nome);
$admin->verificarAdm();

function listarJogos()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM jogos");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$listar = listarJogos();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\style.css">
    <title>WalkinGear</title>
</head>

<body>
    <?php foreach ($listar as $jogo): ?>
        <li>
            <a href="editarJogo.php?id=<?= $jogo['id'] ?>" class="link-jogo">
                <?= htmlspecialchars($jogo['nome']) ?> -
                <?= htmlspecialchars($jogo['categoria']) ?>
                (<?= (int) $jogo['ano'] ?>)
            </a>
        </li>
    <?php endforeach; ?>
</body>

</html>