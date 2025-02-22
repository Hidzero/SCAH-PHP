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
            {{ __('Obras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <!-- Card de Cadastro -->
            <div class="card mb-4">
                <div class="card-header">
                    Cadastrar Obra
                </div>
                <div class="card-body">
                    <form action="{{ route('obra.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente"
                                placeholder="Digite o nome do cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço da Obra</label>
                            <textarea class="form-control" id="endereco" name="endereco" rows="2"
                                placeholder="Digite o endereço da obra" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="inicio_obra" class="form-label">Data de Início</label>
                            <input type="date" class="form-control" id="inicio_obra" name="inicio_obra" required>
                        </div>
                        <div class="mb-3">
                            <label for="fim_obra" class="form-label">Data de Término (Opcional)</label>
                            <input type="date" class="form-control" id="fim_obra" name="fim_obra">
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <!-- Card de Listagem -->
            <div class="card">
                <div class="card-header">
                    Obras Cadastradas
                </div>
                <div class="card-body">
                    @if($obras->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Endereço</th>
                                        <th>Início</th>
                                        <th>Término</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($obras as $obra)
                                        <!-- Linha de visualização -->
                                        <tr id="view-row-{{ $obra->id }}">
                                            <td>{{ $obra->id }}</td>
                                            <td>{{ $obra->cliente }}</td>
                                            <td>{{ $obra->endereco }}</td>
                                            <td>{{ \Carbon\Carbon::parse($obra->inicio_obra)->format('d/m/Y') }}</td>
                                            <td>
                                                {{ $obra->fim_obra ? \Carbon\Carbon::parse($obra->fim_obra)->format('d/m/Y') : 'Em andamento' }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="showEditForm({{ $obra->id }})">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('obra.destroy', $obra->id) }}"
                                                        method="POST" class="d-inline-flex flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Tem certeza que deseja excluir esta obra?')">
                                                            Deletar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Linha de edição (inicialmente oculta) -->
                                        <tr id="edit-row-{{ $obra->id }}" style="display: none;">
                                            <td>{{ $obra->id }}</td>
                                            <td>
                                                <form action="{{ route('obra.update', $obra->id) }}" method="POST"
                                                    id="edit-form-{{ $obra->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="cliente" class="form-control"
                                                        value="{{ $obra->cliente }}">
                                            </td>
                                            <td>
                                                <input type="text" name="endereco" class="form-control"
                                                    value="{{ $obra->endereco }}">
                                            </td>
                                            <td>
                                                <input type="date" name="inicio_obra" class="form-control"
                                                    value="{{ $obra->inicio_obra }}">
                                            </td>
                                            <td>
                                                <input type="date" name="fim_obra" class="form-control"
                                                    value="{{ $obra->fim_obra }}">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="cancelEdit({{ $obra->id }})">
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
                        <p class="mb-0">Nenhuma obra cadastrada.</p>
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
