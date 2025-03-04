<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="">
        <h2>Sistema de Notas</h2>
        <label for="aluno">Insira seu nome:</label>
        <input type="text" name="aluno" required>
        <label for="nota">Insira sua nota:</label>
        <input type="number" name="nota" required>
        <input type="submit" value="Enviar">

    </form>
    <br>
    <form method="POST" action="">
        <input type="submit" name="media" value="Calcular médias." ;>
    </form>
    <br>
    <form method="POST" action="">
        <input type="submit" value="Mostrar notas" name="mostrar">
    </form>
    <br>
    <form method="POST" action="">
        <input type="submit" value="Apagar tudo" name="apagar">
    </form>
    <br>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['nota']) && isset($_POST['aluno'])) {
            $aluno = $_POST["aluno"];
            $nota = intval($_POST["nota"]);
            if ($nota <= 10 && $nota >= 0) {
                $arquivo = "notas.txt";
                $handle = fopen("$arquivo", "a");
                $dados = "Aluno: $aluno Nota: $nota \n";
                fwrite($handle, $dados);
                fclose($handle);

                $media = "mediana.txt";
                $escrita = "$nota \n";
                $escreveMedia = fopen($media, "a");
                fwrite($escreveMedia, $escrita);
                fclose($escreveMedia);

                echo "Sua nota foi registrada.";
            } else {
                echo "Sua nota não foi registrada, a nota deve ser maior que 0 e menor que 10.";
            }
        }
        if (isset($_POST["media"])) {
            $arquivo = "mediana.txt";
            $ler = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $soma = 0;
            $contador = 0;

            foreach ($ler as $linha) {
                $numero = floatval($linha);
                $soma += $numero;
                $contador++;
            }

            if ($contador > 0) {
                $media = $soma / $contador;
                echo "A média das notas é: " . number_format($media, 2);
            } else {
                echo "Não há notas para calcular a média.";
            }
        }
        if (isset($_POST['mostrar'])) {
            $arquivo = "notas.txt";
            $conteudo = file_get_contents("$arquivo");
            echo "<pre>" . $conteudo . "</pre>";
        }
        if (isset($_POST['apagar'])) {
            $arquivo = "notas.txt";
            $arquivo2 = "mediana.txt";
            $handle = fopen("$arquivo", "w");
            $handle2 = fopen("$arquivo2", "w");
            fwrite($handle, "");
            fwrite($handle2, "");
            fclose($handle);
            fclose($handle2);

        }
    }
    ?>




</body>

</html>