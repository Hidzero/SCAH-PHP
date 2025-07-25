{{-- resources/views/manuais/index.blade.php --}}
<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">{{ __('Manuais') }}</h2>
  </x-slot>

  <div class="py-10 container mx-auto px-4">
    <div class="space-y-6">
      <a href="{{ route('manutencao.manuais.create') }}"
        class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
        + Enviar Manual
      </a>

      @if(session('success'))
      <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

      @if($manuais->count())
      <!-- Mobile view: cards -->
      <div class="block lg:hidden space-y-4">
      @foreach($manuais as $m)
      <div class="bg-white shadow rounded-lg p-4">
      <div class="font-medium text-gray-800 truncate">{{ $m->original_name }}</div>
      <div class="text-gray-600 text-sm">{{ $m->uploader->name }}</div>
      <div class="text-gray-500 text-xs">{{ $m->created_at->format('d/m/Y H:i') }}</div>
      <div class="mt-4 flex space-x-2">
      <a href="{{ route('manutencao.manuais.download', $m) }}"
        class="flex-1 text-center px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
        Download
      </a>
      <form action="{{ route('manutencao.manuais.destroy', $m) }}" method="POST" class="flex-1">
        @csrf @method('DELETE')
        <button type="submit" class="w-full px-3 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"
        onclick="return confirm('Deseja excluir este manual?')">
        Excluir
        </button>
      </form>
      </div>
      </div>
    @endforeach
      </div>

      <!-- Desktop view: table -->
      <div class="hidden lg:block bg-white shadow rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Arquivo</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Enviado por</th>
          <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Data</th>
          <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500 uppercase">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($manuais as $m)
        <tr class="hover:bg-gray-50">
        <td class="px-4 py-3 text-sm text-gray-700 truncate">{{ $m->original_name }}</td>
        <td class="px-4 py-3 text-sm text-gray-700">{{ $m->uploader->name }}</td>
        <td class="px-4 py-3 text-sm text-gray-700">{{ $m->created_at->format('d/m/Y H:i') }}</td>
        <td class="px-4 py-3 text-sm text-gray-700 text-right space-x-2">
        <a href="{{ route('manutencao.manuais.download', $m) }}"
        class="px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
        Download
        </a>
        <form action="{{ route('manutencao.manuais.destroy', $m) }}" method="POST" class="inline">
        @csrf @method('DELETE')
        <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"
          onclick="return confirm('Deseja excluir este manual?')">
          Excluir
        </button>
        </form>
        </td>
        </tr>
      @endforeach
        </tbody>
        </table>
      </div>
      </div>
    @else
      <p class="text-center text-gray-500">Nenhum manual disponível.</p>
    @endif
    </div>
  </div>
  </div>
</x-app-layout>