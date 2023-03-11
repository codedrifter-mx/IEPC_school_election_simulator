<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo-large class="w-50 h-50 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Create user -->
        <div>
            @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Salir de Sesión') }}
                    </button>
                </form>

            @else
                <a href="{{ route('register') }}">
                    <button
                        class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Genera tu cuenta') }}
                    </button>
                </a>
{{--                login--}}
                <a href="{{ route('login') }}">
                    <button
                        class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Inicia Sesión') }}
                    </button>
                </a>
            @endif


        </div>

        <!-- Realiza tu registro -->
        <div>
            <a href="{{ route('events') }}">
                <button
                    class="btn-block inline-flex w-full mt-6 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Realiza tu registro
                </button>
            </a>
        </div>


{{--        <!-- Asistencia tecnica -->--}}
{{--        <div>--}}
{{--            <button--}}
{{--                class="btn-block inline-flex w-full mt-6 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                Asistencia tecnica--}}
{{--            </button>--}}
{{--        </div>--}}

    </x-auth-card>
</x-guest-layout>
