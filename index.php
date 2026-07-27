<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercícios de PHP - Markiu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --card-border: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent: #6366f1;
            --accent-hover: #4f46e5;
            --success: #22c55e;
            --input-bg: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            padding: 2rem 1rem;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--card-border);
        }

        header h1 {
            font-size: 2rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        header p {
            color: var(--text-secondary);
        }

        .repo-link {
            display: inline-block;
            margin-top: 1rem;
            color: #818cf8;
            text-decoration: none;
            font-weight: 500;
        }

        .repo-link:hover {
            text-decoration: underline;
        }

        .section-title {
            font-size: 1.5rem;
            color: #818cf8;
            margin: 2.5rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--card-border);
        }

        .exercise-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .exercise-card h3 {
            font-size: 1.1rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .exercise-card h3 span {
            background: var(--accent);
            color: #fff;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .result-box {
            background: var(--input-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            color: #38bdf8;
            font-family: monospace;
            white-space: pre-line;
        }

        form {
            display: grid;
            gap: 1rem;
            margin-top: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        label {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        input, select, textarea {
            background: var(--input-bg);
            border: 1px solid var(--card-border);
            color: var(--text-primary);
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.95rem;
            width: 100%;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--accent);
        }

        button, .btn {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover, .btn:hover {
            background: var(--accent-hover);
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .card-cadastro {
            background: linear-gradient(135deg, #1e1b4b 0%, #311042 100%);
            border: 2px solid var(--accent);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        }

        .card-cadastro h4 {
            color: #a78bfa;
            font-size: 1.3rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 0.5rem;
        }

        .card-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .card-item strong {
            color: var(--text-secondary);
            font-size: 0.85rem;
            display: block;
            text-transform: uppercase;
        }

        .card-item span {
            color: var(--text-primary);
            font-size: 1.05rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">

    <header>
        <h1>Resolução dos Exercícios de PHP</h1>
        <p>Desenvolvido por Eduardo Iensen</p>
        <a class="repo-link" href="https://github.com/DEVEduardoIensen/Markiu" target="_blank">🔗 Repositório GitHub: DEVEduardoIensen/Markiu</a>
    </header>

    <!-- SECTION: IF E ELSE -->
    <h2 class="section-title">IF e ELSE</h2>

    <!-- Exercício 1 -->
    <div class="exercise-card">
        <h3><span>Ex 1</span> Verificação de Idade</h3>
        <div class="result-box"><?php
            $idade = 20;
            if ($idade >= 18) {
                echo "Você é maior de idade";
            } else {
                echo "Você é menor de idade";
            }
        ?></div>
    </div>

    <!-- Exercício 2 -->
    <div class="exercise-card">
        <h3><span>Ex 2</span> Classificação Financeira</h3>
        <div class="result-box"><?php
            $dinheiro = 50000;
            if ($dinheiro < 2000) {
                echo "Pobre";
            } elseif ($dinheiro < 10000) {
                echo "Classe Média";
            } elseif ($dinheiro < 100000) {
                echo "Riquinho";
            } elseif ($dinheiro < 1000000000) {
                echo "Ricão";
            } else {
                echo "Elon Musk";
            }
        ?></div>
    </div>

    <!-- Exercício 3 -->
    <div class="exercise-card">
        <h3><span>Ex 3</span> Operação Matemática (Switch / If)</h3>
        <div class="result-box"><?php
            $numero1 = 10;
            $numero2 = 5;
            $operacao = "+";

            switch ($operacao) {
                case "+":
                    echo "$numero1 + $numero2 = " . ($numero1 + $numero2);
                    break;
                case "-":
                    echo "$numero1 - $numero2 = " . ($numero1 - $numero2);
                    break;
                case "*":
                    echo "$numero1 * $numero2 = " . ($numero1 * $numero2);
                    break;
                case "/":
                    if ($numero2 != 0) {
                        echo "$numero1 / $numero2 = " . ($numero1 / $numero2);
                    } else {
                        echo "Divisão por zero não é permitida";
                    }
                    break;
                default:
                    echo "Operação inválida";
            }
        ?></div>
    </div>

    <!-- SECTION: LOOPS -->
    <h2 class="section-title">LOOPS</h2>

    <!-- Exercício 4 -->
    <div class="exercise-card">
        <h3><span>Ex 4</span> Números Pares de 1 até 100</h3>
        <div class="result-box"><?php
            $pares = [];
            for ($i = 1; $i <= 100; $i++) {
                if ($i % 2 === 0) {
                    $pares[] = $i;
                }
            }
            echo implode(", ", $pares);
        ?></div>
    </div>

    <!-- Exercício 5 -->
    <div class="exercise-card">
        <h3><span>Ex 5</span> Tabuada dos Números (4, 7 e 12.879,5)</h3>
        <div class="result-box"><?php
            $numerosTabuada = [4, 7, 12879.5];

            foreach ($numerosTabuada as $num) {
                $numFormatado = number_format($num, ($num == floor($num) ? 0 : 1), ',', '.');
                echo "--- TABUADA DO $numFormatado ---\n";
                for ($i = 1; $i <= 10; $i++) {
                    $resultado = $num * $i;
                    $resFormatado = number_format($resultado, ($resultado == floor($resultado) ? 0 : 2), ',', '.');
                    echo "$numFormatado x $i = $resFormatado\n";
                }
                echo "\n";
            }
        ?></div>
    </div>

    <!-- SECTION: FUNÇÕES -->
    <h2 class="section-title">FUNÇÕES</h2>

    <!-- Exercício 6 -->
    <div class="exercise-card">
        <h3><span>Ex 6</span> Função de Saudação</h3>
        <div class="result-box"><?php
            function saudar($nome) {
                return "Olá " . $nome . "!";
            }
            echo saudar("Carlos Johnson");
        ?></div>
    </div>

    <!-- Exercício 7 -->
    <div class="exercise-card">
        <h3><span>Ex 7</span> Função de Operações e Frase</h3>
        <div class="result-box"><?php
            function operacoesEFrase($n1, $n2) {
                $soma = $n1 + $n2;
                $subtracao = $n1 - $n2;
                $frase = "A programação PHP une a precisão da matemática com o poder da criação!";
                return [
                    'soma' => $soma,
                    'subtracao' => $subtracao,
                    'frase' => $frase
                ];
            }

            $resFuncao = operacoesEFrase(15, 7);
            echo "Soma: " . $resFuncao['soma'] . "\n";
            echo "Subtração: " . $resFuncao['subtracao'] . "\n";
            echo "Frase Incrível: " . $resFuncao['frase'];
        ?></div>
    </div>

    <!-- SECTION: ARRAYS -->
    <h2 class="section-title">ARRAYS</h2>

    <!-- Exercício 8 -->
    <div class="exercise-card">
        <h3><span>Ex 8</span> Lista de Memes (com foreach)</h3>
        <div class="result-box"><?php
            $memes = ["Doge", "Gigachad", "Gato da Mesa", "Calma Calabreso", "Flork"];
            foreach ($memes as $meme) {
                echo "• " . $meme . "\n";
            }
        ?></div>
    </div>

    <!-- Exercício 9 -->
    <div class="exercise-card">
        <h3><span>Ex 9</span> Raças de Papagaio ($array[] =)</h3>
        <div class="result-box"><?php
            $papagaios = ["Papagaio-verdadeiro", "Papagaio-do-mangue", "Papagaio-chauá"];
            $papagaios[] = "Papagaio-imperial"; // Adicionando mais uma raça

            foreach ($papagaios as $papagaio) {
                echo "• " . $papagaio . "\n";
            }
        ?></div>
    </div>

    <!-- Exercício 10 -->
    <div class="exercise-card">
        <h3><span>Ex 10</span> Array Associativo (Pessoa)</h3>
        <div class="result-box"><?php
            $pessoa = [
                "Nome" => "Carlos Johnson",
                "Idade" => 25,
                "Cidade" => "Curitiba",
                "Tchola" => "Não"
            ];

            foreach ($pessoa as $chave => $valor) {
                echo "$chave: $valor\n";
            }
        ?></div>
    </div>

    <!-- SECTION: FORMULÁRIOS -->
    <h2 class="section-title">FORMULÁRIOS</h2>

    <!-- Exercício 11 -->
    <div class="exercise-card" id="ex11">
        <h3><span>Ex 11</span> Calculadora de IMC</h3>
        <form method="POST" action="#ex11">
            <div class="form-row">
                <div class="form-group">
                    <label for="peso">Peso (kg):</label>
                    <input type="number" step="0.1" name="peso" id="peso" placeholder="Ex: 75.5" required>
                </div>
                <div class="form-group">
                    <label for="altura">Altura (m):</label>
                    <input type="number" step="0.01" name="altura" id="altura" placeholder="Ex: 1.75" required>
                </div>
            </div>
            <button type="submit" name="calc_imc">Calcular IMC</button>
        </form>

        <?php if (isset($_POST['calc_imc'])): ?>
            <?php
                $peso = floatval($_POST['peso']);
                $altura = floatval($_POST['altura']);
                if ($altura > 0) {
                    $imc = $peso / ($altura * $altura);
                    $imcFormatado = number_format($imc, 2, ',', '.');
                    echo "<div class='result-box'>Seu IMC é: $imcFormatado</div>";
                } else {
                    echo "<div class='result-box'>Altura inválida!</div>";
                }
            ?>
        <?php endif; ?>
    </div>

    <!-- Exercício 12 -->
    <div class="exercise-card" id="ex12">
        <h3><span>Ex 12</span> Calculadora HTML</h3>
        <form method="POST" action="#ex12">
            <div class="form-row">
                <div class="form-group">
                    <label for="calc_num1">Número 1:</label>
                    <input type="number" step="any" name="calc_num1" id="calc_num1" required>
                </div>
                <div class="form-group">
                    <label for="calc_num2">Número 2:</label>
                    <input type="number" step="any" name="calc_num2" id="calc_num2" required>
                </div>
            </div>
            <div class="btn-group">
                <button type="submit" name="op" value="somar">Somar</button>
                <button type="submit" name="op" value="subtrair">Subtrair</button>
                <button type="submit" name="op" value="multiplicar">Multiplicar</button>
                <button type="submit" name="op" value="dividir">Dividir</button>
            </div>
        </form>

        <?php if (isset($_POST['op'])): ?>
            <?php
                $n1 = floatval($_POST['calc_num1']);
                $n2 = floatval($_POST['calc_num2']);
                $op = $_POST['op'];
                $resCalc = 0;

                switch ($op) {
                    case 'somar':
                        $resCalc = $n1 + $n2;
                        echo "<div class='result-box'>Resultado: $n1 + $n2 = $resCalc</div>";
                        break;
                    case 'subtrair':
                        $resCalc = $n1 - $n2;
                        echo "<div class='result-box'>Resultado: $n1 - $n2 = $resCalc</div>";
                        break;
                    case 'multiplicar':
                        $resCalc = $n1 * $n2;
                        echo "<div class='result-box'>Resultado: $n1 * $n2 = $resCalc</div>";
                        break;
                    case 'dividir':
                        if ($n2 != 0) {
                            $resCalc = $n1 / $n2;
                            echo "<div class='result-box'>Resultado: $n1 / $n2 = $resCalc</div>";
                        } else {
                            echo "<div class='result-box'>Erro: Divisão por zero não é permitida!</div>";
                        }
                        break;
                }
            ?>
        <?php endif; ?>
    </div>

    <!-- Exercício 13 -->
    <div class="exercise-card" id="ex13">
        <h3><span>Ex 13</span> Formulário de Cadastro Completo</h3>
        <form method="POST" action="#ex13">
            <div class="form-row">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" required>
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado:</label>
                    <input type="text" name="estado" id="estado" placeholder="Ex: PR, SP, RJ" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo" required>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="curso">Curso:</label>
                <input type="text" name="curso" id="curso" placeholder="Ex: Desenvolvimento Web PHP" required>
            </div>
            <div class="form-group">
                <label for="observacoes">Observações:</label>
                <textarea name="observacoes" id="observacoes" rows="3"></textarea>
            </div>
            <button type="submit" name="enviar_cadastro">Enviar Cadastro</button>
        </form>

        <?php if (isset($_POST['enviar_cadastro'])): ?>
            <div class="card-cadastro">
                <h4>🪪 Cartão de Cadastro</h4>
                <div class="card-info">
                    <div class="card-item">
                        <strong>Nome</strong>
                        <span><?php echo htmlspecialchars($_POST['nome']); ?></span>
                    </div>
                    <div class="card-item">
                        <strong>E-mail</strong>
                        <span><?php echo htmlspecialchars($_POST['email']); ?></span>
                    </div>
                    <div class="card-item">
                        <strong>Telefone</strong>
                        <span><?php echo htmlspecialchars($_POST['telefone']); ?></span>
                    </div>
                    <div class="card-item">
                        <strong>Data de Nascimento</strong>
                        <span><?php echo htmlspecialchars($_POST['data_nascimento']); ?></span>
                    </div>
                    <div class="card-item">
                        <strong>Cidade / Estado</strong>
                        <span><?php echo htmlspecialchars($_POST['cidade']) . ' / ' . htmlspecialchars($_POST['estado']); ?></span>
                    </div>
                    <div class="card-item">
                        <strong>Sexo</strong>
                        <span><?php echo htmlspecialchars($_POST['sexo']); ?></span>
                    </div>
                    <div class="card-item">
                        <strong>Curso</strong>
                        <span><?php echo htmlspecialchars($_POST['curso']); ?></span>
                    </div>
                    <div class="card-item" style="grid-column: 1 / -1;">
                        <strong>Observações</strong>
                        <span><?php echo !empty($_POST['observacoes']) ? htmlspecialchars($_POST['observacoes']) : 'Nenhuma observação informada.'; ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

</body>
</html>