<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Gestão de Manutenção') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="container-lg px-4">
        <div class="card">
          <div class="card-header">Manutenções</div>
          <div class="card-body">
            <ul class="nav nav-tabs" id="manutencaoTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="aguardando-tab" data-bs-toggle="tab" data-bs-target="#aguardando" type="button" role="tab">Aguardando Peça</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="conserto-tab" data-bs-toggle="tab" data-bs-target="#conserto" type="button" role="tab">Em Conserto</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="condenada-tab" data-bs-toggle="tab" data-bs-target="#condenada" type="button" role="tab">Condenada</button>
              </li>
            </ul>
  
            <div class="tab-content mt-3" id="manutencaoTabsContent">
              <div class="tab-pane fade show active" id="aguardando" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Ferramenta</th>
                        <th>Descrição</th>
                        <th>Data Retorno</th>
                        <th Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($aguardandoPeca as $m)
                        <tr>
                          <td>{{ optional($m->retirada->ferramenta)->nome }}</td>
                          <td>{{ $m->descricao }}</td>
                          <td>{{ $m->data_retorno->format('d/m/Y') }}</td>
                          <td class="d-flex gap-1">
                            <form method="POST" action="{{ route('manutencao.solicitar', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-info" {{ $m->peca_solicitada ? 'disabled' : '' }}>Solicitar Peça</button>
                            </form>
                            <form method="POST" action="{{ route('manutencao.conserto', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-warning">Enviar para Conserto</button>
                            </form>
                            <form method="POST" action="{{ route('manutencao.condenar', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-danger">Condenar</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="4" class="text-center">Nenhuma manutenção aguardando peça.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
  
              <div class="tab-pane fade" id="conserto" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Ferramenta</th>
                        <th>Descrição</th>
                        <th>Data Conserto</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($emConserto as $m)
                        <tr>
                          <td>{{ optional($m->retirada->ferramenta)->nome }}</td>
                          <td>{{ $m->descricao }}</td>
                          <td>{{ optional($m->data_conserto)->format('d/m/Y') ?? '–' }}</td>
                          <td class="d-flex gap-1">
                            <form method="POST" action="{{ route('manutencao.voltar', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-secondary">Voltar a Aguardando</button>
                            </form>
                            <form method="POST" action="{{ route('manutencao.condenar', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-danger">Condenar</button>
                            </form>
                            <form method="POST" action="{{ route('manutencao.voltar.estoque', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-success">Voltar para Estoque</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="4" class="text-center">Nenhuma manutenção em conserto.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
  
              <div class="tab-pane fade" id="condenada" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Ferramenta</th>
                        <th>Descrição</th>
                        <th>Data Retorno</th>
                        <th>Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($condenada as $m)
                        <tr>
                          <td>{{ optional($m->retirada->ferramenta)->nome }}</td>
                          <td>{{ $m->descricao }}</td>
                          <td>{{ $m->data_retorno->format('d/m/Y') }}</td>
                          <td>
                            <form method="POST" action="{{ route('manutencao.voltar', $m->id) }}">@csrf
                              <button class="btn btn-sm btn-secondary">Voltar a Aguardando</button>
                            </form>
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="4" class="text-center">Nenhuma manutenção condenada.</td></tr>
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