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
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
              Dashboard
            </x-nav-link>
  
            {{-- Dropdown genérico componentizado para simplificar repetição --}}
            @foreach ([
              'Cadastro' => [
                ['Ferramentas', 'ferramentas.index'],
                ['Obra', 'obra.index'],
                ['Veículo', 'veiculo.index'],
                ['Motorista', 'motorista.index'],
                ['Equipamentos', 'equipamentos.index'],
                ['Usuários', 'usuario.index'],
              ],
              'Estoque' => [
                ['Visualizar', 'estoque.visualizar'],
                ['Retirar', 'estoque.retirar'],
                ['Devolução', 'estoque.devolucao'],
              ],
              'Manutenção' => [
                ['Gestão', 'manutencao.gestao_manutencao.index'],
                ['Manuais', 'manutencao.consulta_manuales.index'],
              ],
              'Veículos' => [
                ['Saída', 'veiculos.saida'],
                ['Retorno', 'veiculos.retorno'],
                ['Dashboard', 'veiculos.dashboard'],
              ],
            ] as $label => $links)
              <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                  <button
                    class="flex items-center space-x-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition"
                  >
                    <span>{{ $label }}</span>
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                  </button>
                </x-slot>
                <x-slot name="content">
                  @foreach($links as [$text, $route])
                    <x-dropdown-link :href="route($route)" class="px-4 py-2 hover:bg-gray-100">
                      {{ $text }}
                    </x-dropdown-link>
                  @endforeach
                </x-slot>
              </x-dropdown>
            @endforeach
          </div>
        </div>
  
        {{-- Direita: Usuário --}}
        <div class="hidden lg:flex items-center space-x-4">
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              <button
                class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-md transition"
              >
                <span>{{ Auth::user()->name }}</span>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
              </button>
            </x-slot>
            <x-slot name="content">
              <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                  onclick="event.preventDefault(); this.closest('form').submit();">
                  Sair
                </x-dropdown-link>
              </form>
            </x-slot>
          </x-dropdown>
        </div>
  
        {{-- Hamburger mobile --}}
        <div class="flex lg:hidden">
          <button @click="open = ! open"
                  class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path :class="{'hidden': open, 'inline-flex': !open }"
                    class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
              <path :class="{'hidden': !open, 'inline-flex': open }"
                    class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
  
      </div>
    </div>
  
    {{-- Menu mobile --}}
    <div x-show="open" class="lg:hidden bg-white border-t border-gray-200 shadow-sm">
      <div class="pt-4 pb-2 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
          Dashboard
        </x-responsive-nav-link>
  
        @foreach ([
          'CADASTRO' => [
            ['Ferramentas', 'ferramentas.index'],
            ['Obra', 'obra.index'],
            ['Veículo', 'veiculo.index'],
            ['Motorista', 'motorista.index'],
            ['Equipamentos', 'equipamentos.index'],
            ['Usuários', 'usuario.index'],
          ],
          'ESTOQUE' => [
            ['Visualizar', 'estoque.visualizar'],
            ['Retirar', 'estoque.retirar'],
            ['Devolução', 'estoque.devolucao'],
          ],
          'MANUTENÇÃO' => [
            ['Gestão', 'manutencao.gestao_manutencao.index'],
            ['Manuais', 'manutencao.consulta_manuales.index'],
          ],
          'VEÍCULOS' => [
            ['Saída', 'veiculos.saida'],
            ['Retorno', 'veiculos.retorno'],
            ['Dashboard', 'veiculos.dashboard'],
          ],
        ] as $section => $links)
          <div class="px-4 pt-4 text-gray-500 uppercase text-xs font-semibold">{{ $section }}</div>
          @foreach($links as [$text, $route])
            <x-responsive-nav-link :href="route($route)">
              {{ $text }}
            </x-responsive-nav-link>
          @endforeach
        @endforeach
  
        <div class="border-t border-gray-200 mt-4 pt-4 px-4">
          <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
          <div class="text-sm text-gray-500 mb-2">{{ Auth::user()->email }}</div>
          <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
              onclick="event.preventDefault(); this.closest('form').submit();">
              Sair
            </x-responsive-nav-link>
          </form>
        </div>
      </div>
    </div>
  </nav>
  