<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestão de Estoque') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="container-lg px-4">
        <div class="card">
          <div class="card-header">Gestão de Estoque</div>
          <div class="card-body">
  
            <ul class="nav nav-tabs" id="estoqueTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="estoque-tab" data-bs-toggle="tab"
                        data-bs-target="#estoque" type="button" role="tab">
                  Estoque
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="retiradas-tab" data-bs-toggle="tab"
                        data-bs-target="#retiradas" type="button" role="tab">
                  Retiradas
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="manutencao-tab" data-bs-toggle="tab"
                        data-bs-target="#manutencao" type="button" role="tab">
                  Manutenção
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="reparadas-tab" data-bs-toggle="tab"
                        data-bs-target="#reparadas" type="button" role="tab">
                  Reparadas
                </button>
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
                        <th>Número de Série</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($estoque as $item)
                        <tr>
                          <td>{{ $item->nome }}</td>
                          <td>{{ $item->numero_serie }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="2" class="text-center">Nenhum item em estoque.</td>
                        </tr>
                      @endforelse
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
                      @forelse($retiradas as $r)
                        <tr>
                          <td>{{ $r->ferramenta->nome }}</td>
                          <td>{{ $r->responsavel->name }}</td>
                          <td>{{ $r->obra_id
                                    ? $r->obra->cliente
                                    : 'Uso Interno' }}
                          </td>
                          <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">Nenhuma retirada registrada.</td>
                        </tr>
                      @endforelse
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
                        <th>Descrição</th>
                        <th>Data Retorno</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($manutencoes as $m)
                        <tr>
                          <td>{{ optional($m->retirada->ferramenta)->nome }}</td>
                          <td>{{ $m->descricao }}</td>
                          <td>{{ $m->data_retorno->format('d/m/Y') }}</td>
                          <td>{{ ucfirst($m->status) }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">Nenhuma manutenção em andamento.</td>
                        </tr>
                      @endforelse
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
                        <th>Item</th>
                        <th>Descrição</th>
                        <th>Data Retorno</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($reparadas as $m)
                        <tr>
                          <td>{{ optional($m->retirada->ferramenta)->nome }}</td>
                          <td>{{ $m->descricao }}</td>
                          <td>{{ $m->data_retorno->format('d/m/Y') }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="3" class="text-center">Nenhuma peça reparada.</td>
                        </tr>
                      @endforelse
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
  