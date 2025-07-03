<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Obras') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="container mx-auto px-4 space-y-8">

      <!-- Card de Cadastro -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Cadastrar Nova Obra</h3>
        <form action="{{ route('obra.store') }}" method="POST" class="space-y-4">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="cliente" class="block text-sm font-medium text-gray-600">Cliente</label>
              <input type="text" id="cliente" name="cliente" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Nome do cliente" />
            </div>
            <div>
              <label for="endereco" class="block text-sm font-medium text-gray-600">Endereço da Obra</label>
              <textarea id="endereco" name="endereco" rows="2" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Endereço completo"></textarea>
            </div>
            <div>
              <label for="inicio_obra" class="block text-sm font-medium text-gray-600">Data de Início</label>
              <input type="date" id="inicio_obra" name="inicio_obra" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
              <label for="fim_obra" class="block text-sm font-medium text-gray-600">Data de Término (Opcional)</label>
              <input type="date" id="fim_obra" name="fim_obra"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
          </div>
          <div class="text-right">
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
              Cadastrar
            </button>
          </div>
        </form>
      </div>

      <!-- Card de Lista -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Obras Cadastradas</h3>
        @if($obras->count())
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-50">
          <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Cliente</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Endereço</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Início</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Término</th>
          <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($obras as $obra)
          <tr class="hover:bg-gray-50" id="view-row-{{ $obra->id }}">
          <td class="px-4 py-2 text-sm text-gray-700">{{ $obra->id }}</td>
          <td class="px-4 py-2 text-sm text-gray-700">{{ $obra->cliente }}</td>
          <td class="px-4 py-2 text-sm text-gray-700">{{ $obra->endereco }}</td>
          <td class="px-4 py-2 text-sm text-gray-700">
          {{ \Carbon\Carbon::parse($obra->inicio_obra)->format('d/m/Y') }}</td>
          <td class="px-4 py-2 text-sm text-gray-700">
          {{ $obra->fim_obra
        ? \Carbon\Carbon::parse($obra->fim_obra)->format('d/m/Y')
        : 'Em andamento' }}
          </td>
          <td class="px-4 py-2 text-sm text-gray-700 text-center space-x-2">
          <button type="button"
          class="inline-flex px-2 py-1 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600 transition"
          onclick="showEditForm({{ $obra->id }})">Editar</button>
          <form action="{{ route('obra.destroy', $obra->id) }}" method="POST" class="inline">
          @csrf @method('DELETE')
          <button type="submit"
            class="inline-flex px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition"
            onclick="return confirm('Deseja excluir esta obra?')">Excluir</button>
          </form>
          </td>
          </tr>
          <tr id="edit-row-{{ $obra->id }}" class="hidden bg-gray-50">
          <td class="px-4 py-2 text-sm text-gray-700">{{ $obra->id }}</td>
          <form action="{{ route('obra.update', $obra->id) }}" method="POST" class="w-full">
          @csrf @method('PUT')
          <td class="px-4 py-2 text-sm">
          <input type="text" name="cliente" value="{{ $obra->cliente }}"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
          </td>
          <td class="px-4 py-2 text-sm">
          <input type="text" name="endereco" value="{{ $obra->endereco }}"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
          </td>
          <td class="px-4 py-2 text-sm">
          <input type="date" name="inicio_obra" value="{{ $obra->inicio_obra }}"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
          </td>
          <td class="px-4 py-2 text-sm">
          <input type="date" name="fim_obra" value="{{ $obra->fim_obra }}"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
          </td>
          <td class="px-4 py-2 text-sm text-center space-x-2">
          <button type="submit"
            class="inline-flex px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">Salvar</button>
          <button type="button" onclick="cancelEdit({{ $obra->id }})"
            class="inline-flex px-2 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition">Cancelar</button>
          </td>
          </form>
          </tr>
      @endforeach
        </tbody>
        </table>
      </div>
      <div class="mt-4">  
        {{ $obras->links() }}
      </div>
    @else
      <p class="text-center text-gray-500">Nenhuma obra cadastrada.</p>
    @endif
      </div>
    </div>
  </div>

  <script>
    function showEditForm(id) {
      document.getElementById('view-row-' + id).classList.add('hidden');
      document.getElementById('edit-row-' + id).classList.remove('hidden');
    }
    function cancelEdit(id) {
      document.getElementById('edit-row-' + id).classList.add('hidden');
      document.getElementById('view-row-' + id).classList.remove('hidden');
    }
  </script>
</x-app-layout>