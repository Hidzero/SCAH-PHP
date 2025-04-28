<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestão de Estoque') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <div class="card">
                <div class="card-header">
                    Gestão de Estoque
                </div>
                <div class="card-body">
                    <!-- Navegação entre abas -->
                    <ul class="nav nav-tabs" id="estoqueTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="estoque-tab" data-bs-toggle="tab" data-bs-target="#estoque" type="button" role="tab">Estoque</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="retiradas-tab" data-bs-toggle="tab" data-bs-target="#retiradas" type="button" role="tab">Retiradas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manutencao-tab" data-bs-toggle="tab" data-bs-target="#manutencao" type="button" role="tab">Manutenção</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reparadas-tab" data-bs-toggle="tab" data-bs-target="#reparadas" type="button" role="tab">Reparadas</button>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="estoqueTabsContent">
                        <!-- Aba Estoque -->
                        <div class="tab-pane fade show active" id="estoque" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Numero de Serie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($estoque) && count($estoque))
                                            @foreach($estoque as $item)
                                                <tr>
                                                    <td>{{ $item->nome }}</td>
                                                    <td>{{ $item->numero_serie }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Nenhum item em estoque.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Aba Retiradas -->
                        <div class="tab-pane fade" id="retiradas" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Retirado por</th>
                                            <th>Usando em</th>
                                            <th>Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($retiradas) && count($retiradas))
                                            @foreach($retiradas as $retirada)
                                                <tr>
                                                    <td>{{ $retirada->ferramenta->nome }}</td>
                                                    <td>{{ $retirada->responsavel->name }}</td>
                                                    <td>
                                                        {{ $retirada->obra_id
                                                            ? $retirada->obra->cliente
                                                            : 'Uso Interno' }}
                                                      </td>
                                                      
                                                    <td>{{ \Carbon\Carbon::parse($retirada->created_at)->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Nenhuma retirada registrada.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Aba Manutenção -->
                        <div class="tab-pane fade" id="manutencao" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Motivo</th>
                                            <th>Data de Envio</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($manutencoes) && count($manutencoes))
                                            @foreach($manutencoes as $manutencao)
                                            {{-- @dd($manutencao->retirada) --}}
                                                <tr>
                                                    <td>{{ $manutencao->retirada->ferramenta->nome }}</td>
                                                    <td>{{ $manutencao->descricao }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($manutencao->data_retorno)->format('d/m/Y') }}</td>
                                                    <td>{{ ucfirst($manutencao->status) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Nenhuma manutenção em andamento.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Aba Reparadas -->
                        <div class="tab-pane fade" id="reparadas" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Item</th>
                                            <th>Data de Conclusão</th>
                                            <th>Observação</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($reparadas) && count($reparadas))
                                            @foreach($reparadas as $reparada)
                                                <tr>
                                                    <td>{{ $reparada->id }}</td>
                                                    <td>{{ $reparada->nome }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reparada->data_conclusao)->format('d/m/Y') }}</td>
                                                    <td>{{ $reparada->observacao }}</td>
                                                    <td><span class="badge bg-success">Reparado</span></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Nenhuma peça reparada.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
