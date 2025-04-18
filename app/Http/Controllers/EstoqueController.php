<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Retirada;
use App\Models\Ferramenta;
use App\Models\User;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function visualizar()
    {
        $estoque = Ferramenta::all();
        $retiradas = Retirada::all();
        $manutencoes = Ferramenta::all();
        $reparadas = Ferramenta::all();
        // dd($estoque);
        return view('estoque.index', compact('estoque', 'retiradas', 'manutencoes', 'reparadas'));
    }

    public function retirar()
    {
        $ferramentas = Ferramenta::all();
        $obras = Obra::all();
        $responsaveis = User::all();
        return view('estoque.retirar', compact('ferramentas', 'obras', 'responsaveis'));
    }

    public function store(Request $request)
    {
        dd($request);
        try {
            // Criar registro de retirada
            Retirada::create([
                'ferramenta_id' => $request->ferramenta_id,
                'responsavel_id' => $request->responsavel,
                'previsao_retorno' => $request->previsao_retorno,
                'uso_interno' => $request->has('uso_interno') ? 1 : 0,
                'obra_id' => $request->obra_id,
            ]);

            return redirect()->route('estoque.visualizar')
                ->with('success', 'Retirada registrada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('estoque.visualizar')
                ->with('error', 'Erro ao registrar a retirada. Tente novamente.');
        }
    }

}
