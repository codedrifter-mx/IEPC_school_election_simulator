<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo-large class="w-50 h-50 fill-current text-gray-500" />
            </a>
        </x-slot>

        @if (Auth::check())
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Salir de Sesión') }}
                    </button>
                </form>
            </div>

            @if ( Auth::user()->level  === 'Administrador')
                <div>
                    <a href="{{ route('admin_active_events') }}">
                        <button
                            class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Eventos Activos') }}
                        </button>
                    </a>
                </div>

                <div>
                    <a href="{{ route('admin_validate_events') }}">
                        <button
                            class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Eventos por validar') }}
                        </button>
                    </a>
                </div>

            @endif

        @else
            <!-- Create user -->
            <div>
                <a href="{{ route('register_admin') }}">
                    <button
                        class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Genera tu cuenta') }}
                    </button>
                </a>
            </div>

            <!-- Login -->
            <div>
                <a href="{{ route('login') }}">
                    <button
                        class="btn-block inline-flex w-full mt-2 mb-2 text-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Iniciar Sesión') }}
                    </button>
                </a>
            </div>
        @endif


    </x-auth-card>
</x-guest-layout>
