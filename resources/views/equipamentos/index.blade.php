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
            {{ __('Equipamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <!-- Card de Cadastro -->
            <div class="card mb-4">
                <div class="card-header">
                    Cadastrar Equipamento
                </div>
                <div class="card-body">
                    <form action="{{ route('equipamentos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Equipamento</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                placeholder="Digite o nome do equipamento" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo do Equipamento</label>
                            <input type="text" class="form-control" id="tipo" name="tipo"
                                placeholder="Digite o tipo do equipamento" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <!-- Card de Listagem -->
            <div class="card">
                <div class="card-header">
                    Equipamentos Cadastrados
                </div>
                <div class="card-body">
                    @if($equipamentos->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipamentos as $equipamento)
                                        <tr id="view-row-{{ $equipamento->id }}">
                                            <td>{{ $equipamento->id }}</td>
                                            <td>{{ $equipamento->nome }}</td>
                                            <td>{{ $equipamento->tipo }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="showEditForm({{ $equipamento->id }})">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('equipamentos.destroy', $equipamento->id) }}"
                                                        method="POST" class="d-inline-flex flex-fill">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                                            Deletar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr id="edit-row-{{ $equipamento->id }}" style="display: none;">
                                            <td>{{ $equipamento->id }}</td>
                                            <td>
                                                <form action="{{ route('equipamentos.update', $equipamento->id) }}" method="POST"
                                                    id="edit-form-{{ $equipamento->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="nome" class="form-control"
                                                        value="{{ $equipamento->nome }}">
                                            </td>
                                            <td>
                                                <input type="text" name="tipo" class="form-control"
                                                    value="{{ $equipamento->tipo }}">
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="cancelEdit({{ $equipamento->id }})">
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
                        <p class="mb-0">Nenhum equipamento cadastrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
