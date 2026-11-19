<?php

namespace App\Http\Controllers;

use App\Models\Lixeira;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LixeiraController extends Controller
{
    public function listar()
    {
        $lixeiras = Lixeira::query()
            ->orderBy('nome')
            ->get(['tipo', 'nome', 'cor', 'aberta', 'updated_at']);

        $acoesRecentes = Lixeira::query()
            ->with('atualizadoPor:id,nome')
            ->whereNotNull('atualizada_por')
            ->latest('updated_at')
            ->limit(5)
            ->get(['tipo', 'nome', 'aberta', 'atualizada_por', 'updated_at']);

        return response()->json([
            'lixeiras' => $lixeiras,
            'acoes_recentes' => $acoesRecentes->map(fn (Lixeira $lixeira) => [
                'nome' => $lixeira->nome,
                'aberta' => $lixeira->aberta,
                'usuario' => $lixeira->atualizadoPor->nome,
                'atualizada_em' => $lixeira->updated_at,
            ]),
        ]);
    }

    public function atualizar(Request $request, string $tipo)
    {
        $dados = $request->validate([
            'aberta' => 'required|boolean',
        ]);

        if ($tipo === 'plastico') {
            $url = config('services.plastico_servo.'.($dados['aberta'] ? 'abrir_url' : 'fechar_url'));

            try {
                Http::timeout(5)->post($url)->throw();
            } catch (ConnectionException $exception) {
                Log::warning('Falha de conexão com o servo da lixeira plástica.', [
                    'url' => $url,
                    'erro' => $exception->getMessage(),
                ]);

                return response()->json([
                    'mensagem' => 'Não foi possível conectar ao servo da lixeira plástica. Verifique a rede e tente novamente.',
                ], 502);
            } catch (RequestException $exception) {
                Log::warning('O servo da lixeira plástica rejeitou a solicitação.', [
                    'url' => $url,
                    'status_http' => $exception->response->status(),
                ]);

                return response()->json([
                    'mensagem' => 'O servo da lixeira plástica recebeu a solicitação, mas retornou um erro HTTP.',
                ], 502);
            }
        }

        $lixeira = DB::transaction(function () use ($dados, $request, $tipo) {
            $lixeira = Lixeira::query()->lockForUpdate()->findOrFail($tipo);
            $lixeira->update([
                'aberta' => $dados['aberta'],
                'atualizada_por' => $request->attributes->get('auth_id'),
            ]);

            return $lixeira->fresh();
        });

        return response()->json([
            'mensagem' => 'Estado da lixeira atualizado.',
            'lixeira' => $lixeira->only(['tipo', 'nome', 'cor', 'aberta', 'updated_at']),
        ]);
    }
}
