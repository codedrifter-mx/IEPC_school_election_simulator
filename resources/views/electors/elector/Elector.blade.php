<x-public-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-3 md:mt-0 md:col-span-1">

                <div class="grid grid-cols-1 md:grid-cols-3 m-3">
                    <div></div>
                    <div class="shadow rounded-md overflow-hidden">
                        <form id="store" class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            {{-- Title Form --}}
                            <div class="mt-5 md:mt-0 text-center">
                                <h1 class="block"> Registro de Electores </h1>
                            </div>
                            {{-- Form structure --}}
                            <div class="grid grid-cols-1 gap-3">

                                {{-- name --}}
                                <div>
                                    <label for="name"
                                           class="block font-medium text-gray-700">
                                        Nombres(s) </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="name" id="name"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="Nombre">
                                    </div>
                                </div>

                                {{-- paternal_surname --}}
                                <div>
                                    <label for="paternal_surname"
                                           class="block font-medium text-gray-700">
                                        Apellido paterno </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="paternal_surname" id="paternal_surname"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="Apellido">
                                    </div>
                                </div>

                                {{-- maternal_surname --}}
                                <div>
                                    <label for="maternal_surname"
                                           class="block font-medium text-gray-700">
                                        Apellido materno</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="maternal_surname" id="maternal_surname"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                               placeholder="Apellido">
                                    </div>
                                </div>

                                {{-- grade --}}
                                <div>
                                    <label for="grade"
                                           class="block font-medium text-gray-700">
                                        Grado </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="grade" id="grade"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300">
                                            <option value="1">Primero</option>
                                            <option value="2">Segundo</option>
                                            <option value="3">Tercero</option>
                                            <option value="4">Cuarto</option>
                                            <option value="5">Quinto</option>
                                            <option value="6">Sexto</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- group --}}
                                <div>
                                    <label for="group"
                                           class="block font-medium text-gray-700">
                                        Grupo </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <select name="group" id="group"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                            <option value="F">F</option>
                                            <option value="G">G</option>
                                            <option value="H">H</option>
                                            <option value="I">I</option>
                                            <option value="J">J</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>


                                    {{-- code --}}
                                    <div>
                                        <label for="code"
                                               class="block font-medium text-gray-700">
                                            Crea tu codigo de voto </label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="code" id="code"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:border-gray-300"
                                                   placeholder="XXXX1234">
                                        </div>
                                    </div>

                                    {{-- Aviso de privacidad checkbox with flex--}}
                                    <div class="flex items-center text-center p-1 mt-3">
                                        <input type="checkbox" name="privacy" id="privacy"  class="m-2">
                                        <label
                                               class="link block font-medium text-gray-700" onclick=
                                                  "document.getElementById('viewprivacy').checked = true;">Acepto el aviso de privacidad </label>
                                    </div>
                                </div>

                                {{-- insert --}}
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Registrarse
                                </button>

                            </div>


                        </form>
                    </div>
                    <div></div>
                </div>

            </div>
        </div>
    </div>

    <input type="checkbox" id="viewCandidateModal" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="grid grid-cols-1">

                <div class="flex flex-wrap justify-center" id="candidates">

                </div>

                <div class="modal-action col-span-3">
                    <label for="viewCandidateModal" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="viewprivacy" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="grid grid-cols-1">

                <div>
                    <p>
                        AVISO DE PRIVACIDAD SIMPLIFICADO

                        El Instituto Electoral y de Participación Ciudadana del Estado de Durango informa que es el
                        responsable del tratamiento de los datos personales que se recaben, los cuales serán protegidos
                        conforme a las leyes aplicables en la materia y serán utilizados únicamente para los fines de la
                        elección estudiantil.

                        Si deseas ejercer los derechos de acceso, rectificación, cancelación u oposición de datos
                        personales,
                        puedes hacerlo directamente en la Unidad de Técnica de Transparencia del Instituto Electoral y
                        de
                        Participación Ciudadana del Estado de Durango, ubicado en calle Litio sin número, colonia Ciudad
                        Industrial, Durango, Dgo. C.P. 34208; en estrados, al correo electrónico:
                        ut.transparencia@iepcdurango.mx o a través de la plataforma nacional de transparencia
                        http://www.plataformadetransparencia.org.mx., igualmente se hace del conocimiento la dirección
                        electrónica del sitio web institucional: www.iepcdurango.mx.
                    </p>
                </div>
                <div class="modal-action col-span-3">
                    <label for="viewprivacy" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript">

            // Create functions: storeElector
            function storeElector(e) {
                e.preventDefault();

                // get event_key from $event_key
                let event_key = '{{ $event_key }}';

                // is privacy checked?
                if (!document.getElementById('privacy').checked) {
                    // toaster error
                    toastr.error("Debes aceptar el aviso de privacidad");

                    return;
                }

                // get input values
                let name = document.getElementById('name').value;
                let paternal_surname = document.getElementById('paternal_surname').value;
                let maternal_surname = document.getElementById('maternal_surname').value;
                let grade = document.getElementById('grade').value;
                let group = document.getElementById('group').value;
                let code = document.getElementById('code').value;

                axios.post("{{ route('elector_store') }}", {
                    event_key: event_key,
                    name: name,
                    paternal_surname: paternal_surname,
                    maternal_surname: maternal_surname,
                    grade: grade,
                    group: group,
                    code: code,
                })
                    .then(function (response) {
                        // console.log(response);

                        // clear input values
                        document.getElementById('name').value = '';
                        document.getElementById('paternal_surname').value = '';
                        document.getElementById('maternal_surname').value = '';
                        document.getElementById('code').value = '';

                        let msg = '¡Si la olvidas no podrás votar el día de la elección! '
                            + 'Te invitamos a consultar la sección “Conoce a tus candidatos y candidatas y revisa sus propuestas”'
                            + 'antes de emitir tu voto.'


                        Swal.fire({
                            title: 'Haz concluido tu registro, te recomendamos que tomes nota de la clave que generaste y la conserves',
                            text: msg,
                            icon: 'success',
                            confirmButtonText: 'Conoce a tus candidatos',
                            // black space not leaveble
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {

                                indexCandidates(event_key);

                                document.getElementById('viewCandidateModal').checked = true;
                            }
                        }).catch(function (error) {
                            // console.log(error);
                            // console.log(error.response.data.error);

                            for (var key in error.response.data.errors) {
                                if (error.response.data.errors.hasOwnProperty(key)) {
                                    toastr.error(error.response.data.errors[key]);
                                }
                            }
                        });

                    })
                    .catch(function (error) {
                        // console.log(error);
                        // console.log(error.response.data.error);

                        toastr.error(error.response.data.message)

                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }
                    });
            }

            // Create indexCandidates to fill all candidates as cards
            function indexCandidates(event_key) {

                axios.get("{{ route('candidate_index') }}", {
                    params: {
                        event_key: event_key
                    }
                })
                    .then(function (response) {
                        let candidates = response.data;

                        var t = "";
                        for (var i = 0; i < response.data.length; i++) {

                            let src = window.location.origin + "/candidate/image/" + candidates[i].candidate_key;

                            t += `<div class="max-w-xs w-[13.5rem] m-2">
                                    <div class="relative">
                                        <div for="` + 'candidate_' + i + `"
                                               class="card flex rounded-xl bg-white bg-opacity-90 backdrop-blur-2xl shadow-xl hover:bg-opacity-25 peer-checked:bg-purple-900 peer-checked:text-whitetransition">
                                            <figure class="object-fit"><img src="` + src + `" alt="` + 'candidate_' + i + `" class=" h-[14.5rem]"/></figure>
                                            <div class="p-4">
                                                <div>
                                                    <h3 class="card-title text-center">Equipo: ` + candidates[i].teamname + `</h3>
                                                    <p>` + candidates[i].name +`</p>
                                                </div>
                                            </div>
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

                        document.getElementById('title').innerHTML = response.data.data.name;

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }





            // when document loaded
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('store').addEventListener('submit', storeElector);
                indexCandidates('{{ $event_key }}');

            });

        </script>
    </x-slot>
</x-public-layout>
