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
            {{ __('Motoristas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <!-- Card de Cadastro -->
            <div class="card mb-4">
                <div class="card-header">
                    Cadastrar Motorista
                </div>
                <div class="card-body">
                    <form action="{{ route('motorista.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do motorista" required>
                        </div>
                        <div class="mb-3">
                            <label for="cnh" class="form-label">CNH</label>
                            <input type="text" class="form-control" id="cnh" name="cnh" placeholder="Número da CNH" required>
                        </div>
                        <div class="mb-3">
                            <label for="validade_cnh" class="form-label">Validade da CNH</label>
                            <input type="date" class="form-control" id="validade_cnh" name="validade_cnh" required>
                        </div>
                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone de contato" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail do motorista" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <!-- Card de Listagem -->
            <div class="card">
                <div class="card-header">
                    Motoristas Cadastrados
                </div>
                <div class="card-body">
                    @if($motoristas->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>CNH</th>
                                        <th>Validade</th>
                                        <th>Data Nascimento</th>
                                        <th>Endereço</th>
                                        <th>Telefone</th>
                                        <th>E-mail</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($motoristas as $motorista)
                                        <!-- Linha de visualização -->
                                        <tr id="view-row-{{ $motorista->id }}">
                                            <td>{{ $motorista->id }}</td>
                                            <td>{{ $motorista->nome }}</td>
                                            <td>{{ $motorista->cnh }}</td>
                                            <td>{{ \Carbon\Carbon::parse($motorista->validade_cnh)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($motorista->data_nascimento)->format('d/m/Y') }}</td>
                                            <td>{{ $motorista->endereco }}</td>
                                            <td>{{ $motorista->telefone }}</td>
                                            <td>{{ $motorista->email }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="showEditForm({{ $motorista->id }})">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('motorista.destroy', $motorista->id) }}"
                                                        method="POST" class="d-inline-flex flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Tem certeza que deseja excluir este motorista?')">
                                                            Deletar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Linha de edição (inicialmente oculta) -->
                                        <tr id="edit-row-{{ $motorista->id }}" style="display: none;">
                                            <td>{{ $motorista->id }}</td>
                                            <td>
                                                <form action="{{ route('motorista.update', $motorista->id) }}" method="POST"
                                                    id="edit-form-{{ $motorista->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="nome" class="form-control"
                                                        value="{{ $motorista->nome }}">
                                            </td>
                                            <td>
                                                <input type="text" name="cnh" class="form-control"
                                                    value="{{ $motorista->cnh }}">
                                            </td>
                                            <td>
                                                <input type="date" name="validade_cnh" class="form-control"
                                                    value="{{ $motorista->validade_cnh }}">
                                            </td>
                                            <td>
                                                <input type="date" name="data_nascimento" class="form-control"
                                                    value="{{ $motorista->data_nascimento }}">
                                            </td>
                                            <td>
                                                <input type="text" name="endereco" class="form-control"
                                                    value="{{ $motorista->endereco }}">
                                            </td>
                                            <td>
                                                <input type="text" name="telefone" class="form-control"
                                                    value="{{ $motorista->telefone }}">
                                            </td>
                                            <td>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ $motorista->email }}">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="cancelEdit({{ $motorista->id }})">
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
                        <p class="mb-0">Nenhum motorista cadastrado.</p>
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
