<x-app-layout>
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">{{ __('Devolução de Ferramenta') }}</h2>
  </x-slot>

  <!-- Wrapper com Alpine.js -->
  <div x-data="modalData()">
    <!-- Tabela de retiradas -->
    <div class="py-10 container mx-auto px-4">
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
          <h3 class="text-lg font-medium text-gray-800">Ferramentas Retiradas</h3>
        </div>

        <div class="p-6">
          @if($retirada->count())
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Responsável</th>
                    <th class="px-4 py-2">Número de Série</th>
                    <th class="px-4 py-2">Ações</th>
                  </tr>
                </thead>
                <tbody class="divide-y">
                  @foreach($retirada as $item)
                    <tr class="hover:bg-gray-50">
                      <td class="px-4 py-2">{{ $item->id }}</td>
                      <td class="px-4 py-2">{{ $item->ferramenta->nome }}</td>
                      <td class="px-4 py-2">{{ $item->responsavel->name }}</td>
                      <td class="px-4 py-2">{{ $item->ferramenta->numero_serie }}</td>
                      <td class="px-4 py-2">
                        <button
                          @click.prevent="openModal('{{ $item->id }}')"
                          class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700 focus:outline-none"
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
            <p class="text-center text-gray-500">Nenhuma ferramenta retirada.</p>
          @endif
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      x-show="open"
      x-cloak
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md overflow-hidden">
        <form
          :action="actionUrl"
          method="POST"
          class="space-y-4"
          @submit="prepareSubmit"
        >
          @csrf
          <input type="hidden" name="retirada_id" :value="currentId">

          <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-800">Registrar Devolução</h3>
          </div>

          <div class="px-6 py-4 space-y-4">
            <div>
              <label class="inline-flex items-center">
                <input
                  type="checkbox"
                  x-model="defeito"
                  class="form-checkbox h-5 w-5 text-indigo-600 rounded"
                />
                <span class="ml-2 text-gray-700">Item devolvido com defeito</span>
              </label>
            </div>

            <div x-show="defeito" x-cloak>
              <label for="observacao" class="block text-sm font-medium text-gray-700">Observação do defeito</label>
              <textarea
                id="observacao"
                name="observacao"
                x-bind:required="defeito"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              ></textarea>
            </div>

            <div>
              <label for="data_retorno" class="block text-sm font-medium text-gray-700">Data de Retorno</label>
              <input
                type="date"
                id="data_retorno"
                name="data_retorno"
                x-bind:value="today"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required
              />
            </div>
          </div>

          <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-2">
            <button
              type="button"
              @click="close()"
              class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 focus:outline-none"
            >Cancelar</button>
            <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none"
            >Confirmar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function modalData() {
      return {
        open: false,
        currentId: null,
        defeito: false,
        actionUrl: '',
        today: new Date().toISOString().substr(0, 10),
        openModal(id) {
          this.currentId = id;
          this.defeito = false;
          this.actionUrl = '{{ route('estoque.devolucao.store') }}';
          this.open = true;
        },
        prepareSubmit(event) {
          this.actionUrl = this.defeito
            ? '{{ route('estoque.devolucao.defeito') }}'
            : '{{ route('estoque.devolucao.store') }}';
        },
        close() {
          this.open = false;
        }
      };
    }
  </script>
</x-app-layout>
