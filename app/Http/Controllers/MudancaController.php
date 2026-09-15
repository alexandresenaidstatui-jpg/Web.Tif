<?php

namespace App\Http\Controllers;

use App\Models\Mudanca;
use Illuminate\Http\Request;

class MudancaController extends Controller
{
    public function criar(Request $request)
    {
        $dados = $request->validate([
            'material' => 'required|string|max:120',
            'justificativa' => 'required|string|max:2000',
        ]);

        $mudanca = Mudanca::create($dados);

        return response()->json([
            'mensagem' => 'Mensagem salva com sucesso.',
            'mudanca' => $mudanca,
        ], 201);
    }
}
