<?php
require 'bd.php';
require 'jogo.php';
require 'post.php';
require 'autenticacao.php';

$autenticado->protegerPagina();
$usuario_nome = $_SESSION['usuario_nome'];
$usuario_apelido = $_SESSION['usuario_apelido'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jogo = new Jogo($_POST['jogo']);
    if (!$jogo->carregarJogo()) {
        die("Jogo inválido");
    }

    $post = new Post(
        $usuario_apelido,
        $jogo,
        $_POST['tempoJogado'],
        $_POST['recomenda'] === '1',
        $_POST['descricao']
    );

    $resultado = $post->adicionarPost();
    echo "<p>$resultado</p>";
    header("Location: index.php");
}

$jogos = Post::listarJogos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>WalkinGear-Criar Post</title>
</head>

<body>
    <h1>Criar Novo Post</h1>

    <form method="post">
        <div>
            <label for="jogo">Jogo:</label>
            <select id="jogo" name="jogo" required>
                <option value="">Selecione um jogo</option>
                <?php foreach ($jogos as $jogo): ?>
                    <option value="<?= $jogo['id'] ?>">
                        <?= htmlspecialchars($jogo['nome']) ?>
                        (<?= htmlspecialchars($jogo['categoria']) ?>,
                        <?= $jogo['ano'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="tempoJogado">Tempo jogado (horas):</label>
            <input type="number" id="tempoJogado" name="tempoJogado" min="1" required>
        </div>

        <div>
            <label for="recomenda">Recomenda?</label>
            <select id="recomenda" name="recomenda" required>
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>

        <div>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>
        </div>

        <button type="submit">Criar Post</button>
    </form>

    <p><a href="index.php">Ver todos os posts</a></p>
</body>

</html>