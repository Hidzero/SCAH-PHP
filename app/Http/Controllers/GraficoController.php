<?php

namespace App\Http\Controllers;

use App\Services\ChartService;  // <-- Verifique este import

class GraficoController extends Controller
{
    public function index()
    {
        $retiradasData  = ChartService::getRetiradasPorMes();
        $manutencaoData = ChartService::getManutencaoPorStatus();
        $veiculosUso    = ChartService::getVeiculosUso();
        $retiradasAno   = ChartService::getRetiradasPorAno();
        $tempoMedio     = ChartService::getTempoMedioManutencao();
        $distFerramenta = ChartService::getDistribuicaoStatusFerramentas();
        $topFerramentas = ChartService::getTopFerramentasRetiradas();
        $kmMedioMensal  = ChartService::getKmMedioMensal();

        return view('dashboard', compact(
            'retiradasData',
            'manutencaoData',
            'veiculosUso',
            'retiradasAno',
            'tempoMedio',
            'distFerramenta',
            'topFerramentas',
            'kmMedioMensal'
        ));
    }
}
