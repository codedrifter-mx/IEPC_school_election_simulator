<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block">Validacion de votaciones vigentes</h1>
                    </div>

                    <div class="grid grid-cols-6 gap-4" id="form_event">

                        {{-- Table --}}
                        <div class="col-span-6">
                            <div class="overflow-x-auto">
                                <livewire:admin-validate-table/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block">Validacion de usuarios</h1>
                    </div>

                    <div class="grid grid-cols-6 gap-4" id="form_event">

                        {{-- Table --}}
                        <div class="col-span-6">
                            <div class="overflow-x-auto">
                                <livewire:admin-users-table/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="checkbox" id="viewValidationModal" class="modal-toggle"/>
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
                        Fecha de inicio de la votación </label>
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
                    <label for="viewValidationModal" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script type="text/javascript">

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

            function validateEvent(event_key) {
                document.getElementById('viewValidationModal').checked = true;
                document.getElementById('event_key').value = event_key;


                axios.get("{{ route('event_show') }}",
                    {
                        params: {
                            event_key: event_key
                        }
                    })
                    .then(function (response) {
                        response = response.data;

                        // console.log(response);

                        document.getElementById('end_at').value = convertDate(response.data.end_at);
                        document.getElementById('end_at_new').value = convertDateToInput(response.data.end_at);
                        document.getElementById('start_at').value = convertDate(response.data.start_at);
                        document.getElementById('start_at_new').value = convertDateToInput(response.data.start_at);
                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.message);
                    });
            }

            function updateEvent() {

                let event_key = document.getElementById('event_key').value;
                let start_at = document.getElementById('start_at_new').value;
                let end_at = document.getElementById('end_at_new').value;

                axios.post("{{ route('event_update') }}",
                    {
                        event_key: event_key,
                        start_at: start_at,
                        end_at: end_at,
                        approved: true
                    })
                    .then(function (response) {
                        document.getElementById('viewValidationModal').checked = false;

                        Swal.fire({
                            title: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        })

                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.message);
                    });

            }

            function accept(user_id) {
                let now = new Date().toISOString().slice(0, 19).replace('T', ' ');

                axios.post("{{ route('user_update') }}",
                    {
                        user_id: user_id,
                        email_verified_at: now,
                    })
                    .then(function (response) {
                        // swal with response.data.message
                        Swal.fire({
                            title: response.data.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.message);
                    });

            }


            function denyUser(user_id) {
                axios.post("{{ route('user_destroy') }}",
                    {
                        user_id: user_id
                    })
                    .then(function (response) {
                        toastr.success(response.data.message);
                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.message);
                    });
            }

            document.getElementById('validate_event').addEventListener('click', updateEvent);

        </script>
    </x-slot>

</x-app-layout>
