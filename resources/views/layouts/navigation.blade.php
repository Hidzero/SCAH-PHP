@php
  $role = Auth::user()->role;
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      {{-- Esquerda: Logo + Links --}}
      <div class="flex items-center space-x-6">
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="flex-shrink-0">
          <x-application-logo class="h-10 w-auto text-gray-800" />
        </a>

        {{-- Navegação desktop --}}
        <div class="hidden lg:flex items-center space-x-4">

          {{-- Gráficos --}}
          <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Gráficos
          </x-nav-link>

          {{-- Cadastro --}}
          @if(in_array($role, ['master', 'admin']))
            <x-dropdown align="left" width="48">
            <x-slot name="trigger">
              <button
              class="flex items-center space-x-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition">
              <span>Cadastro</span>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              </button>
            </x-slot>
            <x-slot name="content">
              <x-dropdown-link :href="route('ferramentas.index')">Ferramentas</x-dropdown-link>
              <x-dropdown-link :href="route('obra.index')">Obra</x-dropdown-link>
              <x-dropdown-link :href="route('veiculo.index')">Veículo</x-dropdown-link>
              <x-dropdown-link :href="route('motorista.index')">Motorista</x-dropdown-link>
              <x-dropdown-link :href="route('equipamentos.index')">Equipamentos</x-dropdown-link>
              <x-dropdown-link :href="route('usuario.index')">Usuários</x-dropdown-link>
            </x-slot>
            </x-dropdown>
          @endif

          {{-- Estoque --}}
          @if(in_array($role, ['master', 'admin', 'estoque']))
            <x-dropdown align="left" width="48">
            <x-slot name="trigger">
              <button
              class="flex items-center space-x-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition">
              <span>Estoque</span>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              </button>
            </x-slot>
            <x-slot name="content">
              <x-dropdown-link :href="route('estoque.visualizar')">Visualizar</x-dropdown-link>
              <x-dropdown-link :href="route('estoque.retirar')">Retirar</x-dropdown-link>
              <x-dropdown-link :href="route('estoque.devolucao')">Devolução</x-dropdown-link>
            </x-slot>
            </x-dropdown>
          @endif

          {{-- Manutenção --}}
          @if(in_array($role, ['master', 'admin', 'manutencao']))
            <x-dropdown align="left" width="48">
            <x-slot name="trigger">
              <button
              class="flex items-center space-x-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition">
              <span>Manutenção</span>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              </button>
            </x-slot>
            <x-slot name="content">
              <x-dropdown-link :href="route('manutencao.gestao_manutencao.index')">Gestão</x-dropdown-link>
              <x-dropdown-link :href="route('manutencao.manuais.index')">Manuais</x-dropdown-link>
            </x-slot>
            </x-dropdown>
          @endif

          {{-- Veículos --}}
          @if(in_array($role, ['master', 'admin', 'veiculos']))
            <x-dropdown align="left" width="48">
            <x-slot name="trigger">
              <button
              class="flex items-center space-x-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition">
              <span>Veículos</span>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              </button>
            </x-slot>
            <x-slot name="content">
              <x-dropdown-link :href="route('veiculos.dashboard')">Dashboard</x-dropdown-link>
              <x-dropdown-link :href="route('veiculos.saida')">Saída</x-dropdown-link>
              <x-dropdown-link :href="route('veiculos.retorno')">Retorno</x-dropdown-link>
            </x-slot>
            </x-dropdown>
          @endif
        </div>
      </div>

      {{-- Direita: Usuário --}}
      <div class="hidden lg:flex items-center space-x-4">
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button
              class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition">
              <span>{{ Auth::user()->name }}</span>
              <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
          </x-slot>
          <x-slot name="content">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">Sair</x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>
      </div>

      {{-- Hamburger mobile --}}
      <div class="flex lg:hidden">
        <button @click="open = ! open"
          class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Menu mobile --}}
  <div x-show="open" class="lg:hidden bg-white border-t border-gray-200 shadow-sm">
    <div class="pt-4 pb-2 space-y-1">
      {{-- Gráficos mobile --}}
      <x-responsive-nav-link :href="route('dashboard')"
        :active="request()->routeIs('dashboard')">Gráficos</x-responsive-nav-link>

      {{-- Cadastro mobile --}}
      @if(in_array($role, ['master', 'admin']))
        <div class="px-4 pt-4 text-gray-500 uppercase text-xs font-semibold">CADASTRO</div>
        <x-responsive-nav-link :href="route('ferramentas.index')">Ferramentas</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('obra.index')">Obra</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('veiculo.index')">Veículo</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('motorista.index')">Motorista</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('equipamentos.index')">Equipamentos</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('usuario.index')">Usuários</x-responsive-nav-link>
      @endif

      {{-- Estoque mobile --}}
      @if(in_array($role, ['master', 'admin', 'estoque']))
        <div class="px-4 pt-4 text-gray-500 uppercase text-xs font-semibold">ESTOQUE</div>
        <x-responsive-nav-link :href="route('estoque.visualizar')">Visualizar</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('estoque.retirar')">Retirar</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('estoque.devolucao')">Devolução</x-responsive-nav-link>
      @endif

      {{-- Manutenção mobile --}}
      @if(in_array($role, ['master', 'admin', 'manutencao']))
        <div class="px-4 pt-4 text-gray-500 uppercase text-xs font-semibold">MANUTENÇÃO</div>
        <x-responsive-nav-link :href="route('manutencao.gestao_manutencao.index')">Gestão</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('manutencao.manuais.index')">Manuais</x-responsive-nav-link>
      @endif

      {{-- Veículos mobile --}}
      @if(in_array($role, ['master', 'admin', 'veiculos']))
        <div class="px-4 pt-4 text-gray-500 uppercase text-xs font-semibold">VEÍCULOS</div>
        <x-responsive-nav-link :href="route('veiculos.dashboard')">Dashboard</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('veiculos.saida')">Saída</x-responsive-nav-link>
        <x-responsive-nav-link :href="route('veiculos.retorno')">Retorno</x-responsive-nav-link>
      @endif

      {{-- Perfil/Logout mobile --}}
      <div class="border-t border-gray-200 mt-4 pt-4 px-4">
        <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
        <div class="text-sm text-gray-500 mb-2">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <x-responsive-nav-link :href="route('logout')"
            onclick="event.preventDefault(); this.closest('form').submit();">Sair</x-responsive-nav-link>
        </form>
      </div>
    </div>
  </div>
</nav>