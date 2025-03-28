<?php
require '..\bd.php';
require '..\jogo.php';
require 'admin.php';
require '..\autenticacao.php';

$autenticado->protegerPagina();
$usuario_nome = $_SESSION['usuario_nome'];
$admin = new admin($usuario_nome);
$admin->verificarAdm();

$idJogo = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$idJogo) {
    $_SESSION['mensagem_erro'] = "ID do jogo inválido";
    header("Location: listarJogos.php");
    exit();
}

$jogo = new Jogo($idJogo);

if (!$jogo->carregarJogo()) {
    $_SESSION['mensagem_erro'] = "Jogo não encontrado";
    header("Location: listarJogos.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    if ($nome && $categoria && $ano) {
        try {
            $jogo->setNome($nome);
            $jogo->setCategoria($categoria);
            $jogo->setAno($ano);

            $mensagem = $jogo->editarJogo();
            $_SESSION['mensagem_sucesso'] = $mensagem;
            header("Location: adm.php");
            exit();
        } catch (TypeError $e) {
            $_SESSION['mensagem_erro'] = "Erro nos dados: " . $e->getMessage();
        }
    } else {
        $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos corretamente!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WalkinGear-Editar Jogo</title>
    <link rel="stylesheet" href="..\style.css">
</head>

<body>
    <div class="form-container">
        <h1>Editar Jogo</h1>

        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="mensagem erro"><?= htmlspecialchars($_SESSION['mensagem_erro']) ?></div>
            <?php unset($_SESSION['mensagem_erro']); ?>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome do Jogo:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($jogo->getNome()) ?>" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="Ação">Ação</option>
                    <option value="Aventura">Aventura</option>
                    <option value="RPG">RPG</option>
                    <option value="Estratégia">Estratégia</option>
                    <option value="Esportes">Esportes</option>
                    <option value="Luta">Luta</option>
                    <option value="Terror">Terror</option>
                    <option value="Sobrevivência">Sobrevivência</option>
                    <option value="Gerenciamento">Gerenciamento</option>
                    <option value="Simulação">Simulação</option>
                    <option value="Competitivo">Competitivo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ano">Ano de Lançamento:</label>
                <input type="number" id="ano" name="ano" min="1950" max="<?= date('Y') + 1 ?>"
                    value="<?= $jogo->getAno() ?>" required>
            </div>

            <button type="submit">Salvar Alterações</button>
            <a href="listarJogo.php">Cancelar</a>
        </form>
    </div>
</body>

</html>