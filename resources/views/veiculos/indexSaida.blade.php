{{-- resources/views/saidas/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Registrar Saída de Veículo') }}
      </h2>
    </x-slot>
  
    <div class="py-12">
      <div class="container-lg px-4">
        <div class="card">
          <div class="card-header">Nova Saída</div>
          <div class="card-body">
            <form action="{{ route('veiculos.saida.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
  
              <div class="row mb-3">
                <label for="veiculo" class="col-sm-2 col-form-label">Veículo</label>
                <div class="col-sm-10">
                  <select name="veiculo_id" id="veiculo" class="form-select" required>
                    <option value="" selected>Selecione um veículo</option>
                    @foreach($veiculos as $veiculo)
                      <option value="{{ $veiculo->id }}" {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                        {{ $veiculo->nome }} — {{ $veiculo->placa }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
  
              <div class="row mb-3">
                <label for="motorista" class="col-sm-2 col-form-label">Motorista</label>
                <div class="col-sm-10">
                  <select name="motorista_id" id="motorista" class="form-select" required>
                    <option value="" selected>Selecione um motorista</option>
                    @foreach($motoristas as $motorista)
                      <option value="{{ $motorista->id }}" {{ old('motorista_id') == $motorista->id ? 'selected' : '' }}>
                        {{ $motorista->nome }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
  
              <div class="row mb-3">
                <label for="km_atual" class="col-sm-2 col-form-label">KM Atual</label>
                <div class="col-sm-10">
                  <input
                    type="number"
                    name="km_atual"
                    id="km_atual"
                    class="form-control"
                    value="{{ old('km_atual') }}"
                    required
                  >
                </div>
              </div>
  
              <div class="row mb-3">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 d-flex align-items-center">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      id="possui_avarias"
                      name="possui_avarias"
                      value="true"
                    >
                    <label class="form-check-label ms-2" for="possui_avarias">
                      Possui avarias
                    </label>
                  </div>
                </div>
              </div>
  
              <div class="row mb-3" id="avarias_container" style="display:none;">
                <label for="avarias_descritas" class="col-sm-2 col-form-label">Descreva as avarias</label>
                <div class="col-sm-10">
                  <textarea
                    class="form-control"
                    id="avarias_descritas"
                    name="avarias_descritas"
                    rows="3"
                  >{{ old('avarias_descritas') }}</textarea>
                </div>
              </div>
  
              <div class="text-end">
                <button type="submit" class="btn btn-primary">Registrar Saída</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const checkbox      = document.getElementById('possui_avarias');
        const container     = document.getElementById('avarias_container');
        const textarea      = document.getElementById('avarias_descritas');
  
        checkbox.addEventListener('change', function () {
          if (this.checked) {
            container.style.display   = 'flex';
            textarea.required         = true;
          } else {
            container.style.display   = 'none';
            textarea.required         = false;
          }
        });
      });
    </script>
  </x-app-layout>
  