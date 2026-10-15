<?php

/**
 * API RESTful de Produtos - Tarefa de Faculdade
 * Implementa:
 * A. Rotas RESTful (GET, POST, PUT, DELETE)
 * B. Resource (ProdutoResource)
 */

require_once __DIR__ . '/service.php';
require_once __DIR__ . '/resource.php';

// Configurações de cabeçalho para API RESTful e CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=utf-8");

// Resposta para requisição prévia (OPTIONS) do navegador
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$service = new ProdutoService(__DIR__ . '/produtos.json');
$metodo = $_SERVER['REQUEST_METHOD'];

// Captura o ID se vier na URL (?id=1 ou /api.php/1)
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if (!$id && isset($_SERVER['PATH_INFO'])) {
    $partes = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    if (!empty($partes[0]) && is_numeric($partes[0])) {
        $id = (int)$partes[0];
    }
}

// Rota de cotações externas caso solicitada
if (isset($_GET['rota']) && $_GET['rota'] === 'cotacoes') {
    $url = "https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL";
    $resposta = @file_get_contents($url);
    if ($resposta) {
        echo $resposta;
    } else {
        http_response_code(500);
        echo json_encode(['erro' => 'Não foi possível consultar as cotações']);
    }
    exit;
}

// Captura os dados do corpo da requisição (JSON)
$corpoRequisicao = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    switch ($metodo) {
        case 'GET':
            if ($id) {
                // GET /api.php?id={id} - Buscar produto específico
                $produto = $service->buscarPorId($id);
                if (!$produto) {
                    http_response_code(404);
                    echo json_encode(['mensagem' => 'Produto não encontrado!'], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                // Utilizando o Resource para formatar a resposta
                echo json_encode(ProdutoResource::formatar($produto), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                // GET /api.php - Listar todos os produtos
                $produtos = $service->listar();
                // Utilizando o Resource para formatar a lista
                echo json_encode(ProdutoResource::formatarColecao($produtos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
            break;

        case 'POST':
            // POST /api.php - Criar novo produto
            // Se veio via formulário tradicional ($_POST) ou JSON
            $dados = !empty($corpoRequisicao) ? $corpoRequisicao : $_POST;
            $novoProduto = $service->create($dados);
            
            http_response_code(201); // 201 Created
            echo json_encode([
                'mensagem' => 'Produto criado com sucesso!',
                'produto' => ProdutoResource::formatar($novoProduto)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        case 'PUT':
            // PUT /api.php?id={id} - Atualizar produto com o método update do service
            if (!$id) {
                http_response_code(400);
                echo json_encode(['mensagem' => 'Informe o ID do produto para atualizar!'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $produtoAtualizado = $service->update($id, $corpoRequisicao);
            echo json_encode([
                'mensagem' => 'Produto atualizado com sucesso!',
                'produto' => ProdutoResource::formatar($produtoAtualizado)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        case 'DELETE':
            // DELETE /api.php?id={id} - Excluir produto
            if (!$id) {
                http_response_code(400);
                echo json_encode(['mensagem' => 'Informe o ID do produto para exclusão!'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $deletou = $service->delete($id);
            if ($deletou) {
                echo json_encode(['mensagem' => 'Produto deletado com sucesso!'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(['mensagem' => 'Produto não encontrado para deletar!'], JSON_UNESCAPED_UNICODE);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['mensagem' => 'Método HTTP não permitido!'], JSON_UNESCAPED_UNICODE);
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'erro' => true,
        'mensagem' => $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
