<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">

<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="min-h-screen"
        style="background: url('/img/background_work_1.jpg');background-repeat: no-repeat;background-size: cover;background-position: center; margin-top: 4rem;">
        {{ $slot }}
    </main>
</div>

{{-- script for each blade --}}

{{ $scripts }}
@livewireScripts
</body>
</html>
