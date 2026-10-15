<?php

/**
 * TAREFA 2 - CRIAÇÃO DE API RESTFUL
 * Rotas: GET, POST, PUT, DELETE
 * Resource: ProdutoResource
 */

require_once __DIR__ . '/service.php';
require_once __DIR__ . '/resource.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$service = new ProdutoService();

// Suporte a RESTful direto e também via formulário HTML com _method
$metodo = $_SERVER['REQUEST_METHOD'];
if ($metodo === 'POST' && isset($_POST['_method'])) {
    $metodo = strtoupper($_POST['_method']);
} elseif (isset($_GET['_method'])) {
    $metodo = strtoupper($_GET['_method']);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : null);
if (!$id && isset($_SERVER['PATH_INFO'])) {
    $partes = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    if (!empty($partes[0]) && is_numeric($partes[0])) {
        $id = (int)$partes[0];
    }
}

// Captura dados tanto de JSON quanto de formulário normal
$entradaJson = json_decode(file_get_contents('php://input'), true);
$dados = !empty($entradaJson) ? $entradaJson : $_POST;

// Se a requisição veio de formulário simples com redirecionamento solicitado
$redirecionar = isset($_GET['redirect']) || isset($_POST['redirect']);

try {
    switch ($metodo) {
        case 'GET':
            header("Content-Type: application/json; charset=utf-8");
            if ($id) {
                $produto = $service->buscarPorId($id);
                if (!$produto) {
                    http_response_code(404);
                    echo json_encode(['mensagem' => 'Produto não encontrado!'], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                echo json_encode(ProdutoResource::formatar($produto), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                $produtos = $service->listar();
                echo json_encode(ProdutoResource::formatarColecao($produtos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
            break;

        case 'POST':
            $novo = $service->create($dados);
            if ($redirecionar) {
                header("Location: testar_api.php?msg=Produto criado com sucesso!");
                exit;
            }
            header("Content-Type: application/json; charset=utf-8");
            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Produto criado com sucesso!',
                'produto' => ProdutoResource::formatar($novo)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        case 'PUT':
            if (!$id) {
                throw new Exception("Informe o ID do produto para atualizar!");
            }
            $atualizado = $service->update($id, $dados);
            if ($redirecionar) {
                header("Location: testar_api.php?msg=Produto atualizado com sucesso!");
                exit;
            }
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode([
                'mensagem' => 'Produto atualizado com sucesso!',
                'produto' => ProdutoResource::formatar($atualizado)
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        case 'DELETE':
            if (!$id) {
                throw new Exception("Informe o ID do produto para exclusão!");
            }
            $deletou = $service->delete($id);
            if ($redirecionar) {
                header("Location: testar_api.php?msg=Produto excluído!");
                exit;
            }
            header("Content-Type: application/json; charset=utf-8");
            if ($deletou) {
                echo json_encode(['mensagem' => 'Produto deletado com sucesso!'], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(['mensagem' => 'Produto não encontrado!'], JSON_UNESCAPED_UNICODE);
            }
            break;

        default:
            http_response_code(405);
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(['mensagem' => 'Método HTTP não permitido!'], JSON_UNESCAPED_UNICODE);
            break;
    }
} catch (Exception $e) {
    if ($redirecionar) {
        header("Location: testar_api.php?erro=" . urlencode($e->getMessage()));
        exit;
    }
    header("Content-Type: application/json; charset=utf-8");
    http_response_code(400);
    echo json_encode(['erro' => true, 'mensagem' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
