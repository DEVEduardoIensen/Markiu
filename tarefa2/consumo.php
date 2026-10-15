<?php

/**
 * TAREFA 2 - CONSUMO DE API GRATUITA ONLINE (EXCETO VIACEP)
 * Consumindo a AwesomeAPI (Cotações de Moedas em Tempo Real: Dólar, Euro, Bitcoin)
 */

$url = "https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL";

// Faz a requisição HTTP GET para a API externa
$respostaJson = @file_get_contents($url);

if ($respostaJson === false) {
    die("Erro ao tentar consumir a API externa.");
}

$dados = json_decode($respostaJson, true);

// Se chamado no terminal (CLI)
if (php_sapi_name() === 'cli') {
    echo "=============================================\n";
    echo " CONSUMO DE API GRATUITA: COTAÇÕES DE MOEDAS \n";
    echo " API: economia.awesomeapi.com.br             \n";
    echo "=============================================\n";
    echo "Dólar:   R$ " . number_format($dados['USDBRL']['bid'], 2, ',', '.') . "\n";
    echo "Euro:    R$ " . number_format($dados['EURBRL']['bid'], 2, ',', '.') . "\n";
    echo "Bitcoin: R$ " . number_format($dados['BTCBRL']['bid'], 2, ',', '.') . "\n";
    echo "=============================================\n";
    exit;
}

// Se chamado via API (JSON)
if (isset($_GET['json'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'api' => 'AwesomeAPI - Cotações',
        'dados' => $dados
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// Se chamado no navegador (HTML)
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Tarefa 2 - Consumo de API Externa</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 40px; }
        .card { background: white; padding: 25px; border-radius: 8px; max-width: 480px; margin: auto; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { font-size: 20px; color: #1e3a8a; text-align: center; }
        .item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; }
        .nome { font-weight: bold; color: #333; }
        .valor { font-weight: bold; color: #16a34a; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Consumo de API Externa (AwesomeAPI)</h1>
        <p style="text-align: center; color: #666; font-size: 13px;">Cotações em Tempo Real</p>
        <div class="item">
            <span class="nome">Dólar Comercial (USD)</span>
            <span class="valor">R$ <?= number_format($dados['USDBRL']['bid'], 2, ',', '.') ?></span>
        </div>
        <div class="item">
            <span class="nome">Euro (EUR)</span>
            <span class="valor">R$ <?= number_format($dados['EURBRL']['bid'], 2, ',', '.') ?></span>
        </div>
        <div class="item">
            <span class="nome">Bitcoin (BTC)</span>
            <span class="valor">R$ <?= number_format($dados['BTCBRL']['bid'], 2, ',', '.') ?></span>
        </div>
    </div>
</body>
</html>
