<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
</head>

<body>
    <?php
    session_start();


    //login 
    

    function estaLogado()
    {
        return isset($_SESSION['logado']) && $_SESSION['logado'] === true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        if ($usuario === 'admin' && $senha === '123') {
            $_SESSION['logado'] = true;
        } else {
            echo "<p>Usuário ou senha incorretos.</p>";
        }
    }

    if (isset($_GET['logout'])) {
        unset($_SESSION['logado']);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    if (!estaLogado()) {
        ?>
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" placeholder="Digite o usuário" required>
            <br>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" placeholder="Digite a senha" required>
            <br>
            <input type="submit" name="login" value="Entrar">
        </form>
        <?php
        exit();
    }
    ?>

    <h2>Cadastro de Alunos</h2>
    <p>Bem-vindo, admin! <a href="?logout=true">Logout</a></p>

    <form method="POST" action="">
        <h3>Preencha as informações abaixo:</h3>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" placeholder="Seu nome" required>
        <br>
        <label for="matricula">Matricula:</label>
        <input type="number" name="matricula" placeholder="Sua matricula" required>
        <br>
        <label for="curso">Curso:</label>
        <input type="text" name="curso" placeholder="Seu curso" required>
        <br>
        <br>
        <input type="submit" value="Cadastrar">
        <br>
        <br>
    </form>
    <form method="POST" action="">
        <input type="submit" value="Mostrar cadastros" name="cadastros">
    </form>
    <br>
    <form method="POST" action="">
        <input type="submit" value="Apagar cadastros" name="apagar">
    </form>
    <br>
    <form method="POST" action="">
        <label for="deletaraluno">Digite o nome do aluno que deseja deletar o cadastro:</label>
        <br>
        <input type="text" placeholder="Nome do aluno" name="deletaraluno">
        <input type="submit" value="Apagar cadastros">
        <br>
    </form>
    <br>

    <?php
    //php script
    class Aluno
    {
        private $nome;
        private $matricula;
        private $curso;

        public function __construct($nome, $matricula, $curso)
        {
            $this->nome = $nome;
            $this->matricula = $matricula;
            $this->curso = $curso;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function getMatricula()
        {
            return $this->matricula;
        }

        public function getCurso()
        {
            return $this->curso;
        }
    }

    class CadastroAlunos
    {
        private $alunos = [];

        public function __construct()
        {
            if (isset($_SESSION['alunos'])) {
                $this->alunos = $_SESSION['alunos'];
            }
        }

        public function cadastrarAluno($nome, $matricula, $curso)
        {
            $aluno = new Aluno($nome, $matricula, $curso);
            $this->alunos[] = $aluno;
            $_SESSION['alunos'] = $this->alunos;
            echo "Aluno cadastrado com sucesso: $nome<br>";
        }

        public function deletarAluno($nomeAluno)
        {
            foreach ($this->alunos as $indice => $aluno) {
                if ($aluno->getNome() == $nomeAluno) {
                    unset($this->alunos[$indice]);
                    $this->alunos = array_values($this->alunos);
                    $_SESSION['alunos'] = $this->alunos;
                    echo "Aluno '$nomeAluno' removido.<br>";
                    return;
                }
            }
            echo "Aluno '$nomeAluno' não encontrado.<br>";
        }

        public function listarAlunos()
        {
            if (empty($this->alunos)) {
                echo "Nenhum aluno cadastrado.<br>";
            } else {
                echo "<h3>Alunos Cadastrados:</h3>";
                foreach ($this->alunos as $aluno) {
                    echo "Aluno: " . $aluno->getNome() . ", Matrícula: " . $aluno->getMatricula() . ", Curso: " . $aluno->getCurso() . "<br>";
                }
            }
        }

        public function apagarAlunos()
        {
            $this->alunos = [];
            $_SESSION['alunos'] = $this->alunos;
            echo "Os cadastros foram excluídos.";
        }
    }

    $cadastro = new CadastroAlunos();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['nome']) && isset($_POST['matricula']) && isset($_POST['curso'])) {
            $nome = $_POST['nome'];
            $matricula = $_POST['matricula'];
            $curso = $_POST['curso'];
            $cadastro->cadastrarAluno($nome, $matricula, $curso);
        }
        if (isset($_POST['cadastros'])) {
            $cadastro->listarAlunos();
        }
        if (isset($_POST['apagar'])) {
            $cadastro->apagarAlunos();
        }
        if (isset($_POST['deletaraluno'])) {
            $deletarAluno = $_POST['deletaraluno'];
            $cadastro->deletarAluno($deletarAluno);
        }
    }
    ?>
</body>

</html>