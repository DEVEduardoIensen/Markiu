<?php

/**
 * TAREFA 1 - SERVICE
 * 1) Crie o método update dentro do service
 */

class ProdutoService
{
    private static $produtos = null;

    public function __construct()
    {
        if (self::$produtos === null) {
            $this->resetar();
        }
    }

    // Inicializa com dados de exemplo na memória (sem arquivos .json)
    public function resetar()
    {
        self::$produtos = [
            ['id' => 1, 'nome' => 'Caderno 10 Matérias', 'valor' => 25.50, 'quantidade' => 10],
            ['id' => 2, 'nome' => 'Caneta Azul', 'valor' => 2.00, 'quantidade' => 50],
            ['id' => 3, 'nome' => 'Borracha Escolar', 'valor' => 1.50, 'quantidade' => 30]
        ];
    }

    public function listar()
    {
        return self::$produtos ?? [];
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
        if (!isset($dados['valor']) || !$this->validarRegraValor($dados['valor'])) {
            throw new Exception("Erro de regra de negócio: O valor do produto deve ser maior que zero!");
        }

        if (empty($dados['nome'])) {
            throw new Exception("O nome do produto é obrigatório!");
        }

        $novoId = 1;
        foreach (self::$produtos as $p) {
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

        self::$produtos[] = $novoProduto;
        return $novoProduto;
    }

    // ==============================================================
    // 1) MÉTODO UPDATE DENTRO DO SERVICE (REQUISITO DA TAREFA)
    // ==============================================================
    public function update($id, $dados)
    {
        $encontrado = false;
        $produtoAtualizado = null;

        if (isset($dados['valor'])) {
            if (!$this->validarRegraValor($dados['valor'])) {
                throw new Exception("Erro de regra de negócio: O valor do produto deve ser maior que zero!");
            }
        }

        foreach (self::$produtos as $i => $p) {
            if ($p['id'] == $id) {
                if (isset($dados['nome'])) {
                    self::$produtos[$i]['nome'] = $dados['nome'];
                }
                if (isset($dados['valor'])) {
                    self::$produtos[$i]['valor'] = (float)$dados['valor'];
                }
                if (isset($dados['quantidade'])) {
                    self::$produtos[$i]['quantidade'] = (int)$dados['quantidade'];
                }

                $produtoAtualizado = self::$produtos[$i];
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            throw new Exception("Produto não encontrado para atualização!");
        }

        return $produtoAtualizado;
    }
}
