<x-app-layout>
    @if (session('success'))
        <x-message type="success">
            {{ session('success') }}
        </x-message>
    @endif

    @if (session('error'))
        <x-message type="error">
            {{ session('error') }}
        </x-message>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Retirada de Ferramenta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <div class="card">
                <div class="card-header">
                    Retirada de Ferramenta
                </div>
                <div class="card-body">
                    <form action="{{ route('estoque.store') }}" method="POST">
                        @csrf

                        <div class="row form p-3">
                            <!-- Ferramenta -->
                            <div class="col-sm-4">
                                <label for="ferramenta" class="form-label">Ferramenta</label>
                                <select class="form-select" id="ferramenta" name="ferramenta_id" required>
                                    <option value="" selected>Selecione uma ferramenta</option>
                                    @foreach($ferramentas as $ferramenta)
                                        <option value="{{ $ferramenta->id }}">
                                            {{ $ferramenta->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Responsável pela Retirada -->
                            <div class="col-sm-4">
                                <label for="responsavel" class="form-label">Responsável pela Retirada</label>
                                <select type="text" class="form-control" id="responsavel" name="responsavel" value=""
                                    required>
                                    <option value="" selected>Selecione um responsavel</option>
                                    @foreach ($responsaveis as $responsavel)
                                        <option value="{{ $responsavel->id }}">{{ $responsavel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Previsão de Retorno -->
                            <div class="col-sm-4">
                                <label for="previsao_retorno" class="form-label">Previsão de Retorno</label>
                                <input type="date" class="form-control" id="previsao_retorno" name="previsao_retorno"
                                    required>
                            </div>
                        </div>
                        <div class="row p-3">
                            <!-- Checkbox de Uso Interno -->
                            <div class="col-md-2 d-flex align-items-center justify-content-center">
                              <div class="form-check ">
                                <input type="checkbox" class="form-check-input" id="uso_interno" name="uso_interno">
                                <label class="form-check-label ms-2" for="uso_interno">Uso Interno</label>
                              </div>
                            </div>
                          
                            <!-- Obra -->
                            <div class="col-md-10">
                              <label for="obra" class="form-label">Obra</label>
                              <select class="form-select" id="obra" name="obra_id">
                                <option value="" selected>Selecione uma obra</option>
                                @foreach($obras as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->cliente }} - {{ $obra->endereco }}</option>
                                @endforeach
                            </select>                            
                            </div>
                        </div>
                          
                        <button type="submit" class="btn btn-primary">Registrar Retirada</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para preencher os campos e desativar obra -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const usoInternoCheckbox = document.getElementById("uso_interno");
            const obraSelect = document.getElementById("obra");

            usoInternoCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    // Impede interação, mas mantém o campo no formulário
                    obraSelect.style.pointerEvents = "none";
                    obraSelect.style.opacity = "0.5";
                    obraSelect.value = ""; // limpa o valor
                } else {
                    obraSelect.style.pointerEvents = "auto";
                    obraSelect.style.opacity = "1";
                }
            });
        });
    </script>
</x-app-layout>