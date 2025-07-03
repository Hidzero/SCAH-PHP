<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h1 class="text-2xl font-semibold text-gray-900">
      {{ __('Gestão de Estoque') }}
    </h1>
  </x-slot>

  <div class="py-10 container mx-auto px-4" x-data="{ activeTab: 'estoque' }">
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b">
        <!-- Mobile: dropdown selector -->
        <div class="block lg:hidden mb-4">
          <select x-model="activeTab"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="estoque">Estoque</option>
            <option value="retiradas">Retiradas</option>
            <option value="manutencao">Manutenção</option>
            <option value="reparadas">Reparadas</option>
          </select>
        </div>

        <!-- Desktop: horizontal tabs -->
        <ul class="hidden lg:flex space-x-6 overflow-x-auto">
          <li>
            <button @click.prevent="activeTab = 'estoque'"
              :class="activeTab === 'estoque' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap">Estoque</button>
          </li>
          <li>
            <button @click.prevent="activeTab = 'retiradas'"
              :class="activeTab === 'retiradas' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap">Retiradas</button>
          </li>
          <li>
            <button @click.prevent="activeTab = 'manutencao'"
              :class="activeTab === 'manutencao' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap">Manutenção</button>
          </li>
          <li>
            <button @click.prevent="activeTab = 'reparadas'"
              :class="activeTab === 'reparadas' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap">Reparadas</button>
          </li>
        </ul>
      </div>

      <div class="p-6 space-y-6">
        <!-- Estoque Tab -->
        <div x-show="activeTab === 'estoque'" class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Nome</th>
                <th class="px-4 py-2">Número de Série</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($estoque as $item)
          <tr class="hover:bg-gray-50">
          <td class="px-4 py-2">{{ $item->nome }}</td>
          <td class="px-4 py-2">{{ $item->numero_serie }}</td>
          </tr>
        @empty
          <tr>
          <td colspan="2" class="px-4 py-2 text-center">Nenhum item em estoque.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
          <div class="mt-4">
            {{ $estoque->appends(['tab' => 'estoque'])->links() }}
          </div>
        </div>

        <!-- Retiradas Tab -->
        <div x-show="activeTab === 'retiradas'" class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Item</th>
                <th class="px-4 py-2">Retirado por</th>
                <th class="px-4 py-2">Usando em</th>
                <th class="px-4 py-2">Data</th>
                <th class="px-4 py-2">Devolução</th> <!-- nova coluna -->
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($retiradas as $r)
            <tr class="hover:bg-gray-50">
            <td class="px-4 py-2">{{ $r->ferramenta->nome }}</td>
            <td class="px-4 py-2">{{ $r->responsavel->name }}</td>
            <td class="px-4 py-2">{{ $r->obra_id ? $r->obra->cliente : 'Uso Interno' }}</td>
            <td class="px-4 py-2">{{ $r->created_at->format('d/m/Y H:i') }}</td>
            <td class="px-4 py-2">
              @if($r->deleted_at)
          {{ $r->deleted_at->format('d/m/Y H:i') }}
          @else
          — {{-- ou você pode colocar 'Pendente' --}}
          @endif
            </td>
            </tr>
        @empty
          <tr>
          <td colspan="5" class="px-4 py-2 text-center">Nenhuma retirada registrada.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
          <div class="mt-4">
            {{ $retiradas->appends(['tab' => 'retiradas'])->links() }}
          </div>
        </div>

        <!-- Manutenção Tab -->
        <div x-show="activeTab === 'manutencao'" class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Item</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Data Retorno</th>
                <th class="px-4 py-2">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($manutencoes as $m)
          <tr class="hover:bg-gray-50">
          <td class="px-4 py-2">{{ optional($m->retirada->ferramenta)->nome }}</td>
          <td class="px-4 py-2">{{ $m->descricao }}</td>
          <td class="px-4 py-2">{{ $m->data_retorno->format('d/m/Y') }}</td>
          <td class="px-4 py-2">{{ ucfirst($m->status) }}</td>
          </tr>
        @empty
          <tr>
          <td colspan="4" class="px-4 py-2 text-center">Nenhuma manutenção em andamento.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
          <div class="mt-4">
            {{ $manutencoes->appends(['tab' => 'manutencao'])->links() }}
          </div>
        </div>

        <!-- Reparadas Tab -->
        <div x-show="activeTab === 'reparadas'" class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Item</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Data Retorno</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($reparadas as $m)
          <tr class="hover:bg-gray-50">
          <td class="px-4 py-2">{{ optional($m->retirada->ferramenta)->nome }}</td>
          <td class="px-4 py-2">{{ $m->descricao }}</td>
          <td class="px-4 py-2">{{ $m->data_retorno->format('d/m/Y') }}</td>
          </tr>
        @empty
          <tr>
          <td colspan="3" class="px-4 py-2 text-center">Nenhuma peça reparada.</td>
          </tr>
        @endforelse
            </tbody>
          </table>
          <div class="mt-4">
            {{ $reparadas->appends(['tab' => 'reparadas'])->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>