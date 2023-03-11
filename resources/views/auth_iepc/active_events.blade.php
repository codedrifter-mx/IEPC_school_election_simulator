<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block">Elecciones Activas</h1>
                    </div>

                    <div class="grid grid-cols-6 gap-4" id="form_event">

                        {{-- Table --}}
                        <div class="col-span-6">
                            <div class="overflow-x-auto">
                                <livewire:admin-events-table/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <input type="checkbox" id="viewModalNominal" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="overflow-x-auto">
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
                        <td>Escuela</td>
                        <td id="nominal_name"></td>
                    </tr>
                    <tr>
                        <td>Numero de alumnos y grupos inscritos</td>
                        <td id="nominal_population"></td>
                    </tr>
                    <tr>
                        <td>Número de alumnos que faltan por registrar, del universo de alumnos
                            esperados.
                        </td>
                        <td id="nomina_left"></td>
                    </tr>
                    <tr>
                        <td>Fecha Inicio</td>
                        <td id="nominal_start_at"></td>
                    </tr>
                    <tr>
                        <td>Fecha Fin</td>
                        <td id="nominal_end_at"></td>
                    </tr>
                    <tr>
                        <td>Tiempo Transcurrido</td>
                        <td>
                            <div class="p-3 break-all rounded bg-primary text-center">
                                <div class="text-white font-bold" id="timer">0d 0h 0m 0s</div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>


            <div class="modal-action">
                <button class="btn btn-primary" id="btnDates">Modificar Fechas</button>
                <button class="btn btn-primary" id="btnXlsx">Descargar Excel</button>
                <label for="viewModalNominal" class="btn">Cerrar</label>
            </div>
        </div>
    </div>

    <input type="checkbox" id="viewModalDate" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom ">
            <div class="grid grid-cols-1">
                <input type="hidden" id="event_key" name="event_key" value="">

                <div>
                    <div class="flex flex-col">
                        <label for="start_at" class="block text-sm font-medium text-gray-700">Fecha de inicio
                            propuesto</label>
                        <div class="mt-1">
                            <input type="text" name="end_at" id="start_at"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200"
                                   disabled>
                        </div>
                    </div>

                    <label for="start_at_new"
                           class="mt-3 block text-sm font-medium text-gray-700">
                        Fecha de fin de la votación </label>
                    <input type="datetime-local" name="end_at" id="start_at_new"
                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                           pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}T[0-9]{2}:[0-9]{2}"
                    >

                    <div class="flex flex-col mt-3">
                        <label for="end_at" class="block text-sm font-medium text-gray-700">Fecha de fin
                            propuesto</label>
                        <div class="mt-1">
                            <input type="text" name="end_at" id="end_at"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md bg-gray-200"
                                   disabled>
                        </div>
                    </div>

                    <label for="end_at_new"
                           class="mt-3 block text-sm font-medium text-gray-700">
                        Fecha de fin de la votación </label>
                    <input type="datetime-local" name="end_at" id="end_at_new"
                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                    >
                </div>


                <div class="modal-action col-span-3">
                    <button type="button" class="btn btn-primary" id="validate_event">
                        Validar
                    </button>
                    <label for="viewModalDate" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="viewModalResults" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="overflow-x-auto">
                <div class="p-2 " id="third">
                    <div class="shadow rounded-md overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <button id="details_button"
                                    class="btn-primary w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white ">
                                Conoce los resultados de la elección
                            </button>
                            <button id="results_button"
                                    class="btn-primary w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white ">
                                Descargar cartel de resultados
                            </button>
                            <button id="journey_button"
                                    class="btn-primary w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white ">
                                Descargar Acta de la Jornada Electoral
                            </button>
                            <button id="majority_button"
                                    class="btn-primary w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white ">
                                Descargar Constancia de Mayoría y Validez
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-action">
                <label for="viewModalResults" class="btn">Cerrar</label>
            </div>
        </div>
    </div>


    <input type="checkbox" id="viewDetails" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
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
                    <td>Institución educativa</td>
                    <td id="details_name"></td>
                </tr>
                <tr>
                    <td>Turno</td>
                    <td id="details_schedule"></td>
                </tr>
                <tr>
                    <td>Ciclo escolar</td>
                    <td id="details_cycle"></td>
                </tr>
                <tr>
                    <td>Total de Estudiantes</td>
                    <td id="details_population"></td>
                </tr>
                <tr>
                    <td>Total de Votos</td>
                    <td id="details_total_votes"></td>
                </tr>
                <tr>
                    <td>Desglose por planilla</td>
                    <td id="details_candidates"></td>
                </tr>
                <tr>
                    <td>Abstencionismo</td>
                    <td id="details_no_votes"></td>
                </tr>
                </tbody>
            </table>
            <div class="modal-action col-span-3">
                <label for="viewDetails" class="btn">Cerrar</label>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">

            let event_key = null;
            var x = null;

            function convertDate(date) {
                let dateObj = new Date(date);
                let month = dateObj.getUTCMonth() + 1; //months from 1-12
                let day = dateObj.getUTCDate();
                let year = dateObj.getUTCFullYear();
                let hours = dateObj.getUTCHours().toString().padStart(2, '0');
                let minutes = dateObj.getUTCMinutes().toString().padStart(2, '0');
                let seconds = dateObj.getUTCSeconds().toString().padStart(2, '0');

                let newdate = day + "/" + month + "/" + year + " " + hours + ":" + minutes + ":" + seconds;
                return newdate;
            }

            function convertDateToInput(date) {
                let dateObj = new Date(date);
                let month = (dateObj.getUTCMonth() + 1).toString().padStart(2, '0'); //months from 1-12
                let day = dateObj.getUTCDate().toString().padStart(2, '0');
                let year = dateObj.getUTCFullYear();
                let hours = dateObj.getUTCHours().toString().padStart(2, '0');
                let minutes = dateObj.getUTCMinutes().toString().padStart(2, '0');
                let seconds = dateObj.getUTCSeconds().toString().padStart(2, '0');

                let newdate = year + "-" + month + "-" + day + "T" + hours + ":" + minutes;
                return newdate;
            }

            function showNominal(event_key_) {
                event_key = event_key_;

                axios.get("{{ route('event_getResults') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        document.getElementById('nominal_name').innerHTML = response.data.name;
                        document.getElementById('nominal_population').innerHTML = response.data.population + ' alumnos y ' + response.data.groups + ' grupos';
                        document.getElementById('nomina_left').innerHTML = (response.data.population - response.data.total_votes) + ' faltantes de ' + response.data.population;
                        document.getElementById('nominal_start_at').innerHTML = convertDate(response.data.start_at);
                        document.getElementById('nominal_end_at').innerHTML = convertDate(response.data.end_at);

                        var countDownDate = response.data.start_at;
                        if (countDownDate) {
                            countDownDate = new Date(countDownDate);
                        } else {
                            countDownDate = new Date();
                            localStorage.setItem('startDate', countDownDate);
                        }

                        clearInterval(x)
                        x = setInterval(function () {

                            // Get todays date and time convert to timezone
                            let now = new Date();
                            let utc = now.getTime() + (now.getTimezoneOffset() * 60000);
                            let utc_countDownDate = countDownDate.getTime() + (countDownDate.getTimezoneOffset() * 60000);


                            // Find the distance between now an the count down date
                            let distance = utc - utc_countDownDate;

                            let dateObj = new Date(distance);
                            let month = dateObj.getMonth();
                            let day = dateObj.getDate() - 1;
                            let hours = dateObj.getHours().toString().padStart(2, '0');
                            let minutes = dateObj.getMinutes().toString().padStart(2, '0');
                            let seconds = dateObj.getSeconds().toString().padStart(2, '0');


                            // Output the result in an element with id="demo"
                            document.getElementById("timer").innerHTML = day + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                        }, 1000);


                        document.getElementById('viewModalNominal').checked = true;
                    })
                    .catch(function (error) {
                        toastr.error(error.response.data);
                    });
            }

            function showResultsModal(event_key_) {
                event_key = event_key_;

                document.getElementById('viewModalResults').checked = true;
            }

            function showDetails() {
                axios.get("{{ route('event_details') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {

                        // console.log(response)
                        // fill all details_* with data
                        document.getElementById('details_name').innerHTML = response.data.name;
                        document.getElementById('details_schedule').innerHTML = response.data.schedule;
                        document.getElementById('details_cycle').innerHTML = response.data.cycle;
                        document.getElementById('details_population').innerHTML = response.data.population;
                        document.getElementById('details_total_votes').innerHTML = response.data.total_votes;
                        // document.getElementById('details_candidates').innerHTML = response.data.candidates;
                        document.getElementById('details_no_votes').innerHTML = response.data.no_votes;


                        var table = "<table>";
                        for (let key in response.data.candidates) {
                            table += `<tr><td>${key}</td><td>${response.data.candidates[key]}</td></tr>`;
                        }
                        table += "</table>";

                        document.getElementById("details_candidates").innerHTML = table;

                        document.getElementById('viewDetails').checked = true;

                    })
                    .catch(function (error) {
                        console.log(error)
                        // show toastr error
                        toastr.error(error.response.data);
                    });
            }

            function getFileResults() {

                Swal.fire({
                    title: '¡Un documento digital tiene validez!',
                    text: "Antes de imprimir, piensa si es necesario hacerlo. En el IEPC somos amigables con el medio ambiente, por lo que te invitamos a no imprimir estos documentos, ya que puedes descargarlos y compartirlos vía electrónica",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Descargar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get("{{ route('event_getResultsPdf') }}",
                            {
                                params: {
                                    event_key: event_key
                                }
                            })
                            .then(function (response) {
                                window.open(response.data.url, '_blank');
                            })
                            .catch(function (error) {
                                console.log(error)
                                // show toastr error
                                toastr.error(error.response.data.message);
                            });
                    }
                })

            }

            // function to show details
            function getFileAct() {
                Swal.fire({
                    title: '¡Un documento digital tiene validez!',
                    text: "Antes de imprimir, piensa si es necesario hacerlo. En el IEPC somos amigables con el medio ambiente, por lo que te invitamos a no imprimir estos documentos, ya que puedes descargarlos y compartirlos vía electrónica",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Descargar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get("{{ route('event_getAct') }}",
                            {
                                params: {
                                    event_key: event_key
                                }
                            })
                            .then(function (response) {
                                window.open(response.data.url, '_blank');
                            })
                            .catch(function (error) {
                                console.log(error)
                                // show toastr error
                                toastr.error(error.response.data.message);
                            });
                    }
                })
            }

            // function to show details
            function getFileMayority() {
                //show info toastr that it can take a while



                Swal.fire({
                    title: '¡Un documento digital tiene validez!',
                    text: "Antes de imprimir, piensa si es necesario hacerlo. En el IEPC somos amigables con el medio ambiente, por lo que te invitamos a no imprimir estos documentos, ya que puedes descargarlos y compartirlos vía electrónica",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Descargar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        toastr.info("Este proceso puede tardar unos segundos en descargar...");

                        axios.get("{{ route('event_getMajority') }}",
                            {
                                params: {
                                    event_key: event_key
                                }
                            })
                            .then(function (response) {
                                window.open(response.data.url, '_blank');
                            })
                            .catch(function (error) {
                                console.log(error)
                                // show toastr error
                                toastr.error(error.response.data.message);
                            });
                    }
                })
            }

            function downloadResults() {
                // create a http request for event_getResultsXlsx without axios
                var xhr = new XMLHttpRequest();
                xhr.open('GET', "{{ route('event_getResultsXlsx') }}?event_key=" + event_key, true);
                xhr.responseType = 'blob';
                xhr.onload = function (e) {
                        var blob = this.response;
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "resultados.xlsx";
                        link.click();
                };
                xhr.send();

            }


            function validateEvent() {

                console.log(event_key);

                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        response = response.data;

                        document.getElementById('end_at').value = convertDate(response.data.end_at);
                        document.getElementById('end_at_new').value = convertDateToInput(response.data.end_at);
                        document.getElementById('start_at').value = convertDate(response.data.start_at);
                        document.getElementById('start_at_new').value = convertDateToInput(response.data.start_at);

                        document.getElementById('viewModalDate').checked = true;

                    })
                    .catch(function (error) {
                        console.log(error)
                        toastr.error(error.response.data.message);
                    });
            }

            function updateEvent() {
                let start_at = document.getElementById('start_at_new').value;
                let end_at = document.getElementById('end_at_new').value;

                //event update route
                axios.post("{{ route('event_update') }}",
                    {
                        event_key: event_key,
                        start_at: start_at,
                        end_at: end_at,
                        approved: true
                    })
                    .then(function (response) {
                        toastr.success(response.data.message);

                        //close modal
                        document.getElementById('viewModalDate').checked = false;
                        document.getElementById('viewModalNominal').checked = false;

                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.message);
                    });
            }


            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('btnDates').addEventListener('click', validateEvent);
                document.getElementById('btnXlsx').addEventListener('click', downloadResults);
                document.getElementById('validate_event').addEventListener('click', updateEvent);


                document.getElementById('details_button').addEventListener('click', showDetails);
                document.getElementById('results_button').addEventListener('click', getFileResults);
                document.getElementById('journey_button').addEventListener('click', getFileAct);
                document.getElementById('majority_button').addEventListener('click', getFileMayority);

            });

        </script>
    </x-slot>

</x-app-layout>
