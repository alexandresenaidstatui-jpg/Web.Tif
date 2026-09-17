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

    public function test_a_worker_can_log_in_with_one_of_the_registered_subjects(): void
    {
        $this->postJson('/api/cadastro-funcionario', [
            'nome' => 'Carlos Professor',
            'email' => 'carlos.professor@example.com',
            'senha' => 'senha-segura',
            'cpf' => 'REG-002',
            'materias' => 'Matemática, História',
            'data_nascimento' => '1985-03-15',
        ])->assertOk();

        $response = $this->postJson('/api/login-funcionario', [
            'email' => 'carlos.professor@example.com',
            'senha' => 'senha-segura',
            'materia' => 'história',
        ]);

        $response->assertOk()
            ->assertJsonPath('erro', 'n')
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('token_funcionario', [
            'funcionario_id' => Funcionario::where('email', 'carlos.professor@example.com')->value('id'),
        ]);
    }

    public function test_a_change_request_saves_origin_and_destination(): void
    {
        $response = $this->postJson('/api/mudancas', [
            'origem' => 'Sala 1',
            'destino' => 'Sala 4',
            'material' => 'Notebook',
            'justificativa' => 'Transferência de equipamento.',
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('mudancas', [
            'origem' => 'Sala 1',
            'destino' => 'Sala 4',
            'material' => 'Notebook',
        ]);
    }

    public function test_the_changes_page_lists_saved_requests(): void
    {
        $this->postJson('/api/mudancas', [
            'origem' => 'Laboratório',
            'destino' => 'Biblioteca',
            'material' => 'Tablet',
            'justificativa' => 'Aula prática.',
        ])->assertCreated();

        $this->get('/mudancas-realizadas')
            ->assertOk()
            ->assertSee('Laboratório')
            ->assertSee('Biblioteca')
            ->assertSee('Tablet')
            ->assertSee('Aula prática.');
    }

    public function test_a_change_records_whether_it_was_created_by_a_student(): void
    {
        $this->postJson('/api/cadastro_usuario', [
            'nome' => 'Pedro Aluno',
            'email' => 'pedro.aluno@example.com',
            'senha' => 'senha-segura',
            'cpf' => '111.222.333-44',
            'data_nascimento' => '2005-06-18',
        ])->assertOk();

        $login = $this->postJson('/api/login', [
            'email' => 'pedro.aluno@example.com',
            'senha' => 'senha-segura',
        ])->assertOk();

        $this->withHeader('Authorization', 'Bearer '.$login->json('token'))
            ->postJson('/api/mudancas', [
                'origem' => 'Sala A',
                'destino' => 'Sala B',
                'material' => 'Celular',
                'justificativa' => 'Troca de sala.',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('mudancas', [
            'responsavel_tipo' => 'aluno',
            'material' => 'Celular',
        ]);
    }

    public function test_a_change_records_whether_it_was_created_by_a_worker(): void
    {
        $this->postJson('/api/cadastro-funcionario', [
            'nome' => 'Fernanda Funcionaria',
            'email' => 'fernanda.funcionaria@example.com',
            'senha' => 'senha-segura',
            'cpf' => 'REG-003',
            'materias' => 'Geografia',
            'data_nascimento' => '1987-08-22',
        ])->assertOk();

        $login = $this->postJson('/api/login-funcionario', [
            'email' => 'fernanda.funcionaria@example.com',
            'senha' => 'senha-segura',
            'materia' => 'Geografia',
        ])->assertOk();

        $this->withHeader('Authorization', 'Bearer '.$login->json('token'))
            ->postJson('/api/mudancas', [
                'origem' => 'Sala C',
                'destino' => 'Sala D',
                'material' => 'Tablet',
                'justificativa' => 'Organização do laboratório.',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('mudancas', [
            'responsavel_tipo' => 'funcionario',
            'material' => 'Tablet',
        ]);
    }

    public function test_a_change_request_can_be_updated_and_deleted(): void
    {
        $createResponse = $this->postJson('/api/mudancas', [
            'origem' => 'Sala antiga',
            'destino' => 'Sala nova',
            'material' => 'Celular',
            'justificativa' => 'Solicitação inicial.',
        ])->assertCreated();

        $mudancaId = $createResponse->json('mudanca.id');

        $this->put('/mudancas/' . $mudancaId, [
            'origem' => 'Sala atualizada',
            'destino' => 'Biblioteca',
            'material' => 'Tablet',
            'justificativa' => 'Solicitação corrigida.',
        ])->assertRedirect(route('mudancas.realizadas'));

        $this->assertDatabaseHas('mudancas', [
            'id' => $mudancaId,
            'origem' => 'Sala atualizada',
            'material' => 'Tablet',
        ]);

        $this->delete('/mudancas/' . $mudancaId)
            ->assertRedirect(route('mudancas.realizadas'));

        $this->assertDatabaseMissing('mudancas', ['id' => $mudancaId]);
    }
}
