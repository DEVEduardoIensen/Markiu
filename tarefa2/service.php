<?php

/**
 * TAREFA 2 - Service de Produtos para a API (Armazenamento em Sessão/Memória, sem arquivos .json)
 */

class ProdutoService
{
    private static $produtosMemoria = [
        ['id' => 1, 'nome' => 'Caderno 10 Matérias', 'valor' => 25.50, 'quantidade' => 10],
        ['id' => 2, 'nome' => 'Caneta Azul', 'valor' => 2.00, 'quantidade' => 50],
        ['id' => 3, 'nome' => 'Borracha Escolar', 'valor' => 1.50, 'quantidade' => 30]
    ];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        if (isset($_SESSION) && !isset($_SESSION['produtos'])) {
            $_SESSION['produtos'] = self::$produtosMemoria;
        }
    }

    public function listar()
    {
        if (isset($_SESSION['produtos'])) {
            return $_SESSION['produtos'];
        }
        return self::$produtosMemoria;
    }

    public function buscarPorId($id)
    {
        foreach ($this->listar() as $p) {
            if ($p['id'] == $id) {
                return $p;
            }
        }
        return null;
    }

    public function create($dados)
    {
        if (empty($dados['nome'])) {
            throw new Exception("O nome do produto é obrigatório!");
        }

        if (!isset($dados['valor']) || !is_numeric($dados['valor']) || $dados['valor'] <= 0) {
            throw new Exception("O valor do produto deve ser maior que zero!");
        }

        $produtos = $this->listar();
        $novoId = 1;
        foreach ($produtos as $p) {
            if ($p['id'] >= $novoId) {
                $novoId = $p['id'] + 1;
            }
        }

        $novoProduto = [
            'id' => $novoId,
            'nome' => $dados['nome'],
            'valor' => (float)$dados['valor'],
            'quantidade' => isset($dados['quantidade']) ? (int)$dados['quantidade'] : 0
        ];

        $produtos[] = $novoProduto;
        $this->salvar($produtos);
        return $novoProduto;
    }

    public function update($id, $dados)
    {
        $produtos = $this->listar();
        $encontrado = false;
        $atualizado = null;

        if (isset($dados['valor']) && (!is_numeric($dados['valor']) || $dados['valor'] <= 0)) {
            throw new Exception("O valor do produto deve ser maior que zero!");
        }

        foreach ($produtos as $i => $p) {
            if ($p['id'] == $id) {
                if (isset($dados['nome'])) $produtos[$i]['nome'] = $dados['nome'];
                if (isset($dados['valor'])) $produtos[$i]['valor'] = (float)$dados['valor'];
                if (isset($dados['quantidade'])) $produtos[$i]['quantidade'] = (int)$dados['quantidade'];

                $atualizado = $produtos[$i];
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            throw new Exception("Produto não encontrado para atualização!");
        }

        $this->salvar($produtos);
        return $atualizado;
    }

    public function delete($id)
    {
        $produtos = $this->listar();
        $novos = [];
        $deletado = false;

        foreach ($produtos as $p) {
            if ($p['id'] == $id) {
                $deletado = true;
            } else {
                $novos[] = $p;
            }
        }

        if ($deletado) {
            $this->salvar($novos);
        }

        return $deletado;
    }

    private function salvar($produtos)
    {
        if (isset($_SESSION)) {
            $_SESSION['produtos'] = $produtos;
        }
        self::$produtosMemoria = $produtos;
    }
}
