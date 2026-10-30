<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoOperacoesTest extends TestCase
{
    use RefreshDatabase;

    public function test_filtra_por_nome_e_intervalo_de_preco(): void
    {
        Produto::create(['nome' => 'Lajota barata', 'preco_custo' => 5, 'preco' => 10]);
        Produto::create(['nome' => 'Lajota media', 'preco_custo' => 10, 'preco' => 20]);
        Produto::create(['nome' => 'Lajota cara', 'preco_custo' => 20, 'preco' => 30]);
        Produto::create(['nome' => 'Cimento', 'preco_custo' => 10, 'preco' => 20]);

        $this->getJson('/api/produtos?search=Lajota&preco_min=20&preco_max=20')
            ->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.nome', 'Lajota media');
        $this->getJson('/api/produtos?preco_max=0')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/produtos?preco_min=invalido')->assertUnprocessable();
    }

    public function test_atualiza_e_exclui_produto(): void
    {
        $produto = Produto::create(['nome' => 'Lajota', 'preco_custo' => 100, 'preco' => 110]);

        $this->patchJson("/api/produtos/{$produto->id}", ['nome' => 'Nova lajota'])
            ->assertOk()->assertJsonPath('data.nome', 'Nova lajota');
        $this->patchJson("/api/produtos/{$produto->id}", ['preco_custo' => 200])
            ->assertUnprocessable();
        $this->assertDatabaseHas('produtos', ['id' => $produto->id, 'nome' => 'Nova lajota', 'preco_custo' => 100]);
        $this->deleteJson("/api/produtos/{$produto->id}")->assertNoContent();
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
        $this->deleteJson("/api/produtos/{$produto->id}")->assertNotFound();
    }
}
