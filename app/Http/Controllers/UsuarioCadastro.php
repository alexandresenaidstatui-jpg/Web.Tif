<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usuario;

class UsuarioCadastro extends Controller
{
    public function cadastro_usuario_html()
    {
        return view('cadastro_usuario');
    }

    public function cadastro_usuario(Request $request){
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'senha' => 'required|string|min:8',
            'cpf' => 'required|string|max:14',
            'data_nascimento' => 'required|date',
        ]);

        // Verifica se email já existe
        if(Usuario::where('email', $request->email)->exists()){
            return response()->json(['erro' => 's', 'mensagem' => 'O email já está em uso.', 'data' => ['erro' => 's']], 200);
        }
       
        try {
            $usuario = new Usuario();
            $usuario->nome = $request->nome;
            $usuario->email = $request->email;
            $usuario->senha = bcrypt($request->senha);
            $usuario->cpf = $request->cpf;
            $usuario->data_nascimento = $request->data_nascimento;
            $usuario->save();

            return response()->json(['erro' => 'n', 'mensagem' => 'Cadastro realizado com sucesso.', 'data' => ['erro' => 'n']], 200);
        } catch (\Exception $e) {
            return response()->json(['erro' => 's', 'mensagem' => 'Erro ao cadastrar usuário: ' . $e->getMessage(), 'data' => ['erro' => 's']], 200);
        }
    }
}
