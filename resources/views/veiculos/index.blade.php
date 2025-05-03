<x-app-layout>
    <x-slot name="header">
      <h2 class="text-2xl font-semibold text-gray-900">
        {{ __('Veículos') }}
      </h2>
    </x-slot>
  
    <div class="py-8">
      <div class="container mx-auto px-4 space-y-8">
  
        <!-- Card de Cadastro -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-xl font-medium text-gray-700 mb-4">Cadastrar Novo Veículo</h3>
          <form action="{{ route('veiculo.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div>
                <label for="nome" class="block text-sm font-medium text-gray-600">Nome do Ativo</label>
                <input
                  type="text" id="nome" name="nome" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Ex: Caminhão Branco"
                />
              </div>
              <div>
                <label for="tipo" class="block text-sm font-medium text-gray-600">Tipo do Ativo</label>
                <select
                  id="tipo" name="tipo" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                  <option value="Carro">Carro</option>
                  <option value="Caminhão">Caminhão</option>
                </select>
              </div>
              <div>
                <label for="marca" class="block text-sm font-medium text-gray-600">Marca</label>
                <input
                  type="text" id="marca" name="marca" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Ex: Volvo"
                />
              </div>
              <div>
                <label for="modelo" class="block text-sm font-medium text-gray-600">Modelo</label>
                <input
                  type="text" id="modelo" name="modelo" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Ex: FH 540"
                />
              </div>
              <div>
                <label for="placa" class="block text-sm font-medium text-gray-600">Placa</label>
                <input
                  type="text" id="placa" name="placa" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="ABC-1234"
                />
              </div>
              <div>
                <label for="km_atual" class="block text-sm font-medium text-gray-600">KM Atual</label>
                <input
                  type="number" id="km_atual" name="km_atual" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="0"
                />
              </div>
            </div>
            <div class="text-right">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition"
              >
                Cadastrar
              </button>
            </div>
          </form>
        </div>
  
        <!-- Card de Listagem -->
        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-xl font-medium text-gray-700 mb-4">Veículos Cadastrados</h3>
          @if($veiculos->count())
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Tipo</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Marca</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Modelo</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Placa</th>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">KM Atual</th>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Ações</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($veiculos as $veiculo)
                    <tr class="hover:bg-gray-50" id="view-row-{{ $veiculo->id }}">
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->id }}</td>
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->nome }}</td>
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->tipo }}</td>
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->marca }}</td>
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->modelo }}</td>
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->placa }}</td>
                      <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($veiculo->km_atual,0,',','.') }} km</td>
                      <td class="px-4 py-2 text-sm text-gray-700 text-center space-x-2">
                        <button
                          type="button"
                          class="inline-flex px-2 py-1 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600 transition"
                          onclick="showEditForm({{ $veiculo->id }})"
                        >Editar</button>
                        <form action="{{ route('veiculo.destroy',$veiculo->id) }}" method="POST" class="inline">
                          @csrf @method('DELETE')
                          <button
                            type="submit"
                            class="inline-flex px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition"
                            onclick="return confirm('Deseja excluir este veículo?')"
                          >Excluir</button>
                        </form>
                      </td>
                    </tr>
                    <tr id="edit-row-{{ $veiculo->id }}" class="hidden bg-gray-50">
                      <td class="px-4 py-2 text-sm text-gray-700">{{ $veiculo->id }}</td>
                      <form action="{{ route('veiculo.update',$veiculo->id) }}" method="POST" class="w-full">
                        @csrf @method('PUT')
                        <td class="px-4 py-2 text-sm">
                          <input
                            type="text" name="nome" value="{{ $veiculo->nome }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          />
                        </td>
                        <td class="px-4 py-2 text-sm">
                          <select
                            name="tipo"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          >
                            <option value="Carro" {{ $veiculo->tipo==='Carro'? 'selected':'' }}>Carro</option>
                            <option value="Caminhão" {{ $veiculo->tipo==='Caminhão'? 'selected':'' }}>Caminhão</option>
                          </select>
                        </td>
                        <td class="px-4 py-2 text-sm">
                          <input
                            type="text" name="marca" value="{{ $veiculo->marca }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          />
                        </td>
                        <td class="px-4 py-2 text-sm">
                          <input
                            type="text" name="modelo" value="{{ $veiculo->modelo }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          />
                        </td>
                        <td class="px-4 py-2 text-sm">
                          <input
                            type="text" name="placa" value="{{ $veiculo->placa }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          />
                        </td>
                        <td class="px-4 py-2 text-sm">
                          <input
                            type="number" name="km_atual" value="{{ $veiculo->km_atual }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                          />
                        </td>
                        <td class="px-4 py-2 text-sm text-center space-x-2">
                          <button
                            type="submit"
                            class="inline-flex px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition"
                          >Salvar</button>
                          <button
                            type="button" onclick="cancelEdit({{ $veiculo->id }})"
                            class="inline-flex px-2 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition"
                          >Cancelar</button>
                        </td>
                      </form>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <p class="text-center text-gray-500">Nenhum veículo cadastrado.</p>
          @endif
        </div>
      </div>
    </div>
  
    <script>
      function showEditForm(id) {
        document.getElementById('view-row-'+id).classList.add('hidden');
        document.getElementById('edit-row-'+id).classList.remove('hidden');
      }
      function cancelEdit(id) {
        document.getElementById('edit-row-'+id).classList.add('hidden');
        document.getElementById('view-row-'+id).classList.remove('hidden');
      }
    </script>
  </x-app-layout>
  