{{-- resources/views/saidas/retorno.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="text-2xl font-semibold text-gray-900">
        {{ __('Registrar Retorno de Veículo') }}
      </h2>
    </x-slot>
  
    <div class="py-10 container mx-auto px-4">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
          <h3 class="text-lg font-medium text-gray-800">{{ __('Retorno de Veículo') }}</h3>
        </div>
        <div class="p-6">
          <form action="{{ route('veiculos.retorno.store') }}" method="POST" class="space-y-6">
            @csrf
  
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Seleção de saída ativa -->
              <div>
                <label for="saida_id" class="block text-sm font-medium text-gray-700">
                  {{ __('Veículo em Uso') }}
                </label>
                <select name="saida_id" id="saida_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                  <option value="">{{ __('Selecione um veículo') }}</option>
                  @foreach($veiculos as $saida)
                    <option value="{{ $saida->id }}">
                      {{ $saida->veiculo->nome }}
                      — {{ $saida->veiculo->placa }}
                      ({{ $saida->motorista->nome }})
                    </option>
                  @endforeach
                </select>
              </div>
  
              <!-- KM Atual -->
              <div>
                <label for="km_atual" class="block text-sm font-medium text-gray-700">
                  {{ __('KM Atual') }}
                </label>
                <input
                  type="number"
                  name="km_atual"
                  id="km_atual"
                  min="0"
                  required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Ex.: 15000"
                />
              </div>
  
              <!-- Notas de Retorno (full width on md) -->
              <div class="md:col-span-2">
                <label for="notas_retorno" class="block text-sm font-medium text-gray-700">
                  {{ __('Notas de Retorno') }}
                </label>
                <textarea
                  name="notas_retorno"
                  id="notas_retorno"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Adicione observações ou detalhes do retorno..."
                >{{ old('notas_retorno') }}</textarea>
              </div>
            </div>
  
            <div class="text-right">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
              >
                {{ __('Confirmar Retorno') }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </x-app-layout>
  