<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nombre de Institución')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Municipio -->
            <div class="mt-4">
                <x-label for="municipio" :value="__('Municipio')" />

                <x-input id="municipio" class="block mt-1 w-full" type="text" name="municipio" :value="old('municipio')" required />
            </div>

            <!-- Domicilio -->
            <div class="mt-4">
                <x-label for="domicilio" :value="__('Domicilio')" />

                <x-input id="domicilio" class="block mt-1 w-full" type="text" name="domicilio" :value="old('domicilio')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Correo Electronico')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-label for="level" :value="__('Nivel Educativo')" />

                <select id="level" name="level"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block mt-1 w-full rounded-md sm:text-sm border-gray-300" required autofocus>
                    <option>Primaria</option>
                    <option>Secundaria</option>
                    <option>Preparatoria</option>
                    <option>Universidad</option>
                </select>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya estas registrado?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
