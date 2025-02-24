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
            {{ __('Veículos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <!-- Card de Cadastro -->
            <div class="card mb-4">
                <div class="card-header">
                    Cadastrar Veículo
                </div>
                <div class="card-body">
                    <form action="{{ route('veiculo.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Ativo</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                placeholder="Digite o nome do ativo" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo do Ativo</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="Carro">Carro</option>
                                <option value="Caminhão">Caminhão</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca"
                                placeholder="Digite a marca do veículo" required>
                        </div>
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo"
                                placeholder="Digite o modelo do veículo" required>
                        </div>
                        <div class="mb-3">
                            <label for="placa" class="form-label">Placa</label>
                            <input type="text" class="form-control" id="placa" name="placa"
                                placeholder="Digite a placa do veículo" required>
                        </div>
                        <div class="mb-3">
                            <label for="km_atual" class="form-label">KM Atual</label>
                            <input type="number" class="form-control" id="km_atual" name="km_atual"
                                placeholder="Digite a quilometragem atual" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <!-- Card de Listagem -->
            <div class="card">
                <div class="card-header">
                    Veículos Cadastrados
                </div>
                <div class="card-body">
                    @if($veiculos->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Modelo</th>
                                        <th>Marca</th>
                                        <th>Placa</th>
                                        <th>KM Atual</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($veiculos as $veiculo)
                                        <!-- Linha de visualização -->
                                        <tr id="view-row-{{ $veiculo->id }}">
                                            <td>{{ $veiculo->id }}</td>
                                            <td>{{ $veiculo->nome }}</td>
                                            <td>{{ $veiculo->tipo }}</td>
                                            <td>{{ $veiculo->marca }}</td>
                                            <td>{{ $veiculo->modelo }}</td>
                                            <td>{{ $veiculo->placa }}</td>
                                            <td>{{ number_format($veiculo->km_atual, 0, ',', '.') }} km</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="showEditForm({{ $veiculo->id }})">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('veiculo.destroy', $veiculo->id) }}"
                                                        method="POST" class="d-inline-flex flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Tem certeza que deseja excluir este veículo?')">
                                                            Deletar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Linha de edição (inicialmente oculta) -->
                                        <tr id="edit-row-{{ $veiculo->id }}" style="display: none;">
                                            <td>{{ $veiculo->id }}</td>
                                            <td>
                                                <form action="{{ route('veiculo.update', $veiculo->id) }}" method="POST"
                                                    id="edit-form-{{ $veiculo->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="nome" class="form-control"
                                                        value="{{ $veiculo->nome }}">
                                            </td>
                                            <td>
                                                <select name="tipo" class="form-control">
                                                    <option value="Carro" {{ $veiculo->tipo == 'Carro' ? 'selected' : '' }}>Carro</option>
                                                    <option value="Caminhão" {{ $veiculo->tipo == 'Caminhão' ? 'selected' : '' }}>Caminhão</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="modelo" class="form-control"
                                                    value="{{ $veiculo->modelo }}">
                                            </td>
                                            <td>
                                                <input type="text" name="marca" class="form-control"
                                                    value="{{ $veiculo->marca }}">
                                            </td>
                                            <td>
                                                <input type="text" name="placa" class="form-control"
                                                    value="{{ $veiculo->placa }}">
                                            </td>
                                            <td>
                                                <input type="number" name="km_atual" class="form-control"
                                                    value="{{ $veiculo->km_atual }}">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="cancelEdit({{ $veiculo->id }})">
                                                        Cancelar
                                                    </button>
                                                </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0">Nenhum veículo cadastrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para alternar entre visualização e edição -->
    <script>
        function showEditForm(id) {
            document.getElementById('view-row-' + id).style.display = 'none';
            document.getElementById('edit-row-' + id).style.display = 'table-row';
        }

        function cancelEdit(id) {
            document.getElementById('edit-row-' + id).style.display = 'none';
            document.getElementById('view-row-' + id).style.display = 'table-row';
        }
    </script>
</x-app-layout>
