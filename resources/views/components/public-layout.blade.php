<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<div class="min-h-screen relative">
    <div class="relative">
        <div class="px-4 sm:px-6" >
            <div
                class="flex flex-wrap items-center justify-center text-center justify-items-center border-b-2 border-gray-100 py-6 md:space-x-10">

                <nav class="flex items-center justify-center">

                    <a href="{{ route('welcome') }}">
                        <x-application-logo-mid class="block h-10 w-auto fill-current text-gray-600 sm:h-4"/>
                    </a>
                    <div class="h-20 w-px bg-slate-500/20"></div>
                    <p class="p-2 text-base font-medium hover:text-gray-900">
                        Sistema Virtual de Elecciones Escolares</p>

                </nav>
            </div>
        </div>
        <main
            style="background: url('/img/background.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;min-height: 54vh;">
            {{ $slot }}
        </main>
    </div>
    <footer class="mx-auto bg-gray-100 inset-x-0 bottom-0">
        <div class="border-t border-slate-900/5 py-8">

            <p class="mt-2 text-center text-sm leading-6 text-slate-500">© 2022 2022 Desarrollado por el Ing. Alfredo Flores García, en conjunto con la Dirección de Capacitación Electoral y Educación Cívica. </p>
            <p class="mt-2 text-center text-sm leading-6 text-slate-500">IEPC | Instituto Electoral y de Participación Ciudadana del Estado de Durango.</p>
            <p class="mt-2 text-center text-sm leading-6 text-slate-500">Calle Litio S/N entre Plata y Níquel. CP. 34208. Colonia Ciudad Industrial. Durango, Dgo</p>
            <div
                class="mt-4 flex flex-wrap items-center justify-center space-x-4 text-sm font-semibold leading-6 text-slate-700 py-8">
                <a href="https://www.iepcdurango.mx/IEPC_DURANGO/">IEPC</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.iepcdurango.mx/IEPC_DURANGO/documentos/2021/avisos_privacidad/mod_15_feb_2021/CAPACITACION/FORMATO%20AVISO%20PRIVACIDAD%20-%20DCEYEC.pdf">Politica de privacidad</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a>618 825 25 33</a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.facebook.com/InstitutoElectoralDurangoIEPC/">
                    <i class="bi bi-facebook"></i>
                </a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.instagram.com/iepcdurango/?utm_medium=copy_link">
                    <i class="bi bi-instagram"></i>
                </a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://twitter.com/iepcdurango?lang=es">
                    <i class="bi bi-twitter"></i>
                </a>
                <div class="h-4 w-px bg-slate-500/20"></div>
                <a href="https://www.youtube.com/channel/UCa_O86yXp85xHPNLnz5wujQ">
                    <i class="bi bi-youtube"></i>
                </a>
            </div>
        </div>
    </footer>
{{ $scripts }}
</body>
</html>
