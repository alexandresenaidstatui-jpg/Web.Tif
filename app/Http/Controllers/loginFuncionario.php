<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\TokenFuncionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class loginFuncionario extends Controller
{
    public function login_html()
    {
        return view('login_funcionario');
    }

    public function login(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email|max:255',
            'senha' => 'required|string|min:8',
        ]);

        $funcionario = Funcionario::where('email', $dados['email'])->first();

        if (!$funcionario || !Hash::check($dados['senha'], $funcionario->senha)) {
            return response()->json([
                'erro' => 's',
                'mensagem' => 'Email ou senha de funcionário inválidos.',
            ], 401);
        }

        try {
            TokenFuncionario::where('funcionario_id', $funcionario->id)->delete();

            $token = TokenFuncionario::create([
                'funcionario_id' => $funcionario->id,
                'token' => Str::random(80),
                'valido_ate' => now()->addDays(2),
            ]);

            return response()->json([
                'erro' => 'n',
                'mensagem' => 'Login de funcionário realizado com sucesso.',
                'token' => $token->token,
                'data' => ['erro' => 'n'],
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'erro' => 's',
                'mensagem' => 'Não foi possível iniciar a sessão do funcionário.',
            ], 500);
        }
    }
}
