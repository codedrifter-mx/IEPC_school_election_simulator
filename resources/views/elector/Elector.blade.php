<x-public-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-3 md:mt-0 md:col-span-1">

                <div class="grid grid-cols-1 md:grid-cols-3 m-3">
                    <div></div>
                    <div class="shadow rounded-md overflow-hidden">
                        <form method="POST" action="{{ route('elector_store') }}"
                              class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            {{-- Title Form --}}
                            <div class="mt-5 md:mt-0 text-center">
                                <h1 class="block"> Registro de Electores </h1>
                            </div>
                            {{-- Form structure --}}
                            <div class="grid grid-cols-1 gap-3">

                                {{-- name --}}
                                <div>
                                    <label for="name"
                                           class="block font-medium text-gray-700">
                                        Nombres(s) </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="name" id="name"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="Nombre">
                                    </div>
                                </div>

                                {{-- paternal_surname --}}
                                <div>
                                    <label for="paternal_surname"
                                           class="block font-medium text-gray-700">
                                        Apellido paterno </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="paternal_surname" id="paternal_surname"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="Apellido">
                                    </div>
                                </div>

                                {{-- maternal_surname --}}
                                <div>
                                    <label for="maternal_surname"
                                           class="block font-medium text-gray-700">
                                        Apellido materno</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="maternal_surname" id="maternal_surname"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="Apellido">
                                    </div>
                                </div>

                                @if(Route::is('superior.elector'))
                                    {{-- email --}}
                                    <div>
                                        <label for="email"
                                               class="block font-medium text-gray-700">
                                            Email </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="email" id="email"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                                   placeholder="Email">
                                        </div>
                                    </div>
                                @endif

                                {{-- code --}}
                                <div>
                                    <label for="code"
                                           class="block font-medium text-gray-700">
                                        Crea tu codigo de voto </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="code" id="code"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="XXXX1234">
                                    </div>
                                </div>

                                {{-- insert --}}
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Registrarse
                                </button>

                            </div>


                        </form>
                    </div>
                    <div></div>
                </div>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">


            function storeElector(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // console.log(formData)

                // axios post request
                axios.post("{{ route('event_store') }}", formData)
                    .then(function (response) {
                        // console.log(response);

                        // toastr success message, but in spanish
                        toastr.success('Evento creado con éxito');


                        // clear form except user_id input
                        document.getElementById('store').reset();
                        document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";
                    })
                    .catch(function (error) {
                        // console.log(error);
                        // console.log(error.response.data.errors);

                        // for each errors with toastr
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }

                    });
            }

        </script>
    </x-slot>

</x-public-layout>
