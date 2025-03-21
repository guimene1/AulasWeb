<?php
session_start();
class Produto
{
    protected $nome;
    protected $preco;
    protected $quantidade;

    public function __construct($nome, $preco, $quantidade)
    {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getPreco()
    {
        return $this->preco;
    }

    public function setPreco($preco)
    {
        $this->preco = $preco;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function aplicarDesconto($desconto)
    {
        $this->preco = $this->preco - ($this->preco * ($desconto / 100));
    }
}

class Estoque
{
    protected $produtos = [];

    public function adicionarProduto($nome, $preco, $quantidade)
    {
        $produto = new Produto($nome, $preco, $quantidade);
        $this->produtos[] = $produto;
        echo "<br>Produto '$nome' adicionado ao estoque.";
    }

    public function listarProdutos()
    {
        if (empty($this->produtos)) {
            echo "<br>Nenhum produto no estoque.";
        } else {
            echo "<br>Produtos no estoque:";
            foreach ($this->produtos as $produto) {
                echo "<br>Nome: " . $produto->getNome() . ", Preço: R$" . number_format($produto->getPreco(), 2) . ", Quantidade: " . $produto->getQuantidade();
            }
        }
    }

    public function calcularValorTotal()
    {
        $total = 0;
        foreach ($this->produtos as $produto) {
            $total += $produto->getPreco() * $produto->getQuantidade();
        }
        echo "<br>Valor total do estoque: R$" . number_format($total, 2);
    }

    public function buscarProduto($nome)
    {
        foreach ($this->produtos as $produto) {
            if ($produto->getNome() === $nome) {
                echo "<br>Produto encontrado: Nome: " . $produto->getNome() . ", Preço: R$" . number_format($produto->getPreco(), 2) . ", Quantidade: " . $produto->getQuantidade();
                return $produto;
            }
        }
        echo "<br>Produto não encontrado: $nome";
        return null;
    }

    public function removerProduto()
    {
        $this->produtos = [];
        echo "<br>Todos os produtos foram removidos do estoque.";
    }

    public function atualizarQuantidadeProduto($nome, $quantidade)
    {
        $produto = $this->buscarProduto($nome);
        if ($produto) {
            $produto->setQuantidade($quantidade);
            echo "<br>Quantidade do produto '" . $produto->getNome() . "' atualizada para: " . $quantidade;
        } else {
            echo "<br>Produto não encontrado.";
        }
    }

    public function aplicarDesconto($nome, $desconto)
    {
        $produto = $this->buscarProduto($nome);
        if ($produto) {
            $produto->aplicarDesconto($desconto);
            echo "<br>Desconto de $desconto% aplicado ao produto '" . $produto->getNome() . "'. Novo preço: R$" . number_format($produto->getPreco(), 2);
        } else {
            echo "<br>Produto não encontrado.";
        }
    }
}

if (!isset($_SESSION['estoque'])) {
    $_SESSION['estoque'] = new Estoque();
}

$estoque = $_SESSION['estoque'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['nome']) && isset($_POST['preco']) && isset($_POST['quantidade'])) {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];
        $estoque->adicionarProduto($nome, $preco, $quantidade);
    }
    if (isset($_POST['remover'])) {
        $estoque->removerProduto();
    }
    if (isset($_POST['lista'])) {
        $estoque->listarProdutos();
    }
    if (isset($_POST['nomeb'])) {
        $nome = $_POST['nomeb'];
        $estoque->buscarProduto($nome);
    }
    if (isset($_POST['valor'])) {
        $estoque->calcularValorTotal();
    }
    if (isset($_POST['atualizar']) && isset($_POST['qatualizar'])) {
        $nome = $_POST['atualizar'];
        $quantidade = $_POST['qatualizar'];
        $estoque->atualizarQuantidadeProduto($nome, $quantidade);
    }
    if (isset($_POST['prodesconto']) && isset($_POST['desconto'])) {
        $nome = $_POST['prodesconto'];
        $desconto = $_POST['desconto'];
        $estoque->aplicarDesconto($nome, $desconto);
    }
}

$_SESSION['estoque'] = $estoque;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>

<body>

    <h2>Sistema de gerenciamento de Produtos</h2>

    <form method="POST" action="">
        <label for="adicionar">Adicionar produto</label>
        <br>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label for="preco">Preço:</label>
        <input type="number" name="preco" required>
        <br>
        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" required>
        <input type="submit" value="Adicionar">
    </form>

    <form method="POST" action="">
        <label for="remover">Remover todos os produtos</label>
        <br>
        <input type="submit" name="remover" value="Remover">
    </form>

    <form method="POST" action="">
        <label for="lista">Listar produtos</label>
        <br>
        <input type="submit" name="lista" value="Listar">
    </form>

    <form method="POST" action="">
        <label for="busca">Buscar Produto Específico</label>
        <br>
        <label for="nomeb">Nome:</label>
        <input type="text" name="nomeb">
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <form method="POST" action="">
        <label for="valor">Valor total do estoque</label>
        <br>
        <input type="submit" name="valor" value="Calcular">
    </form>

    <form method="POST" action="">
        <label for="atualizar">Atualizar quantidade de um produto</label>
        <br>
        <label for="atualizar">Nome:</label>
        <input type="text" name="atualizar" required>
        <br>
        <label for="qatualizar">Quantidade:</label>
        <input type="number" name="qatualizar" required>
        <input type="submit" value="Atualizar">
    </form>

    <form method="POST" action="">
        <label for="desconto">Aplicar desconto a um produto</label>
        <br>
        <label for="prodesconto">Nome:</label>
        <input type="text" name="prodesconto" required>
        <br>
        <label for="desconto">Desconto (%):</label>
        <input type="number" name="desconto" required>
        <input type="submit" value="Aplicar">
    </form>
</body>

</html>