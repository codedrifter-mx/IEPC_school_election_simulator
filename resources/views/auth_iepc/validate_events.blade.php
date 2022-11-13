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

    <input type="checkbox" id="viewValidationModal" class="modal-toggle"/>
    <div class="modal">
        <div class="modal-box modal-bottom ">
            <div class="grid grid-cols-1">
                <input type="hidden" id="event_key" name="event_key" value="">

                <div>
                    <div class="flex flex-col">
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

            // function to conver string to date dd-mm-YYYYThh:mm format
            function stringToDate(string) {
                let date = new Date(string);
                let day = date.getDate();
                let month = date.getMonth() + 1;
                let year = date.getFullYear();
                let hour = date.getHours();
                let minutes = date.getMinutes();
                let seconds = date.getSeconds();

                if (day < 10) {
                    day = '0' + day;
                }
                if (month < 10) {
                    month = '0' + month;
                }
                if (hour < 10) {
                    hour = '0' + hour;
                }
                if (minutes < 10) {
                    minutes = '0' + minutes;
                }
                if (seconds < 10) {
                    seconds = '0' + seconds;
                }

                return year + '-' + month + '-' + day + ' ' + hour + ':' + minutes;
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
                        console.log(response);
                        document.getElementById('end_at').value = stringToDate(response.data.data.end_at).replace('T', ' ');
                        document.getElementById('end_at_new').value = stringToDate(response.data.data.end_at);
                    })
                    .catch(function (error) {
                        // show toastr error
                        toastr.error(error.response.data.message);
                    });
            }

                function updateEvent() {
                    event_key = document.getElementById('event_key').value;
                    end_at = document.getElementById('end_at_new').value;

                    //event update route
                    axios.post("{{ route('event_update') }}",
                        {
                            event_key: event_key,
                            end_at: end_at,
                            approved: true
                        })
                        .then(function (response) {
                            toastr.success(response.data.message);

                            //close modal
                            document.getElementById('viewValidationModal').checked = false;

                        })
                        .catch(function (error) {
                            toastr.error(error.response.data.message);
                        });
                }


                document.getElementById('validate_event').addEventListener('click', updateEvent);


        </script>
    </x-slot>

</x-app-layout>
