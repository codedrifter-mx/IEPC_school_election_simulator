<x-public-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-3 md:mt-0 md:col-span-1">

                <div class="grid grid-cols-1 md:grid-cols-3 m-3">
                    <div></div>
                    <div class="shadow rounded-md overflow-hidden">
                        <form id="store" class="px-4 py-5 bg-white space-y-6 sm:p-6">
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

                                {{-- grade --}}
                                <div>
                                    <label for="grade"
                                           class="block font-medium text-gray-700">
                                        Grado </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="grade" id="grade"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300">
                                            <option value="1">Primero</option>
                                            <option value="2">Segundo</option>
                                            <option value="3">Tercero</option>
                                            <option value="4">Cuarto</option>
                                            <option value="5">Quinto</option>
                                            <option value="6">Sexto</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- group --}}
                                <div>
                                    <label for="group"
                                           class="block font-medium text-gray-700">
                                        Grupo </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="group" id="group"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>


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

            // Create functions: storeElector
            function storeElector(e) {
                e.preventDefault();

                // get input values
                let name = document.getElementById('name').value;
                let paternal_surname = document.getElementById('paternal_surname').value;
                let maternal_surname = document.getElementById('maternal_surname').value;

                let email = "";
                if (document.getElementById("email").style.display !== "none") {
                    email = document.getElementById('email').value;
                }
                let code = document.getElementById('code').value;

                axios.post("{{ route('elector_store') }}", {
                    name: name,
                    paternal_surname: paternal_surname,
                    maternal_surname: maternal_surname,
                    email: email,
                    code: code,
                })
                    .then(function (response) {
                        // console.log(response);

                        // clear input values
                        document.getElementById('name').value = '';
                        document.getElementById('paternal_surname').value = '';
                        document.getElementById('maternal_surname').value = '';
                        if (document.getElementById("email").style.display !== "none") {
                            document.getElementById('email').value = '';
                        }
                        document.getElementById('code').value = '';

                        // Swal success message in spanish about wait the School to give the Event URL
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro exitoso!',
                            text: '¡Espera a que la escuela te proporcione la acceso al evento!',
                        })

                    })
                    .catch(function (error) {
                        // console.log(error);
                        // console.log(error.response.data.error);

                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }

                        // if on error.response.data.error and match the first SQL duplicate entry, show error message with Swal
                        if (error.response.data.error) {
                            if (error.response.data.error.includes("Duplicate entry")) {
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡El código de voto ya existe! Por favor, escribe otro.'
                                })
                            }
                        }
                    });
            }



            document.getElementById('store').addEventListener('submit', storeElector);

        </script>
    </x-slot>
</x-public-layout>
