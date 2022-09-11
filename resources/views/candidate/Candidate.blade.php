<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div id="validation-form" class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <h1 class="block"> Nuevo Candidato </h1>
                    </div>


                    {{-- Form structure --}}
                    <div class="grid grid-cols-3 gap-4">

                        <div class="col-span-3">
                            <label for="event_key" class="block text-sm font-medium text-gray-700">Elije una
                                votacion</label>
                            <select id="event_key" name="event_key"
                                    class="my-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </select>
                        </div>

                        {{-- Form --}}
                        <form class="grid grid-cols-1 gap-1 col-span-3 md:col-span-1 place-items-center" id="store">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="">
                            <input type="hidden" id="candidate_id" name="candidate_id">

                            {{-- teamname --}}
                            <div class="rounded-md shadow-sm grid grid-cols-2 gap-4 aling-items-center">
                                <label for="teamname"
                                       class="text-sm text-right ">
                                    Nombre de Equipo </label>
                                <div class="my-1 flex rounded-md shadow-sm">
                                    <input type="text" name="teamname" id="teamname"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Equipo">
                                </div>
                            </div>

                            {{-- name --}}
                            <div class="rounded-md shadow-sm grid grid-cols-2 gap-4 place-items-center">
                                <label for="name"
                                       class="block text-sm font-medium text-gray-700 text-right">
                                    Nombres del candidato </label>
                                <div class="my-1 flex rounded-md shadow-sm">
                                    <input type="text" name="name" id="name"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Nombre">
                                </div>
                            </div>

                            {{-- paternal_surname --}}
                            <div class="rounded-md shadow-sm grid grid-cols-2 gap-4 place-items-center">
                                <label for="paternal_surname"
                                       class="block text-sm font-medium text-gray-700 text-right">
                                    Apellido paterno del candidato </label>
                                <div class="my-1 flex rounded-md shadow-sm">
                                    <input type="text" name="paternal_surname" id="paternal_surname"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Apellido">
                                </div>
                            </div>

                            {{-- maternal_surname --}}
                            <div class="rounded-md shadow-sm grid grid-cols-2 gap-4 place-items-center">
                                <label for="maternal_surname"
                                       class="block text-sm font-medium text-gray-700 text-right">
                                    Apellido materno del candidato </label>
                                <div class="my-1 flex rounded-md shadow-sm">
                                    <input type="text" name="maternal_surname" id="maternal_surname"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Apellido">
                                </div>
                            </div>

                            {{-- Blob --}}
                            <div class="w-full">
                                <label class="my-1 block text-sm font-medium text-gray-700"> Foto
                                    (Opcional) </label>
                                <div
                                    class="my-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
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

                            {{-- Button Form --}}
                            <div>
                                <button id="form_button"
                                        class="btn-block inline-flex w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Guardar
                                </button>
                            </div>
                        </form>

                        {{-- Table --}}
                        <div class="col-span-3 md:col-span-2">
                            <div class="col-span-3 md:col-span-2">
                                <div class="overflow-x-auto">
                                    <table id="candidates" class="table table-compact w-full">
                                        <!-- head -->
                                        <thead>
                                        <tr>
                                            <th>Nombre de equipo</th>
                                            <th>Nombre</th>
                                            <th>Apellido Paterno</th>
                                            <th>Apellido Materno</th>
                                            <th>Editar</th>
                                            <th>Borrar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="candidates_tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">

            // create function to populate the #event <select> from with event_index
            function populateEventSelect() {
                // get the event_index from the server
                axios.get("{{ route('event_index') }}", {
                    params: {
                        user_id: document.getElementById('user_id').value
                    }
                })
                    .then(function (response) {
                        // if response.data is empty, show toastr error
                        if (response.data.length === 0) {
                            toastr.error('No hay eventos disponibles, registra minimo uno', 'Error');

                            // remove validation-form
                            document.getElementById('validation-form').remove();
                        }

                        // get the event_index from the response
                        let event_index = response.data;
                        // get the #event <select>
                        let eventSelect = document.getElementById('event_key');
                        // remove all options from html select "event_key"
                        eventSelect.innerHTML = '';
                        // loop through the event_index
                        for (let i = 0; i < event_index.length; i++) {
                            // create a new <option> element
                            let option = document.createElement('option');
                            // set the value of the <option> to the event_key
                            option.value = event_index[i].event_key;
                            // set the text of the <option> to the event_name
                            option.text = event_index[i].name;
                            // add the <option> to the #event <select>
                            eventSelect.appendChild(option);
                        }

                        populateTable();
                    })
                    .catch(function (error) {
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }
                    });
            }

            // create function to populate the #candidates_tbody <tbody> from with candidate_index
            function populateTable() {
                // get select event_key1
                let select = document.getElementById('event_key');
                let event_key = select.options[select.selectedIndex].value;
                // console.log(event_key); // en

                axios.get("{{ route('candidate_index') }}", {
                    params: {
                        event_key: event_key
                    }
                })
                    .then(function (response) {
                        let candidates = response.data;

                        // console.log(events);

                        var t = "";
                        for (var i = 0; i < response.data.length; i++) {

                            t += "<tr>";
                            t += "<td>" + candidates[i].teamname + "</td>";
                            t += "<td>" + candidates[i].name + "</td>";
                            t += "<td>" + candidates[i].paternal_surname + "</td>";
                            t += "<td>" + candidates[i].maternal_surname + "</td>";

                            t += ` <th>
                                                    <button class="btn btn-square btn-outline"
                                                            onclick="setCandidate(` + candidates[i].candidate_id + `)">
                                                        <svg width="24" stroke-width="1.5" height="24"
                                                             viewBox="0 0 24 24" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M20 12V5.74853C20 5.5894 19.9368 5.43679 19.8243 5.32426L16.6757 2.17574C16.5632 2.06321 16.4106 2 16.2515 2H4.6C4.26863 2 4 2.26863 4 2.6V21.4C4 21.7314 4.26863 22 4.6 22H11"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                            <path d="M8 10H16M8 6H12M8 14H11" stroke="currentColor"
                                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                d="M16 5.4V2.35355C16 2.15829 16.1583 2 16.3536 2C16.4473 2 16.5372 2.03725 16.6036 2.10355L19.8964 5.39645C19.9628 5.46275 20 5.55268 20 5.64645C20 5.84171 19.8417 6 19.6464 6H16.6C16.2686 6 16 5.73137 16 5.4Z"
                                                                fill="currentColor" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path
                                                                d="M17.9541 16.9394L18.9541 15.9394C19.392 15.5015 20.102 15.5015 20.5399 15.9394V15.9394C20.9778 16.3773 20.9778 17.0873 20.5399 17.5252L19.5399 18.5252M17.9541 16.9394L14.963 19.9305C14.8131 20.0804 14.7147 20.2741 14.6821 20.4835L14.4394 22.0399L15.9957 21.7973C16.2052 21.7646 16.3988 21.6662 16.5487 21.5163L19.5399 18.5252M17.9541 16.9394L19.5399 18.5252"
                                                                stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                        </svg>
                                                    </button>
                                                </th>`;
                            t += `<th>
                                                    <button class="btn btn-square btn-outline"
                                                            onclick="dropCandidate(` + candidates[i].candidate_id + `)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </th>`;

                            t += "</tr>";
                        }

                        document.getElementById("candidates_tbody").innerHTML = '';
                        document.getElementById("candidates_tbody").innerHTML += t;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // Create functions: storeCandidate, editCandidate, setCandidate, dropCandidate
            function storeCandidate(e) {
                e.preventDefault();

                // get select event_key
                let select_event_key = document.getElementById("event_key");
                let event_key = select_event_key.options[select_event_key.selectedIndex].value;

                // get input values
                let teamname = document.getElementById('teamname').value;
                let name = document.getElementById('name').value;
                let paternal_surname = document.getElementById('paternal_surname').value;
                let maternal_surname = document.getElementById('maternal_surname').value;

                axios.post("{{ route('candidate_store') }}", {
                    event_key: event_key,
                    teamname: teamname,
                    name: name,
                    paternal_surname: paternal_surname,
                    maternal_surname: maternal_surname,
                })
                    .then(function (response) {
                        // console.log(response);
                        // clear input values
                        document.getElementById('teamname').value = '';
                        document.getElementById('name').value = '';
                        document.getElementById('paternal_surname').value = '';
                        document.getElementById('maternal_surname').value = '';
                        // refresh table
                        populateTable();

                        // toastr success message, but in spanish
                        toastr.success('Candidato registrado con éxito');

                    })
                    .catch(function (error) {
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }
                    });
            }

            function setCandidate(candidate_id) {

                axios.get("{{ route('candidate_show') }}", {
                    params: {
                        candidate_id: candidate_id
                    }
                })
                    .then(function (response) {
                        // console.log(response);
                        // set input values
                        document.getElementById('candidate_id').value = response.data.candidate_id;
                        document.getElementById('teamname').value = response.data.teamname;
                        document.getElementById('name').value = response.data.name;
                        document.getElementById('paternal_surname').value = response.data.paternal_surname;
                        document.getElementById('maternal_surname').value = response.data.maternal_surname;

                        // change the button text to "Modificar evento"
                        document.getElementById('form_button').innerHTML = 'Modificar candidato';

                        // change addEventListener to editEvent Function
                        // first, remove all the event listeners on 'store' form
                        document.getElementById('store').removeEventListener('submit', storeCandidate);
                        document.getElementById('store').addEventListener('submit', editCandidate);

                        // show toastr info message that you are editing the event, but in spanish
                        toastr.info('Estas editando el candidato ' + response.data.name);
                    })
                    .catch(function (error) {
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }
                    });
            }

            function editCandidate(e) {
                e.preventDefault();

                // get input values
                let candidate_id = document.getElementById('candidate_id').value;
                let teamname = document.getElementById('teamname').value;
                let name = document.getElementById('name').value;
                let paternal_surname = document.getElementById('paternal_surname').value;
                let maternal_surname = document.getElementById('maternal_surname').value;

                axios.post("{{ route('candidate_update') }}", {
                    candidate_id: candidate_id,
                    teamname: teamname,
                    name: name,
                    paternal_surname: paternal_surname,
                    maternal_surname: maternal_surname,
                })
                    .then(function (response) {
                        // console.log(response);
                        // clear input values
                        document.getElementById('candidate_id').value = '';
                        document.getElementById('teamname').value = '';
                        document.getElementById('name').value = '';
                        document.getElementById('paternal_surname').value = '';
                        document.getElementById('maternal_surname').value = '';
                        // refresh table
                        populateTable();

                        // change the button text to "Agregar candidato"
                        document.getElementById('form_button').innerHTML = 'Agregar candidato';

                        // change store form event listener to storeCandidate function
                        document.getElementById('store').removeEventListener('submit', editCandidate);
                        document.getElementById('store').addEventListener('submit', storeCandidate);

                        // show toastr success message that you are editing the event, but in spanish
                        toastr.success('Candidato editado correctamente');
                    })
                    .catch(function (error) {
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }
                    });
            }

            // Create a dropCandidate function with an candidate_id parameter, Use Swal to confirm the deletion
            function dropCandidate(candidate_id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, bórralo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("{{ route('candidate_destroy') }}", {
                            candidate_id: candidate_id,
                        })
                            .then(function (response) {
                                // console.log(response);
                                // refresh table
                                populateTable();

                                // show toastr success message
                                toastr.success('Candidato eliminado con éxito');
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                })
            }

            // Set store eventListener to storeCandidate function
            document.getElementById('store').addEventListener('submit', storeCandidate);

            // Set user_id to the user_id of the user
            document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";

            // When DOM is ready, execute populateTable function
            document.addEventListener('DOMContentLoaded', function () {

                // When document.getElementById('events') changes, refresh the table
                document.getElementById('event_key').addEventListener('change', function () {
                    populateTable();
                });

                populateEventSelect();
            });

        </script>
    </x-slot>

</x-app-layout>
