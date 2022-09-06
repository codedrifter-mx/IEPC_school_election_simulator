<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block"> Nueva votación </h1>
                    </div>

                    <div class="grid grid-cols-3 gap-4">

                        <input type="hidden" id="event_id" name="event_id">

                        {{-- Form --}}
                        <form class="col-span-3 md:col-span-1 grid grid-cols-1 gap-4" id="store">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="">

                            {{-- name --}}
                            <div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="name" id="name"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Nombre de la votación">
                                </div>
                            </div>

                            {{-- schedule --}}
                            <div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <select id="schedule" name="schedule"
                                            class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                                        <option>Matutino</option>
                                        <option>Vespertino</option>
                                        <option>Mixto</option>
                                    </select>
                                </div>
                            </div>

                            {{-- director --}}
                            <div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="director" id="director"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Nombre completo del director">
                                </div>
                            </div>

                            {{-- in_charge --}}
                            <div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="in_charge" id="in_charge"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Nombre completo del organizador ">
                                </div>
                            </div>

                            {{-- population --}}
                            <div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="population" id="population"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Numero de alumnos con derecho a voto"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>

                            {{-- groups --}}
                            <div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="groups" id="groups"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="Numero de grupos con derecho a voto"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>

                            {{-- start_at --}}
                            <div>
                                <label for="start_at"
                                       class="block text-sm font-medium text-gray-700">
                                    Inicio de votación </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type=datetime-local step=1 name="start_at" id="start_at"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="">
                                </div>
                            </div>

                            {{-- end_at --}}
                            <div>
                                <label for="end_at"
                                       class="block text-sm font-medium text-gray-700">
                                    Fin de votación </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type=datetime-local step=1 name="end_at" id="end_at"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="">
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
                                    <table id="events" class="table table-compact w-full">
                                        <!-- head -->
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Evento</th>
                                            <th>Inicio de votación</th>
                                            <th>Fin de votación</th>
                                            <th>Ver</th>
                                            <th>Editar</th>
                                            <th>Borrar</th>
                                        </tr>
                                        </thead>
                                        <tbody id="events_tbody">

{{--                                        <!-- Get events all atributes in a laravel foreach -->--}}
{{--                                        @foreach($events as $event)--}}
{{--                                            <tr>--}}
{{--                                                <th>{{$event->event_id}}</th>--}}
{{--                                                <th>{{$event->name}}</th>--}}
{{--                                                <th>{{$event->start_at}}</th>--}}
{{--                                                <th>{{$event->end_at}}</th>--}}
{{--                                                <th>--}}
{{--                                                    <button class="btn btn-square btn-outline"--}}
{{--                                                            onclick="showEvent({{$event->event_id}})">--}}
{{--                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"--}}
{{--                                                             height="16" fill="currentColor" class="bi bi-eye-fill"--}}
{{--                                                             viewBox="0 0 16 16">--}}
{{--                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>--}}
{{--                                                            <path--}}
{{--                                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>--}}
{{--                                                        </svg>--}}
{{--                                                    </button>--}}
{{--                                                </th>--}}
{{--                                                <th>--}}
{{--                                                    <button class="btn btn-square btn-outline"--}}
{{--                                                            onclick="setEvent({{$event->event_id}})">--}}
{{--                                                        <svg width="24" stroke-width="1.5" height="24"--}}
{{--                                                             viewBox="0 0 24 24" fill="none"--}}
{{--                                                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                            <path--}}
{{--                                                                d="M20 12V5.74853C20 5.5894 19.9368 5.43679 19.8243 5.32426L16.6757 2.17574C16.5632 2.06321 16.4106 2 16.2515 2H4.6C4.26863 2 4 2.26863 4 2.6V21.4C4 21.7314 4.26863 22 4.6 22H11"--}}
{{--                                                                stroke="currentColor" stroke-linecap="round"--}}
{{--                                                                stroke-linejoin="round"/>--}}
{{--                                                            <path d="M8 10H16M8 6H12M8 14H11" stroke="currentColor"--}}
{{--                                                                  stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                                            <path--}}
{{--                                                                d="M16 5.4V2.35355C16 2.15829 16.1583 2 16.3536 2C16.4473 2 16.5372 2.03725 16.6036 2.10355L19.8964 5.39645C19.9628 5.46275 20 5.55268 20 5.64645C20 5.84171 19.8417 6 19.6464 6H16.6C16.2686 6 16 5.73137 16 5.4Z"--}}
{{--                                                                fill="currentColor" stroke="currentColor"--}}
{{--                                                                stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                                            <path--}}
{{--                                                                d="M17.9541 16.9394L18.9541 15.9394C19.392 15.5015 20.102 15.5015 20.5399 15.9394V15.9394C20.9778 16.3773 20.9778 17.0873 20.5399 17.5252L19.5399 18.5252M17.9541 16.9394L14.963 19.9305C14.8131 20.0804 14.7147 20.2741 14.6821 20.4835L14.4394 22.0399L15.9957 21.7973C16.2052 21.7646 16.3988 21.6662 16.5487 21.5163L19.5399 18.5252M17.9541 16.9394L19.5399 18.5252"--}}
{{--                                                                stroke="currentColor" stroke-linecap="round"--}}
{{--                                                                stroke-linejoin="round"/>--}}
{{--                                                        </svg>--}}
{{--                                                    </button>--}}
{{--                                                </th>--}}
{{--                                                <th>--}}
{{--                                                    <button class="btn btn-square btn-outline"--}}
{{--                                                            onclick="dropEvent({{$event->event_id}})">--}}
{{--                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"--}}
{{--                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>--}}
{{--                                                        </svg>--}}
{{--                                                    </button>--}}
{{--                                                </th>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}

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

    {{--    Create HTML daisyUI modal for view all event attributes--}}
    <input type="checkbox" id="viewEventModal" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box">

            {{--            Create TailwindCSS two column layout for view event attributes, one column for attribute name and other for attribute value, values centered on both columns--}}
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <p class="font-bold">ID</p>
                    <p class="font-bold">Nombre Evento</p>
                    <p class="font-bold">Horario de los electores</p>
                    <p class="font-bold">Director</p>
                    <p class="font-bold">Encargado</p>
                    <p class="font-bold">Total Alumnos</p>
                    <p class="font-bold">Total Grupos</p>
                    <p class="font-bold">Inicio de Votaciones</p>
                    <p class="font-bold">Fin de Votaciones</p>
                </div>
                <div class="col-span-1">
                    <p id="event_id_value"></p>
                    <p id="event_name"></p>
                    <p id="event_schedule"></p>
                    <p id="event_director"></p>
                    <p id="event_in_charge"></p>
                    <p id="event_students"></p>
                    <p id="event_groups"></p>
                    <p id="event_start_date"></p>
                    <p id="event_end_date"></p>
                </div>

                <div class="modal-action col-span-2">
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
                axios.get("{{ route('event_index') }}")
                    .then(function (response) {
                        let events = response.data;

                        // console.log(events);

                        var t = "";
                        for (var i = 0; i < response.data.length; i++) {

                            t += "<tr>";
                            t += "<td>" + events[i].event_id + "</td>";
                            t += "<td>" + events[i].name + "</td>";
                            t += "<td>" + stringToDateMXFormat(events[i].start_at) + "</td>";
                            t += "<td>" + stringToDateMXFormat(events[i].end_at) + "</td>";


                            t += `<td>
                                    <button class="btn btn-square btn-outline"
                                            onclick="showEvent(` + events[i].event_id +`)">
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
                                                            onclick="setEvent(` + events[i].event_id +`)">
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
                                                            onclick="dropEvent(` + events[i].event_id +`)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </th>`;

                            t += "</tr>";
                        }
                        document.getElementById("events_tbody").innerHTML += t;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            }

            function storeEvent(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // console.log(formData)

                // axios post request
                axios.post("{{ route('event_store') }}", formData)
                    .then(function (response) {
                        // console.log(response);

                        Swal.fire(
                            '¡Evento creado con exito!',
                            'Por favor, dirigete a la pestaña de candidatos para agregarlos a este evento',
                            'success'
                        )

                        // clear form except user_id input
                        document.getElementById('store').reset();
                        document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";
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

            function editEvent(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // add event_id to formData
                formData.append('event_id', document.getElementById('event_id').value);

                // console.log(document.getElementById('event_id').value)
                // console.log(formData)

                // axios post request
                axios.post("{{ route('event_update') }}", formData)
                    .then(function (response) {
                        // console.log(response);

                        Swal.fire(
                            '¡Evento modificado con exito!',
                            'Por favor, dirigete a la pestaña de candidatos para agregarlos a este evento',
                            'success'
                        )

                        // clear form except user_id input
                        document.getElementById('store').reset();
                        document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";

                        // change the button text to "Crear evento"
                        document.getElementById('form_button').innerHTML = "Crear evento";

                        // change addEventListener to store
                        document.getElementById('store').removeEventListener('submit', editEvent);
                        document.getElementById('store').addEventListener('submit', storeEvent);

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

            // Create a set event function, it takes the event id as a parameter, get all the event data and put it in the form, then change the button text to "Modificar evento" and change addEventListener to editEvento Function
            function setEvent(id) {

                // set event_id input value
                document.getElementById('event_id').value = id;

                // axios get request
                axios.get("{{ route('event_show') }}", {
                    params: {
                        id: id
                    }
                })
                    .then(function (response) {
                        // console.log(response);

                        // put the event data in the form inputs
                        document.getElementById('event_id').value = response.data.event_id;
                        document.getElementById('user_id').value = response.data.user_id;
                        document.getElementById('name').value = response.data.name;
                        document.getElementById('schedule').value = response.data.schedule;
                        document.getElementById('director').value = response.data.director;
                        document.getElementById('in_charge').value = response.data.in_charge;
                        document.getElementById('population').value = response.data.population;
                        document.getElementById('groups').value = response.data.groups;
                        document.getElementById('start_at').value = stringToDate(response.data.start_at);
                        document.getElementById('end_at').value = stringToDate(response.data.end_at);


                        // change the button text to "Modificar evento"
                        document.getElementById('form_button').innerHTML = "Modificar";

                        // show toastr info message that you are editing the event, but in spanish
                        toastr.info('Estas editando el evento ' + response.data.name);

                        // change addEventListener to editEvent Function
                        // first, remove all the event listeners on 'store' form
                        document.getElementById('store').removeEventListener('submit', storeEvent);
                        document.getElementById('store').addEventListener('submit', editEvent);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // Create a showEvent function, it takes the event id as a parameter, get all the event data and put it in the modal
            function showEvent(id) {
                // axios get request, send id but as dataform

                // console.log(id)

                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            id: id
                        }
                    })
                    .then(function (response) {
                        // console.log(response);

                        // put the event data in the modal
                        document.getElementById('event_id_value').innerHTML = response.data.event_id;
                        document.getElementById('event_name').innerHTML = response.data.name;
                        document.getElementById('event_schedule').innerHTML = response.data.schedule;
                        document.getElementById('event_director').innerHTML = response.data.director;
                        document.getElementById('event_in_charge').innerHTML = response.data.in_charge;
                        document.getElementById('event_students').innerHTML = response.data.population;
                        document.getElementById('event_groups').innerHTML = response.data.groups;

                        document.getElementById('event_start_date').innerHTML = stringToDateMXFormat(response.data.start_at);
                        document.getElementById('event_end_date').innerHTML = stringToDateMXFormat(response.data.end_at);

                        // check the checkbot id="viewEventModal" to show modal
                        document.getElementById('viewEventModal').checked = true;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // Create a drop event function with an id parameter
            function dropEvent(id) {

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

                            id: id

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

            // make $(document).on('submit','#store',function(e) but on vanilla javascript
            document.getElementById('store').addEventListener('submit', storeEvent);
            document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";

            // When DOM is ready, execute populateTable function
            document.addEventListener('DOMContentLoaded', function () {
                populateTable();
            });

        </script>
    </x-slot>

</x-app-layout>
