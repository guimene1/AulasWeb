<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Exercicios php</title>
</head>

<body>
	<h3>1</h3>
	<form method="POST" action="">
		<label for="frase"> Substituição de vogais:</label>
		<input type="text" name="frase">
		<input type="submit" value='Enviar frase'>
	</form>
	<?php
	// Substitua todas as vogais em uma string por asteriscos (*)
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['frase'])) {
		$frase = $_POST['frase'];
		$fraseSubstituida = str_replace(['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O',], '*', $frase);
		if ($fraseSubstituida != '') {
			echo ("Sua frase substituída: $fraseSubstituida");
		} else
			echo "Você não digitou nada.";

	}
	?>

	<br>

	<h3>2</h3>
	<form method="POST" action="">
		<label for="primo">Verificação de número primo:</label>
		<input type="number" name="primo">
		<input type="submit" value="Enviar numero">
	</form>
	<?php
	// Verifique se um número é primo ou não.
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['primo'])) {
		$primo = $_POST["primo"];

		function ehPrimo($numero)
		{
			if ($numero <= 1) {
				return false;
			}
			for ($i = 2; $i <= sqrt($numero); $i++) {
				if ($numero % $i == 0) {
					return false;
				}
			}
			return true;
		}
		if ($primo != "") {
			if (ehPrimo($primo)) {
				echo "O número $primo é primo.";
			} else {
				echo "O número $primo não é primo.";
			}
		} else
			echo "Você não digitou nada.";
	}
	?>
	<br>

	<h3>3</h3>
	<form method="POST" action="">
		<label for="invertida">Inversão de frase:</label>
		<input type="text" name="invertida">
		<input type="submit" value="Enviar texto">
	</form>
	<?php
	// Inverta uma string sem usar a função strrev().
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['invertida'])) {
		$invertida = $_POST["invertida"];

		if ($invertida != "") {
			$invertendo = "";
			$tamanho = strlen($invertida);
			for ($i = $tamanho - 1; $i >= 0; $i--) {
				$invertendo .= $invertida[$i];
			}

			echo "Sua frase invertida é: $invertendo";
		} else {
			echo "Você não digitou nada.";
		}
	}
	?>

	<br>
	<h3>4</h3>
	<form method="POST" action="">
		<label for="positivo"> Verificação positivo/negativo/zero:</label>
		<input type="number" name="positivo">
		<input type="submit" value='Enviar numero'>
	</form>
	<?php
	// Crie uma função que receba um número e retorne se é positivo, negativo ou zero.
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['numero1'])) {
		$numero1 = "";

		function posetivo($numero1)
		{
			if ($numero1 > 0) {
				echo "$numero1 é positivo.";
			} elseif ($numero1 < 0) {
				echo "$numero1 é negativo.";
			} else
				echo "$numero1 é zero.";


		}
		$positivo = $_POST['positivo'];
		if ($positivo != "") {
			posetivo($positivo);
		} else {
			echo 'Você não digitou nada.';
		}


	}
	?>

	<br>
	<h3>5</h3>
	<form method="POST" action="">
		<label for="contar">Contador de palavras</label>
		<input type="text" name="contar">
		<input type="submit" value="Enviar frase">
	</form>
	<?php
	// Conte o número de palavras em uma frase e imprima cada palavra em uma nova linha.
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contar'])) {
		$contar = $_POST['contar'];
		$contadorWord = str_word_count($contar);
		$contadorWordArray = str_word_count($contar, 1);

		echo "$contadorWord palavras.<br>";

		foreach ($contadorWordArray as $palavra) {
			echo $palavra . "<br>";
		}
	}
	?>

	<h3>6</h3>
	<form method="POST" action="">
		<label for="palindromo">Verificação de Palindromos:</label>
		<input type="text" name="palindromo">
		<input type="submit" value="Enviar palavra">
	</form>
	<?php
	// Crie uma função que verifique se uma palavra é um palíndromo.
	function verificarPalindromo($palavra)
	{
		if ($palavra != "") {
			$invertendo = "";
			$tamanho = strlen($palavra);
			for ($i = $tamanho - 1; $i >= 0; $i--) {
				$invertendo .= $palavra[$i];
			}
			if ($invertendo == $palavra) {
				return "$palavra é um palíndromo. Palavra: $palavra | Inversão: $invertendo.";
			} else {
				return "$palavra não é um palíndromo. Palavra: $palavra | Inversão: $invertendo.";
			}
		} else {
			return "Você não digitou nada.";
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['palindromo'])) {
		$palindromo = $_POST["palindromo"];
		echo verificarPalindromo($palindromo);
	}
	?>

	<br>
	<h3>7</h3>
	<form method="POST" action="">
		<label for="multiplos">Substituição de múltiplos de 3 por X</label>
		<input type="submit" name="multiplos" value="Imprimir valores de 1 a 20">
	</form>

	<?php
	// Crie um programa que imprima os números de 1 a 20, substituindo múltiplos de 3 por X
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['multiplos'])) {
		for ($i = 1; $i < 21; $i++) {
			if ($i % 3 == 0) {
				echo 'X';
				echo ' ';
			} else
				echo "$i ";

		}
	}
	?>

	<br>
	<h3>8</h3>
	<form method="POST" action="">
		<label for="espacos">Removedor de espaços</label>
		<input type="text" name="espacos">
		<input type="submit" value="Enviar texto">
	</form>
	<?php
	// Crie uma função que remova os espaços em branco de uma string.
	function substituir($semespaco)
	{
		$substituir = str_replace(' ', '', $semespaco);
		return $substituir;
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['espacos'])) {
		$espacos = $_POST['espacos'];
		$substituicao = substituir($espacos);
		echo "Sua frase sem espaços: $substituicao";
	}
	?>

	<br>
	<h3>9</h3>
	<form method="POST" action="">
		<label for="fibonacci">Sequência de Fibonacci até 10:</label>
		<input type="submit" name="fibonacci">
	</form>
	<?php
	// Crie um programa que calcule e imprima os números Fibonacci até o décimo termo.
	function fibonacci1($n)
	{
		$fib = [0, 1];
		for ($i = 2; $i < $n; $i++) {
			$fib[$i] = $fib[$i - 1] + $fib[$i - 2];
		}
		return $fib;
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fibonacci'])) {
		$fibon = fibonacci1(10);
		foreach ($fibon as $numero) {
			echo $numero . " ";
		}
	}


	?>

	<br>
	<h3>10</h3>
	<form method="POST" action="">
		<label for="pangrama">Verificação de Pangrama:</label>
		<input type="text" name="pangrama">
		<input type="submit" value="Enviar pangrama">
	</form>

	<?php
	// Crie uma função que receba um texto e retorne se é um pangrama (contém todas as letras do alfabeto pelo menos uma vez).
	function pangramas($texto)
	{
		$texto = strtolower($texto);
		$alfabeto = range('a', 'z');

		foreach ($alfabeto as $letra) {
			if (strpos($texto, $letra) === false) {
				return false;
			}
		}

		return true;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pangrama'])) {
		$pangrama = $_POST['pangrama'];
		if (pangramas($pangrama)) {
			echo "Seu texto é um pangrama. | $pangrama";
		} else {
			echo "Seu texto não é um pangrama. | $pangrama";
		}
	}
	?>
</body>

</html>