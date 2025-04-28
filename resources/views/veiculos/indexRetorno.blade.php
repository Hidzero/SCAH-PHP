{{-- resources/views/saidas/retorno.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Retorno de Veículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <div class="card">
                <div class="card-header">Retorno de Veículo</div>
                <div class="card-body">
                    <form action="{{ route('veiculos.retorno.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label for="saida_id" class="col-sm-2 col-form-label">Veículo em Uso</label>
                            <div class="col-sm-10">
                                @foreach($veiculos as $saida)
                                <select id="saida_id" name="saida_id" class="form-select" required>
                                    <option value="" selected>Selecione um veículo</option>
                                        <option value="{{ $saida->id }}">
                                            {{ $saida->veiculo->nome }}
                                            — {{ $saida->veiculo->placa }}
                                            ({{ $saida->motorista->nome }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="km_atual" class="col-sm-2 col-form-label">KM Atual</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="km_atual" name="km_atual" min="0"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="notas_retorno" class="col-sm-2 col-form-label">Notas de Retorno</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="notas_retorno" name="notas_retorno"
                                    rows="3"></textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                Confirmar Retorno
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>