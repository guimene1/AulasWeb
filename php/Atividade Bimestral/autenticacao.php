<?php
require 'bd.php';

class Autenticacao
{
    public function cadastrar($nome, $senha, $apelido)
    {
        global $pdo;

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nome = :nome");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Nome de usuário já utilizado.";
                return;
            }

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, senha, apelido) VALUES (:nome, :senha, :apelido)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':apelido', $apelido);

            if ($stmt->execute()) {
                echo "Usuário cadastrado com sucesso";
            } else {
                echo "Erro ao cadastrar o usuário.";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function login($nome, $senha)
    {
        global $pdo;

        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nome = :nome");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                session_start();
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_apelido'] = $usuario['apelido'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function protegerPagina()
    {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit();
        }
    }
}
//instancia
$autenticado = new Autenticacao();
?>