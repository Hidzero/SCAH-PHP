{{-- resources/views/veiculos/dashboard.blade.php --}}
<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Dashboard de Veículos') }}
    </h2>
  </x-slot>

  <div class="py-10 container mx-auto px-4 space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-xl font-medium text-gray-700 mb-4">{{ __('Dashboard de Veículos') }}</h3>

      @if($veiculos->count())
      <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Modelo</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Marca</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">KM Atual</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Próxima Troca</th>
          <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Em Uso?</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @foreach($veiculos as $v)
        <tr class="hover:bg-gray-50">
        <td class="px-4 py-3 text-sm text-gray-700">{{ $v->nome }}</td>
        <td class="px-4 py-3 text-sm text-gray-700">{{ $v->modelo }}</td>
        <td class="px-4 py-3 text-sm text-gray-700">{{ $v->marca }}</td>
        <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($v->km_atual, 0, ',', '.') }} km</td>
        <td class="px-4 py-3 text-sm text-gray-700">
        @if($v->proxima_troca_oleo)
        {{ $v->proxima_troca_oleo->format('d/m/Y') }}
      @else
        {{ number_format($v->km_atual + 10000, 0, ',', '.') }} km
      @endif
        </td>
        <td class="px-4 py-3 text-center">
        @if($v->em_uso)
        <span class="inline-block bg-red-500 text-white text-xs font-medium px-2 py-1 rounded-full">
        Sim
        </span>
      @else
        <span class="inline-block bg-green-500 text-white text-xs font-medium px-2 py-1 rounded-full">
        Não
        </span>
      @endif
        </td>
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
</x-app-layout>