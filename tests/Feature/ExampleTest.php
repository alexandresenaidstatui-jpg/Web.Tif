<?php

namespace Tests\Feature;

use App\Models\Usuario;
use App\Models\Funcionario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_a_user_can_be_registered(): void
    {
        $response = $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
            'cpf' => '123.456.789-00',
            'data_nascimento' => '1995-04-20',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.erro', 'n');

        $this->assertDatabaseHas('usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'cpf' => '123.456.789-00',
        ]);

        $this->assertNotEmpty(Usuario::first()->senha);
    }

    public function test_a_registered_user_can_log_in(): void
    {
        $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Joao da Silva',
            'email' => 'joao@example.com',
            'senha' => 'senha-segura',
            'cpf' => '987.654.321-00',
            'data_nascimento' => '1990-02-10',
        ])->assertOk();

        $response = $this->postJson('/api/login', [
            'email' => 'joao@example.com',
            'senha' => 'senha-segura',
        ]);

        $response->assertOk()
            ->assertJsonPath('erro', 'n')
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('token_usuario', [
            'usuario_id' => Usuario::where('email', 'joao@example.com')->value('id'),
        ]);
    }

    public function test_a_worker_is_saved_separately_from_a_user(): void
    {
        $response = $this->postJson('/api/cadastro-funcionario', [
            'nome' => 'Ana Funcionaria',
            'email' => 'ana.funcionaria@example.com',
            'senha' => 'senha-segura',
            'cpf' => 'REG-001',
            'materias' => 'Matematica, Historia',
            'data_nascimento' => '1988-07-12',
        ]);

        $response->assertOk()->assertJsonPath('data.erro', 'n');

        $this->assertDatabaseHas('funcionario', [
            'nome' => 'Ana Funcionaria',
            'email' => 'ana.funcionaria@example.com',
            'registro_funcionario' => 'REG-001',
            'materias' => 'Matematica, Historia',
        ]);

        $this->assertDatabaseMissing('usuario', [
            'email' => 'ana.funcionaria@example.com',
        ]);
        $this->assertNotEmpty(Funcionario::first()->senha);
    }
}
