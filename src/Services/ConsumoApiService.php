<?php

namespace App\Services;

use Exception;

/**
 * Serviço responsável pelo CONSUMO DE API EXTERNA
 * Consome a API pública AwesomeAPI (Cotações de Moedas em Tempo Real)
 * Endpoint: https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL
 */
class ConsumoApiService
{
    private string $url = 'https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BTC-BRL';

    /**
     * Faz a requisição HTTP para a API externa e retorna os dados tratados
     */
    public function obterCotacoes(): array
    {
        $contexto = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 5,
                'header' => "User-Agent: Markiu-Faculdade-PHP-Client/1.0\r\nAccept: application/json\r\n"
            ]
        ]);

        $resposta = @file_get_contents($this->url, false, $contexto);

        if ($resposta === false) {
            // Caso falhe por timeout ou conexão, lança exceção com mensagem clara
            throw new Exception("Falha ao se conectar com a API externa de cotações.");
        }

        $dados = json_decode($resposta, true);

        if (!$dados || !is_array($dados)) {
            throw new Exception("Resposta inválida recebida da API externa.");
        }

        // Formata os dados para o padrão da nossa aplicação
        return [
            'api_consumida' => 'AwesomeAPI Cotações (economia.awesomeapi.com.br)',
            'consultado_em' => date('d/m/Y H:i:s'),
            'moedas' => [
                'dolar' => [
                    'nome' => 'Dólar Comercial',
                    'simbolo' => 'USD',
                    'valor' => (float)$dados['USDBRL']['bid'],
                    'valor_formatado' => 'R$ ' . number_format((float)$dados['USDBRL']['bid'], 2, ',', '.'),
                    'variacao' => $dados['USDBRL']['pctChange'] . '%',
                    'maxima' => 'R$ ' . number_format((float)$dados['USDBRL']['high'], 2, ',', '.'),
                    'minima' => 'R$ ' . number_format((float)$dados['USDBRL']['low'], 2, ',', '.')
                ],
                'euro' => [
                    'nome' => 'Euro',
                    'simbolo' => 'EUR',
                    'valor' => (float)$dados['EURBRL']['bid'],
                    'valor_formatado' => 'R$ ' . number_format((float)$dados['EURBRL']['bid'], 2, ',', '.'),
                    'variacao' => $dados['EURBRL']['pctChange'] . '%',
                    'maxima' => 'R$ ' . number_format((float)$dados['EURBRL']['high'], 2, ',', '.'),
                    'minima' => 'R$ ' . number_format((float)$dados['EURBRL']['low'], 2, ',', '.')
                ],
                'bitcoin' => [
                    'nome' => 'Bitcoin',
                    'simbolo' => 'BTC',
                    'valor' => (float)$dados['BTCBRL']['bid'],
                    'valor_formatado' => 'R$ ' . number_format((float)$dados['BTCBRL']['bid'], 2, ',', '.'),
                    'variacao' => $dados['BTCBRL']['pctChange'] . '%',
                    'maxima' => 'R$ ' . number_format((float)$dados['BTCBRL']['high'], 2, ',', '.'),
                    'minima' => 'R$ ' . number_format((float)$dados['BTCBRL']['low'], 2, ',', '.')
                ]
            ]
        ];
    }
}
