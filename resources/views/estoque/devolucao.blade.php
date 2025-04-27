<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Devolução de Ferramenta') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="container-lg px-4">
        <div class="card">
          <div class="card-header">Ferramentas Retiradas</div>
          <div class="card-body">
            @if($retirada->count())
              <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Responsável</th>
                      <th>Número de Série</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($retirada as $item)
                      <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->ferramenta->nome }}</td>
                        <td>{{ $item->responsavel->name }}</td>
                        <td>{{ $item->ferramenta->numero_serie }}</td>
                        <td>
                          <!-- Botão que abre o modal -->
                          <button
                            class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#devolucaoModal"
                            data-retirada-id="{{ $item->id }}"
                          >
                            Devolver
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <p class="mb-0">Nenhuma ferramenta retirada.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  
    <!-- Modal de Devolução -->
    <div
      class="modal fade"
      id="devolucaoModal"
      tabindex="-1"
      aria-labelledby="devolucaoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <form action="{{ route('estoque.devolucao.store') }}" method="POST" class="modal-content">
          @csrf
          <input type="hidden" name="retirada_id" id="modal_retirada_id">
  
          <div class="modal-header">
            <h5 class="modal-title" id="devolucaoModalLabel">Registrar Devolução</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
  
          <div class="modal-body">
            <!-- Checkbox de item quebrado -->
            <div class="form-check mb-3">
              <input
                class="form-check-input"
                type="checkbox"
                id="modal_com_defeito"
                name="precisa_manutencao"
              >
              <label class="form-check-label" for="modal_com_defeito">
                Item devolvido com defeito
              </label>
            </div>
  
            <!-- Campo de observação, oculto por padrão -->
            <div class="mb-3" id="modal_obs_container" style="display:none;">
              <label for="modal_observacao" class="form-label">Observação do defeito</label>
              <textarea
                class="form-control"
                id="modal_observacao"
                name="observacao"
                rows="3"
              ></textarea>
            </div>
  
            <!-- Data de retorno -->
            <div class="mb-3">
              <label for="modal_data_retorno" class="form-label">Data de Retorno</label>
              <input
                type="date"
                class="form-control"
                id="modal_data_retorno"
                name="data_retorno"
                required
              >
            </div>
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
              Confirmar Devolução
            </button>
          </div>
        </form>
      </div>
    </div>
  
    <!-- Scripts de ativação do modal e do campo de observação -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('devolucaoModal');
        const obsContainer = document.getElementById('modal_obs_container');
        const checkbox = document.getElementById('modal_com_defeito');
        const hiddenId = document.getElementById('modal_retirada_id');
  
        // Ao abrir o modal, captura o retirada-id do botão
        modal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          hiddenId.value = button.getAttribute('data-retirada-id');
          // reseta estado
          checkbox.checked = false;
          obsContainer.style.display = 'none';
        });
  
        // Ao marcar defect, mostra campo de observação
        checkbox.addEventListener('change', function () {
          obsContainer.style.display = this.checked ? 'block' : 'none';
        });
      });
    </script>
  </x-app-layout>
  