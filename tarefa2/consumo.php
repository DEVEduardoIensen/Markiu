<?php

// TAREFA 2 - CONSUMO DE API GRATUITA ONLINE (AwesomeAPI - Cotações de Moedas)

$url = "https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL";

// Contexto para garantir funcionamento mesmo em Windows sem certificados locais
$contexto = stream_context_create([
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false
    ],
    "http" => [
        "timeout" => 5
    ]
]);

$resposta = @file_get_contents($url, false, $contexto);

if ($resposta === false) {
    echo "Erro ao consumir a API externa.";
    exit;
}

$dados = json_decode($resposta, true);

if (php_sapi_name() === 'cli') {
    echo "Dólar: R$ " . number_format($dados['USDBRL']['bid'], 2, ',', '.') . "\n";
    echo "Euro: R$ " . number_format($dados['EURBRL']['bid'], 2, ',', '.') . "\n";
    echo "Bitcoin: R$ " . number_format($dados['BTCBRL']['bid'], 2, ',', '.') . "\n";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consumo de API Externa</title>
</head>
<body>
    <h2>Consumo de API Externa (AwesomeAPI - Moedas em Tempo Real)</h2>
    <p><strong>URL consumida:</strong> <?= $url ?></p>
    <hr>
    <ul>
        <li><strong>Dólar Comercial:</strong> R$ <?= number_format($dados['USDBRL']['bid'], 2, ',', '.') ?> (Variação: <?= $dados['USDBRL']['pctChange'] ?>%)</li>
        <li><strong>Euro:</strong> R$ <?= number_format($dados['EURBRL']['bid'], 2, ',', '.') ?> (Variação: <?= $dados['EURBRL']['pctChange'] ?>%)</li>
        <li><strong>Bitcoin:</strong> R$ <?= number_format($dados['BTCBRL']['bid'], 2, ',', '.') ?> (Variação: <?= $dados['BTCBRL']['pctChange'] ?>%)</li>
    </ul>
    <hr>
    <p><a href="../index.php">Voltar para o início</a></p>
</body>
</html>
