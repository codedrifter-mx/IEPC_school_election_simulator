<x-public-layout>

    <div>
        <div>
            <div class="md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-3 h-96">

                    <a href="{{ route('panel') }}" class="flex">
                        <button type="button" class="flex-1 text-center transition bg-gray-900 hover:bg-gray-800 active:bg-gray-700 focus:bg-gray-800 sm:w-max">
                            <span class="block text-white font-semibold">
                                Instituciones Educativas
                            </span>
                        </button>
                    </a>
                    <a href="{{ route('elector') }}" class="flex">
                        <button type="button" class="flex-1 text-center transition bg-gray-400 hover:bg-gray-200 active:bg-gray-300 focus:bg-gray-200 sm:w-max">
                            <span class="block text-gray-700 font-semibold group-focus:text-yellow-700">
                                Alumnos
                            </span>
                        </button>
                    </a>
                    <a href="{{ route('admin_panel') }}" class="flex">
                        <button type="button" class="flex-1 text-center transition bg-gray-900 hover:bg-gray-800 active:bg-gray-700 focus:bg-gray-800 sm:w-max">
                            <span class="block text-white font-semibold">
                                IEPC
                            </span>
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
    </x-slot>

</x-public-layout>
