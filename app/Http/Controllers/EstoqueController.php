<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use App\Models\User;
use App\Models\Retirada;
use App\Models\Ferramenta;
use App\Models\Manutencao;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function visualizar()
    {
        $estoque = Ferramenta::paginate(10);
    
        // traz tudo, ordena: não devolvidos (deleted_at NULL) vêm primeiro por created_at asc,
        // depois devolvidos (deleted_at NOT NULL) por deleted_at desc
        $retiradas = Retirada::withTrashed()
            ->orderByRaw('(deleted_at IS NULL) DESC')
            ->orderByRaw('CASE WHEN deleted_at IS NULL THEN created_at END ASC')
            ->orderByRaw('CASE WHEN deleted_at IS NOT NULL THEN deleted_at END DESC')
            ->paginate(10);
    
        $manutencoes = Manutencao::with('retirada.ferramenta')
            ->whereIn('status', ['aguardando peça', 'em conserto', 'condenado'])
            ->paginate(10);
    
        $reparadas = Manutencao::with('retirada.ferramenta')
            ->where('status', 'voltar para estoque')
            ->paginate(10);
    
        return view('estoque.index', compact(
            'estoque',
            'retiradas',
            'manutencoes',
            'reparadas'
        ));
    }

    public function retirar()
    {
        $ferramentas = Ferramenta::where('em_uso', false)
            ->get();
        $obras = Obra::all();
        $responsaveis = User::all();
        return view('estoque.retirar', compact('ferramentas', 'obras', 'responsaveis'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'ferramenta_id'    => 'required|exists:ferramentas,id',
                'responsavel'      => 'required|exists:users,id',
                'previsao_retorno' => 'required|date',
                'uso_interno'      => 'required_without:obra_id|boolean',
                'obra_id'          => 'required_without:uso_interno|nullable|exists:obras,id',
            ]);
    
            // Cria a retirada
            Retirada::create([
                'ferramenta_id'    => $data['ferramenta_id'],
                'responsavel_id'   => $data['responsavel'],
                'previsao_retorno' => $data['previsao_retorno'],
                'obra_id'          => $data['uso_interno'] ? null : $data['obra_id'],
                'uso_interno'      => (bool) ($data['uso_interno'] ?? false),
            ]);
    
            // Marca a ferramenta como em uso
            Ferramenta::find($data['ferramenta_id'])->update(['em_uso' => true]);
    
            return back()
                ->with('success', 'Retirada registrada com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao registrar retirada: '.$e->getMessage());
    
            return back()
                ->withInput()
                ->with('error', 'Não foi possível registrar a retirada. Por favor, tente novamente.');
        }
    }
      

    public function devolucao(Request $request)
    {
        $retirada = Retirada::whereNull('deleted_at')->paginate(10);
        return view('estoque.devolucao', compact('retirada'));
    }

    public function storeDevolucao(Request $request)
    {
        $data = $request->validate([
            'retirada_id' => 'required|exists:retiradas,id',
            'data_retorno' => 'required|date',
        ]);

        try {
            // 1) marcar deleted_at
            $retirada = Retirada::findOrFail($data['retirada_id']);
            $retirada->deleted_at = now();
            $retirada->save();

            // 2) liberar ferramenta
            $f = $retirada->ferramenta;
            $f->em_uso = false;
            $f->save();

            return redirect()->back()
                ->with('success', 'Devolução registrada com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Devolução error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao registrar devolução.');
        }
    }

    public function storeDevolucaoDefeito(Request $request)
    {
        $data = $request->validate([
            'retirada_id' => 'required|exists:retiradas,id',
            'data_retorno' => 'required|date',
            'observacao' => 'required|string',
        ]);

        try {
            // soft delete da retirada
            $retirada = Retirada::findOrFail($data['retirada_id']);
            $retirada->deleted_at = now();
            $retirada->save();

            // registra manutenção sem liberar a ferramenta (em_uso permanece true)
            Manutencao::create([
                'retirada_id' => $retirada->id,
                'data_retorno' => $data['data_retorno'],
                'descricao' => $data['observacao'],
            ]);

            return redirect()->back()
                ->with('success', 'Problema registrado e item enviado para manutenção.');
        } catch (\Exception $e) {
            \Log::error('Erro ao registrar devolução com defeito: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao registrar a devolução com defeito.');
        }
    }

}
