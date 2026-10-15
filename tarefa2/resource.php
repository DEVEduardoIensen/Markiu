<?php

/**
 * TAREFA 2 - B. RESOURCE
 * Classe Resource para padronizar e formatar a resposta do produto na API
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

    // Formata uma coleção (lista) de produtos
    public static function formatarColecao($produtos)
    {
        $listaFormatada = [];
        foreach ($produtos as $p) {
            $listaFormatada[] = self::formatar($p);
        }
        return $listaFormatada;
    }
}
