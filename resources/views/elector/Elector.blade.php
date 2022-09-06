<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-1">
                <form method="POST" action="{{ route('elector_store') }}">
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

    <x-slot name="scripts">
        <script type="text/javascript">


        </script>
    </x-slot>

</x-public-layout>
