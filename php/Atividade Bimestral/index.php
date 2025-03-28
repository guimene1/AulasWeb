<?php
require 'autenticacao.php';
require 'ADM\admin.php';
require 'post.php';
require 'jogo.php';

$autenticado->protegerPagina();
$usuario_nome = $_SESSION['usuario_nome'];
$usuario_apelido = $_SESSION['usuario_apelido'];


$post = new Post('', new Jogo(null), 0, false, '');
$posts = $post->listarPosts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WalkinGear-Página Inicial</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header">
        <div class="logo-container">
            <img src="WalkinGear.png" alt="Logo WalkinGear" class="logo">
            <h1>WalkinGear</h1>
        </div>
        <div class="user-info">
            <h2>Bem-vindo, <?php echo htmlspecialchars($usuario_apelido); ?>!</h2>
            <p>Logado como <strong><?php echo htmlspecialchars($usuario_nome); ?></strong></p>
            <nav class="nav">
                <?php
                if ($usuario_nome == "admin") {
                    echo "<a href='ADM\adm.php'>Área Admin</a>";
                }
                ?>
                <a href="criarPost.php">Criar um post</a>
                <a href="logout.php">Deslogar</a>
            </nav>
        </div>

    </header>

    <main class="container">
        <h2>Últimos Posts</h2>

        <?php if (empty($posts)): ?>
            <p>Nenhum post encontrado.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <article class="post">
                    <div class="post-header">
                        <span><strong><?php echo htmlspecialchars($post['apelido']); ?></strong></span>
                    </div>

                    <p class="jogo-info">
                        <strong>
                            Jogo: <?php echo htmlspecialchars($post['jogo_nome']); ?>
                            (<?php echo htmlspecialchars($post['jogo_categoria']); ?>,
                            <?php echo $post['jogo_ano']; ?>)
                        </strong>
                    </p>

                    <p><strong>Tempo jogado:</strong> <?php echo $post['tempoJogado']; ?> horas</p>

                    <p>
                        <strong>Recomenda:</strong>
                        <span class="<?php echo $post['recomenda'] ? 'recomenda' : 'nao-recomenda'; ?>">
                            <?php echo $post['recomenda'] ? 'Sim' : 'Não'; ?>
                        </span>
                    </p>

                    <div class="post-content">
                        <p><?php echo nl2br(htmlspecialchars($post['descricao'])); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</body>

</html>