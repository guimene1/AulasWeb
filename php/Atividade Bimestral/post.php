<?php
class Post
{
    private $apelido;
    private $jogo;
    private $tempoJogado;
    private $recomenda;
    private $descricao;
    private $id;

    public function __construct($apelido, Jogo $jogo, $tempoJogado, $recomenda, $descricao)
    {
        $this->apelido = $apelido;
        $this->jogo = $jogo;
        $this->tempoJogado = $tempoJogado;
        $this->recomenda = $recomenda;
        $this->descricao = $descricao;
    }

    public static function listarJogos(): array
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM jogos ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionarPost(): string
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("INSERT INTO posts (apelido, jogo, tempoJogado, recomenda, descricao) VALUES (:apelido, :jogo, :tempoJogado, :recomenda, :descricao)");

            $jogoId = $this->jogo->getId();

            $stmt->bindParam(':apelido', $this->apelido);
            $stmt->bindParam(':jogo', $jogoId, PDO::PARAM_INT);
            $stmt->bindParam(':tempoJogado', $this->tempoJogado, PDO::PARAM_INT);
            $stmt->bindParam(':recomenda', $this->recomenda, PDO::PARAM_BOOL);
            $stmt->bindParam(':descricao', $this->descricao);

            if ($stmt->execute()) {
                $this->id = $pdo->lastInsertId();
                return "Post adicionado!";
            }
            return "Erro ao postar.";

        } catch (PDOException $e) {
            return "Erro no banco de dados: " . $e->getMessage();
        }
    }

    public function listarPosts(): array
    {
        global $pdo;
        $stmt = $pdo->query("SELECT posts.*, jogos.nome as jogo_nome, jogos.categoria as jogo_categoria, jogos.ano as jogo_ano 
                            FROM posts 
                            JOIN jogos ON posts.jogo = jogos.id 
                            ORDER BY posts.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}