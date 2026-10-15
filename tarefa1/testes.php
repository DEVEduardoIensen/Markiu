<?php

/**
 * TAREFA 1 - TESTES
 * 
 * 1) Crie um teste para verificar se o produto não cria se o valor não segue a regra de negócio;
 * 2) Crie 2 testes para o método update do service
 * 
 * Como rodar:
 * php testes.php
 */

require_once __DIR__ . '/service.php';

// Arquivo temporário para isolar os testes
$arquivoTeste = __DIR__ . '/produtos_teste.json';
if (file_exists($arquivoTeste)) {
    unlink($arquivoTeste);
}

$service = new ProdutoService($arquivoTeste);
$total = 0;
$passou = 0;

function verificar($titulo, $condicao, $msgSucesso, $msgErro) {
    global $total, $passou;
    $total++;
    echo "--------------------------------------------------------\n";
    if ($condicao) {
        $passou++;
        echo "[PASSOU] $titulo\n";
        echo "         $msgSucesso\n";
    } else {
        echo "[FALHOU] $titulo\n";
        echo "         $msgErro\n";
    }
}

echo "========================================================\n";
echo "           TAREFA 1 - EXECUTANDO TESTES DO SERVICE      \n";
echo "========================================================\n\n";

// ==============================================================
// TESTE 1: Verificar se o produto NÃO cria se o valor não segue a regra de negócio
// Regra: valor deve ser maior que zero (R$ 0,00)
// ==============================================================
$teste1Passou = false;
$msgCapturada1 = '';
try {
    // Tenta criar produto com valor negativo
    $service->create([
        'nome' => 'Produto Inválido',
        'valor' => -15.00,
        'quantidade' => 5
    ]);
} catch (Exception $e) {
    $teste1Passou = true;
    $msgCapturada1 = $e->getMessage();
}

verificar(
    "1) Não criar produto se o valor não segue a regra de negócio",
    $teste1Passou,
    "SUCESSO: Bloqueou a criação com valor negativo. Mensagem: '$msgCapturada1'",
    "FALHA: O produto foi criado mesmo com valor inválido!"
);


// ==============================================================
// TESTE 2 (1º Teste do Update): Método update atualiza com sucesso
// Atualiza o produto com novos valores válidos
// ==============================================================
$teste2Passou = false;
$msg2 = '';
try {
    // 1. Cria um produto válido
    $p = $service->create([
        'nome' => 'Mouse Básico',
        'valor' => 20.00,
        'quantidade' => 10
    ]);

    // 2. Chama o método update alterando nome e valor
    $atualizado = $service->update($p['id'], [
        'nome' => 'Mouse Gamer RGB',
        'valor' => 89.90,
        'quantidade' => 12
    ]);

    if ($atualizado['nome'] === 'Mouse Gamer RGB' && $atualizado['valor'] == 89.90 && $atualizado['quantidade'] == 12) {
        $teste2Passou = true;
        $msg2 = "Produto ID {$p['id']} atualizado corretamente com os novos dados válidos.";
    } else {
        $msg2 = "Os dados atualizados não bateram com o esperado.";
    }
} catch (Exception $e) {
    $msg2 = "Erro inesperado: " . $e->getMessage();
}

verificar(
    "2) Método update do service - Atualizar com sucesso",
    $teste2Passou,
    "SUCESSO: $msg2",
    "FALHA: $msg2"
);


// ==============================================================
// TESTE 3 (2º Teste do Update): Método update falha se novo valor for inválido
// Tenta atualizar com valor <= 0
// ==============================================================
$teste3Passou = false;
$msgCapturada3 = '';
try {
    // 1. Cria um produto para testar
    $prod = $service->create([
        'nome' => 'Teclado USB',
        'valor' => 45.00,
        'quantidade' => 8
    ]);

    // 2. Tenta atualizar com valor 0 (inválido pela regra de negócio)
    $service->update($prod['id'], [
        'valor' => 0.00
    ]);
} catch (Exception $e) {
    $teste3Passou = true;
    $msgCapturada3 = $e->getMessage();
}

verificar(
    "3) Método update do service - Bloquear novo valor inválido (<= 0)",
    $teste3Passou,
    "SUCESSO: O método update bloqueou o valor 0.00. Mensagem: '$msgCapturada3'",
    "FALHA: O método update permitiu alterar para um valor inválido!"
);

// Limpeza do arquivo de teste
if (file_exists($arquivoTeste)) {
    unlink($arquivoTeste);
}

echo "--------------------------------------------------------\n";
echo "RESULTADO: $passou de $total testes passaram!\n";
echo "========================================================\n";
