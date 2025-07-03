<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Motoristas') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="container mx-auto px-4 space-y-8">

      <!-- Card de Cadastro -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Cadastrar Motorista</h3>
        <form action="{{ route('motorista.store') }}" method="POST" class="space-y-4">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
              <label for="nome" class="block text-sm font-medium text-gray-600">Nome</label>
              <input type="text" id="nome" name="nome" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Nome do motorista" />
            </div>
            <div>
              <label for="cnh" class="block text-sm font-medium text-gray-600">CNH</label>
              <input type="text" id="cnh" name="cnh" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Número da CNH" />
            </div>
            <div>
              <label for="validade_cnh" class="block text-sm font-medium text-gray-600">Validade CNH</label>
              <input type="date" id="validade_cnh" name="validade_cnh" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
              <label for="data_nascimento" class="block text-sm font-medium text-gray-600">Data Nascimento</label>
              <input type="date" id="data_nascimento" name="data_nascimento" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            </div>
            <div>
              <label for="endereco" class="block text-sm font-medium text-gray-600">Endereço</label>
              <input type="text" id="endereco" name="endereco" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Endereço" />
            </div>
            <div>
              <label for="telefone" class="block text-sm font-medium text-gray-600">Telefone</label>
              <input type="text" id="telefone" name="telefone" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Telefone de contato" />
            </div>
            <div class="md:col-span-2 lg:col-span-1">
              <label for="email" class="block text-sm font-medium text-gray-600">E-mail</label>
              <input type="email" id="email" name="email" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="E-mail do motorista" />
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

      <!-- Card de Listagem -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-medium text-gray-700 mb-4">Motoristas Cadastrados</h3>
        @if($motoristas->count())
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-50">
          <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">CNH</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Validade</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nascimento</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Endereço</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Telefone</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">E-mail</th>
          <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($motoristas as $motorista)
        <tr class="hover:bg-gray-50" id="view-row-{{ $motorista->id }}">
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->id }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->nome }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->cnh }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">
        {{ \Carbon\Carbon::parse($motorista->validade_cnh)->format('d/m/Y') }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">
        {{ \Carbon\Carbon::parse($motorista->data_nascimento)->format('d/m/Y') }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->endereco }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->telefone }}</td>
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->email }}</td>
        <td class="px-4 py-2 text-sm text-gray-700 text-center space-x-2">
        <button type="button"
        class="inline-flex px-2 py-1 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600 transition"
        onclick="showEditForm({{ $motorista->id }})">Editar</button>
        <form action="{{ route('motorista.destroy', $motorista->id) }}" method="POST" class="inline">
        @csrf @method('DELETE')
        <button type="submit"
          class="inline-flex px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition"
          onclick="return confirm('Deseja excluir este motorista?')">Excluir</button>
        </form>
        </td>
        </tr>
        <tr id="edit-row-{{ $motorista->id }}" class="hidden bg-gray-50">
        <td class="px-4 py-2 text-sm text-gray-700">{{ $motorista->id }}</td>
        <form action="{{ route('motorista.update', $motorista->id) }}" method="POST" class="w-full">
        @csrf @method('PUT')
        <td class="px-4 py-2 text-sm">
        <input type="text" name="nome" value="{{ $motorista->nome }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="text" name="cnh" value="{{ $motorista->cnh }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="date" name="validade_cnh" value="{{ $motorista->validade_cnh }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="date" name="data_nascimento" value="{{ $motorista->data_nascimento }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="text" name="endereco" value="{{ $motorista->endereco }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="text" name="telefone" value="{{ $motorista->telefone }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm">
        <input type="email" name="email" value="{{ $motorista->email }}"
          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
        </td>
        <td class="px-4 py-2 text-sm text-center space-x-2">
        <button type="submit"
          class="inline-flex px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">
          Salvar
        </button>
        <button type="button" onclick="cancelEdit({{ $motorista->id }})"
          class="inline-flex px-2 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition">
          Cancelar
        </button>
        </td>
        </form>
        </tr>
      @endforeach
        </tbody>
        </table>
      </div>
      <div class="mt-4">  
        {{ $motoristas->links() }}
      </div>
    @else
      <p class="text-center text-gray-500">Nenhum motorista cadastrado.</p>
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