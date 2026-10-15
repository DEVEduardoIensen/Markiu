<?php

/**
 * TAREFA 1 - SERVICE
 * 1) Crie o método update dentro do service
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

    // Regra de negócio: o valor do produto deve ser maior que zero (R$ 0,00)
    public function validarRegraValor($valor)
    {
        if (!is_numeric($valor) || $valor <= 0) {
            return false;
        }
        return true;
    }

    // Criação de produto com validação da regra de negócio
    public function create($dados)
    {
        // Regra de negócio: valor deve ser maior que zero
        if (!isset($dados['valor']) || !$this->validarRegraValor($dados['valor'])) {
            throw new Exception("Erro de regra de negócio: O valor do produto deve ser maior que zero!");
        }

        if (empty($dados['nome'])) {
            throw new Exception("O nome do produto é obrigatório!");
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

    // ==============================================================
    // 1) MÉTODO UPDATE DENTRO DO SERVICE (REQUISITO DA TAREFA)
    // ==============================================================
    public function update($id, $dados)
    {
        $produtos = $this->listar();
        $encontrado = false;
        $produtoAtualizado = null;

        // Se veio o campo valor, valida a regra de negócio
        if (isset($dados['valor'])) {
            if (!$this->validarRegraValor($dados['valor'])) {
                throw new Exception("Erro de regra de negócio: O valor do produto deve ser maior que zero!");
            }
        }

        foreach ($produtos as $i => $p) {
            if ($p['id'] == $id) {
                if (isset($dados['nome'])) {
                    $produtos[$i]['nome'] = $dados['nome'];
                }
                if (isset($dados['valor'])) {
                    $produtos[$i]['valor'] = (float)$dados['valor'];
                }
                if (isset($dados['quantidade'])) {
                    $produtos[$i]['quantidade'] = (int)$dados['quantidade'];
                }

                $produtoAtualizado = $produtos[$i];
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            throw new Exception("Produto não encontrado para atualização!");
        }

        file_put_contents($this->arquivoJson, json_encode($produtos, JSON_PRETTY_PRINT));
        return $produtoAtualizado;
    }
}
