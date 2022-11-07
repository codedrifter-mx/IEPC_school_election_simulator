<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <h1 class="block"> Registro nominal de elecciones escolares </h1>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-3">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">Elije una escuela</label>
                            <select id="user_id" name="event_key"
                                    class="my-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="sm:px-6 mx-2 lg:px-8">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div id="validation-form" class="px-4 py-5 bg-white space-y-6 sm:p-6">

                        {{-- Title Form --}}
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <h1 class="block"> Número de alumnos y grupos inscritos</h1>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <h1 class="block"> Universo de Alumnos</h1>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <h1 class="block"> Fecha y hora del registro nominal</h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <x-slot name="scripts">
        <script type="text/javascript">



        </script>
    </x-slot>

</x-app-layout>
