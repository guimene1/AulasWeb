<?php
require '..\bd.php';
require '..\jogo.php';
require 'admin.php';
require '..\autenticacao.php';

$mensagem = '';
$jogo = new Jogo();

$autenticado->protegerPagina();
$usuario_nome = $_SESSION['usuario_nome'];
$admin = new admin($usuario_nome);
$admin->verificarAdm();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
    $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);

    if ($nome && $categoria && $ano) {
        try {
            $jogo->setNome($nome);
            $jogo->setCategoria($categoria);
            $jogo->setAno($ano);

            $mensagem = $jogo->adicionarJogo();
            header("Location: ..\index.php");
        } catch (TypeError $e) {
            $mensagem = "Erro nos dados: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos corretamente!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\style.css">
    <title>WalkinGear-Adicionar Jogo</title>
</head>

<body>
    <div class="form-container">
        <h1>Adicionar Novo Jogo</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nome">Nome do Jogo:</label>
                <input type="text" id="nome" name="nome" required>
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
                <input type="number" id="ano" name="ano" min="1950" max="<?php echo date('Y') + 1; ?>" required>
            </div>

            <button type="submit">Adicionar Jogo</button>
        </form>
    </div>
</body>

</html>