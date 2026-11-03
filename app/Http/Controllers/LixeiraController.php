<?php

namespace App\Http\Controllers;

use App\Models\Lixeira;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
