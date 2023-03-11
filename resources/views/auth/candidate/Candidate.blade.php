<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <h1 class="block"> Selecciona un evento </h1>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-3">
                            <label for="event_key" class="block text-sm font-medium text-gray-700">Elije un
                                evento</label>
                            <select id="event_key" name="event_key"
                                    class="my-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="sm:px-6 mx-2 lg:px-8">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div id="validation-form" class="px-4 py-5 bg-white space-y-6 sm:p-6">

                        {{-- Title Form --}}
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <h1 class="block"> Nuevo Candidato </h1>
                        </div>


                        {{-- Form structure --}}
                        <div class="flex flex-wrap">

                            {{-- Form --}}
                            <form id="store" class="p-2 flex-initial basis-2/5">
                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value="">
                                <input type="hidden" id="candidate_key" name="candidate_key">

                                {{-- teamname --}}
                                <div class="my-3">
                                    <label for="teamname"
                                           class="text-sm text-right">
                                        Nombre de Planilla </label>
                                    <div class="my-1 flex rounded-md shadow-sm">
                                        <input type="text" name="teamname" id="teamname"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                               placeholder="Planilla">
                                    </div>
                                </div>


                                {{-- name --}}
                                <div class="my-3">
                                    <label for="name"
                                           class="text-sm text-right">
                                        Nombre completo del candidato representante</label>
                                    <div class="my-1 flex rounded-md shadow-sm">
                                        <input type="text" name="name" id="name"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                               placeholder="Nombre">
                                    </div>
                                </div>

                                {{-- Blob --}}
                                <div class="my-3">
                                    <label class="text-sm text-right"
                                           for="photo">Logotipo de la planilla</label>
                                    <input class="block w-full text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold" id="photo" type="file" name="photo">

                                </div>

                                {{-- Blob --}}
                                <div class="my-3">
                                    <label class="text-sm text-right"
                                           for="photo">Video de propuestas</label>
                                    <input class="block w-full text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold" id="video" type="file" name="video">

                                </div>


                                {{-- Aviso de privacidad checkbox with flex--}}
                                <div class="flex items-center justify-center m-2">
                                    <input type="checkbox" name="privacy" id="privacy" class="m-3">
                                    <label
                                        class="block link" for="privacy">Declaro que la escuela cuenta con el
                                        consentimiento escrito
                                        de la persona candidata de esta planilla (en su caso del padre,
                                        madre o tutor) para la utilización de su nombre e imagen en
                                        esta plataforma durante el desarrollo de esta elección.</label>
                                </div>


                                {{-- Button Form --}}
                                <div>
                                    <button id="form_button"
                                            class="btn-primary inline-flex w-full mt-3 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white">
                                        Guardar
                                    </button>
                                </div>
                            </form>

                            {{-- Table --}}
                            <div class="p-2 flex-1 overflow-x-auto">
                                <div class="">
                                    <div class="">
                                        <table id="candidates" class="table table-compact w-full">
                                            <!-- head -->
                                            <thead>
                                            <tr>
                                                <th>Planilla</th>
                                                <th>Candidato</th>
                                                <th>Ver</th>
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

        <input type="checkbox" id="viewCandidateModal" class="modal-toggle"/>
        <div class="modal">
            <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
                <div class="grid grid-cols-40/60">
                    <div class="p-6 col-span-2 md:col-span-1">
                        <img class="max-w-full m-0 p-6" id="modal_photo" src="" alt="photo">
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
                            <td>Planilla</td>
                            <td id="modal_teamname"></td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td id="modal_name"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="modal-action col-span-3">
                        <a href="" type="button" class="btn btn-primary" id="view_video">
                            Ver video
                        </a>
                        <label for="viewCandidateModal" class="btn">Cerrar</label>
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
                        user_id: document.getElementById('user_id').value,
                        ongoing: true
                    }
                })
                    .then(function (response) {
                        if (response.data.length === 0) {
                            // toastr.error('No hay eventos disponibles, registra minimo uno', 'Error'); but on top middle

                            toastr.error('No hay eventos disponibles, registra minimo uno', 'Error', {
                                positionClass: 'toast-top-center',
                                closeButton: true,
                                progressBar: true,
                            });

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
                            t += `<td>
                                    <button class="btn btn-primary"
                                            onclick="showCandidate('` + candidates[i].candidate_key + `')">
                                        Ver
                                    </button>
                                </td>`;
                            t += ` <th>
                                                    <button class="btn btn-primary"
                                                            onclick="setCandidate('` + candidates[i].candidate_key + `')">
                                                        Editar
                                                    </button>
                                                </th>`;
                            t += `<th>
                                                    <button class="btn btn-primary"
                                                            onclick="dropCandidate('` + candidates[i].candidate_key + `')">
                                                        Borrar
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

                if (!document.getElementById('privacy').checked) {
                    toastr.error("Debes aceptar el aviso de consentimiento");
                    return;
                }

                let select_event_key = document.getElementById("event_key");
                let event_key = select_event_key.options[select_event_key.selectedIndex].value;

                let formData = new FormData();

                let teamname = document.getElementById('teamname').value;
                let name = document.getElementById('name').value;
                let photo = document.getElementById('photo').files[0];
                let video = document.getElementById('video').files[0];

                //append values to formData
                formData.append('event_key', event_key);
                formData.append('teamname', teamname);
                formData.append('name', name);
                formData.append('photo', photo);
                formData.append('video', video);

                // show toaster info message about uploading is photo or video exists, in spanish
                if (photo || video) {
                    toastr.info('Subiendo foto o video, por favor espere...', 'Subiendo');
                }

                // axios post on candidate_store laravel route, with all input values and photo input
                axios.post("{{ route('candidate_store') }}", formData)
                    .then(function (response) {
                        // console.log(response);
                        // clear input values
                        document.getElementById('teamname').value = '';
                        document.getElementById('name').value = '';
                        // refresh table
                        populateTable();

                        if (response.status === 200) {
                            // success swal with response.data.message
                            Swal.fire({
                                icon: 'success',
                                title: response.data.message
                            })
                        } else if (response.status === 203) {
                            // error swal with response.data.message
                            Swal.fire({
                                icon: 'error',
                                title: response.data.message
                            })
                        } else if (response.status === 413) {
                            // error swal with response.data.message
                            Swal.fire({
                                icon: 'error',
                                title: 'El archivo es muy grande'
                            })
                        } else {
                            // warning swal with response.data.message
                            Swal.fire({
                                icon: 'warning',
                                title: response.data.message
                            })
                        }

                    })
                    .catch(function (error) {
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }
                    });
            }

            function setCandidate(candidate_key) {

                axios.get("{{ route('candidate_show') }}", {
                    params: {
                        candidate_key: candidate_key
                    }
                })
                    .then(function (response) {
                        // console.log(response);
                        // set input values
                        document.getElementById('candidate_key').value = response.data.candidate_key;
                        document.getElementById('teamname').value = response.data.teamname;
                        document.getElementById('name').value = response.data.name;

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
                if (!document.getElementById('privacy').checked) {
                    toastr.error("Debes aceptar el aviso de consentimiento");
                    return;
                }

                let candidate_key = document.getElementById('candidate_key').value;
                let teamname = document.getElementById('teamname').value;
                let name = document.getElementById('name').value;
                let photo = document.getElementById('photo').files[0];
                let video = document.getElementById('video').files[0];

                let formData = new FormData();
                formData.append('candidate_key', candidate_key);
                formData.append('event_key', event_key);
                formData.append('teamname', teamname);
                formData.append('name', name);
                formData.append('photo', photo);
                formData.append('video', video);

                // show toaster info message about uploading is photo or video exists, in spanish
                if (photo || video) {
                    toastr.info('Subiendo foto o video, por favor espere...', 'Subiendo');
                }

                axios.post("{{ route('candidate_update') }}", formData)
                    .then(function (response) {
                        document.getElementById('candidate_key').value = '';
                        document.getElementById('teamname').value = '';
                        document.getElementById('name').value = '';

                        populateTable();

                        document.getElementById('form_button').innerHTML = 'Agregar candidato';
                        document.getElementById('store').removeEventListener('submit', editCandidate);
                        document.getElementById('store').addEventListener('submit', storeCandidate);

                        toastr.success('Candidato editado correctamente');
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

            // Create a dropCandidate function with an candidate_key parameter, Use Swal to confirm the deletion
            function dropCandidate(candidate_key) {
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
                            candidate_key: candidate_key,
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

            function showCandidate(candidate_key) {

                // console.log(event_key)

                // axios get request
                axios.get("{{ route('candidate_show') }}",
                    {
                        params: {
                            candidate_key: candidate_key
                        }
                    })
                    .then(function (response) {
                        // console.log(response);
                        document.getElementById("modal_photo").src = window.location.origin + "/candidate/image/" + response.data.candidate_key;
                        document.getElementById("view_video").href = window.location.origin + "/candidate/video/" + response.data.candidate_key;


                        // put the candidate data in the modal
                        document.getElementById('modal_teamname').innerHTML = response.data.teamname;
                        document.getElementById('modal_name').innerHTML = response.data.name;


                        // check the checkbot id="viewEventModal" to show modal
                        document.getElementById('viewCandidateModal').checked = true;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
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

                if (!localStorage.getItem('firstTime')) {
                    Swal.fire({
                        title: '¡Bienvenido!',
                        icon: 'info',
                        width: 800,
                        html: `
                            <div style="text-align: left;">
                                A continuación ingresa los datos de la elección. Deberás hacer un registro por cada planilla registrada. Considera que los datos que requerirás son los siguientes:
                             <br><br>Nombre de las planillas
                            <br>Nombre completo de las personas candidatas
                            <br>Logotipos de las planillas
                            <br>Video de propuestas de las personas candidatas
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
