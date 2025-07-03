<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Equipamentos') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="container mx-auto px-4 space-y-8">

      <!-- Card de Cadastro -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Cadastrar Equipamento</h3>
        <form action="{{ route('equipamentos.store') }}" method="POST" class="space-y-4">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="nome" class="block text-sm font-medium text-gray-600">Nome</label>
              <input type="text" id="nome" name="nome" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Ex: Compressor de Ar" />
            </div>
            <div>
              <label for="tipo" class="block text-sm font-medium text-gray-600">Tipo</label>
              <input type="text" id="tipo" name="tipo" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Ex: Pneumático" />
            </div>
          </div>
          <div class="text-right">
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
              Cadastrar
            </button>
          </div>
        </form>
      </div>

      <!-- Card de Listagem -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Equipamentos Cadastrados</h3>
        @if($equipamentos->count())
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-50">
          <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Tipo</th>
          <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($equipamentos as $equipamento)
        <tr id="view-row-{{ $equipamento->id }}" class="hover:bg-gray-50">
        <td class="px-4 py-2 text-sm text-gray-700">{{ $equipamento->id }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $equipamento->nome }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $equipamento->tipo }}</td>
        <td class="px-4 py-2 text-sm text-gray-700 text-center space-x-2">
        <button type="button"
        class="inline-flex px-2 py-1 bg-yellow-500 text-white text-xs font-medium rounded hover:bg-yellow-600 transition"
        onclick="showEditForm({{ $equipamento->id }})">Editar</button>
        <form action="{{ route('equipamentos.destroy', $equipamento->id) }}" method="POST" class="inline">
        @csrf @method('DELETE')
        <button type="submit"
          class="inline-flex px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition"
          onclick="return confirm('Deseja excluir este equipamento?')">Excluir</button>
        </form>
        </td>
        </tr>
        <tr id="edit-row-{{ $equipamento->id }}" class="hidden bg-gray-50">
        <td class="px-4 py-2 text-sm text-gray-700">{{ $equipamento->id }}</td>
        <form action="{{ route('equipamentos.update', $equipamento->id) }}" method="POST" class="w-full">
        @csrf @method('PUT')
        <td class="px-4 py-2 text-sm">
        <input type="text" name="nome" value="{{ $equipamento->nome }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="text" name="tipo" value="{{ $equipamento->tipo }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm text-center space-x-2">
        <button type="submit"
          class="inline-flex px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">Salvar</button>
        <button type="button" onclick="cancelEdit({{ $equipamento->id }})"
          class="inline-flex px-2 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition">Cancelar</button>
        </td>
        </form>
        </tr>
      @endforeach
        </tbody>
        </table>
      </div>
      <div class="mt-4">  
        {{ $equipamentos->links() }}
      </div>
    @else
      <p class="text-center text-gray-500">Nenhum equipamento cadastrado.</p>
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