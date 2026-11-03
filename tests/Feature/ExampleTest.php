<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_exposes_only_the_three_requested_screens(): void
    {
        $this->get('/')->assertOk()->assertSee('Abrir e Fechar');
        $this->get('/cadastro')->assertOk()->assertSee('Crie sua conta');
        $this->get('/login')->assertOk()->assertSee('Acesse sua conta para continuar.');

        $this->get('/boas-vindas')->assertNotFound();
        $this->get('/cadastro_usuario')->assertNotFound();
        $this->get('/mudanca')->assertNotFound();
        $this->postJson('/api/mudancas', [])->assertNotFound();
    }

    public function test_a_user_can_be_registered_with_the_new_fields(): void
    {
        $response = $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
            'senha_confirmation' => 'senha-segura',
            'telefone' => '(11) 99999-0000',
            'tipo_usuario' => 'morador',
        ]);

        $response->assertOk()->assertJsonPath('data.erro', 'n');

        $this->assertDatabaseHas('usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'telefone' => '(11) 99999-0000',
            'tipo_usuario' => 'morador',
        ]);

        $this->assertNotSame('senha-segura', Usuario::where('email', 'maria@example.com')->value('senha'));
    }

    public function test_registration_requires_matching_passwords_and_a_valid_user_type(): void
    {
        $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
            'senha_confirmation' => 'senha-diferente',
            'telefone' => '(11) 99999-0000',
            'tipo_usuario' => 'morador',
        ])->assertUnprocessable()->assertJsonValidationErrors('senha');

        $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
            'senha_confirmation' => 'senha-segura',
            'telefone' => '(11) 99999-0000',
            'tipo_usuario' => 'administrador',
        ])->assertUnprocessable()->assertJsonValidationErrors('tipo_usuario');
    }

    public function test_a_registered_user_can_log_in_and_log_out(): void
    {
        $this->registerUser();

        $response = $this->postJson('/api/login', [
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
            'lembrar' => true,
        ]);

        $response->assertOk()
            ->assertJsonPath('erro', 'n')
            ->assertJsonPath('usuario.nome', 'Maria da Silva')
            ->assertJsonPath('usuario.tipo_usuario', 'morador')
            ->assertJsonStructure(['token']);

        $token = $response->json('token');
        $this->withToken($token)->postJson('/api/logout')->assertNoContent();
        $this->withToken($token)->getJson('/api/lixeiras')->assertUnauthorized();
    }

    public function test_the_bin_states_require_authentication_and_are_persisted(): void
    {
        $this->getJson('/api/lixeiras')->assertUnauthorized();

        $token = $this->loginUser();
        $this->withToken($token)->getJson('/api/lixeiras')
            ->assertOk()
            ->assertJsonCount(4, 'lixeiras');

        $this->withToken($token)->patchJson('/api/lixeiras/metal', [
            'aberta' => true,
        ])->assertOk()->assertJsonPath('lixeira.aberta', true);

        $this->assertDatabaseHas('lixeiras', [
            'tipo' => 'metal',
            'aberta' => true,
            'atualizada_por' => Usuario::where('email', 'maria@example.com')->value('id'),
        ]);

        $this->withToken($token)->getJson('/api/lixeiras')
            ->assertOk()
            ->assertJsonPath('acoes_recentes.0.nome', 'Metal')
            ->assertJsonPath('acoes_recentes.0.usuario', 'Maria da Silva');
    }

    private function registerUser(): void
    {
        $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
            'senha_confirmation' => 'senha-segura',
            'telefone' => '(11) 99999-0000',
            'tipo_usuario' => 'morador',
        ])->assertOk();
    }

    private function loginUser(): string
    {
        $this->registerUser();

        return $this->postJson('/api/login', [
            'email' => 'maria@example.com',
            'senha' => 'senha-segura',
        ])->assertOk()->json('token');
    }
}
