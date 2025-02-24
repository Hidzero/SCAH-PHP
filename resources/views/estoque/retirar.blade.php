<x-app-layout>
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

                        <!-- Ferramenta -->
                        <div class="mb-3">
                            <label for="ferramenta" class="form-label">Ferramenta</label>
                            <select class="form-select" id="ferramenta" name="ferramenta_id" required>
                                <option value="" disabled selected>Selecione uma ferramenta</option>
                                @foreach($ferramentas as $ferramenta)
                                    <option value="{{ $ferramenta->id }}"
                                        data-descricao="{{ $ferramenta->descricao }}"
                                        data-numero="{{ $ferramenta->numero_serie }}">
                                        {{ $ferramenta->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" readonly>
                        </div>

                        <!-- Número de Série -->
                        <div class="mb-3">
                            <label for="numero_serie" class="form-label">Número de Série</label>
                            <input type="text" class="form-control" id="numero_serie" name="numero_serie" readonly>
                        </div>

                        <!-- Responsável pela Retirada -->
                        <div class="mb-3">
                            <label for="responsavel" class="form-label">Responsável pela Retirada</label>
                            <input type="text" class="form-control" id="responsavel" name="responsavel"
                                value="{{ auth()->user()->name }}" required>
                        </div>

                        <!-- Previsão de Retorno -->
                        <div class="mb-3">
                            <label for="previsao_retorno" class="form-label">Previsão de Retorno</label>
                            <input type="date" class="form-control" id="previsao_retorno" name="previsao_retorno" required>
                        </div>

                        <!-- Checkbox de Uso Interno -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="uso_interno" name="uso_interno">
                            <label class="form-check-label" for="uso_interno">Uso Interno</label>
                        </div>

                        <!-- Obra -->
                        <div class="mb-3">
                            <label for="obra" class="form-label">Obra</label>
                            <select class="form-select" id="obra" name="obra_id">
                                <option value="" disabled selected>Selecione uma obra</option>
                                @foreach($obras as $obra)
                                    <option value="{{ $obra->id }}">{{ $obra->cliente }} - {{ $obra->endereco }}</option>
                                @endforeach
                            </select>
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
            const ferramentaSelect = document.getElementById("ferramenta");
            const descricaoInput = document.getElementById("descricao");
            const numeroSerieInput = document.getElementById("numero_serie");
            const usoInternoCheckbox = document.getElementById("uso_interno");
            const obraSelect = document.getElementById("obra");

            // Preencher descrição e número de série ao selecionar ferramenta
            ferramentaSelect.addEventListener("change", function () {
                const selectedOption = ferramentaSelect.options[ferramentaSelect.selectedIndex];
                descricaoInput.value = selectedOption.getAttribute("data-descricao");
                numeroSerieInput.value = selectedOption.getAttribute("data-numero");
            });

            // Desativar obra se uso interno estiver marcado
            usoInternoCheckbox.addEventListener("change", function () {
                obraSelect.disabled = this.checked;
            });
        });
    </script>
</x-app-layout>
