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
            {{ __('Ferramenta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <!-- Card de Cadastro (permanece igual) -->
            <div class="card mb-4">
                <div class="card-header">
                    Cadastrar Ferramenta
                </div>
                <div class="card-body">
                    <form action="{{ route('ferramentas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Ferramenta</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                placeholder="Digite o nome da ferramenta" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3"
                                placeholder="Digite a descrição" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="numero_serie" class="form-label">Número de Série</label>
                            <input type="text" class="form-control" id="numero_serie" name="numero_serie"
                                placeholder="Digite o número de série" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <!-- Card de Listagem -->
            <div class="card">
                <div class="card-header">
                    Ferramentas Cadastradas
                </div>
                <div class="card-body">
                    @if($ferramentas->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Descrição</th>
                                        <th>Número de Série</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ferramentas as $ferramenta)
                                        <!-- Linha de visualização -->
                                        <tr id="view-row-{{ $ferramenta->id }}">
                                            <td>{{ $ferramenta->id }}</td>
                                            <td>{{ $ferramenta->nome }}</td>
                                            <td>{{ $ferramenta->descricao }}</td>
                                            <td>{{ $ferramenta->numero_serie }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="showEditForm({{ $ferramenta->id }})">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('ferramentas.destroy', $ferramenta->id) }}"
                                                        method="POST" class="d-inline-flex flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Tem certeza que deseja excluir essa ferramenta?')">
                                                            Deletar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Linha de edição (inicialmente oculta) -->
                                        <tr id="edit-row-{{ $ferramenta->id }}" style="display: none;">
                                            <td>{{ $ferramenta->id }}</td>
                                            <td>
                                                <!-- Aqui colocamos um form que engloba a linha ou os inputs -->
                                                <form action="{{ route('ferramentas.update', $ferramenta->id) }}" method="POST"
                                                    id="edit-form-{{ $ferramenta->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="nome" class="form-control"
                                                        value="{{ $ferramenta->nome }}">
                                            </td>
                                            <td>
                                                <input type="text" name="descricao" class="form-control"
                                                    value="{{ $ferramenta->descricao }}">
                                            </td>
                                            <td>
                                                <input type="text" name="numero_serie" class="form-control"
                                                    value="{{ $ferramenta->numero_serie }}">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="cancelEdit({{ $ferramenta->id }})">
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
                        <p class="mb-0">Nenhuma ferramenta cadastrada.</p>
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