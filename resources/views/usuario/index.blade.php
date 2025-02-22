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
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container-lg px-4">
            <div class="card mb-4">
                <div class="card-header">
                    Cadastrar Usuario
                </div>
                <div class="card-body">
                    <form action="{{ route('usuario.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Digite o email" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Nivel de usuario</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Selecione uma opção</option>
                                <option value="master">Master</option>
                                <option value="admin">Admin</option>
                                <option value="usuario">Usuario padrão</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Digite a senha" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirme a senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Usuarios cadastrados
                </div>
                <div class="card-body">
                    @if($usuarios->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Nivel de Usuario</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                        <tr id="view-row-{{ $usuario->id }}">
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>{{ $usuario->role }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="showEditForm({{ $usuario->id }})">
                                                        Editar
                                                    </button>
                                                    <form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Tem certeza que deseja excluir este usuario?')">Excluir</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr id="edit-row-{{ $usuario->id }}" style="display: none;">
                                            <td>
                                                <form action="{{ route('usuario.update', $usuario->id) }}" method="POST"
                                                    id="edit-form-{{ $usuario->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" id="name" name="name" class="form-control" value="{{ $usuario->name }}">
                                            </td>
                                            <td>
                                                <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email}}">
                                            </td>
                                            <td>
                                                <select name="role" id="role" class="form-select">
                                                    <option value="master" {{ $usuario->role === 'master' ? 'selected' : '' }}>
                                                        Master</option>
                                                    <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Admin
                                                    </option>
                                                    <option value="usuario" {{ $usuario->role === 'usuario' ? 'selected' : '' }}>
                                                        Usuário Padrão</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        onclick="cancelEdit({{ $usuario->id }})">
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
                        <p class="mb-0">Nenhum usuario cadastrado.</p>
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