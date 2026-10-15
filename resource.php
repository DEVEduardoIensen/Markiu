<?php

/**
 * Resource simples para formatar a resposta do produto na API
 */
class ProdutoResource
{
    // Formata um único produto
    public static function formatar($produto)
    {
        if (!$produto) {
            return null;
        }

        return [
            'id' => (int)$produto['id'],
            'nome' => $produto['nome'],
            'valor' => (float)$produto['valor'],
            'valor_formatado' => 'R$ ' . number_format($produto['valor'], 2, ',', '.'),
            'quantidade' => (int)$produto['quantidade']
        ];
    }

    // Formata uma lista de produtos
    public static function formatarColecao($produtos)
    {
        $resultado = [];
        foreach ($produtos as $p) {
            $resultado[] = self::formatar($p);
        }
        return $resultado;
    }
}
