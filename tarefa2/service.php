<?php

/**
 * TAREFA 2 - Service de Produtos para a API
 */

class ProdutoService
{
    private $arquivoJson;

    public function __construct($arquivoJson = __DIR__ . '/produtos.json')
    {
        $this->arquivoJson = $arquivoJson;

        if (!file_exists($this->arquivoJson)) {
            $dadosIniciais = [
                ['id' => 1, 'nome' => 'Caderno 10 Matérias', 'valor' => 25.50, 'quantidade' => 10],
                ['id' => 2, 'nome' => 'Caneta Azul', 'valor' => 2.00, 'quantidade' => 50],
                ['id' => 3, 'nome' => 'Borracha Escolar', 'valor' => 1.50, 'quantidade' => 30]
            ];
            file_put_contents($this->arquivoJson, json_encode($dadosIniciais, JSON_PRETTY_PRINT));
        }
    }

    public function listar()
    {
        if (!file_exists($this->arquivoJson)) {
            return [];
        }
        $conteudo = file_get_contents($this->arquivoJson);
        return json_decode($conteudo, true) ?: [];
    }

    public function buscarPorId($id)
    {
        $produtos = $this->listar();
        foreach ($produtos as $p) {
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
        file_put_contents($this->arquivoJson, json_encode($produtos, JSON_PRETTY_PRINT));
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

        file_put_contents($this->arquivoJson, json_encode($produtos, JSON_PRETTY_PRINT));
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
            file_put_contents($this->arquivoJson, json_encode($novos, JSON_PRETTY_PRINT));
        }

        return $deletado;
    }
}
