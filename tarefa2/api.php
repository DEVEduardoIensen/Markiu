<?php

/**
 * TAREFA 2 - CRIAÇÃO DE API SIMPLES
 * Implementa:
 * A. Rotas RESTful (GET, POST, PUT, DELETE)
 * B. Resource (ProdutoResource)
 */

require_once __DIR__ . '/service.php';
require_once __DIR__ . '/resource.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$service = new ProdutoService(__DIR__ . '/produtos.json');
$metodo = $_SERVER['REQUEST_METHOD'];

// Captura ID via query (?id=1) ou URL (/1)
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if (!$id && isset($_SERVER['PATH_INFO'])) {
    $partes = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    if (!empty($partes[0]) && is_numeric($partes[0])) {
        $id = (int)$partes[0];
    }
}

$corpo = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    switch ($metodo) {
        // A. Rota RESTful: GET (Listar todos ou buscar por ID)
        case 'GET':
            if ($id) {
                $produto = $service->buscarPorId($id);
                if (!$produto) {
                    http_response_code(404);
                    echo json_encode(['mensagem' => 'Produto não encontrado!'], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                // B. Resource: formata produto individual
                echo json_encode(ProdutoResource::formatar($produto), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                $produtos = $service->listar();
                // B. Resource: formata coleção de produtos
                echo json_encode(ProdutoResource::formatarColecao($produtos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
            break;

        // A. Rota RESTful: POST (Criar produto)
        case 'POST':
            $dados = !empty($corpo) ? $corpo : $_POST;
            $novoProduto = $service->create($dados);
            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Produto criado com sucesso!',
                'produto' => ProdutoResource::formatar($novoProduto)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        // A. Rota RESTful: PUT (Atualizar produto)
        case 'PUT':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['mensagem' => 'ID do produto não informado!'], JSON_UNESCAPED_UNICODE);
                exit;
            }
            $atualizado = $service->update($id, $corpo);
            echo json_encode([
                'mensagem' => 'Produto atualizado com sucesso!',
                'produto' => ProdutoResource::formatar($atualizado)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        // A. Rota RESTful: DELETE (Excluir produto)
        case 'DELETE':
            if (!$id) {
                http_response_code(400);
                echo json_encode(['mensagem' => 'ID do produto não informado!'], JSON_UNESCAPED_UNICODE);
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
            echo json_encode(['mensagem' => 'Método não permitido!'], JSON_UNESCAPED_UNICODE);
            break;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['erro' => true, 'mensagem' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
