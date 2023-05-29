<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-3 md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-3 m-3">

                    <div class="p-2 col-span-2 md:col-span-1">
                        <div class="h-full px-4 py-5 bg-white space-y-6 sm:p-6 rounded-md">
                            <div class="text-center">
                                <h1 class="block"> Elije el evento</h1>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <div>
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

                    <div class="p-2 col-span-3 md:col-span-2 rounded-md">
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
                                <td>Fin de Votaciones</td>
                                <td id="event_end_date"></td>
                            </tr>
                            <tr>
                                <td>Votos Actuales / Total de Estudiantes</td>
                                <td id="event_progress"></td>
                            </tr>
                            <tr>
                                <td>Estado</td>
                                <td id="event_status"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-2 col-span-2 md:col-span-1 rounded-md" id="first">

                        <div class="shadow rounded-md overflow-hidden ">
                            <div class="px-4 py-2 bg-white space-y-4 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 1: Registro de votantes</h1>
                                </div>
                                <div class="p-2 rounded shadow-xl bg-gray-100">
                                    <img class="max-w-full " id="qr_register" src="" alt="QR">
                                </div>

                                <div class="text-center rounded bg-primary p-3"><a
                                        class="text-white text-xs font-bold p-3 break-all text-center"
                                        id="link_register" href=""></a>
                                </div>


                                @if(Auth::user()->level == 'Primaria' || Auth::user()->level == 'Secundaria')
                                    <button id="list_button"
                                            class="btn-primary w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white ">
                                        Descargar lista de votantes
                                    </button>
                                @endif

                            </div>


                        </div>


                    </div>

                    <div class="p-2 col-span-2 md:col-span-1 rounded-md" id="second">
                        <div class="shadow rounded-md overflow-hidden">
                            <div class="px-4 py-2 bg-white space-y-4 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 2: Votación</h1>
                                </div>
                                <div class="p-2 rounded shadow-xl bg-gray-100">
                                    <img class="max-w-full" id="qr_vote" src="" alt="QR">
                                </div>

                                <div class="text-center rounded bg-primary p-3">
                                    <a class="text-white text-xs font-bold p-3 break-all rounded bg-primary text-center"
                                       id="link_vote" href=""></a>
                                </div>

                                <div class="p-3 break-all rounded bg-primary text-center text-xs" id="timer_upper">
                                    <div class="text-white font-bold" id="timer">0d 0h 0m 0s</div>
                                </div>

                                <button id="stop_button"
                                        class="btn-primary w-full text-sm py-2 px-2 border border-transparent shadow-sm font-medium rounded-md text-white">
                                    Terminar Votación
                                </button>

                            </div>

                        </div>
                    </div>

                    <div class="p-2 col-span-2 md:col-span-1 rounded-md" id="third">
                        <div class="shadow rounded-md overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="text-center">
                                    <h1 class="block">Fase 3: Resultados y constancias</h1>
                                </div>

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
                    <td>Votantes registrados</td>
                    <td id="details_registered"></td>
                </tr>
                <tr>
                    <td>Votantes registrados que no votaron</td>
                    <td id="details_no_votes"></td>
                </tr>
                <tr>
                    <td>Votantes registrados que votaron</td>
                    <td id="details_yes_votes"></td>
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

            var x = null;

            function showEvent() {
                let event_key = document.getElementById('event_key').value;

                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        if (response.data.data.status === 201) {
                            toastr.error(response.data.message);
                        }

                        setStep(response.data.data.status, response)
                    })
                    .catch(function (error) {
                        console.log(error)

                        // if (error.response.status === 400) {
                        //     document.getElementById('event_director').innerHTML = '';
                        //     document.getElementById('event_responsible').innerHTML = '';
                        //     document.getElementById('event_status').innerHTML = '';
                        //     document.getElementById('event_start_date').innerHTML = '';
                        //     document.getElementById('first').style.opacity = "0.5";
                        //     document.getElementById('first').style.pointerEvents = "none";
                        //     document.getElementById('second').style.opacity = "0.5";
                        //     document.getElementById('second').style.pointerEvents = "none";
                        //     document.getElementById('third').style.opacity = "0.5";
                        //     document.getElementById('third').style.pointerEvents = "none";
                        // }
                    });
            }

            function setStep(step, response) {
                document.getElementById('event_director').innerHTML = response.data.data.director;
                document.getElementById('event_responsible').innerHTML = response.data.data.responsible;
                document.getElementById('event_start_date').innerHTML = convertDate(response.data.data.start_at);
                document.getElementById('event_end_date').innerHTML = convertDate(response.data.data.end_at);
                document.getElementById('event_progress').innerHTML = response.data.data.total_votes + " / " + response.data.data.population;

                document.getElementById('link_register').innerHTML = window.location.origin + "/votacion/registro/" + response.data.data.event_key;
                document.getElementById('link_register').href = window.location.origin + "/votacion/registro/" + response.data.data.event_key;
                document.getElementById("qr_register").src = window.location.origin + "/qr_register/" + response.data.data.event_key;

                document.getElementById('link_vote').innerHTML = window.location.origin + "/votacion/" + response.data.data.event_key;
                document.getElementById('link_vote').href = window.location.origin + "/votacion/" + response.data.data.event_key;
                document.getElementById("qr_vote").src = window.location.origin + "/qr_vote/" + response.data.data.event_key;

                // enable first and second divs opacoity 1 and pointerEvents
                document.getElementById('first').style.opacity = 1;
                document.getElementById('first').style.pointerEvents = 'auto';
                document.getElementById('second').style.opacity = 1;
                document.getElementById('second').style.pointerEvents = 'auto';

                // remove timer_upper inner html and add again <div class="text-white font-bold" id="timer">0d 0h 0m 0s</div>
                document.getElementById('timer_upper').innerHTML = '<div class="text-white font-bold" id="timer">0d 0h 0m 0s</div>';
                // delete x object if exists
                clearInterval(x);


                switch (step) {
                    case 0:
                        document.getElementById('event_status').innerHTML = '<span class="badge badge-danger">Inactivo</span>';
                        //toaster
                        // toastr.info('La votación no ha iniciado, comparte el enlace a los alumnos', 'Fase 1', {timeOut: 5000}); but top middle
                        toastr.info('La votación no ha iniciado, comparte el enlace a los alumnos', 'Fase 1', {
                            timeOut: 5000,
                            positionClass: "toast-top-center"
                        });
                        //disable id second, third as opaque style
                        document.getElementById('second').style.opacity = "0.5";
                        document.getElementById('second').style.pointerEvents = "none";
                        document.getElementById('third').style.opacity = "0.5";
                        document.getElementById('third').style.pointerEvents = "none";

                        // set id first with a background color purple
                        document.getElementById('first').style.backgroundColor = "#6B46C1";

                        document.getElementById('first').style.backgroundColor = "#6B46C1";
                        document.getElementById('second').style.backgroundColor = null;
                        document.getElementById('third').style.backgroundColor = null;
                        break;
                    case 1:

                        document.getElementById('event_status').innerHTML = '<span class="badge badge-success">Activo</span>';
                        // toaster info message
                        toastr.info('La votación se encuentra activa, puedes continuar con la votación', 'Fase 2', {
                            timeOut: 5000,
                            positionClass: "toast-top-center"
                        });

                        //disable id third as opaque style
                        document.getElementById('third').style.opacity = "0.5";
                        document.getElementById('third').style.pointerEvents = "none";
                        document.getElementById('second').style.backgroundColor = "#6B46C1";


                        // enable clock text as a timer between start_at and current time
                        let countDownDate = response.data.data.start_at;
                        if (countDownDate) {
                            countDownDate = new Date(countDownDate);
                        } else {
                            countDownDate = new Date();
                            localStorage.setItem('startDate', countDownDate);
                        }

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

                        document.getElementById('first').style.backgroundColor = null;
                        document.getElementById('second').style.backgroundColor = "#6B46C1";
                        document.getElementById('third').style.backgroundColor = null;
                        break;
                    case 2:

                        document.getElementById('event_status').innerHTML = '<span class="badge badge-secondary">Finalizado</span>';

                        // toaster info message on top mid
                        toastr.info('La votación ha finalizado, puedes ver los resultados', 'Fase 3', {
                            timeOut: 5000,
                            positionClass: "toast-top-center"
                        });

                        //disable id first, second as opaque style
                        document.getElementById('first').style.opacity = "0.5";
                        document.getElementById('first').style.pointerEvents = "none";
                        document.getElementById('second').style.opacity = "0.5";
                        document.getElementById('second').style.pointerEvents = "none";
                        // able third
                        document.getElementById('third').style.opacity = "1";
                        document.getElementById('third').style.pointerEvents = "auto";

                        // remove link_register and qr_register, link_vote and qr_vote
                        document.getElementById('link_register').innerHTML = "";
                        document.getElementById('link_register').href = "";
                        document.getElementById("qr_register").src = "";

                        document.getElementById('link_vote').innerHTML = "";
                        document.getElementById('link_vote').href = "";
                        document.getElementById("qr_vote").src = "";


                        document.getElementById('first').style.backgroundColor = null;
                        document.getElementById('second').style.backgroundColor = null;
                        document.getElementById('third').style.backgroundColor = "#6B46C1";
                        break;

                    case 3:
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

                        // remove link_register and qr_register, link_vote and qr_vote
                        document.getElementById('link_register').innerHTML = "";
                        document.getElementById('link_register').href = "";
                        document.getElementById("qr_register").src = "";

                        document.getElementById('link_vote').innerHTML = "";
                        document.getElementById('link_vote').href = "";
                        document.getElementById("qr_vote").src = "";
                        break;

                    case 4:
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

                        // remove link_register and qr_register, link_vote and qr_vote
                        document.getElementById('link_register').innerHTML = "";
                        document.getElementById('link_register').href = "";
                        document.getElementById("qr_register").src = "";

                        document.getElementById('link_vote').innerHTML = "";
                        document.getElementById('link_vote').href = "";
                        document.getElementById("qr_vote").src = "";
                        break;
                }
            }

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

            function stringToDate(string) {
                let date = new Date(string);
                return date.toISOString().slice(0, 16);
            }

            function stopEvent() {
                let event_key = document.getElementById('event_key').value;


                axios.post("{{ route('event_stop') }}",
                    {
                        event_key: event_key
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

            // function to show details
            function showDetails() {
                let event_key = document.getElementById('event_key').value;

                axios.get("{{ route('event_details') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        document.getElementById('details_name').innerHTML = response.data.name;
                        document.getElementById('details_schedule').innerHTML = response.data.schedule;
                        document.getElementById('details_cycle').innerHTML = response.data.cycle;
                        document.getElementById('details_population').innerHTML = response.data.population;
                        document.getElementById('details_total_votes').innerHTML = response.data.total_votes;

                        document.getElementById('details_registered').innerHTML = response.data.total_electors;

                        let percentage = (response.data.total_electors_votes / response.data.total_electors) * 100
                        document.getElementById('details_yes_votes').innerHTML = percentage.toFixed(2) + "%";
                        document.getElementById('details_no_votes').innerHTML = (100 - percentage).toFixed(2) + "%";


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

            // function to show details
            function getFileResults() {
                let event_key = document.getElementById('event_key').value;


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

                        axios.get("{{ route('event_getResultsPdf') }}", {
                            params: {
                                event_key: event_key
                            },
                            responseType: 'blob'
                        })
                            .then(function (response) {
                                const url = URL.createObjectURL(response.data);
                                window.open(url, '_blank');
                            })
                            .catch(function (error) {
                                console.log(error);
                                toastr.error(error.response.data);
                            });
                    }
                })

            }

            function getElectors() {
                let event_key = document.getElementById('event_key').value;

                var xhr = new XMLHttpRequest();
                xhr.open('GET', "{{ route('event_getElectorsXlsx') }}?event_key=" + event_key, true);
                xhr.responseType = 'blob';
                xhr.onload = function (e) {
                    var blob = this.response;
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "votantes.xlsx";
                    link.click();
                };
                xhr.send();
            }

            // function to show details
            function getFileAct() {
                let event_key = document.getElementById('event_key').value;

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

                        axios.get("{{ route('event_getAct') }}", {
                            params: {
                                event_key: event_key
                            },
                            responseType: 'blob' // Set the response type to 'blob'
                        })
                            .then(function (response) {
                                // Create a URL object from the blob response
                                const url = URL.createObjectURL(response.data);
                                // Open the URL in a new window or tab
                                window.open(url, '_blank');
                            })
                            .catch(function (error) {
                                console.log(error);
                                // show toastr error
                                toastr.error(error.response.data);
                            });
                    }
                });
            }


            // function to show details
            function getFileMayority() {
                //show info toastr that it can take a while

                let event_key = document.getElementById('event_key').value;


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
                        toastr.info("Este proceso puede tardar unos segundos en descargar...", {
                            timeOut: 5000,
                            positionClass: "toast-top-center"
                        });

                        axios.get("{{ route('event_getMajority') }}", {
                            params: {
                                event_key: event_key
                            },
                            responseType: 'blob'
                        })
                            .then(function (response) {
                                const url = URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
                                const link = document.createElement('a');
                                link.href = url;
                                link.target = '_blank';
                                link.click();
                            })
                            .catch(function (error) {
                                console.log(error);
                                // show toastr error
                                toastr.error(error.response.data);
                            });
                    }
                })
            }


            // When DOM is ready, execute populateTable function
            document.addEventListener('DOMContentLoaded', function () {
                // When document.getElementById('events') changes, refresh the table
                document.getElementById('event_key').addEventListener('change', showEvent);
                document.getElementById('stop_button').addEventListener('click', stopEvent);
                document.getElementById('details_button').addEventListener('click', showDetails);
                document.getElementById('list_button').addEventListener('click', getElectors);
                document.getElementById('results_button').addEventListener('click', getFileResults);
                document.getElementById('journey_button').addEventListener('click', getFileAct);
                document.getElementById('majority_button').addEventListener('click', getFileMayority);

                showEvent();
            });

        </script>
    </x-slot>
</x-app-layout>
