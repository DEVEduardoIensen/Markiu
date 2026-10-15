<?php

namespace App\Services;

use App\Repositories\ProdutoRepository;
use InvalidArgumentException;
use Exception;

class ProdutoService
{
    private ProdutoRepository $repository;

    public function __construct(?ProdutoRepository $repository = null)
    {
        $this->repository = $repository ?? new ProdutoRepository();
    }

    /**
     * Regra de negócio:
     * O valor do produto deve ser estritamente maior que zero.
     */
    public function validarRegraDeNegocioValor($valor): void
    {
        if (!is_numeric($valor) || (float)$valor <= 0) {
            throw new InvalidArgumentException("Regra de negócio violada: O valor do produto deve ser maior que zero.");
        }
    }

    /**
     * Retorna a lista de todos os produtos.
     */
    public function listar(): array
    {
        return $this->repository->listarTodos();
    }

    /**
     * Busca um produto por ID.
     */
    public function buscarPorId(int $id): ?array
    {
        $produto = $this->repository->buscarPorId($id);
        if (!$produto) {
            throw new Exception("Produto com ID {$id} não foi encontrado.");
        }
        return $produto;
    }

    /**
     * Cria um novo produto aplicando as regras de negócio.
     */
    public function create(array $dados): array
    {
        if (empty($dados['nome']) || trim($dados['nome']) === '') {
            throw new InvalidArgumentException("O nome do produto é obrigatório.");
        }

        if (!isset($dados['valor'])) {
            throw new InvalidArgumentException("O valor do produto é obrigatório.");
        }

        // Aplica a validação da regra de negócio do valor
        $this->validarRegraDeNegocioValor($dados['valor']);

        $novoProduto = [
            'nome' => trim($dados['nome']),
            'valor' => (float)$dados['valor'],
            'categoria' => $dados['categoria'] ?? 'Geral',
            'quantidade' => isset($dados['quantidade']) ? (int)$dados['quantidade'] : 0,
        ];

        return $this->repository->salvar($novoProduto);
    }

    /**
     * 1) Método update dentro do service conforme solicitado.
     * Atualiza os dados de um produto existente e valida as regras de negócio.
     */
    public function update(int $id, array $dados): array
    {
        // 1. Verifica se o produto existe
        $produto = $this->buscarPorId($id);

        // 2. Se o valor estiver sendo alterado, valida a regra de negócio
        if (array_key_exists('valor', $dados)) {
            $this->validarRegraDeNegocioValor($dados['valor']);
            $produto['valor'] = (float)$dados['valor'];
        }

        // 3. Atualiza os outros campos permitidos se forem fornecidos
        if (array_key_exists('nome', $dados)) {
            if (empty($dados['nome']) || trim($dados['nome']) === '') {
                throw new InvalidArgumentException("O nome do produto não pode ficar vazio.");
            }
            $produto['nome'] = trim($dados['nome']);
        }

        if (array_key_exists('categoria', $dados)) {
            $produto['categoria'] = trim($dados['categoria']);
        }

        if (array_key_exists('quantidade', $dados)) {
            $produto['quantidade'] = (int)$dados['quantidade'];
        }

        // 4. Salva as alterações
        return $this->repository->salvar($produto);
    }

    /**
     * Remove um produto por ID.
     */
    public function delete(int $id): bool
    {
        $this->buscarPorId($id);
        return $this->repository->deletar($id);
    }
}
