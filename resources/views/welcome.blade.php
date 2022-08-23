<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="antialiased">
<div>
    <div class="relative bg-gradient-to-r from-purple-500 to-pink-500">
        <div class="bg-white px-4 sm:px-6">
            <div
                class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a href="#">
                        <span class="sr-only">Workflow</span>
                        <img class="h-8 w-auto sm:h-10"
                             src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="">
                    </a>
                </div>
                <nav class="flex space-x-10 justify-center">

                    <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> Registro </a>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900"> Votar! </a>

                </nav>
                <div class="flex items-center justify-end md:flex-1 lg:w-0">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Panel</a>
                        @else
                            <a href="{{ route('login') }}"
                               class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">Iniciar Sesion</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Registrarse</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-5 md:mt-0 md:col-span-1">
                    <form method="POST" action="{{ route('voter_store') }}">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                {{-- Title Form --}}
                                <div class="mt-5 md:mt-0 md:col-span-2">
                                    <h1 class="block"> Nuevo Votante </h1>
                                </div>
                                {{-- Form structure --}}
                                <div class="grid grid-cols-1 gap-6">

                                    {{-- name --}}
                                    <div class="col-span-1">
                                        <label for="name"
                                               class="block text-sm font-medium text-gray-700">
                                            Nombres del votante </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="name" id="name"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="Nombre">
                                        </div>
                                    </div>

                                    {{-- paternal_surname --}}
                                    <div class="col-span-1">
                                        <label for="paternal_surname"
                                               class="block text-sm font-medium text-gray-700">
                                            Apellido paterno del votante </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="paternal_surname" id="paternal_surname"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="Apellido">
                                        </div>
                                    </div>

                                    {{-- maternal_surname --}}
                                    <div class="col-span-1">
                                        <label for="maternal_surname"
                                               class="block text-sm font-medium text-gray-700">
                                            Apellido materno del votante </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="maternal_surname" id="maternal_surname"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="Apellido">
                                        </div>
                                    </div>

                                    {{-- email --}}
                                    <div class="col-span-1">
                                        <label for="email"
                                               class="block text-sm font-medium text-gray-700">
                                            Email (Opcional) </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="email" id="email"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="">
                                        </div>
                                    </div>

                                    {{-- code --}}
                                    <div class="col-span-1">
                                        <label for="code"
                                               class="block text-sm font-medium text-gray-700">
                                            Codigo de voto </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="code" id="code"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="">
                                        </div>
                                    </div>

                                </div>

                                {{-- insert --}}
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>


                </div>

            </div>


        </div>

    </div>
</div>
</div>
</body>
</html>
