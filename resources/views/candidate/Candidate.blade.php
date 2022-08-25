<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <form method="POST" action="{{ route('candidate_store') }}">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                        {{-- Title Form --}}
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <h1 class="block"> Nuevo Candidato </h1>
                        </div>
                        {{-- Form structure --}}
                        <div class="grid grid-cols-12 gap-4">

                            {{-- teamname --}}
                            <div class="col-span-6">
                                <label for="teamname"
                                       class="block text-sm font-medium text-gray-700">
                                    Nombre de Equipo </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="teamname" id="teamname"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Equipo">
                                </div>
                            </div>

                            {{-- name --}}
                            <div class="col-span-6">
                                <label for="name"
                                       class="block text-sm font-medium text-gray-700">
                                    Nombres del candidato </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="name" id="name"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Nombre">
                                </div>
                            </div>

                            {{-- paternal_surname --}}
                            <div class="col-span-6">
                                <label for="paternal_surname"
                                       class="block text-sm font-medium text-gray-700">
                                    Apellido paterno del candidato </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="paternal_surname" id="paternal_surname"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Apellido">
                                </div>
                            </div>

                            {{-- maternal_surname --}}
                            <div class="col-span-6">
                                <label for="maternal_surname"
                                       class="block text-sm font-medium text-gray-700">
                                    Apellido materno del candidato </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="maternal_surname" id="maternal_surname"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Apellido">
                                </div>
                            </div>

                            {{-- Blob --}}
                            <div class="col-span-12">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700"> Foto (Opcional) </label>
                                    <div
                                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400"
                                                 stroke="currentColor"
                                                 fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"/>
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="photo"
                                                       class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Sube el archivo</span>
                                                    <input id="photo" name="photo"
                                                           type="file"
                                                           class="sr-only">
                                                </label>
                                                <p class="pl-1">o arrasta y suelta</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF menos de 10 MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- insert --}}
                        <div class="px-2 py-1">
                            <button type="submit"
                                    class="btn-block inline-flex w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">


        </script>
    </x-slot>

</x-app-layout>
