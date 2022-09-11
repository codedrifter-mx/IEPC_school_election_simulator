<x-public-layout>
    <div class="py-3">
        <div class="sm:px-4 lg:px-6">
            <div class="md:mt-0 md:col-span-1">
                <div class="grid grid-cols-1 md:grid-cols-3 m-3 gap-4">

                    <div class="col-span-3 shadow rounded-md overflow-hidden">
                        <div class="p-4 bg-gray-200">
                            {{-- Title Form --}}
                            <div class="text-center">
                                <h1 class="block" id="title">Votacion</h1>
                                <p class="block">¡Elije a tu candidato preferido!</p>
                            </div>
                            {{-- Form structure --}}
                            <div class="flex flex-wrap justify-center" id="candidates">
{{--                                <div class="max-w-xs w-[13.5rem] m-2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <input type="radio" name="candidate" id="candidate_1" value="1"--}}
{{--                                               class="hidden peer">--}}
{{--                                        <label for="candidate_1"--}}
{{--                                               class="card flex rounded-xl bg-white bg-opacity-90 backdrop-blur-2xl shadow-xl hover:bg-opacity-25 peer-checked:bg-purple-900 peer-checked:text-white cursor-pointer transition">--}}
{{--                                            <figure class=""><img src="https://placeimg.com/400/225/arch" alt="Shoes"--}}
{{--                                                                  class="object-cover h-[10.5rem]"/></figure>--}}
{{--                                            <div class="p-4">--}}
{{--                                                <div>--}}
{{--                                                    <h3 class="card-title text-center">Alfredo Flores Garcia</h3>--}}
{{--                                                    <p>Candidato del equipo: punchis punchis1</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </label>--}}
{{--                                        <div--}}
{{--                                            class="flex absolute top-0 right-4 bottom-0 w-7 h-7 my-auto rounded-full bg-purple-700 scale-0 peer-checked:scale-100 transition delay-100">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"--}}
{{--                                                 class="w-5 text-white my-auto mx-auto" viewBox="0 0 16 16">--}}
{{--                                                <path--}}
{{--                                                    d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}



                            </div>
                        </div>
                    </div>

                    <div></div>
                    <div class="col-span-3 md:col-span-1 shadow rounded-md overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-1 gap-3">

                                {{-- code --}}
                                <div>
                                    <label for="code"
                                           class="block font-medium text-gray-700 text-center">
                                        Codigo de voto </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="code" id="code"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="XXXX1234">
                                    </div>
                                </div>

                                {{-- insert --}}
                                <button type="button"
                                        id="vote"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Votar
                                </button>

                            </div>


                        </div>
                    </div>
                    <div></div>

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
                        event_key: event_key
                    }
                })
                    .then(function (response) {
                        let candidates = response.data;

                        // console.log(candidates);

                        var t = "";
                        for (var i = 0; i < response.data.length; i++) {

                            t += `<div class="max-w-xs w-[13.5rem] m-2">
                                    <div class="relative">
                                        <input type="radio" name="candidate" id="` + 'candidate_' + i + `" value="` + candidates[i].candidate_id + `"
                                               class="hidden peer">
                                        <label for="` + 'candidate_' + i + `"
                                               class="card flex rounded-xl bg-white bg-opacity-90 backdrop-blur-2xl shadow-xl hover:bg-opacity-25 peer-checked:bg-purple-900 peer-checked:text-white cursor-pointer transition">
                                            <figure class=""><img src="https://placeimg.com/400/225/arch" alt="` + 'candidate_' + i + `"
                                                                  class="object-cover h-[10.5rem]"/></figure>
                                            <div class="p-4">
                                                <div>
                                                    <h3 class="card-title text-center">Equipo: ` + candidates[i].teamname + `</h3>
                                                    <p>` + candidates[i].name + ' ' + candidates[i].paternal_surname + ' ' + candidates[i].maternal_surname + `</p>
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
                        }

                        document.getElementById("candidates").innerHTML = '';
                        document.getElementById("candidates").innerHTML += t;

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

                        document.getElementById('title').innerHTML = response.data.name;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
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


                        // toastr success message, but in spanish
                        toastr.success('Voto con éxito');

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
                            }
                        }

                    });
            }

            document.getElementById('vote').addEventListener('click', storeVote);


            document.addEventListener('DOMContentLoaded', function () {
                indexCandidates();
            });
        </script>
    </x-slot>

</x-public-layout>
