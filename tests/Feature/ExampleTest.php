<?php

namespace Tests\Feature;

use App\Models\Usuario;
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
}
