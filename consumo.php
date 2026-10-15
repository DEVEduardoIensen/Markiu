<?php

/**
 * 1. CONSUMO DE API GRATUITA ONLINE (EXCETO VIACEP)
 * Consumindo a AwesomeAPI (Cotações de Moedas em Tempo Real)
 */

$url = "https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL";

// Faz a requisição para a API externa
$respostaJson = @file_get_contents($url);

if ($respostaJson === false) {
    die("Erro ao tentar consumir a API externa.");
}

// Converte o JSON para array associativo do PHP
$dados = json_decode($respostaJson, true);

// Se o usuário pedir como JSON (ex: via API)
if (isset($_GET['json']) || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'sucesso',
        'api_consumida' => 'AwesomeAPI - Cotações em Tempo Real',
        'dados' => $dados
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Se rodar no terminal (CLI)
if (php_sapi_name() === 'cli') {
    echo "=============================================\n";
    echo " CONSUMO DE API GRATUITA: COTAÇÕES DE MOEDAS \n";
    echo "=============================================\n";
    echo "Dólar: R$ " . number_format($dados['USDBRL']['bid'], 2, ',', '.') . "\n";
    echo "Euro:  R$ " . number_format($dados['EURBRL']['bid'], 2, ',', '.') . "\n";
    echo "Bitcoin: R$ " . number_format($dados['BTCBRL']['bid'], 2, ',', '.') . "\n";
    echo "=============================================\n";
    exit;
}

// Se abrir no navegador, exibe uma interface bonita e simples
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consumo de API - Cotações de Moedas</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 30px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 500px; margin: auto; }
        h1 { font-size: 20px; color: #333; text-align: center; }
        .moeda { border-bottom: 1px solid #eee; padding: 12px 0; display: flex; justify-content: space-between; }
        .nome { font-weight: bold; color: #555; }
        .valor { color: #28a745; font-weight: bold; }
        .info { font-size: 12px; color: #777; margin-top: 15px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Consumo de API Externa (AwesomeAPI)</h1>
        <div class="moeda">
            <span class="nome">Dólar Comercial (USD)</span>
            <span class="valor">R$ <?= number_format($dados['USDBRL']['bid'], 2, ',', '.') ?></span>
        </div>
        <div class="moeda">
            <span class="nome">Euro (EUR)</span>
            <span class="valor">R$ <?= number_format($dados['EURBRL']['bid'], 2, ',', '.') ?></span>
        </div>
        <div class="moeda">
            <span class="nome">Bitcoin (BTC)</span>
            <span class="valor">R$ <?= number_format($dados['BTCBRL']['bid'], 2, ',', '.') ?></span>
        </div>
        <p class="info">API utilizada: <em>https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL</em></p>
    </div>
</body>
</html>
