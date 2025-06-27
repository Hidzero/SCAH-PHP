{{-- resources/views/veiculos/saida/create.blade.php --}}
<x-app-layout>
  @include('mensagem.mensagem')
  <x-slot name="header">
    <h2 class="text-2xl font-semibold text-gray-900">
      {{ __('Registrar Saída de Veículo') }}
    </h2>
  </x-slot>

  <div class="py-10 container mx-auto px-4">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class=" px-6 py-4 border-b">
        <h3 class="text-lg font-medium text-gray-800">{{ __('Nova Saída') }}</h3>
      </div>
      <div class="p-6">
        <form action="{{ route('veiculos.saida.store') }}" method="POST" enctype="multipart/form-data"
          class="space-y-6">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="veiculo" class="block text-sm font-medium text-gray-700">{{ __('Veículo') }}</label>
              <select name="veiculo_id" id="veiculo" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">{{ __('Selecione um veículo') }}</option>
                @foreach($veiculos as $v)
          <option value="{{ $v->id }}" @selected(old('veiculo_id') == $v->id)>
            {{ $v->nome }} — {{ $v->placa }}
          </option>
        @endforeach
              </select>
            </div>

            <div>
              <label for="motorista" class="block text-sm font-medium text-gray-700">{{ __('Motorista') }}</label>
              <select name="motorista_id" id="motorista" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">{{ __('Selecione um motorista') }}</option>
                @foreach($motoristas as $m)
          <option value="{{ $m->id }}" @selected(old('motorista_id') == $m->id)>
            {{ $m->nome }}
          </option>
        @endforeach
              </select>
            </div>

            <div>
              <label for="km_atual" class="block text-sm font-medium text-gray-700">{{ __('KM Atual') }}</label>
              <input type="number" name="km_atual" id="km_atual" required value="{{ old('km_atual') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Ex.: 12000">
            </div>

            <div class="flex items-center mt-6">
              <div class="flex items-center">
                <input id="possui_avarias" name="possui_avarias" type="checkbox" value="true"
                  class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="possui_avarias" class="ml-2 block text-sm text-gray-700">
                  {{ __('Possui avarias?') }}
                </label>
              </div>
            </div>
          </div>

          <div id="avarias_container" class="grid grid-cols-1 mt-4" style="display:none;">
            <label for="avarias_descritas"
              class="block text-sm font-medium text-gray-700">{{ __('Descreva as avarias') }}</label>
            <textarea id="avarias_descritas" name="avarias_descritas" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="Detalhe as avarias...">{{ old('avarias_descritas') }}</textarea>
          </div>

          <div class="text-right">
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
              {{ __('Registrar Saída') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const chk = document.getElementById('possui_avarias');
      const box = document.getElementById('avarias_container');
      const txt = document.getElementById('avarias_descritas');

      chk.addEventListener('change', () => {
        if (chk.checked) {
          box.style.display = 'block';
          txt.required = true;
        } else {
          box.style.display = 'none';
          txt.required = false;
        }
      });
    });
  </script>
</x-app-layout>