<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\TokenUsuario;

class LoginController extends Controller
{
    public function login_html(Request $request){
        return view('Login');
    }

    public function login_api(Request $request){

        $request->validate([
            'email' => 'required',
            'senha' => 'required'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if($usuario && Hash::check($request->senha, $usuario->senha)){
            $token = new TokenUsuario();
            TokenUsuario::where('usuario_id', '=', $usuario->id)->delete();
            $token->usuario_id = $usuario->id;
            $token->token = md5($usuario->email . now());
            $token->valido_ate = now()->addDays(2);
            $token->save();

            return response()->json(['erro' => 'n','mensagem' => 'Login realizado com sucesso', 'token' => $token->token], 200);
        } else {
            return response()->json(['erro' => 's','mensagem' => 'Email ou senha inválidos'], 200);
        }


    }
}
