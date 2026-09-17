<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\TokenUsuario;

class LoginController extends Controller
{
    public function login_html(Request $request){
        return view('Login');
    }

    public function login_api(Request $request){

        $dados = $request->validate([
            'email' => 'required|email|max:255',
            'senha' => 'required|string|min:8',
        ]);

        $usuario = Usuario::where('email', $dados['email'])->first();

        if (!$usuario || !Hash::check($dados['senha'], $usuario->senha)) {
            return response()->json([
                'erro' => 's',
                'mensagem' => 'Email ou senha inválidos.',
            ], 401);
        }

        try {
            TokenUsuario::where('usuario_id', $usuario->id)->delete();

            $token = TokenUsuario::create([
                'usuario_id' => $usuario->id,
                'token' => Str::random(80),
                'valido_ate' => now()->addDays(2),
            ]);

            return response()->json([
                'erro' => 'n',
                'mensagem' => 'Login realizado com sucesso.',
                'token' => $token->token,
                'data' => ['erro' => 'n'],
            ], 200);
        } catch (\Exception $e) {
            report($e);

            return response()->json([
                'erro' => 's',
                'mensagem' => 'Não foi possível iniciar a sessão.',
            ], 500);
        }
    }
}
