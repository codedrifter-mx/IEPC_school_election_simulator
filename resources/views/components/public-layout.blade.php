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

                    <p class="text-base font-medium text-gray-500 hover:text-gray-900">
                        Sistema Virtual de Elecciones Escolares</p>

                </nav>
                <div class="flex items-center justify-end w-0 lflex-1"></div>
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
        <div class="border-t border-slate-900/5 py-6">

{{--            <div class="mx-auto h-10 w-auto text-slate-900">--}}
{{--                <a href="{{ route('welcome') }}">--}}
{{--                    <x-application-logo class="h-10 w-auto fill-current text-gray-600 mx-auto"/>--}}
{{--                </a>--}}
{{--            </div>--}}
            <p class="mt-2 text-center text-sm leading-6 text-slate-500">© 2022 Desarrollado por la Dirección de Capacitación Electoral y Educación Cívica</p>
            <p class="mt-2 text-center text-sm leading-6 text-slate-500">IEPC | Instituto Electoral y de Participación Ciudadana del Estado de Durango.
                Dirección de Capacitación Electoral y Educación Cívica.</p>
            <p class="mt-2 text-center text-sm leading-6 text-slate-500">Calle Litio S/N entre Plata y Níquel. CP. 34208. Colonia Ciudad Industrial. Durango, Dgo</p>
            <div class="mt-8 flex items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-700">
                <a href="https://www.iepcdurango.mx/IEPC_DURANGO/">IEPC</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.iepcdurango.mx/IEPC_DURANGO/documentos/2021/avisos_privacidad/mod_15_feb_2021/CAPACITACION/FORMATO%20AVISO%20PRIVACIDAD%20-%20DCEYEC.pdf">Politica de privacidad</a>
{{--                @if (Route::has('login'))--}}
{{--                    @auth--}}
{{--                        <a href="{{ route('events') }}">Panel</a>--}}
{{--                    @else--}}
{{--                        <a href="{{ route('login') }}">Iniciar--}}
{{--                            Sesion</a>--}}
{{--                        <div class="h-4 w-px bg-slate-500/20"></div>--}}
{{--                        @if (Route::has('register'))--}}
{{--                            <a href="{{ route('register') }}">Registrarse</a>--}}
{{--                        @endif--}}
{{--                    @endauth--}}
{{--                @endif--}}
            </div>
            <div
                class="mt-4 flex items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-700">
                <a>618 825 25 33</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.facebook.com/InstitutoElectoralDurangoIEPC/">Facebook</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.instagram.com/iepcdurango/?utm_medium=copy_link">Instagram</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://twitter.com/iepcdurango?lang=es">Twitter</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.youtube.com/channel/UCa_O86yXp85xHPNLnz5wujQ">Youtube</a>

            </div>
        </div>
    </footer>

{{ $scripts }}

</body>
</html>
