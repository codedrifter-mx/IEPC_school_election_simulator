<x-app-layout>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-error shadow-lg">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $error }}</span>
                </div>
            </div>
        @endforeach
    @endif

    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <form method="POST" action="{{ route('event_store') }}">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                        {{-- Title Form --}}
                        <div class="mt-5 md:mt-0 ">
                            <h1 class="block"> Nueva votación </h1>
                        </div>

                        {{-- Form structure --}}
                        <div class="grid grid-cols-3 gap-4">

                            <div class="col-span-3 md:col-span-1 grid grid-cols-1 gap-4">
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

                                {{-- Button --}}

                                <div>
                                    <button type="submit"
                                            class="btn-block inline-flex w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Guardar
                                    </button>
                                </div>


                            </div>

                            {{-- Table --}}
                            <div class="col-span-3 md:col-span-2">
                                <div class="col-span-3 md:col-span-2">
                                    <div class="overflow-x-auto">
                                        <table class="table table-compact w-full">
                                            <!-- head -->
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Evento</th>
                                                <th>Horario</th>
                                                <th>Director</th>
                                                <th>Encargado</th>
                                                <th>Alumnos</th>
                                                <th>Grupos</th>
                                                <th>Inicio de votación</th>
                                                <th>Fin de votación</th>
                                                <th>Ver</th>
                                                <th>Editar</th>
                                                <th>Borrar</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th>1</th>
                                                <th>Votacion</th>
                                                <th>Vespertino</th>
                                                <th>Alfredo chido</th>
                                                <th>Alfredo tambien</th>
                                                <th>300</th>
                                                <th>12</th>
                                                <th>01/01/2022</th>
                                                <th>01/03/2022</th>
                                                <th>
                                                    <button class="btn btn-square btn-outline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                             height="16" fill="currentColor" class="bi bi-eye-fill"
                                                             viewBox="0 0 16 16">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path
                                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                        </svg>
                                                    </button>
                                                </th>
                                                <th>
                                                    <button class="btn btn-square btn-outline">
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
                                                </th>
                                                <th>
                                                    <button class="btn btn-square btn-outline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
