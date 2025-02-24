<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\Retirada;
use App\Models\Ferramenta;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function visualizar()
    {
        $estoque = Ferramenta::all();
        $retiradas = Ferramenta::all();
        $manutencoes = Ferramenta::all();
        $reparadas = Ferramenta::all();
        // dd($estoque);
        return view('estoque.index', compact('estoque', 'retiradas', 'manutencoes', 'reparadas'));
    }

    public function retirar() 
    {
        $ferramentas = Ferramenta::all();
        $obras = Obra::all();
        return view('estoque.retirar', compact('ferramentas', 'obras'));
    }

    public function store(Request $request)
{
    try {
        dd($request);
        // Validação dos dados
        $validatedData = $request->validate([
            'ferramenta_id' => 'required|exists:ferramentas,id',
            'descricao' => 'required|string|max:255',
            'numero_serie' => 'required|string|max:255',
            'responsavel' => 'required|string|max:255',
            'previsao_retorno' => 'required|date|after:today',
            'uso_interno' => 'nullable|boolean',
            'obra_id' => 'nullable|exists:obras,id',
        ]);

        // Se uso interno estiver marcado, zera o ID da obra
        if ($request->has('uso_interno')) {
            $validatedData['obra_id'] = null;
        }

        // Criar registro de retirada
        Retirada::create([
            'ferramenta_id' => $validatedData['ferramenta_id'],
            'descricao' => $validatedData['descricao'],
            'numero_serie' => $validatedData['numero_serie'],
            'responsavel' => $validatedData['responsavel'],
            'previsao_retorno' => $validatedData['previsao_retorno'],
            'uso_interno' => $request->has('uso_interno') ? 1 : 0,
            'obra_id' => $validatedData['obra_id'],
        ]);

        return redirect()->route('estoque.visualizar')
            ->with('success', 'Retirada registrada com sucesso!');
    } catch (\Exception $e) {
        return redirect()->route('estoque.visualizar')
            ->with('error', 'Erro ao registrar a retirada. Tente novamente.');
    }
}

}
