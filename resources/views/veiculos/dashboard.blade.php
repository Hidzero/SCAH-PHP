{{-- resources/views/veiculos/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard de Veículos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <div class="card">
                <div class="card-header">Dashboard de Veículos</div>
                <div class="card-body">
                    @if($veiculos->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped rounded-3 mb-0"
                                style="border-collapse: separate; border-spacing: 0;">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Modelo</th>
                                        <th>Marca</th>
                                        <th>KM Atual</th>
                                        <th>Próxima Troca de Óleo</th>
                                        <th>Em Uso?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($veiculos as $veiculo)
                                        <tr>
                                            <td>{{ $veiculo->nome }}</td>
                                            <td>{{ $veiculo->modelo }}</td>
                                            <td>{{ $veiculo->marca }}</td>
                                            <td>{{ number_format($veiculo->km_atual, 0, ',', '.') }} km</td>
                                            <td>
                                                @if($veiculo->proxima_troca_oleo)
                                                    {{ $veiculo->proxima_troca_oleo->format('d/m/Y') }}
                                                @else
                                                    {{ number_format($veiculo->km_atual + 10000, 0, ',', '.') }} km
                                                @endif
                                            </td>
                                            <td>
                                                @if($veiculo->em_uso)
                                                    <span class="badge bg-danger">Sim</span>
                                                @else
                                                    <span class="badge bg-success">Não</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0">Nenhum veículo cadastrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>