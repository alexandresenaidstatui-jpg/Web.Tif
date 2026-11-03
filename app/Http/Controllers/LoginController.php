<?php

namespace App\Http\Controllers;

use App\Models\TokenUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login_api(Request $request)
    {
        $dados = $request->validate([
            'email' => 'required|email|max:255',
            'senha' => 'required|string|min:8',
            'lembrar' => 'sometimes|boolean',
        ]);

        $usuario = Usuario::where('email', $dados['email'])->first();

        if (! $usuario || ! Hash::check($dados['senha'], $usuario->senha)) {
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
                'valido_ate' => now()->addDays(($dados['lembrar'] ?? false) ? 30 : 2),
            ]);

            return response()->json([
                'erro' => 'n',
                'mensagem' => 'Login realizado com sucesso.',
                'token' => $token->token,
                'usuario' => [
                    'nome' => $usuario->nome,
                    'tipo_usuario' => $usuario->tipo_usuario,
                ],
                'data' => ['erro' => 'n'],
            ], 200);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'erro' => 's',
                'mensagem' => 'Não foi possível iniciar a sessão.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        TokenUsuario::where('token', $request->bearerToken())->delete();

        return response()->noContent();
    }
}
