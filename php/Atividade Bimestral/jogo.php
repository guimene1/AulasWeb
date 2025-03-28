<?php
require 'bd.php';

class Jogo
{
    private string $nome;
    private string $categoria;
    private int $ano;
    private ?int $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }
    public function setCategoria(string $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function getAno(): int
    {
        return $this->ano;
    }
    public function setAno(int $ano): void
    {
        $this->ano = $ano;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function carregarJogo(): bool
    {
        global $pdo;

        if (!$this->id) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("SELECT nome, categoria, ano FROM jogos WHERE id = :id");
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dados) {
                $this->nome = $dados['nome'];
                $this->categoria = $dados['categoria'];
                $this->ano = $dados['ano'];
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erro ao carregar jogo: " . $e->getMessage());
            return false;
        }
    }
    public function editarJogo(): string
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("UPDATE jogos SET nome = :nome, categoria = :categoria, ano = :ano WHERE id = :id");

            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':ano', $this->ano, PDO::PARAM_INT);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "Jogo atualizado com sucesso!";
            }
            return "Erro ao atualizar jogo.";
        } catch (PDOException $e) {
            return "Erro no banco de dados: " . $e->getMessage();
        }
    }
    public function adicionarJogo(): string
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("INSERT INTO jogos (nome, categoria, ano) VALUES (:nome, :categoria, :ano)");

            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':categoria', $this->categoria);
            $stmt->bindParam(':ano', $this->ano);

            if ($stmt->execute()) {
                $this->id = $pdo->lastInsertId();
                return "Jogo adicionado com sucesso!";
            }
            return "Erro ao adicionar jogo.";

        } catch (PDOException $e) {
            return "Erro no banco de dados: " . $e->getMessage();
        }
    }
}