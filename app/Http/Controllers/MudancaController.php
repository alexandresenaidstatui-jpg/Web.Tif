<?php

namespace App\Http\Controllers;

use App\Models\Mudanca;
use App\Models\TokenFuncionario;
use App\Models\TokenUsuario;
use Illuminate\Http\Request;

class MudancaController extends Controller
{
    public function listar()
    {
        $mudancas = Mudanca::latest()->get();

        return view('mudança_realizada', compact('mudancas'));
    }

    public function editar(Mudanca $mudanca)
    {
        return view('mudanca_editar', compact('mudanca'));
    }

    public function criar(Request $request)
    {
        $dados = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'material' => 'required|string|max:120',
            'justificativa' => 'required|string|max:2000',
        ]);

        $dados['responsavel_tipo'] = $this->identificarResponsavel($request);
        $mudanca = Mudanca::create($dados);

        return response()->json([
            'mensagem' => 'Mensagem salva com sucesso.',
            'mudanca' => $mudanca,
        ], 201);
    }

    private function identificarResponsavel(Request $request): ?string
    {
        $token = $request->bearerToken();

        if (!$token) {
            return null;
        }

        if (TokenFuncionario::where('token', $token)->where('valido_ate', '>', now())->exists()) {
            return 'funcionario';
        }

        if (TokenUsuario::where('token', $token)->where('valido_ate', '>', now())->exists()) {
            return 'aluno';
        }

        return null;
    }

    public function atualizar(Request $request, Mudanca $mudanca)
    {
        $dados = $request->validate([
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'material' => 'required|string|max:120',
            'justificativa' => 'required|string|max:2000',
        ]);

        $mudanca->update($dados);

        return redirect()
            ->route('mudancas.realizadas')
            ->with('status', 'Mudança atualizada com sucesso.');
    }

    public function excluir(Mudanca $mudanca)
    {
        $mudanca->delete();

        return redirect()
            ->route('mudancas.realizadas')
            ->with('status', 'Mudança excluída com sucesso.');
    }
}
