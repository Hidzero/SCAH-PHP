<?php

namespace App\Services;

use App\Models\Saida;
use App\Models\Veiculo;
use App\Models\Retirada;
use App\Models\Ferramenta;
use App\Models\Manutencao;
use Illuminate\Support\Facades\DB;

class ChartService
{
    public static function getRetiradasPorMes(): array
    {
        return Retirada::withTrashed()  // inclui retiradas com deleted_at != null
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, count(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->toArray();
    }


    public static function getManutencaoPorStatus()
    {
        return Manutencao::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->toArray();
    }

    public static function getVeiculosUso()
    {
        return [
            'em_uso' => Veiculo::where('em_uso', true)->count(),
            'disponiveis' => Veiculo::where('em_uso', false)->count(),
        ];
    }
    /**
     * 1) Retiradas ao longo do ano (por mês)
     */
    public static function getRetiradasPorAno(int $year = null): array
    {
        $query = Retirada::withTrashed()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, count(*) as total");

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        return $query
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->toArray();
    }


    /**
     * 2) Tempo médio de manutenção (dias) por mês de conclusão
     */
    public static function getTempoMedioManutencao(): array
    {
        return Manutencao::where('status', 'voltar para estoque')
            ->selectRaw("DATE_FORMAT(updated_at, '%Y-%m') as mes, AVG(DATEDIFF(updated_at, created_at)) as media_dias")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->toArray();
    }

    /**
     * 3) Distribuição de status de ferramentas
     */
    public static function getDistribuicaoStatusFerramentas(): array
    {
        $emUso = Ferramenta::where('em_uso', true)->count();
        $disponiveis = Ferramenta::where('em_uso', false)->count();
        $emManut = Manutencao::whereIn('status', ['aguardando peça', 'em conserto'])->distinct('retirada_id')->count();
        $condenadas = Manutencao::where('status', 'condenado')->distinct('retirada_id')->count();

        return [
            'labels' => ['Em Uso', 'Disponíveis', 'Em Manutenção', 'Condenadas'],
            'data' => [$emUso, $disponiveis, $emManut, $condenadas],
        ];
    }

    /**
     * 4) Top 5 ferramentas mais retiradas
     */
    public static function getTopFerramentasRetiradas(): array
    {
        $rows = Retirada::withTrashed()  // inclui retiradas soft-deleted
            ->select('ferramenta_id', DB::raw('count(*) as total'))
            ->groupBy('ferramenta_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return $rows->map(fn($r) => [
            'nome' => optional($r->ferramenta)->nome,
            'total' => $r->total,
        ])->toArray();
    }

    /**
     * 5) Quilometragem média mensal (Saídas)
     */
    public static function getKmMedioMensal(): array
    {
        return Saida::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, AVG(km_atual) as km_medio")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->toArray();
    }
}
