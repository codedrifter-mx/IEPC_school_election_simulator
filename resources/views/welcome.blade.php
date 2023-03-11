<x-public-layout>

    <div class="md:mt-0 md:col-span-1 pt-8" >
        <div class="grid grid-cols-1 md:grid-cols-2 p-2 justify-center justify-items-center text-center items-center place-items-center md:px-60 lg:px-80">

            <a href="{{ route('panel') }}" class="flex py-2 ">
                <button type="button"
                        class="bg-gray-900 hover:bg-gray-800 active:bg-gray-700 focus:bg-gray-800 sm:w-max rounded-xl">
                    <div class="p-6">
                        <img src="{{ asset('img/school.png') }}" alt="Iniciar sesion para IEPC" style="height: 18rem" >
                    </div>
                            <span class="block text-white font-semibold p-6 ">
                                Instituciones Educativas
                            </span>
                </button>
            </a>
            <a href="{{ route('admin_panel') }}" class="flex py-2 ">
                <button type="button"
                        class="bg-gray-900 hover:bg-gray-800 active:bg-gray-700 focus:bg-gray-800 sm:w-max rounded-xl">
                    <div class="p-6">
                        <img src="{{ asset('img/iepc_mono.png') }}" alt="Iniciar sesion para IEPC" style="height: 18rem" >
                    </div>
                    <span class="block text-white font-semibold p-6">
                                IEPC
                            </span>
                </button>
            </a>

        </div>


    </div>

    <x-slot name="scripts">
        @if (Route::currentRouteName() == 'rejected')
            <script>
                window.addEventListener('load', function () {
                    toastr.error('Tu cuenta aun no ha sido aprobada por el IEPC');
                });
            </script>
        @endif

    </x-slot>

</x-public-layout>
