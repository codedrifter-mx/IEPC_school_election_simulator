<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-3 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-3 m-3">
                    <div class="shadow rounded-md overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
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
                    <div class="p-2 col-span-3 md:col-span-2">
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
                                <td>Director</td>
                                <td id="event_director"></td>
                            </tr>
                            <tr>
                                <td>Encargado</td>
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
                                <img class="max-w-full m-0 p-6" id="qr" src="/qrcode/demo" alt="QR">
                                <div class="p-6 break-all rounded bg-primary text-center"><a
                                        class="text-white font-bold"
                                        id="link" href=""></a></div>
                            </div>
                        </div>


                    </div>
                    <div class="p-2 col-span-2 md:col-span-1" id="second">
                        <div class="shadow rounded-md overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 2: Desarrollo de la votación</h1>
                                </div>
                                <img class="max-w-full m-0 p-6" id="qr" src="/qrcode/demo" alt="QR">
                                <div class="p-6 break-all rounded bg-primary text-center"><a
                                        class="text-white font-bold"
                                        id="link" href=""></a></div>
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


                        document.getElementById('event_director').innerHTML = response.data.director;
                        document.getElementById('event_responsible').innerHTML = response.data.responsible;

                        // if response.data.status is 0, add a badge with the text "Inactivo", if is 1, add a badge with the text "Activo", if is 2, add a badge with the text "Finalizado"
                        if (response.data.status === 0) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-danger">Inactivo</span>';
                            //disable id second, third as opaque style
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";

                        } else if (response.data.status === 1) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-success">Activo</span>';
                            //disable id third as opaque style
                            document.getElementById('third').style.opacity = "0.5";
                            document.getElementById('third').style.pointerEvents = "none";


                        } else if (response.data.status === 2) {
                            document.getElementById('event_status').innerHTML = '<span class="badge badge-secondary">Finalizado</span>';
                            //disable id first, second as opaque style
                            document.getElementById('first').style.opacity = "0.5";
                            document.getElementById('first').style.pointerEvents = "none";
                            document.getElementById('second').style.opacity = "0.5";
                            document.getElementById('second').style.pointerEvents = "none";
                        }

                        document.getElementById('event_start_date').innerHTML = stringToDateMXFormat(response.data.start_at);

                        document.getElementById('link').innerHTML = window.location.origin + "/votacion/" + response.data.event_key;
                        document.getElementById('link').href = window.location.origin + "/votacion/" + response.data.event_key;
                        document.getElementById("qr").src = window.location.origin + "/qrcode/" + response.data.event_key;
                    })
                    .catch(function (error) {
                        console.log(error);
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


            // When DOM is ready, execute populateTable function
            document.addEventListener('DOMContentLoaded', function () {
                // When document.getElementById('events') changes, refresh the table
                document.getElementById('event_key').addEventListener('change', showEvent);

                showEvent();
            });

        </script>
    </x-slot>
</x-app-layout>
