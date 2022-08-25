<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="min-h-screen relative bg-gradient-to-r from-purple-500 to-pink-500">

    <!-- Layout -->

    <div class="relative">
        <div class="bg-white px-4 sm:px-6">
            <div
                class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:space-x-10">
                <div class="flex justify-start w-0 lflex-1">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600"/>
                    </a>
                </div>
                <nav class="flex space-x-10 items-center justify-center">

                    <a href="{{ route('elector') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Registro </a>
                    <a href="{{ route('votacion') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Votar! </a>

                </nav>
                <div class="flex items-center justify-end w-0 lflex-1"></div>
                {{--                <div class="flex items-center justify-end md:flex-1 lg:w-0">--}}
                {{--                    @if (Route::has('login'))--}}
                {{--                        @auth--}}
                {{--                            <a href="{{ url('/dashboard') }}"--}}
                {{--                               class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Panel</a>--}}
                {{--                        @else--}}
                {{--                            <a href="{{ route('login') }}"--}}
                {{--                               class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">Iniciar--}}
                {{--                                Sesion</a>--}}

                {{--                            @if (Route::has('register'))--}}
                {{--                                <a href="{{ route('register') }}"--}}
                {{--                                   class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Registrarse</a>--}}
                {{--                            @endif--}}
                {{--                        @endauth--}}
                {{--                    @endif--}}
                {{--                </div>--}}
            </div>
        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <footer class="mx-auto mt-24 w-full max-w-container px-4 sm:px-6 lg:px-8 bg-gray-100
             inset-x-0
             bottom-0">
        <div class="border-t border-slate-900/5 py-10">

            <div class="mx-auto h-10 w-auto text-slate-900">
                <a href="{{ route('welcome') }}">
                    <x-application-logo class="h-10 w-auto fill-current text-gray-600 mx-auto"/>
                </a>
            </div>
            <p class="mt-5 text-center text-sm leading-6 text-slate-500">© 2022 Desarrollado por la Unidad Técnica de
                Transparencia IEPC DURANGO</p>
            <div
                class="mt-16 flex items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-700">
                <a href="https://www.iepcdurango.mx/IEPC_DURANGO/">IEPC</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="#">Politica de privacidad</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="#">Terminos y condiciones</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="#">Sobre Nosotros</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Panel</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar
                            Sesion</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>

        </div>
    </footer>

{{ $scripts }}

</body>
</html>
