<?php

namespace App\Resources;

/**
 * Resource para padronizar e formatar o retorno JSON dos produtos.
 */
class ProdutoResource
{
    /**
     * Transforma um único produto em array formatado para a API.
     */
    public static function toArray(array $produto): array
    {
        return [
            'id' => (int)$produto['id'],
            'nome' => (string)$produto['nome'],
            'valor' => (float)$produto['valor'],
            'valor_formatado' => 'R$ ' . number_format((float)$produto['valor'], 2, ',', '.'),
            'categoria' => $produto['categoria'] ?? 'Geral',
            'quantidade' => (int)($produto['quantidade'] ?? 0),
            'criado_em' => $produto['criado_em'] ?? null,
            'atualizado_em' => $produto['atualizado_em'] ?? null
        ];
    }

    /**
     * Transforma uma lista de produtos usando o Resource.
     */
    public static function collection(array $produtos): array
    {
        return array_map([self::class, 'toArray'], $produtos);
    }
}
