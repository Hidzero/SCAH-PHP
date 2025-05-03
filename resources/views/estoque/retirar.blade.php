<x-app-layout>
    <x-slot name="header">
      <h2 class="text-2xl font-semibold text-gray-900">{{ __('Retirada de Ferramenta') }}</h2>
    </x-slot>
  
    <div class="py-10 container mx-auto px-4">
      <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
          <h3 class="text-lg font-medium text-gray-800">Registrar Retirada</h3>
        </div>
        <form action="{{ route('estoque.store') }}" method="POST" class="px-6 py-6 space-y-6">
          @csrf
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Ferramenta -->
            <div>
              <label for="ferramenta" class="block text-sm font-medium text-gray-700">Ferramenta</label>
              <select id="ferramenta" name="ferramenta_id" required
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" disabled selected>Selecione...</option>
                @foreach($ferramentas as $f)
                  <option value="{{ $f->id }}">{{ $f->nome }}</option>
                @endforeach
              </select>
            </div>
            <!-- Responsável -->
            <div>
              <label for="responsavel" class="block text-sm font-medium text-gray-700">Responsável</label>
              <select id="responsavel" name="responsavel" required
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" disabled selected>Selecione...</option>
                @foreach($responsaveis as $r)
                  <option value="{{ $r->id }}">{{ $r->name }}</option>
                @endforeach
              </select>
            </div>
            <!-- Previsão Retorno -->
            <div>
              <label for="previsao_retorno" class="block text-sm font-medium text-gray-700">Previsão de Retorno</label>
              <input type="date" id="previsao_retorno" name="previsao_retorno" required
                     class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
          </div>
  
          <div class="flex items-center space-x-4">
            <div class="flex items-center">
              <input id="uso_interno" name="uso_interno" type="checkbox"
                     class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
              <label for="uso_interno" class="ml-2 block text-sm text-gray-700">Uso Interno</label>
            </div>
            <div class="flex-1">
              <label for="obra" class="block text-sm font-medium text-gray-700">Obra (opcional)</label>
              <select id="obra" name="obra_id" disabled
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" selected>Selecione...</option>
                @foreach($obras as $obra)
                  <option value="{{ $obra->id }}">{{ $obra->cliente }} - {{ $obra->endereco }}</option>
                @endforeach
              </select>
            </div>
          </div>
  
          <div class="text-right">
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Registrar
            </button>
          </div>
        </form>
      </div>
    </div>
  
    <script>
      document.addEventListener('DOMContentLoaded', ()=>{
        const checkbox = document.getElementById('uso_interno');
        const obraSelect = document.getElementById('obra');
        checkbox.addEventListener('change', ()=>{
          if(checkbox.checked) {
            obraSelect.disabled = true;
            obraSelect.classList.add('bg-gray-100','cursor-not-allowed');
          } else {
            obraSelect.disabled = false;
            obraSelect.classList.remove('bg-gray-100','cursor-not-allowed');
          }
        });
      });
    </script>
  </x-app-layout>
  