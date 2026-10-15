<?php

namespace App\Repositories;

class ProdutoRepository
{
    private string $caminhoArquivo;

    public function __construct(?string $caminhoArquivo = null)
    {
        // Salva os dados em um arquivo JSON local para persistência simples
        $this->caminhoArquivo = $caminhoArquivo ?? dirname(__DIR__, 2) . '/database/produtos.json';
        $this->inicializarArquivo();
    }

    private function inicializarArquivo(): void
    {
        $diretorio = dirname($this->caminhoArquivo);
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        if (!file_exists($this->caminhoArquivo)) {
            // Dados iniciais de exemplo para a faculdade
            $dadosIniciais = [
                [
                    'id' => 1,
                    'nome' => 'Caderno Universitário 10 Matérias',
                    'valor' => 24.90,
                    'categoria' => 'Papelaria',
                    'quantidade' => 15,
                    'criado_em' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 2,
                    'nome' => 'Caneta Esferográfica Azul',
                    'valor' => 2.50,
                    'categoria' => 'Papelaria',
                    'quantidade' => 100,
                    'criado_em' => date('Y-m-d H:i:s')
                ],
                [
                    'id' => 3,
                    'nome' => 'Mochila para Notebook',
                    'valor' => 149.90,
                    'categoria' => 'Acessórios',
                    'quantidade' => 8,
                    'criado_em' => date('Y-m-d H:i:s')
                ]
            ];
            file_put_contents($this->caminhoArquivo, json_encode($dadosIniciais, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    public function listarTodos(): array
    {
        if (!file_exists($this->caminhoArquivo)) {
            return [];
        }
        $conteudo = file_get_contents($this->caminhoArquivo);
        return json_decode($conteudo, true) ?? [];
    }

    public function buscarPorId(int $id): ?array
    {
        $produtos = $this->listarTodos();
        foreach ($produtos as $produto) {
            if ($produto['id'] === $id) {
                return $produto;
            }
        }
        return null;
    }

    public function salvar(array $produto): array
    {
        $produtos = $this->listarTodos();

        if (empty($produto['id'])) {
            // Gerar próximo ID
            $maiorId = 0;
            foreach ($produtos as $p) {
                if ($p['id'] > $maiorId) {
                    $maiorId = $p['id'];
                }
            }
            $produto['id'] = $maiorId + 1;
            $produto['criado_em'] = date('Y-m-d H:i:s');
            $produtos[] = $produto;
        } else {
            // Atualizar existente
            $encontrado = false;
            foreach ($produtos as $chave => $p) {
                if ($p['id'] === $produto['id']) {
                    $produto['atualizado_em'] = date('Y-m-d H:i:s');
                    $produtos[$chave] = $produto;
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) {
                $produtos[] = $produto;
            }
        }

        file_put_contents($this->caminhoArquivo, json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $produto;
    }

    public function deletar(int $id): bool
    {
        $produtos = $this->listarTodos();
        $produtosAtualizados = [];
        $deletado = false;

        foreach ($produtos as $produto) {
            if ($produto['id'] === $id) {
                $deletado = true;
            } else {
                $produtosAtualizados[] = $produto;
            }
        }

        if ($deletado) {
            file_put_contents($this->caminhoArquivo, json_encode($produtosAtualizados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        return $deletado;
    }
}
