<x-app-layout>
  <x-slot name="header">
    <h1 class="text-2xl font-semibold text-gray-900">
      {{ __('Gestão de Manutenção') }}
    </h1>
  </x-slot>

  <div class="py-10 container mx-auto px-4" x-data="{ activeTab: 'aguardando' }">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      {{-- abas --}}
      <div class="border-b px-6 py-4">
        <ul class="flex space-x-6">
          <li>
            <button
              @click.prevent="activeTab = 'aguardando'"
              :class="activeTab === 'aguardando' 
                ? 'border-b-2 border-indigo-600 text-indigo-600' 
                : 'text-gray-600 hover:text-gray-800'"
              class="pb-2 font-medium focus:outline-none"
            >
              Aguardando Peça
            </button>
          </li>
          <li>
            <button
              @click.prevent="activeTab = 'conserto'"
              :class="activeTab === 'conserto' 
                ? 'border-b-2 border-indigo-600 text-indigo-600' 
                : 'text-gray-600 hover:text-gray-800'"
              class="pb-2 font-medium focus:outline-none"
            >
              Em Conserto
            </button>
          </li>
          <li>
            <button
              @click.prevent="activeTab = 'condenada'"
              :class="activeTab === 'condenada' 
                ? 'border-b-2 border-indigo-600 text-indigo-600' 
                : 'text-gray-600 hover:text-gray-800'"
              class="pb-2 font-medium focus:outline-none"
            >
              Condenada
            </button>
          </li>
        </ul>
      </div>

      <div class="p-6 space-y-6">
        {{-- Aguardando Peça --}}
        <div x-show="activeTab === 'aguardando'" x-cloak>
          <div class="overflow-x-auto">
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
                      <form method="POST" action="{{ route('manutencao.solicitar', $m->id) }}" class="inline">@csrf
                        <button 
                          class="px-2 py-1 bg-blue-500 text-white text-xs rounded disabled:opacity-50"
                          {{ $m->peca_solicitada ? 'disabled' : '' }}
                        >Solicitar Peça</button>
                      </form>
                      <form method="POST" action="{{ route('manutencao.conserto', $m->id) }}" class="inline">@csrf
                        <button class="px-2 py-1 bg-yellow-500 text-white text-xs rounded">Enviar p/ Conserto</button>
                      </form>
                      <form method="POST" action="{{ route('manutencao.condenar', $m->id) }}" class="inline">@csrf
                        <button class="px-2 py-1 bg-red-600 text-white text-xs rounded">Condenar</button>
                      </form>
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
        </div>

        {{-- Em Conserto --}}
        <div x-show="activeTab === 'conserto'" x-cloak>
          <div class="overflow-x-auto">
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
                      <form method="POST" action="{{ route('manutencao.voltar', $m->id) }}" class="inline">@csrf
                        <button class="px-2 py-1 bg-gray-500 text-white text-xs rounded">Voltar</button>
                      </form>
                      <form method="POST" action="{{ route('manutencao.condenar', $m->id) }}" class="inline">@csrf
                        <button class="px-2 py-1 bg-red-600 text-white text-xs rounded">Condenar</button>
                      </form>
                      <form method="POST" action="{{ route('manutencao.voltar.estoque', $m->id) }}" class="inline">@csrf
                        <button class="px-2 py-1 bg-green-600 text-white text-xs rounded">p/ Estoque</button>
                      </form>
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
        </div>

        {{-- Condenada --}}
        <div x-show="activeTab === 'condenada'" x-cloak>
          <div class="overflow-x-auto">
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
                      <form method="POST" action="{{ route('manutencao.voltar', $m->id) }}" class="inline">@csrf
                        <button class="px-2 py-1 bg-gray-500 text-white text-xs rounded">Voltar</button>
                      </form>
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
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
