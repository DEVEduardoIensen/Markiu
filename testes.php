<?php

/**
 * TESTES UNITÁRIOS SIMPLES - TAREFA DE FACULDADE
 * 
 * Requisitos:
 * 1) Crie um teste para verificar se o produto não cria se o valor não segue a regra de negócio;
 * 2) Crie 2 testes para o método update do service.
 * 
 * Como executar:
 * No terminal: php testes.php
 * No navegador: http://localhost:8000/testes.php
 */

require_once __DIR__ . '/service.php';

// Arquivo temporário para isolar os testes dos dados reais
$arquivoTeste = __DIR__ . '/produtos_teste.json';
if (file_exists($arquivoTeste)) {
    unlink($arquivoTeste);
}

$service = new ProdutoService($arquivoTeste);
$totalTestes = 0;
$testesPassados = 0;
$resultados = [];

function registrarResultado($nomeTeste, $passou, $mensagem) {
    global $totalTestes, $testesPassados, $resultados;
    $totalTestes++;
    if ($passou) {
        $testesPassados++;
    }
    $resultados[] = [
        'nome' => $nomeTeste,
        'passou' => $passou,
        'mensagem' => $mensagem
    ];
}

echo "========================================================\n";
echo "           EXECUTANDO OS TESTES DA FACULDADE           \n";
echo "========================================================\n\n";

// -------------------------------------------------------------
// TESTE 1: Verificar se o produto NÃO cria se o valor não segue a regra de negócio
// Regra: valor deve ser maior que zero (R$ 0,00)
// -------------------------------------------------------------
try {
    // Tentativa com valor negativo
    $service->create([
        'nome' => 'Produto Valor Negativo',
        'valor' => -10.00,
        'quantidade' => 5
    ]);
    // Se chegou aqui, falhou porque deveria ter lançado exceção
    registrarResultado(
        "1. Bloquear criação com valor inválido (<= 0)",
        false,
        "FALHA: O produto foi criado mesmo com valor negativo!"
    );
} catch (Exception $e) {
    // Sucesso: a regra de negócio impediu a criação!
    registrarResultado(
        "1. Bloquear criação com valor inválido (<= 0)",
        true,
        "SUCESSO: A regra de negócio bloqueou a criação. Mensagem capturada: " . $e->getMessage()
    );
}

// -------------------------------------------------------------
// TESTE 2: Método UPDATE do service - Teste de Sucesso
// Atualiza o produto com novos dados válidos
// -------------------------------------------------------------
try {
    // 1. Cria um produto válido inicial
    $produtoInicial = $service->create([
        'nome' => 'Teclado Simples',
        'valor' => 50.00,
        'quantidade' => 10
    ]);

    $id = $produtoInicial['id'];

    // 2. Chama o método update do service com novos valores
    $produtoAtualizado = $service->update($id, [
        'nome' => 'Teclado Mecânico RGB',
        'valor' => 199.90,
        'quantidade' => 15
    ]);

    // 3. Verifica se atualizou os campos corretamente
    if ($produtoAtualizado['nome'] === 'Teclado Mecânico RGB' && $produtoAtualizado['valor'] == 199.90 && $produtoAtualizado['quantidade'] == 15) {
        registrarResultado(
            "2. Update do Service - Atualização com sucesso",
            true,
            "SUCESSO: Produto ID {$id} atualizado com novos valores válidos."
        );
    } else {
        registrarResultado(
            "2. Update do Service - Atualização com sucesso",
            false,
            "FALHA: Os dados retornados não correspondem aos valores atualizados."
        );
    }
} catch (Exception $e) {
    registrarResultado(
        "2. Update do Service - Atualização com sucesso",
        false,
        "FALHA: Erro inesperado ao atualizar: " . $e->getMessage()
    );
}

// -------------------------------------------------------------
// TESTE 3: Método UPDATE do service - Teste de Falha pela Regra de Negócio
// Tenta atualizar o produto com valor inválido (<= 0)
// -------------------------------------------------------------
try {
    // 1. Cria um produto para o teste
    $produto = $service->create([
        'nome' => 'Mouse USB',
        'valor' => 30.00,
        'quantidade' => 20
    ]);

    $id = $produto['id'];

    // 2. Tenta atualizar com valor inválido (R$ 0,00)
    $service->update($id, [
        'valor' => 0.00
    ]);

    // Se chegou aqui, falhou pois não deveria permitir valor zero
    registrarResultado(
        "3. Update do Service - Bloquear alteração com valor inválido",
        false,
        "FALHA: O update permitiu alterar o valor para zero!"
    );
} catch (Exception $e) {
    // Sucesso: a regra de negócio impediu a alteração inválida!
    registrarResultado(
        "3. Update do Service - Bloquear alteração com valor inválido",
        true,
        "SUCESSO: O método update bloqueou o valor inválido. Mensagem capturada: " . $e->getMessage()
    );
}

// Limpeza do arquivo de teste
if (file_exists($arquivoTeste)) {
    unlink($arquivoTeste);
}

// Exibe resumo no terminal
foreach ($resultados as $r) {
    $status = $r['passou'] ? "[PASSOU]" : "[FALHOU]";
    echo "{$status} {$r['nome']}\n";
    echo "         {$r['mensagem']}\n\n";
}

echo "========================================================\n";
echo "RESULTADO FINAL: {$testesPassados}/{$totalTestes} testes passaram com sucesso!\n";
echo "========================================================\n";

// Se for acessado pelo navegador
if (php_sapi_name() !== 'cli') {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Resultados dos Testes</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 20px; }
            .card { background: white; max-width: 650px; margin: auto; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
            h1 { color: #333; font-size: 22px; }
            .teste { padding: 12px; margin-bottom: 10px; border-radius: 6px; }
            .passou { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
            .falhou { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
            .resumo { margin-top: 20px; font-weight: bold; font-size: 16px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>Testes da Faculdade - markiu</h1>
            <?php foreach ($resultados as $r): ?>
                <div class="teste <?= $r['passou'] ? 'passou' : 'falhou' ?>">
                    <strong><?= $r['passou'] ? '✔ PASSOU' : '✖ FALHOU' ?>: <?= htmlspecialchars($r['nome']) ?></strong>
                    <p style="margin: 5px 0 0 0; font-size: 14px;"><?= htmlspecialchars($r['mensagem']) ?></p>
                </div>
            <?php endforeach; ?>
            <div class="resumo">
                Total: <?= $testesPassados ?> de <?= $totalTestes ?> testes executados com êxito!
            </div>
        </div>
    </body>
    </html>
    <?php
}

// Código de saída para terminal
if ($testesPassados !== $totalTestes) {
    exit(1);
}
