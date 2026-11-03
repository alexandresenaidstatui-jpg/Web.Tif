<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioCadastro extends Controller
{
    public function cadastro_usuario(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('usuario', 'email')],
            'senha' => 'required|string|min:8|confirmed',
            'telefone' => 'required|string|max:30',
            'tipo_usuario' => ['required', Rule::in(['morador', 'operador'])],
        ]);

        try {
            $dados['senha'] = Hash::make($dados['senha']);
            Usuario::create($dados);

            return response()->json(['erro' => 'n', 'mensagem' => 'Cadastro realizado com sucesso.', 'data' => ['erro' => 'n']], 200);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['erro' => 's', 'mensagem' => 'Não foi possível salvar o cadastro.', 'data' => ['erro' => 's']], 500);
        }
    }
}
