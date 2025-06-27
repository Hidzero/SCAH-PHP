<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Ferramentas') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="container mx-auto px-4 space-y-8">

      <!-- Card de Cadastro -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Cadastrar Nova Ferramenta</h3>
        <form action="{{ route('ferramentas.store') }}" method="POST" class="space-y-4">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label for="nome" class="block text-sm font-medium text-gray-600">Nome</label>
              <input type="text" id="nome" name="nome" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Nome da ferramenta" />
            </div>
            <div>
              <label for="numero_serie" class="block text-sm font-medium text-gray-600">Número de Série</label>
              <input type="text" id="numero_serie" name="numero_serie" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Série" />
            </div>
            <div>
              <label for="descricao" class="block text-sm font-medium text-gray-600">Descrição</label>
              <textarea id="descricao" name="descricao" rows="1" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Breve descrição"></textarea>
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
        <h3 class="text-xl font-medium text-gray-700 mb-4">Ferramentas Cadastradas</h3>
        @if($ferramentas->count())
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-50">
          <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Descrição</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Série</th>
          <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($ferramentas as $f)
        <tr class="hover:bg-gray-50" id="view-row-{{ $f->id }}">
        <td class="px-4 py-2 text-sm text-gray-700">{{ $f->id }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $f->nome }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $f->descricao }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $f->numero_serie }}</td>
        <td class="px-4 py-2 text-sm text-gray-700 text-center space-x-2">
        <button type="button"
        class="inline-flex px-2 py-1 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600 transition"
        onclick="showEditForm({{ $f->id }})">Editar</button>
        <form action="{{ route('ferramentas.destroy', $f->id) }}" method="POST" class="inline">
        @csrf @method('DELETE')
        <button type="submit"
          class="inline-flex px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition"
          onclick="return confirm('Deseja excluir?')">Excluir</button>
        </form>
        </td>
        </tr>
        <tr id="edit-row-{{ $f->id }}" class="hidden bg-gray-50">
        <td class="px-4 py-2 text-sm text-gray-700">{{ $f->id }}</td>
        <form action="{{ route('ferramentas.update', $f->id) }}" method="POST" class="w-full">
        @csrf @method('PUT')
        <td class="px-4 py-2 text-sm">
        <input type="text" name="nome" value="{{ $f->nome }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="text" name="descricao" value="{{ $f->descricao }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="text" name="numero_serie" value="{{ $f->numero_serie }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm text-center space-x-2">
        <button type="submit"
          class="inline-flex px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">Salvar</button>
        <button type="button" onclick="cancelEdit({{ $f->id }})"
          class="inline-flex px-2 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition">Cancelar</button>
        </td>
        </form>
        </tr>
      @endforeach
        </tbody>
        </table>
      </div>
    @else
      <p class="text-center text-gray-500">Nenhuma ferramenta cadastrada.</p>
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