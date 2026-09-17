<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class FuncionarioCadastro extends Controller
{
    public function cadastro_html()
    {
        return view()->file(resource_path('views/cadastro.funcionario.blade.php'));
    }

    public function cadastrar(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('funcionario', 'email')],
            'senha' => 'required|string|min:8',
            'cpf' => ['required', 'string', 'max:50', Rule::unique('funcionario', 'registro_funcionario')],
            'materias' => 'nullable|string|max:255',
            'data_nascimento' => 'required|date',
        ]);

        try {
            $dados['registro_funcionario'] = $dados['cpf'];
            unset($dados['cpf']);
            $dados['senha'] = Hash::make($dados['senha']);

            Funcionario::create($dados);

            return response()->json([
                'erro' => 'n',
                'mensagem' => 'Cadastro de funcionário realizado com sucesso.',
                'data' => ['erro' => 'n'],
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'erro' => 's',
                'mensagem' => 'Não foi possível salvar o cadastro do funcionário.',
                'data' => ['erro' => 's'],
            ], 500);
        }
    }
}
