<x-guest-layout>
    <x-slot name="title">Primeiro Acesso</x-slot>

    <h2 class="text-lg font-medium text-gray-900 mb-4">
        Primeiro Acesso
    </h2>
    <p class="text-sm text-gray-600 mb-6">
        Informe seu e-mail abaixo para receber o link de configuração de senha.
    </p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-primary-button>
                {{ __('Enviar link de acesso') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
