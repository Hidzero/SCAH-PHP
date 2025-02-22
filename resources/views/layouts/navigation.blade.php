<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Container principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Lado esquerdo (Logo e links) -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <!-- Links de navegação (desktop) -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex items-center">
                    <!-- Home -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <!-- Cadastro Dropdown -->
                    <x-dropdown align="left" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <span>Cadastro</span>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('ferramentas.index')">Ferramentas</x-dropdown-link>
                            <x-dropdown-link :href="route('obra.index')">Obra</x-dropdown-link>
                            <x-dropdown-link :href="route('veiculo.index')">Veículo</x-dropdown-link>
                            <x-dropdown-link :href="route('motorista.index')">Motorista</x-dropdown-link>
                            <x-dropdown-link :href="route('equipamentos.index')">Equipamentos</x-dropdown-link>
                            <x-dropdown-link :href="route('usuario.index')">Usuário</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    

                    <!-- Estoque Dropdown -->
                    <x-dropdown align="left" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <span>Estoque</span>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('estoque.visualizar')">Visualizar Estoque</x-dropdown-link>
                            <x-dropdown-link :href="route('estoque.retirar')">Retirar Ferramentas</x-dropdown-link>
                            <x-dropdown-link :href="route('estoque.devolucao')">Devolução de Ferramenta</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Manutenção Dropdown -->
                    <x-dropdown align="left" width="80">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <span>Manutenção</span>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('manutencao.atendimento_os.index')">Atendimento de OS</x-dropdown-link>
                            <x-dropdown-link :href="route('manutencao.ordem_servico.index')">Ordem de Serviço</x-dropdown-link>
                            <x-dropdown-link :href="route('manutencao.gestao_manutencao.index')">Gestão de Manutenção</x-dropdown-link>
                            <x-dropdown-link :href="route('manutencao.consulta_manuales.index')">Consulta de Manuais</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Relatórios -->
                    <x-nav-link :href="route('relatorios.ferramentas')" :active="request()->routeIs('relatorios.ferramentas')">
                        Relatórios
                    </x-nav-link>

                    <!-- Veículos Dropdown -->
                    <x-dropdown align="left" width="72">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <span>Veículos</span>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('veiculos.saida')">Saída de Veículo</x-dropdown-link>
                            <x-dropdown-link :href="route('veiculos.retorno')">Retorno de Veículo</x-dropdown-link>
                            <x-dropdown-link :href="route('veiculos.dashboard_veiculos')">Dashboard de Veículos</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <!-- Consulta -->
                    <x-nav-link :href="route('consulta.gpt')" :active="request()->routeIs('consulta.gpt')">
                        Consulta
                    </x-nav-link>
                </div>
            </div>
            <!-- Lado direito (Dropdown de usuário) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <!-- Autenticação -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Botão Hamburger para responsivo -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu responsivo -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Link Home -->
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <!-- Seção Cadastro -->
            <div class="px-3 text-gray-900 uppercase text-xs font-bold">Cadastro</div>
            <x-responsive-nav-link :href="route('ferramentas.index')">Ferramentas</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('obra.index')">Obra</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('veiculo.index')">Veículo</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('motorista.index')">Motorista</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('equipamentos.index')">Equipamentos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('usuario.index')">Usuário</x-responsive-nav-link>

            <!-- Seção Estoque -->
            <div class="px-3 text-gray-900 uppercase text-xs font-bold">Estoque</div>
            <x-responsive-nav-link :href="route('estoque.visualizar')">Visualizar Estoque</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('estoque.retirar')">Retirar Ferramentas</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('estoque.devolucao')">Devolução de Ferramenta</x-responsive-nav-link>

            <!-- Seção Manutenção -->
            <div class="px-3 text-gray-900 uppercase text-xs font-bold">Manutenção</div>
            <x-responsive-nav-link :href="route('manutencao.atendimento_os.index')">Atendimento de OS</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('manutencao.ordem_servico.index')">Ordem de Serviço</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('manutencao.gestao_manutencao.index')">Gestão de Manutenção</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('manutencao.consulta_manuales.index')">Consulta de Manuais</x-responsive-nav-link>

            <!-- Link Relatórios -->
            <x-responsive-nav-link :href="route('relatorios.ferramentas')">Relatórios</x-responsive-nav-link>

            <!-- Seção Veículos -->
            <div class="px-3 text-gray-900 uppercase text-xs font-bold">Veículos</div>
            <x-responsive-nav-link :href="route('veiculos.saida')">Saída de Veículo</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('veiculos.retorno')">Retorno de Veículo</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('veiculos.dashboard_veiculos')">Dashboard de Veículos</x-responsive-nav-link>

            <!-- Link Consulta -->
            <x-responsive-nav-link :href="route('consulta.gpt')">Consulta</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>
