<?php

/**
 * Service simples de Produtos - Tarefa de Faculdade
 */
class ProdutoService
{
    private $arquivoJson;

    public function __construct($arquivoJson = 'produtos.json')
    {
        $this->arquivoJson = $arquivoJson;

        // Se o arquivo não existir, cria com dados iniciais
        if (!file_exists($this->arquivoJson)) {
            $dadosIniciais = [
                ['id' => 1, 'nome' => 'Caderno 10 Matérias', 'valor' => 25.50, 'quantidade' => 10],
                ['id' => 2, 'nome' => 'Caneta Azul', 'valor' => 2.00, 'quantidade' => 50],
                ['id' => 3, 'nome' => 'Borracha Escolar', 'valor' => 1.50, 'quantidade' => 30]
            ];
            file_put_contents($this->arquivoJson, json_encode($dadosIniciais, JSON_PRETTY_PRINT));
        }
    }

    // Carrega os produtos do arquivo json
    public function listar()
    {
        if (!file_exists($this->arquivoJson)) {
            return [];
        }
        $conteudo = file_get_contents($this->arquivoJson);
        return json_decode($conteudo, true) ?: [];
    }

    // Busca um produto pelo ID
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

    // Cria um novo produto aplicando a regra de negócio
    public function create($dados)
    {
        // Validação da regra de negócio do valor
        if (!isset($dados['valor']) || !$this->validarRegraValor($dados['valor'])) {
            throw new Exception("Erro de regra de negócio: O valor do produto deve ser maior que zero!");
        }

        if (empty($dados['nome'])) {
            throw new Exception("O nome do produto é obrigatório!");
        }

        $produtos = $this->listar();

        // Pega o maior ID para incrementar
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

    // 1) Método UPDATE dentro do service (conforme solicitado na tarefa)
    public function update($id, $dados)
    {
        $produtos = $this->listar();
        $produtoEncontrado = false;
        $produtoAtualizado = null;

        // Se veio o campo valor, valida a regra de negócio
        if (isset($dados['valor'])) {
            if (!$this->validarRegraValor($dados['valor'])) {
                throw new Exception("Erro de regra de negócio: O valor do produto deve ser maior que zero!");
            }
        }

        foreach ($produtos as $indice => $p) {
            if ($p['id'] == $id) {
                // Atualiza os dados
                if (isset($dados['nome'])) {
                    $produtos[$indice]['nome'] = $dados['nome'];
                }
                if (isset($dados['valor'])) {
                    $produtos[$indice]['valor'] = (float)$dados['valor'];
                }
                if (isset($dados['quantidade'])) {
                    $produtos[$indice]['quantidade'] = (int)$dados['quantidade'];
                }

                $produtoAtualizado = $produtos[$indice];
                $produtoEncontrado = true;
                break;
            }
        }

        if (!$produtoEncontrado) {
            throw new Exception("Produto não encontrado para atualização!");
        }

        file_put_contents($this->arquivoJson, json_encode($produtos, JSON_PRETTY_PRINT));
        return $produtoAtualizado;
    }

    // Deleta um produto por id
    public function delete($id)
    {
        $produtos = $this->listar();
        $novosProdutos = [];
        $deletou = false;

        foreach ($produtos as $p) {
            if ($p['id'] == $id) {
                $deletou = true;
            } else {
                $novosProdutos[] = $p;
            }
        }

        if ($deletou) {
            file_put_contents($this->arquivoJson, json_encode($novosProdutos, JSON_PRETTY_PRINT));
        }

        return $deletou;
    }
}
