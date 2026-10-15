<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Services\ProdutoService;
use App\Repositories\ProdutoRepository;
use InvalidArgumentException;
use Exception;

class ProdutoServiceTest extends TestCase
{
    private string $arquivoTeste;
    private ProdutoRepository $repository;
    private ProdutoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        // Arquivo temporário isolado para não afetar os dados reais
        $this->arquivoTeste = sys_get_temp_dir() . '/produtos_teste_' . uniqid() . '.json';
        $this->repository = new ProdutoRepository($this->arquivoTeste);
        $this->service = new ProdutoService($this->repository);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->arquivoTeste)) {
            unlink($this->arquivoTeste);
        }
        parent::tearDown();
    }

    /**
     * TESTES - Requisito 1:
     * Crie um teste para verificar se o produto não cria se o valor não segue a regra de negócio;
     */
    public function test_nao_deve_criar_produto_se_valor_nao_segue_regra_de_negocio(): void
    {
        // Regra de negócio: o valor deve ser maior que zero (R$ 0,00)
        $dadosComValorNegativo = [
            'nome' => 'Mouse Gamer',
            'valor' => -50.00,
            'categoria' => 'Informática',
            'quantidade' => 10
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Regra de negócio violada: O valor do produto deve ser maior que zero.");

        $this->service->create($dadosComValorNegativo);
    }

    /**
     * TESTES - Requisito 1 (Variação com valor zero):
     * Verifica que com valor R$ 0,00 também não permite criar.
     */
    public function test_nao_deve_criar_produto_com_valor_zero(): void
    {
        $dadosComValorZero = [
            'nome' => 'Teclado Mecânico',
            'valor' => 0.00,
            'categoria' => 'Informática',
            'quantidade' => 5
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Regra de negócio violada: O valor do produto deve ser maior que zero.");

        $this->service->create($dadosComValorZero);
    }

    /**
     * TESTES - Requisito 2 (Teste 1 do método update):
     * Teste para o método update do service atualizando dados com sucesso.
     */
    public function test_metodo_update_do_service_atualiza_produto_com_sucesso(): void
    {
        // 1. Cria um produto válido inicialmente
        $produtoCriado = $this->service->create([
            'nome' => 'Monitor 24 Polegadas',
            'valor' => 800.00,
            'categoria' => 'Informática',
            'quantidade' => 3
        ]);

        $id = $produtoCriado['id'];

        // 2. Executa o método update alterando nome e valor
        $dadosAtualizados = [
            'nome' => 'Monitor 27 Polegadas Curvo',
            'valor' => 1250.50,
            'quantidade' => 5
        ];

        $produtoAtualizado = $this->service->update($id, $dadosAtualizados);

        // 3. Asserções verificando que foi atualizado com sucesso
        $this->assertEquals('Monitor 27 Polegadas Curvo', $produtoAtualizado['nome']);
        $this->assertEquals(1250.50, $produtoAtualizado['valor']);
        $this->assertEquals(5, $produtoAtualizado['quantidade']);
        $this->assertEquals('Informática', $produtoAtualizado['categoria']); // manteve categoria
        $this->assertArrayHasKey('atualizado_em', $produtoAtualizado);
    }

    /**
     * TESTES - Requisito 2 (Teste 2 do método update):
     * Teste para o método update do service falhando quando o novo valor viola a regra de negócio.
     */
    public function test_metodo_update_do_service_falha_se_novo_valor_viola_regra_de_negocio(): void
    {
        // 1. Cria um produto válido
        $produtoCriado = $this->service->create([
            'nome' => 'Headset USB',
            'valor' => 150.00,
            'categoria' => 'Áudio',
            'quantidade' => 10
        ]);

        $id = $produtoCriado['id'];

        // 2. Tenta atualizar com valor inválido (<= 0)
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Regra de negócio violada: O valor do produto deve ser maior que zero.");

        $this->service->update($id, [
            'valor' => -25.00
        ]);
    }

    /**
     * TESTES - Bônus para o método update:
     * Verifica que o update falha com exceção ao tentar atualizar um produto que não existe.
     */
    public function test_metodo_update_do_service_falha_se_produto_nao_encontrado(): void
    {
        $idInexistente = 99999;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Produto com ID 99999 não foi encontrado.");

        $this->service->update($idInexistente, [
            'nome' => 'Produto Fantasma',
            'valor' => 50.00
        ]);
    }
}
