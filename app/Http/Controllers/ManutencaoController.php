<?php
namespace App\Http\Controllers;

use App\Models\Manutencao;
use Illuminate\Http\Request;

class ManutencaoController extends Controller
{
    public function index()
    {
        $aguardandoPeca = Manutencao::with('retirada.ferramenta')->where('status', 'aguardando peça')->paginate(10);
        $emConserto = Manutencao::with('retirada.ferramenta')->where('status', 'em conserto')->paginate(10);
        $condenada = Manutencao::with('retirada.ferramenta')->where('status', 'condenado')->paginate(10);

        return view('manutencao.index', compact(
            'aguardandoPeca',
            'emConserto',
            'condenada'
        ));
    }

    public function solicitarPeca($id)
    {
        $m = Manutencao::findOrFail($id);
        if (!$m->peca_solicitada) {
            $m->update(['peca_solicitada' => true]);
        }
        return back();
    }

    public function enviarConserto($id)
    {
        Manutencao::findOrFail($id)->update(['status' => 'em conserto']);
        return back();
    }

    public function condenar($id)
    {
        Manutencao::findOrFail($id)->update(['status' => 'condenado']);
        return back();
    }

    public function voltarAguardando($id)
    {
        Manutencao::findOrFail($id)->update([
            'status' => 'aguardando peça',
            'peca_solicitada' => false
        ]);
        return back();
    }

    public function voltarEstoque($id)
    {
        $manutencao = Manutencao::findOrFail($id);
        // atualiza status para “voltar para estoque”
        $manutencao->update([
            'status' => 'voltar para estoque',
        ]);

        // libera a ferramenta: em_uso = false
        $ferramenta = $manutencao->retirada->ferramenta;
        $ferramenta->update([
            'em_uso' => false,
        ]);

        return back();
    }

    public function manuais()
    {
        return view('manutencao.manuais');
    }
}