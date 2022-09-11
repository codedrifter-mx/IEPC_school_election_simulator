<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block"> Nueva votación </h1>
                    </div>

                    <div class="grid grid-cols-3 gap-4" id="form_event">

                        <input type="hidden" id="event_key" name="event_key">

                        {{-- Form --}}
                        <form class="col-span-3 md:col-span-1 grid grid-cols-1 gap-4">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}">

                            {{-- name --}}
                            <div>
                                <label for="name"
                                       class="block text-sm font-medium text-gray-700">
                                    Nombre del evento de votación </label>
                                <input type="text" name="name" id="name"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Nombre">
                            </div>

                            {{-- schedule --}}
                            <div>
                                <label for="schedule"
                                       class="block text-sm font-medium text-gray-700">
                                    Turno de los votantes </label>
                                <select id="schedule" name="schedule"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                                    <option>Matutino</option>
                                    <option>Vespertino</option>
                                    <option>Mixto</option>
                                </select>
                            </div>

                            {{-- director --}}
                            <div>
                                <label for="director"
                                       class="block text-sm font-medium text-gray-700">
                                    Nombre completo del director actual </label>
                                <input type="text" name="director" id="director"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Nombre">
                            </div>

                            {{-- in_charge --}}
                            <div>
                                <label for="in_charge"
                                       class="block text-sm font-medium text-gray-700">
                                    Nombre completo del organizador </label>
                                <input type="text" name="in_charge" id="in_charge"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Nombre">
                            </div>

                            {{-- population --}}
                            <div>
                                <label for="population"
                                       class="block text-sm font-medium text-gray-700">
                                    Cantidad de Estudiantes actual </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="population" id="population"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>

                            {{-- groups --}}
                            <div>
                                <label for="groups"
                                       class="block text-sm font-medium text-gray-700">
                                    Cantidad de Grupos en la Institución </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="groups" id="groups"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>

                            {{-- start_at --}}
{{--                            Create a datetime-local input with todays date and time--}}
                            <div>
                                <label for="start_at"
                                       class="block text-sm font-medium text-gray-700">
                                    Fecha de inicio de la votación </label>
                                <input type="datetime-local" name="start_at" id="start_at"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       value="{{ date('Y-m-d\TH:i') }}">
                            </div>
                            {{-- end_at --}}
{{--                            Create a datetime-local input with todays date and time + 14 days--}}
                            <div>
                                <label for="end_at"
                                       class="block text-sm font-medium text-gray-700">
                                    Fecha de fin de la votación </label>
                                <input type="datetime-local" name="end_at" id="end_at"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       value="{{ date('Y-m-d\TH:i', strtotime('+14 days')) }}">
                            </div>
                            {{-- Button Form --}}
                            <div>
                                <button id="submit_button"
                                        class="btn-block inline-flex w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Guardar
                                </button>
                            </div>
                        </form>

                        {{-- Table --}}
                        <div class="col-span-3 md:col-span-2">
                            <div class="col-span-3 md:col-span-2">
                                <div class="overflow-x-auto">
                                    <table id="events" class="table table-compact w-full">
                                        <!-- head -->
                                        <thead>
                                        <tr>
                                            <th>Estado</th>
                                            <th>Evento</th>
                                            <th>Inicio de votación</th>
                                            <th>Fin de votación</th>
                                            <th>Ver</th>
                                            <th>Editar</th>
                                            <th>Borrar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="events_tbody">
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
    <input type="checkbox" id="viewEventModal" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="grid grid-cols-40/60">
                <div class="p-6 col-span-2 md:col-span-1">
                    <img class="max-w-full m-0 p-6" id="qr" src="" alt="QR">
                    <div class="p-6 break-all rounded bg-primary text-center"><a class="text-white font-bold"
                                         id="link" href=""></a></div>
                </div>
                <table id="events" class="table table-compact w-full col-span-2 md:col-span-1">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th>Caracteristica</th>
                        <th>Valor</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Identificador</td>
                        <td id="event_key_value"></td>
                    </tr>
                    <tr>
                        <td>Nombre Evento</td>
                        <td id="event_name"></td>
                    </tr>
                    <tr>
                        <td>Horario de los electores</td>
                        <td id="event_schedule"></td>
                    </tr>
                    <tr>
                        <td>Director</td>
                        <td id="event_director"></td>
                    </tr>
                    <tr>
                        <td>Encargado</td>
                        <td id="event_in_charge"></td>
                    </tr>
                    <tr>
                        <td>Total Alumnos</td>
                        <td id="event_students"></td>
                    </tr>
                    <tr>
                        <td>Total Grupos</td>
                        <td id="event_groups"></td>
                    </tr>
                    <tr>
                        <td>Estado</td>
                        <td id="event_status"></td>
                    </tr>
                    <tr>
                        <td>Inicio de Votaciones</td>
                        <td id="event_start_date"></td>
                    </tr>
                    <tr>
                        <td>Fin de Votaciones</td>
                        <td id="event_end_date"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="modal-action col-span-3">
                    <button class="btn btn-accent">EXCEL</button>
                    <label for="viewEventModal" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">

            function stringToDateMXFormat(string) {
                let date = new Date(string);
                return date.toLocaleString("es-MX", {timeZone: "America/Mexico_City"});
            }

            // function to conver string to date yyyy-MM-ddThh:mm format
            function stringToDate(string) {
                let date = new Date(string);
                return date.toISOString().slice(0, 16);
            }

            // create function to populate table from $events variable
            function populateTable() {

                // console.log(document.getElementById('user_id').value)
                axios.get("{{ route('event_index') }}", {
                    params: {
                        user_id: document.getElementById('user_id').value
                    }
                })
                    .then(function (response) {
                        let events = response.data;

                        // console.log(events);

                        var t = "";
                        for (var i = 0; i < response.data.length; i++) {

                            t += "<tr>";
                            // if events[i].status is 0, add a badge with the text "Inactivo", if is 1, add a badge with the text "Activo", if is 2, add a badge with the text "Finalizado"
                            t += "<td><span class='badge badge-" + (events[i].status === 0 ? "danger" : (events[i].status === 1 ? "success" : "warning")) + "'>" + (events[i].status === 0 ? "Inactivo" : (events[i].status === 1 ? "Activo" : "Finalizado")) + "</span></td>";

                            t += "<td>" + events[i].name + "</td>";
                            t += "<td>" + stringToDateMXFormat(events[i].start_at) + "</td>";
                            t += "<td>" + stringToDateMXFormat(events[i].end_at) + "</td>";


                            t += `<td>
                                    <button class="btn btn-square btn-outline"
                                            onclick="showEvent('` + events[i].event_key + `')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                             height="16" fill="currentColor" class="bi bi-eye-fill"
                                             viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
                                    </button>
                                </td>`;
                            t += ` <th>
                                                    <button class="btn btn-square btn-outline"
                                                            onclick="setEvent('` + events[i].event_key + `')">
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
                                                            onclick="dropEvent('` + events[i].event_key + `')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </th>`;

                            t += "</tr>";
                        }

                        document.getElementById("events_tbody").innerHTML = '';
                        document.getElementById("events_tbody").innerHTML += t;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // function to create event
            function storeEvent(e) {
                e.preventDefault();

                // get select event input values
                let user_id = document.getElementById('user_id').value
                let name = document.getElementById('name').value;
                let schedule = document.getElementById('schedule').value;
                let director = document.getElementById('director').value;
                let in_charge = document.getElementById('in_charge').value;
                let population = document.getElementById('population').value;
                let groups = document.getElementById('groups').value;
                let start_at = document.getElementById('start_at').value;
                let end_at = document.getElementById('end_at').value;


                // axios post request
                axios.post("{{ route('event_store') }}", {
                    user_id: user_id,
                    name: name,
                    schedule: schedule,
                    director: director,
                    in_charge: in_charge,
                    population: population,
                    groups: groups,
                    start_at: start_at,
                    end_at: end_at,
                })
                    .then(function (response) {
                        // console.log(response);

                        // toastr success message, but in spanish
                        toastr.success('Evento creado con éxito');

                        // clear each input
                        document.getElementById('name').value = '';
                        document.getElementById('schedule').value = '';
                        document.getElementById('director').value = '';
                        document.getElementById('in_charge').value = '';
                        document.getElementById('population').value = '';
                        document.getElementById('groups').value = '';

                        // Populate table
                        populateTable();
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

            // function to update event
            function editEvent(e) {
                e.preventDefault();

                // get select event input values
                let event_key = document.getElementById('event_key').value;
                let name = document.getElementById('name').value;
                let schedule = document.getElementById('schedule').value;
                let director = document.getElementById('director').value;
                let in_charge = document.getElementById('in_charge').value;
                let population = document.getElementById('population').value;
                let groups = document.getElementById('groups').value;
                let start_at = document.getElementById('start_at').value;
                let end_at = document.getElementById('end_at').value;

                // axios post request
                axios.post("{{ route('event_update') }}", {
                    event_key: event_key,
                    name: name,
                    schedule: schedule,
                    director: director,
                    in_charge: in_charge,
                    population: population,
                    groups: groups,
                    start_at: start_at,
                    end_at: end_at,
                })
                    .then(function (response) {
                        // console.log(response);

                        // toastr success message, but in spanish
                        toastr.success('Evento actualizado con éxito');

                        // clear each input
                        document.getElementById('name').value = '';
                        document.getElementById('director').value = '';
                        document.getElementById('in_charge').value = '';
                        document.getElementById('population').value = '';
                        document.getElementById('groups').value = '';
                        document.getElementById('start_at').value = '';
                        document.getElementById('end_at').value = '';

                        // change the button text to "Crear evento"
                        document.getElementById('submit_button').innerHTML = "Crear evento";

                        // change addEventListener to store
                        document.getElementById('form_event').removeEventListener('submit', editEvent);
                        document.getElementById('form_event').addEventListener('submit', storeEvent);

                        populateTable();
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

            // Create a set event function, get all the only event data and put it in the form
            function setEvent(event_key) {

                // set event_key input value
                document.getElementById('event_key').value = event_key;

                // axios get request
                axios.get("{{ route('event_show') }}", {
                    params: {
                        event_key: event_key
                    }
                })
                    .then(function (response) {
                        // console.log(response);

                        // put the event data in the form inputs
                        document.getElementById('event_key').value = response.data.event_key;
                        document.getElementById('name').value = response.data.name;
                        document.getElementById('schedule').value = response.data.schedule;
                        document.getElementById('director').value = response.data.director;
                        document.getElementById('in_charge').value = response.data.in_charge;
                        document.getElementById('population').value = response.data.population;
                        document.getElementById('groups').value = response.data.groups;
                        document.getElementById('start_at').value = stringToDate(response.data.start_at);
                        document.getElementById('end_at').value = stringToDate(response.data.end_at);

                        // change the button text to "Modificar evento"
                        document.getElementById('submit_button').innerHTML = "Modificar";

                        // change addEventListener to editEvent Function
                        // first, remove all the event listeners on 'store' form
                        document.getElementById('form_event').removeEventListener('submit', storeEvent);
                        document.getElementById('form_event').addEventListener('submit', editEvent);

                        // show toastr info message that you are editing the event, but in spanish
                        toastr.info('Estas editando el evento ' + response.data.name);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // Create a showEvent function, it takes the event id as a parameter, get all the event data and put it in the modal
            function showEvent(event_key) {

                // console.log(event_key)

                // axios get request
                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        // console.log(response);

                        // put the event data in the modal
                        document.getElementById('event_key_value').innerHTML = response.data.event_key;
                        document.getElementById('event_name').innerHTML = response.data.name;
                        document.getElementById('event_schedule').innerHTML = response.data.schedule;
                        document.getElementById('event_director').innerHTML = response.data.director;
                        document.getElementById('event_in_charge').innerHTML = response.data.in_charge;
                        document.getElementById('event_students').innerHTML = response.data.population;
                        document.getElementById('event_groups').innerHTML = response.data.groups;

                        // if response.data.status is 0, add a badge with the text "Inactivo", if is 1, add a badge with the text "Activo", if is 2, add a badge with the text "Finalizado"
                        if (response.data.status === 0) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-danger">Inactivo</span>';
                        } else if (response.data.status === 1) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-success">Activo</span>';
                        } else if (response.data.status === 2) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-secondary">Finalizado</span>';
                        }

                        document.getElementById('event_start_date').innerHTML = stringToDateMXFormat(response.data.start_at);
                        document.getElementById('event_end_date').innerHTML = stringToDateMXFormat(response.data.end_at);

                        document.getElementById('link').innerHTML = window.location.origin + "/votacion/" + response.data.event_key;
                        document.getElementById('link').href = window.location.origin + "/votacion/" + response.data.event_key;
                        document.getElementById("qr").src = window.location.origin + "/qrcode/" + response.data.event_key;

                        // check the checkbot id="viewEventModal" to show modal
                        document.getElementById('viewEventModal').checked = true;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // Create a drop event function with an id parameter
            function dropEvent(event_key) {

                // Sweet alert
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#3085d6',
                    confirmButtonColor: '#d33',
                    confirmButtonText: '¡Si, bórralo!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        // axios delete request
                        axios.post("{{ route('event_destroy') }}", {
                            event_key: event_key
                        })
                            .then(function (response) {
                                // console.log(response);

                                populateTable();

                                // Sweet alert
                                Swal.fire(
                                    '¡Eliminado!',
                                    'El evento ha sido eliminado.',
                                    'success'
                                )


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
                })
            }

            // When DOM is ready, execute populateTable function
            document.addEventListener('DOMContentLoaded', function () {
                // Set on submit_button button the submit event to storeEvent function
                document.getElementById('form_event').addEventListener('submit', storeEvent);
                document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";

                populateTable();
            });

        </script>
    </x-slot>

</x-app-layout>
