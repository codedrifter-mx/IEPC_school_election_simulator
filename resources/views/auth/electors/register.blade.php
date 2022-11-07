<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-3 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-3 m-3">
                    <div class=" shadow rounded-md overflow-hidden">
                        <div class="h-full px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="text-center">
                                <h1 class="block"> Elije el evento</h1>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div>
                                    <div class="flex rounded-md shadow-sm">
                                        <select name="event_key" id="event_key"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300">
                                            @foreach($events as $event)
                                                <option value="{{ $event->event_key }}">{{ $event->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="px-2 col-span-3 md:col-span-2">
                        <table id="events" class="table table-compact w-full col-span-2 md:col-span-1">

                            <tbody>
                            <tr>
                                <td>Director Actual</td>
                                <td id="event_director"></td>
                            </tr>
                            <tr>
                                <td>Encargado del evento</td>
                                <td id="event_responsible"></td>
                            </tr>

                            <tr>
                                <td>Inicio de Votaciones</td>
                                <td id="event_start_date"></td>
                            </tr>
                            <tr>
                                <td>Estado</td>
                                <td id="event_status"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class=" mx-auto sm:px-2 lg:px-4">
            <div class="mt-3 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-3 m-3">
                    <div class="p-2 col-span-2 md:col-span-1" id="first">

                        <div class="shadow rounded-md overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 1: Desarrollo de la votación</h1>
                                </div>
                                <img class="max-w-full m-0 p-6" id="qr_register" src="" alt="QR">
                                <div class="p-6 break-all rounded bg-primary text-center"><a
                                        class="text-white font-bold"
                                        id="link_register" href=""></a></div>
                            </div>
                        </div>


                    </div>
                    <div class="p-2 col-span-2 md:col-span-1" id="second">
                        <div class="shadow rounded-md overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 2: Desarrollo de la votación</h1>
                                </div>

                                <img class="max-w-full m-0 p-6" id="qr_vote" src="" alt="QR">
                                <div class="p-6 break-all rounded bg-primary text-center"><a
                                        class="text-white font-bold"
                                        id="link_vote" href=""></a></div>

                                {{-- timer between start_at and now--}}
                                <div class="p-6 break-all rounded bg-primary text-center">
                                    <div class="text-white font-bold" id="timer">0d 0h 0m 0s</div>
                                </div>

                                <button id="know_button"
                                        class="btn-block w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Terminar Votación
                                </button>

                            </div>

                        </div>
                    </div>
                    <div class="p-2 col-span-2 md:col-span-1" id="third">
                        <div class="shadow rounded-md overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 3: Resultados y constancias</h1>
                                </div>

                                <button id="know_button"
                                        class="btn-block w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Conoce los resultados de la elección
                                </button>
                                <button id="know_button"
                                        class="btn-block w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Descargar cartel de resultados
                                </button>
                                <button id="know_button"
                                        class="btn-block w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Descargar Acta de la Jornada Electoral
                                </button>
                                <button id="know_button"
                                        class="btn-block w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Descargar Constancia de Mayoría y Validez
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">

            // Create a showEvent function, it takes the event id as a parameter, get all the event data and put it in the modal
            function showEvent() {

                // get event_key from combobox
                let event_key = document.getElementById('event_key').value;

                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        // console.log(response);
                        // if status 201, show toaster
                        if (response.data.data.status === 201) {
                            toastr.error(response.data.message);
                        }


                        document.getElementById('event_director').innerHTML = response.data.data.director;
                        document.getElementById('event_responsible').innerHTML = response.data.data.responsible;

                        // enable first and second divs opacoity 1 and pointerEvents
                        document.getElementById('first').style.opacity = 1;
                        document.getElementById('first').style.pointerEvents = 'auto';
                        document.getElementById('second').style.opacity = 1;
                        document.getElementById('second').style.pointerEvents = 'auto';

                        // if response.data.status is 0, add a badge with the text "Inactivo", if is 1, add a badge with the text "Activo", if is 2, add a badge with the text "Finalizado"
                        if (response.data.data.status === 0) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-danger">Inactivo</span>';
                            //toaster
                            toastr.info('La votación no ha iniciado, comparte el enlace a los alumnos', 'Fase 1', {timeOut: 5000});
                            //disable id second, third as opaque style
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";

                        } else if (response.data.data.status === 1) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-success">Activo</span>';
                            // toaster info message
                            toastr.info('La votación se encuentra activa, puedes continuar con la votación', 'Fase 2', {timeOut: 5000});

                            //disable id third as opaque style
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";

                            // enable clock text as a timer between start_at and current time
                            var countDownDate = response.data.data.start_at;
                            if (countDownDate) {
                                countDownDate = new Date(countDownDate);
                            } else {
                                countDownDate = new Date();
                                localStorage.setItem('startDate', countDownDate);
                            }

                            var x = setInterval(function () {

                                // Get todays date and time
                                var now = new Date().getTime();

                                // Find the distance between now an the count down date
                                var distance = now - countDownDate.getTime();

                                // Time calculations for days, hours, minutes and seconds
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                // Output the result in an element with id="demo"
                                document.getElementById("timer").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                            }, 1000);


                        } else if (response.data.data.status === 2) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-secondary">Finalizado</span>';

                            // toaster info message
                            toastr.info('La votación ha finalizado, puedes acceder a los resultados', 'Fase 3', {timeOut: 5000});

                            //disable id first, second as opaque style
                            document.getElementById('first').style.opacity = "0.5";
                            document.getElementById('first').style.pointerEvents = "none";
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                            // able third
                            document.getElementById('third').style.opacity = "1";
                            document.getElementById('third').style.pointerEvents = "auto";
                        } else if (response.data.data.status === 3) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-secondary">Falta validacion IEPC</span>';

                            // toaster info message
                            toastr.error('Falta validacion del IEPC', 'No validado', {timeOut: 5000});

                            //disable id first, second and third as opaque style
                            document.getElementById('first').style.opacity = "0.5";
                            document.getElementById('first').style.pointerEvents = "none";
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";
                        } else if (response.data.data.status === 4) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-secondary">Candidatos Insuficientes</span>';

                            // toaster info message
                            toastr.error('Candidatos insuficientes', 'Insuficientes', {timeOut: 5000});

                            //disable id first, second and third as opaque style
                            document.getElementById('first').style.opacity = "0.5";
                            document.getElementById('first').style.pointerEvents = "none";
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";
                        }

                        document.getElementById('event_start_date').innerHTML = stringToDateMXFormat(response.data.data.start_at);

                        document.getElementById('link_register').innerHTML = window.location.origin + "/votacion/registro/" + response.data.data.event_key;
                        document.getElementById('link_register').href = window.location.origin + "/votacion/registro/" + response.data.data.event_key;
                        document.getElementById("qr_register").src = window.location.origin + "/qr_register/" + response.data.data.event_key;

                        document.getElementById('link_vote').innerHTML = window.location.origin + "/votacion/" + response.data.data.event_key;
                        document.getElementById('link_vote').href = window.location.origin + "/votacion/" + response.data.data.event_key;
                        document.getElementById("qr_vote").src = window.location.origin + "/qr_vote/" + response.data.data.event_key;

                    })
                    .catch(function (error) {
                        // show toastr error
                        toastr.error(error.response.data.message);

                        // if error status is 400, empty event_director, event_responsible, event_status, event_start_date, and disable id second, third as opaque style
                        if (error.response.status === 400) {
                            document.getElementById('event_director').innerHTML = '';
                            document.getElementById('event_responsible').innerHTML = '';
                            document.getElementById('event_status').innerHTML = '';
                            document.getElementById('event_start_date').innerHTML = '';
                            document.getElementById('first').style.opacity = "0.5";
                            document.getElementById('first').style.pointerEvents = "none";
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";
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

            // function to stop event
            function stopEvent() {
                let event_key = document.getElementById('event_key').value;


                axios.post("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        // show toastr success
                        toastr.success(response.data.message);
                        // reload page
                        showEvent();
                    })
                    .catch(function (error) {
                        // show toastr error
                        toastr.error(error.response.data.message);
                    });
            }


            // When DOM is ready, execute populateTable function
            document.addEventListener('DOMContentLoaded', function () {
                // When document.getElementById('events') changes, refresh the table
                document.getElementById('event_key').addEventListener('change', showEvent);

                showEvent();
            });

        </script>
    </x-slot>
</x-app-layout>
