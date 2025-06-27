{{-- resources/views/manuais/create.blade.php --}}
<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">{{ __('Enviar Manual') }}</h2>
  </x-slot>

  <div class="py-10 container mx-auto px-4">
    <div class="bg-white shadow rounded-lg p-6 space-y-6">
      <form action="{{ route('manutencao.manuais.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        <div>
          <label for="arquivo" class="block text-sm font-medium text-gray-700">Selecione o arquivo</label>
          <input type="file" name="arquivo" id="arquivo" required class="mt-1 block w-full text-sm text-gray-700" />
          @error('arquivo')
        <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
      @enderror
        </div>
        <div class="text-right">
          <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Enviar
          </button>
        </div>
      </form>
      <a href="{{ route('manutencao.manuais.index') }}" class="inline-block text-sm text-indigo-600 hover:underline">
        ← Voltar à lista
      </a>
    </div>
  </div>
</x-app-layout>