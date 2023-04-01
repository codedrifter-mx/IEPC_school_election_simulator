<x-public-layout>
    <div class="py-3">
        <div class="sm:px-4 lg:px-6">
            <div>
                <div class="flex flex-col text-center items-center gap-4 px-2">

                    <div>
                        <div class="p-4 shadow rounded-md overflow-hidden bg-white mb-4 mx-2">
                            <label class="label cursor-pointer justify-center">
                                <span class="label-text mx-2">Discapacidad</span>
                                <input type="checkbox" id="isblind" class="toggle" />
                            </label>
                        </div>
                    </div>
                    <div class="shadow rounded-md overflow-hidden w-full md:w-[40rem]">
                        <div class="px-6 py-5 bg-white sm:p-6">

                            <label for="code"
                                   class="block font-medium text-gray-700 text-center">
                                Paso 1.- Ingresa tu codigo de voto </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" name="code" id="code"
                                       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                       placeholder="XXXX1234">
                            </div>
                        </div>
                    </div>

                    <div class="shadow rounded-md overflow-hidden w-full md:w-[40rem]">
                        <div class="px-6 py-5 bg-white sm:p-6">

                            <label
                                   class="block font-medium text-gray-700 text-center">
                                Paso 2.- Conoce a los candidatos </label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <button type="button"
                                        class="w-full flex justify-center text-white p-2 rounded-md shadow-lg btn-primary"
                                        onclick="document.getElementById('viewCandidateModal').checked = true;"
                                        id="knowcandidates"
                                >
                                    Conocer candidatos
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="shrink shadow rounded-md overflow-hidden">
                        <div class="p-4 bg-gray-200">
                            <div class="text-center">
                                <h1 class="block" id="title">Votacion</h1>
                                <p class="block">Paso 3: Vota por la planilla de tu preferencia</p>
                            </div>

                            <div class="flex flex-wrap justify-center" id="candidates">


                            </div>
                        </div>
                    </div>

                    <div class="shadow rounded-md overflow-hidden w-full md:w-[40rem]">
                        <div class="p-4 bg-white">
                            <button type="button"
                                    id="vote"
                                    class="w-full flex justify-center text-white p-2 rounded-md shadow-lg btn-primary"

                            >
                                Votar
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="viewCandidateModal" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="text-center">
                <p class="font-bold">¡Haz click para ver sus propuestas!</p>
            </div>
            <div class="grid grid-cols-1">


                <div class="flex flex-wrap justify-center" id="candidatesVideo">

                </div>

                <div class="modal-action">
                    <label for="viewCandidateModal" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="viewCandidateVideo" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="grid grid-cols-1">

                <div class="flex flex-wrap justify-center">
                    <video id="video" src="" controls></video>
                </div>

                <div class="modal-action">

                    <div>
                        <label for="viewCandidateVideo" class="btn" onclick="document.getElementById('video').pause();">Cerrar</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">

            // Create indexCandidates to fill all candidates as cards
            function indexCandidates() {
                // get the event_key
                let event_key = '{{ $key }}';

                axios.get("{{ route('candidate_index') }}", {
                    params: {
                        event_key: event_key,
                        nulo: true
                    }
                })
                    .then(function (response) {
                        let candidates = response.data;

                        console.log(candidates);

                        var t = "";
                        var v = "";
                        for (var i = 0; i < response.data.length; i++) {

                            let src = window.location.origin + "/candidate/image/" + candidates[i].candidate_key;


                            if (candidates[i].name === 'nulo') {
                                src = window.location.origin + "/candidate/image/nulo";
                                candidates[i].name = '';
                            } else {
                                candidates[i].teamname = 'Planilla: ' + candidates[i].teamname;

                            }

                            t += `<div class="max-w-xs w-[13.5rem] m-2" onmouseenter="tssbynumber('SVEE45', true)">
                                    <div class="relative" >
                                        <input type="radio" name="candidate" id="` + 'candidate_' + i + `" value="` + candidates[i].candidate_id + `"
                                               class="hidden peer">
                                        <label for="` + 'candidate_' + i + `" id="candidatepropose"
                                               class="card flex rounded-xl bg-white bg-opacity-90 backdrop-blur-2xl shadow-xl hover:bg-opacity-25 peer-checked:bg-purple-900 peer-checked:text-white cursor-pointer transition">
                                            <figure class="object-fit h-[17rem]"><img src="` + src + `" alt="` + 'candidate_' + i + `" class="h-[18rem]"/></figure>
                                            <div class="p-3 text-center">
                                                <div class="text-center">
                                                    <h1 class="font-bold text-center">` + candidates[i].teamname + `</h1>
                                                    <p class="">` + candidates[i].name + `</p>
                                                </div>
                                            </div>
                                        </label>
                                        <div
                                            class="flex absolute top-0 right-4 bottom-0 w-7 h-7 my-auto rounded-full bg-purple-700 scale-0 peer-checked:scale-100 transition delay-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 class="w-5 text-white my-auto mx-auto" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>`;

                            if (candidates[i].name !== 'nulo') {
                                v += `<div class="max-w-xs w-[13.5rem] m-2" style="" onclick="setVideo('` + candidates[i].candidate_key + `')">
                                    <div class="relative">
                                        <label for="` + 'candidate_' + i + `"
                                               class="card flex rounded-xl bg-white bg-opacity-90 backdrop-blur-2xl shadow-xl hover:bg-opacity-25 peer-checked:bg-purple-900 peer-checked:text-whitetransition">
                                            <figure class="object-fit"><img src="` + src + `" alt="` + 'candidate_' + i + `" class=" h-[14.5rem]"/></figure>
                                            <div class="p-4">
                                                <div>
                                                    <h3 class="card-title text-center">Equipo: ` + candidates[i].teamname + `</h3>
                                                    <p>` + candidates[i].name + `</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>`;
                            }



                        }

                        document.getElementById("candidatesVideo").innerHTML = '';
                        document.getElementById("candidatesVideo").innerHTML += v;
                        document.getElementById("candidates").innerHTML = '';
                        document.getElementById("candidates").innerHTML += t;

                        document.getElementById("candidatepropose").addEventListener("mouseover", function() { tssbynumber("SVEE45", true) });

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                // axios get request
                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        // console.log(response);

                        document.getElementById('title').innerHTML = response.data.data.name;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            function setVideo(candidate_key) {
                // on id "video" set src to src_video
                document.getElementById('video').src = window.location.origin + "/candidate/video/" + candidate_key;

                document.getElementById('viewCandidateVideo').checked = true;

                document.getElementById('video').play();

            }

            //Create function storeVote
            function storeVote() {

                let candidate_id;
                let code;

                // get candidate_id, inside try catch to avoid error when no candidate is selected
                try {
                    candidate_id = document.querySelector('input[name="candidate"]:checked').value;
                } catch (e) {
                    //show toastr error that you need to select a candidate, but in spanish
                    toastr.error('Debes seleccionar un candidato');
                    return;
                }

                // get code, if its empty show a toastr error that you need to insert a code, but in spanish
                if (document.getElementById('code').value === '') {
                    toastr.error('Debes ingresar un codigo de voto');
                    return;
                } else {
                    code = document.getElementById('code').value;
                }

                let event_key = '{{ $key }}';

                axios.post("{{ route('vote_store') }}", {
                    code: code,
                    candidate_id: candidate_id,
                    event_key: event_key,
                })
                    .then(function (response) {
                        console.log(response);
                        // clear input values
                        document.getElementById('code').value = '';


                        // swal with success message, when message done, refresh page
                        Swal.fire({
                            icon: 'success',
                            title: '¡Voto registrado con exito!',
                            showConfirmButton: false,
                            confirmButtonText: 'Siguiente voto',
                            timer: 5000
                        }).then(function () {
                            location.reload();
                        })

                    })
                    .catch(function (error) {
                        // console.log(error);

                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }

                        if (error.response.data.error) {
                            if (error.response.data.error.includes("Ya votaste")) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Parece que ya has ejercido tu voto...',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: error.response.data.error,
                                })

                                tssbynumber("SVEE44", true);
                            }
                        }

                    });
            }

            document.getElementById('vote').addEventListener('click', storeVote);

            document.addEventListener('DOMContentLoaded', function () {

                indexCandidates();

            });

            // audio functionality
            var SoundEfects = new Audio();
            var isBlind = false;

            // set isblind with event listener checkbox
            document.getElementById("isblind").addEventListener("change", setBlind);
            document.getElementById("code").addEventListener("mouseover", function() { tssbynumber("SVEE41", true) });
            document.getElementById("knowcandidates").addEventListener("mouseover", function() { tssbynumber("SVEE42", true) });
            document.getElementById("vote").addEventListener("mouseover", function() { tssbynumber("SVEE43", true) });
            // document.getElementById("candidates").addEventListener("mouseover", function() { tssbynumber("SVEE39", true) });

            function setBlind() {
                SoundEfects.pause()
                isBlind = !isBlind

                if (isBlind) {

                    SoundEfects = new Audio('/audio/SVEE40.mp3')
                    SoundEfects.play()
                }
            }

            function tssbynumber(num, paused = false) {
                if (isBlind) {
                    if (paused) SoundEfects.pause()
                    SoundEfects = new Audio('/audio/' + num + '.mp3')
                    SoundEfects.play()
                }
            }


        </script>
    </x-slot>

</x-public-layout>
