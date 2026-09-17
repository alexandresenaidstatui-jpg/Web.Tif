<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Usuario;

class UsuarioCadastro extends Controller
{
    public function cadastro_usuario_html()
    {
        return view('cadastro_usuario');
    }

    public function cadastro_funcionario_html()
    {
        return view('cadastro.funcionario');
    }

    public function cadastro_usuario(Request $request){
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('usuario', 'email')],
            'senha' => 'required|string|min:8',
            'cpf' => ['required', 'string', 'max:14', Rule::unique('usuario', 'cpf')],
            'data_nascimento' => 'required|date',
        ]);
       
        try {
            $dados['senha'] = Hash::make($dados['senha']);
            $usuario = Usuario::create($dados);

            return response()->json(['erro' => 'n', 'mensagem' => 'Cadastro realizado com sucesso.', 'data' => ['erro' => 'n']], 200);
        } catch (\Exception $e) {
            report($e);

            return response()->json(['erro' => 's', 'mensagem' => 'Não foi possível salvar o cadastro.', 'data' => ['erro' => 's']], 500);
        }
    }
}
