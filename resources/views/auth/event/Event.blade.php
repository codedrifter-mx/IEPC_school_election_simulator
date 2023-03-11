<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block font-bold">Realiza tu registro</h1>
                    </div>

                    <div class="grid grid-cols-6 gap-4" id="form_event">

                        <input type="hidden" id="event_key" name="event_key">

                        <form class="col-span-6 md:col-span-2 grid grid-cols-1 gap-4">
                            @csrf
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->user_id }}">

                            <div>
                                <label for="name"
                                       class="block text-sm font-medium text-gray-700">
                                    Nombre del evento </label>
                                <input type="text" name="name" id="name"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Ejemplo: Elección de la Sociedad de Alumnos de la Escuela Primaria Benito Juárez">
                            </div>

                            {{-- cycle --}}
                            <div>
                                <label for="cycle"
                                       class="block text-sm font-medium text-gray-700">
                                    Ciclo escolar </label>
                                <select id="cycle" name="cycle"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">

                                </select>
                            </div>

                            {{-- population --}}
                            <div>
                                <label for="population"
                                       class="block text-sm font-medium text-gray-700">
                                    Total de alumnos </label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="population" id="population"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>

                            {{-- groups --}}
                            <div>
                                <div class="tooltip" data-tip="Numero total de grupos en la institución actualmente">
                                    <label for="groups"
                                           class="block text-sm font-medium text-gray-700">
                                        Numeros de grupos
                                    </label>
                                </div>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="groups" id="groups"
                                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                           placeholder="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>

                            {{-- schedule --}}
                            <div>
                                <label for="schedule"
                                       class="block text-sm font-medium text-gray-700">
                                    Turno</label>
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
                                    Título y nombre de la autoridad máxima de la institución</label>
                                <input type="text" name="director" id="director"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Ejemplo: Mtra. Daniela Ruiz Martínez. Directora">
                            </div>

                            {{-- Blob --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700"
                                       for="photo">Logotipo actual de la institución</label>
                                <input class="block w-full text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold" id="photo" type="file" name="photo">

                            </div>

                            {{-- responsible --}}
                            <div>
                                <label for="responsible"
                                       class="block text-sm font-medium text-gray-700">
                                    El IEPC podrá contactar a: </label>
                                <input type="text" name="responsible" id="responsible"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Indique el nombre del personal docente encargado de coordinar la actividad">
                            </div>

                            {{-- responsible_phone --}}
                            <div>
                                <label for="responsible_phone"
                                       class="block text-sm font-medium text-gray-700">
                                    Número telefónico del responsable</label>
                                <input type="text" name="responsible_phone" id="responsible_phone"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       placeholder="Ejemplo: 55 1234 5678"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>

                            {{-- start_at --}}
                            <div>
                                <label for="start_at"
                                       class="block text-sm font-medium text-gray-700">
                                    Fecha de inicio de la votación </label>
                                <input type="datetime-local" name="start_at" id="start_at"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       value="{{ date('Y-m-d\TH:i', mktime(1,0,0)) }}">
                            </div>

                            {{-- end_at --}}
                            <div>
                                <label for="end_at"
                                       class="block text-sm font-medium text-gray-700">
                                    Fecha de fin de la votación </label>
                                <input type="datetime-local" name="end_at" id="end_at"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                       value="{{ date('Y-m-d\TH:i', mktime(23,59,0)+(14*24*60*60)) }}">
                            </div>


                            {{-- Button Form --}}
                            <div>
                                <button id="submit_button"
                                        class="btn-primary inline-flex w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white">
                                    Guardar
                                </button>
                            </div>
                        </form>

                        {{-- Table --}}
                        <div class="col-span-6 md:col-span-4">
                            <div class="overflow-x-auto shadow-xl ">
                                <livewire:events-table/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script type="text/javascript">

            let global_event_key = '';


            // function to create event
            function storeEvent(e) {
                e.preventDefault();

                let user_id = document.getElementById('user_id').value
                let name = document.getElementById("name").value;
                let cycle = document.getElementById("cycle").value;
                let population = document.getElementById("population").value;
                let groups = document.getElementById("groups").value;
                let schedule = document.getElementById("schedule").value;
                let director = document.getElementById("director").value;
                let photo = document.getElementById('photo').files[0];
                let responsible = document.getElementById("responsible").value;
                let responsible_phone = document.getElementById("responsible_phone").value;
                let start_at = document.getElementById("start_at").value;
                let end_at = document.getElementById("end_at").value;

                // create formdata
                let formData = new FormData();

                formData.append('user_id', user_id);
                formData.append('name', name);
                formData.append('cycle', cycle);
                formData.append('population', population);
                formData.append('groups', groups);
                formData.append('schedule', schedule);
                formData.append('director', director);
                formData.append('photo', photo);
                formData.append('responsible', responsible);
                formData.append('responsible_phone', responsible_phone);
                formData.append('start_at', start_at);
                formData.append('end_at', end_at);



                // axios post request
                axios.post("{{ route('event_store') }}", formData)
                    .then(function (response) {

                        // clear each input
                        document.getElementById("name").value = '';
                        document.getElementById("cycle").value = '';
                        document.getElementById("population").value = '';
                        document.getElementById("groups").value = '';
                        document.getElementById("schedule").value = '';
                        document.getElementById("director").value = '';
                        document.getElementById("responsible").value = '';
                        document.getElementById("responsible_phone").value = '';

                        // swal with message "Para continuar con el proceso de registro, realiza el paso 2 ingresando los datos de la elección."
                        Swal.fire({
                            title: '¡Evento creado con éxito!',
                            text: "Para continuar con el proceso de registro, realiza el paso 2 ingresando los datos de la elección.",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Continuar',
                        });

                    })
                    .catch(function (error) {
                        console.log(error);

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
                let responsible = document.getElementById('responsible').value;
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
                    responsible: responsible,
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
                        document.getElementById('responsible').value = '';
                        document.getElementById('population').value = '';
                        document.getElementById('groups').value = '';

                        // change the button text to "Crear evento"
                        document.getElementById('submit_button').innerHTML = "Crear evento";

                        // change addEventListener to store
                        document.getElementById('form_event').removeEventListener('submit', editEvent);
                        document.getElementById('form_event').addEventListener('submit', storeEvent);

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

            function stringToDateMXFormat(string) {
                let date = new Date(string);
                return date.toLocaleString("es-MX", {timeZone: "America/Mexico_City"});
            }

            // function to conver string to date yyyy-MM-ddThh:mm format
            function stringToDate(string) {
                let date = new Date(string);
                return date.toISOString().slice(0, 16);
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
                        document.getElementById('event_key').value = response.data.data.event_key;
                        document.getElementById('name').value = response.data.data.name;
                        document.getElementById('cycle').value = response.data.data.cycle;
                        document.getElementById('schedule').value = response.data.data.schedule;
                        document.getElementById('director').value = response.data.data.director;
                        document.getElementById('responsible').value = response.data.data.responsible;
                        document.getElementById('responsible_phone').value = response.data.data.responsible_phone;
                        document.getElementById('population').value = response.data.data.population;
                        document.getElementById('groups').value = response.data.data.groups;
                        document.getElementById('start_at').value = stringToDate(response.data.data.start_at);
                        document.getElementById('end_at').value = stringToDate(response.data.data.end_at);

                        // change the button text to "Modificar evento"
                        document.getElementById('submit_button').innerHTML = "Modificar";

                        // change addEventListener to editEvent Function
                        // first, remove all the event listeners on 'store' form
                        document.getElementById('form_event').removeEventListener('submit', storeEvent);
                        document.getElementById('form_event').addEventListener('submit', editEvent);

                        // show toastr info message that you are editing the event, but in spanish
                        toastr.info('Estas editando el evento ' + response.data.data.name);
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
                                toastr.success('El evento ha sido eliminado.');
                            })
                            .catch(function (error) {

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

            document.addEventListener('DOMContentLoaded', function () {
                // Set on submit_button button the submit event to storeEvent function
                document.getElementById('form_event').addEventListener('submit', storeEvent);
                document.getElementById('user_id').value = "{{ Auth::user()->user_id }}";

                // fill cycle with "year-year+1" format, 10 years from current
                let currentYear = new Date().getFullYear() - 1;
                for (let i = 0; i < 10; i++) {
                    let option = document.createElement("option");
                    option.text = currentYear + "-" + (currentYear + 1);
                    option.value = currentYear + "-" + (currentYear + 1);
                    document.getElementById("cycle").add(option);
                    currentYear++;
                }

                if (!localStorage.getItem('firstTime')) {
                    Swal.fire({
                        title: '¡Bienvenido!',
                        icon: 'info',
                        width: 800,
                        html: `
                            <div style="text-align: left;">
                                A continuación, se te pedirá realizar el registro de la elección que se organizará en tu escuela. Antes de continuar, te sugerimos que tengas a la mano los siguientes datos:
                             <br><br>Nombre del evento (Ej. Elección de la sociedad de alumnos)
                             <br>Ciclo Escolar
                             <br>Total de alumnos (que votarán)
                             <br>Número de grupos (con los que cuenta tu escuela)
                             <br>Turno
                             <br>Título, nombre y cargo de la máxima autoridad de la escuela
                             <br>Nombre de una persona enlace
                             <br>Número telefónico de la persona designada como enlace
                             <br>Fecha y hora del inicio de la votación
                             <br>Fecha y hora del fin de la votación
                             <br>Logotipo de la escuela en formato JPG o PNG
                             <br>Domicilio de la escuela
                            </div>
                        `,
                        confirmButtonText: '¡Entendido!'
                    });
                    localStorage.setItem('firstTime', true);
                }

            });


        </script>
    </x-slot>

</x-app-layout>
