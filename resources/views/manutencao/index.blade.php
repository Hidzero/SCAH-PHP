<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h1 class="text-2xl font-semibold text-gray-900">
      {{ __('Gestão de Manutenção') }}
    </h1>
  </x-slot>

  <div class="py-10 container mx-auto px-4" x-data="{ activeTab: '{{ request()->query('tab', 'aguardando') }}' }">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      {{-- abas responsivas --}}
      <div class="border-b px-6 py-4">
        <!-- Mobile: dropdown -->
        <div class="block lg:hidden mb-4">
          <select x-model="activeTab"
                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="aguardando">Aguardando Peça</option>
            <option value="conserto">Em Conserto</option>
            <option value="condenada">Condenada</option>
          </select>
        </div>
        <!-- Desktop: horizontal tabs -->
        <ul class="hidden lg:flex space-x-6">
          <li>
            <button
              @click.prevent="activeTab = 'aguardando'"
              :class="activeTab === 'aguardando' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-800'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap"
            >
              Aguardando Peça
            </button>
          </li>
          <li>
            <button
              @click.prevent="activeTab = 'conserto'"
              :class="activeTab === 'conserto' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-800'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap"
            >
              Em Conserto
            </button>
          </li>
          <li>
            <button
              @click.prevent="activeTab = 'condenada'"
              :class="activeTab === 'condenada' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600 hover:text-gray-800'"
              class="pb-2 font-medium focus:outline-none whitespace-nowrap"
            >
              Condenada
            </button>
          </li>
        </ul>
      </div>

      <div class="p-6 space-y-6">
        {{-- Aguardando Peça --}}
        <div x-show="activeTab === 'aguardando'" x-cloak class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Ferramenta</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Data Retorno</th>
                <th class="px-4 py-2 text-right">Ações</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($aguardandoPeca as $m)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2">{{ optional($m->retirada->ferramenta)->nome }}</td>
                  <td class="px-4 py-2">{{ $m->descricao }}</td>
                  <td class="px-4 py-2">{{ $m->data_retorno->format('d/m/Y') }}</td>
                  <td class="px-4 py-2 text-right space-x-1">
                    {{-- botões --}}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                    Nenhuma manutenção aguardando peça.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{-- Paginação Aguardando --}}
        <div class="mt-4">
          {{ $aguardandoPeca->appends(['tab' => 'aguardando'])->links() }}
        </div>

        {{-- Em Conserto --}}
        <div x-show="activeTab === 'conserto'" x-cloak class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Ferramenta</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Data Conserto</th>
                <th class="px-4 py-2 text-right">Ações</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($emConserto as $m)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2">{{ optional($m->retirada->ferramenta)->nome }}</td>
                  <td class="px-4 py-2">{{ $m->descricao }}</td>
                  <td class="px-4 py-2">{{ optional($m->data_conserto)->format('d/m/Y') ?? '–' }}</td>
                  <td class="px-4 py-2 text-right space-x-1">
                    {{-- botões --}}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                    Nenhuma manutenção em conserto.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{-- Paginação Conserto --}}
        <div class="mt-4">
          {{ $emConserto->appends(['tab' => 'conserto'])->links() }}
        </div>

        {{-- Condenada --}}
        <div x-show="activeTab === 'condenada'" x-cloak class="overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2">Ferramenta</th>
                <th class="px-4 py-2">Descrição</th>
                <th class="px-4 py-2">Data Retorno</th>
                <th class="px-4 py-2 text-right">Ações</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              @forelse($condenada as $m)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2">{{ optional($m->retirada->ferramenta)->nome }}</td>
                  <td class="px-4 py-2">{{ $m->descricao }}</td>
                  <td class="px-4 py-2">{{ $m->data_retorno->format('d/m/Y') }}</td>
                  <td class="px-4 py-2 text-right">
                    {{-- botões --}}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                    Nenhuma manutenção condenada.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{-- Paginação Condenada --}}
        <div class="mt-4">
          {{ $condenada->appends(['tab' => 'condenada'])->links() }}
        </div>
        
      </div>
    </div>
  </div>
</x-app-layout>