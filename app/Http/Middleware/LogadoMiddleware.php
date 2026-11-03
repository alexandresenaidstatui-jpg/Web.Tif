<?php

namespace App\Http\Middleware;

use App\Models\TokenUsuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogadoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json([
                'erro' => 's',
                'message' => 'Autenticação necessária.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $tokenUsuario = TokenUsuario::query()
            ->where('token', $token)
            ->where('valido_ate', '>', now())
            ->first();

        if ($tokenUsuario) {
            $request->attributes->set('auth_tipo', 'usuario');
            $request->attributes->set('auth_id', $tokenUsuario->usuario_id);

            return $next($request);
        }

        return response()->json([
            'erro' => 's',
            'message' => 'Token inválido ou expirado.',
        ], Response::HTTP_UNAUTHORIZED);
    }
}
