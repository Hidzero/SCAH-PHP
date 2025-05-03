<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-900">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="container mx-auto px-4 space-y-8">

            <!-- Card de Cadastro -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-medium text-gray-700 mb-4">Cadastrar Novo Usuário</h3>
                <form action="{{ route('usuario.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-600">Nome</label>
                            <input type="text" id="name" name="name" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Digite o nome" />
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                            <input type="email" id="email" name="email" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Digite o email" />
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-600">Nível de Usuário</label>
                            <select id="role" name="role" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecione uma opção</option>
                                <option value="master">Master</option>
                                <option value="admin">Admin</option>
                                <option value="usuario">Usuário Padrão</option>
                            </select>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-600">
                                Senha
                            </label>
                            <div class="relative mt-1">
                                <input type="password" id="password" name="password" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                                    placeholder="Digite a senha" />
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                               9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-600">
                                Confirmar Senha
                            </label>
                            <!-- somente este DIV “abraça” o input e o botão -->
                            <div class="relative mt-1">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-10"
                                    placeholder="Confirme a senha" />
                                <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                               9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Card de Lista -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-medium text-gray-700 mb-4">Usuários Cadastrados</h3>
                @if($usuarios->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nome</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Nível</th>
                                    <th class="px-4 py-2 text-center text-xs font-semibold text-gray-500 uppercase">Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($usuarios as $usuario)
                                    <tr class="hover:bg-gray-50" id="view-row-{{ $usuario->id }}">
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $usuario->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $usuario->email }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 capitalize">{{ $usuario->role }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700 text-center space-x-2">
                                            <button type="button"
                                                class="inline-flex px-2 py-1 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600 transition"
                                                onclick="showEditForm({{ $usuario->id }})">Editar</button>
                                            <form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex px-2 py-1 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition"
                                                    onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr id="edit-row-{{ $usuario->id }}" class="hidden bg-gray-50">
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $usuario->name }}</td>
                                        <form action="{{ route('usuario.update', $usuario->id) }}" method="POST" class="w-full">
                                            @csrf @method('PUT')
                                            <td class="px-4 py-2 text-sm">
                                                <input type="text" name="name" value="{{ $usuario->name }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
                                            </td>
                                            <td class="px-4 py-2 text-sm">
                                                <input type="email" name="email" value="{{ $usuario->email }}"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
                                            </td>
                                            <td class="px-4 py-2 text-sm">
                                                <select name="role"
                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="master" {{ $usuario->role === 'master' ? 'selected' : '' }}>Master
                                                    </option>
                                                    <option value="admin" {{ $usuario->role === 'admin' ? 'selected' : '' }}>Admin
                                                    </option>
                                                    <option value="usuario" {{ $usuario->role === 'usuario' ? 'selected' : '' }}>
                                                        Usuário Padrão</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-center space-x-2">
                                                <button type="submit"
                                                    class="inline-flex px-2 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">Salvar</button>
                                                <button type="button" onclick="cancelEdit({{ $usuario->id }})"
                                                    class="inline-flex px-2 py-1 bg-gray-200 text-gray-800 text-xs font-medium rounded hover:bg-gray-300 transition">Cancelar</button>
                                                </< /form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500">Nenhum usuário cadastrado.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            if (input.type === 'password') {
                input.type = 'text';
                btn.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.306-3.607m3.674-2.672A9.97 9.97 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-.167.666M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
            } else {
                input.type = 'password';
                btn.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>
</x-app-layout>