<?php

// Repositório: https://github.com/DEVEduardoIensen/Markiu

// -----------------------------------------------
// IF e ELSE

// 1.
$idade = 20;
if ($idade >= 18) {
    echo "Você é maior de idade<br>";
} else {
    echo "Você é menor de idade<br>";
}

echo "<br>";

// 2.
$dinheiro = 50000;
if ($dinheiro < 2000) {
    echo "Pobre<br>";
} elseif ($dinheiro < 10000) {
    echo "Classe Média<br>";
} elseif ($dinheiro < 100000) {
    echo "Riquinho<br>";
} elseif ($dinheiro < 1000000000) {
    echo "Ricão<br>";
} else {
    echo "Elon Musk<br>";
}

echo "<br>";

// 3.
$numero1 = 10;
$numero2 = 5;
$operacao = "+";

if ($operacao == "+") {
    echo $numero1 + $numero2;
} elseif ($operacao == "-") {
    echo $numero1 - $numero2;
} elseif ($operacao == "*") {
    echo $numero1 * $numero2;
} elseif ($operacao == "/") {
    echo $numero1 / $numero2;
}

echo "<br><br>";

// -----------------------------------------------
// LOOPS

// 4.
for ($i = 1; $i <= 100; $i++) {
    if ($i % 2 == 0) {
        echo $i . " ";
    }
}

echo "<br><br>";

// 5.
$numeros = [4, 7, 12879.5];
foreach ($numeros as $num) {
    echo "Tabuada do $num:<br>";
    for ($i = 1; $i <= 10; $i++) {
        echo "$num x $i = " . ($num * $i) . "<br>";
    }
    echo "<br>";
}

// -----------------------------------------------
// FUNÇÕES

// 6.
function saudar($nome) {
    echo "Olá " . $nome . "!<br>";
}
saudar("Carlos Johnson");

echo "<br>";

// 7.
function operacoes($n1, $n2) {
    $soma = $n1 + $n2;
    $subtracao = $n1 - $n2;
    echo "Soma: $soma<br>";
    echo "Subtração: $subtracao<br>";
    echo "PHP é incrível!<br>";
}
operacoes(10, 5);

echo "<br>";

// -----------------------------------------------
// ARRAYS

// 8.
$memes = ["Doge", "Gigachad", "Gato da Mesa", "Calabreso", "Flork"];
foreach ($memes as $meme) {
    echo $meme . "<br>";
}

echo "<br>";

// 9.
$papagaios = ["Verdadeiro", "Mangue", "Chauá"];
$papagaios[] = "Imperial";
foreach ($papagaios as $papagaio) {
    echo $papagaio . "<br>";
}

echo "<br>";

// 10.
$pessoa = [
    "Nome" => "Carlos",
    "Idade" => 25,
    "Cidade" => "Curitiba",
    "Tchola" => "Não"
];
foreach ($pessoa as $chave => $valor) {
    echo "$chave: $valor<br>";
}

echo "<br><hr><br>";

// -----------------------------------------------
// FORMULÁRIOS

?>

<!-- 11. Formulário IMC -->
<h3>11. Calculadora de IMC</h3>
<form method="POST">
    Peso: <input type="number" step="any" name="peso"><br><br>
    Altura: <input type="number" step="any" name="altura"><br><br>
    <input type="submit" name="btn_imc" value="Calcular IMC">
</form>

<?php
if (isset($_POST['btn_imc'])) {
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $imc = $peso / ($altura * $altura);
    echo "Seu IMC é: " . $imc . "<br>";
}
?>

<br><hr><br>

<!-- 12. Calculadora HTML -->
<h3>12. Calculadora</h3>
<form method="POST">
    Número 1: <input type="number" name="num1"><br><br>
    Número 2: <input type="number" name="num2"><br><br>
    <input type="submit" name="op" value="Somar">
    <input type="submit" name="op" value="Subtrair">
    <input type="submit" name="op" value="Multiplicar">
    <input type="submit" name="op" value="Dividir">
</form>

<?php
if (isset($_POST['op'])) {
    $n1 = $_POST['num1'];
    $n2 = $_POST['num2'];
    $op = $_POST['op'];

    if ($op == "Somar") {
        echo "Resultado: " . ($n1 + $n2);
    } elseif ($op == "Subtrair") {
        echo "Resultado: " . ($n1 - $n2);
    } elseif ($op == "Multiplicar") {
        echo "Resultado: " . ($n1 * $n2);
    } elseif ($op == "Dividir") {
        echo "Resultado: " . ($n1 / $n2);
    }
}
?>

<br><hr><br>

<!-- 13. Formulário Cadastro -->
<h3>13. Formulário de Cadastro</h3>
<form method="POST">
    Nome: <input type="text" name="nome"><br><br>
    Email: <input type="email" name="email"><br><br>
    Telefone: <input type="text" name="telefone"><br><br>
    Data de nascimento: <input type="date" name="data_nasc"><br><br>
    Cidade: <input type="text" name="cidade"><br><br>
    Estado: <input type="text" name="estado"><br><br>
    Sexo: <input type="text" name="sexo"><br><br>
    Curso: <input type="text" name="curso"><br><br>
    Observações: <textarea name="obs"></textarea><br><br>
    <input type="submit" name="btn_cadastrar" value="Enviar">
</form>

<?php
if (isset($_POST['btn_cadastrar'])) {
    echo "<br>--- CARTÃO DE CADASTRO ---<br>";
    echo "Nome: " . $_POST['nome'] . "<br>";
    echo "Email: " . $_POST['email'] . "<br>";
    echo "Telefone: " . $_POST['telefone'] . "<br>";
    echo "Data de Nascimento: " . $_POST['data_nasc'] . "<br>";
    echo "Cidade: " . $_POST['cidade'] . "<br>";
    echo "Estado: " . $_POST['estado'] . "<br>";
    echo "Sexo: " . $_POST['sexo'] . "<br>";
    echo "Curso: " . $_POST['curso'] . "<br>";
    echo "Observações: " . $_POST['obs'] . "<br>";
}
?>