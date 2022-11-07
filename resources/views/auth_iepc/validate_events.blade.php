<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block">Validaciond de votaciones vigentes</h1>
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
        <div class="modal-box modal-bottom sm:modal-middle md:w-11/12 md:max-w-5xl">
            <div class="grid grid-cols-2">
                <input type="hidden" id="event_key" name="event_key" value="">

                <div>
                    <label for="end_at"
                           class="block text-sm font-medium text-gray-700">
                        Fecha de fin de la votación </label>
                    <input type="datetime-local" name="end_at" id="end_at"
                           class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                    >
                </div>


                <div class="modal-action col-span-3">
                    <label for="viewValidationModal" class="btn">Cerrar</label>
                </div>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script type="text/javascript">


            function stringToDateMXFormat(string) {
                let date = new Date(string);
                return date.toLocaleString("es-MX", {timeZone: "America/Mexico_City"});
            }

            // function to conver string to date yyyy-MM-ddThh:mm format
            function stringToDate(string) {
                let date = new Date(string);
                return date.toISOString().slice(0, 16);
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
                        // if status 201, show toaster
                        if (response.data.data.status === 201) {
                            document.getElementById('end_at').innerHTML = stringToDate(response.data.data.end_at);
                        }
                    })
                    .catch(function (error) {
                        // show toastr error
                        toastr.error(error.response.data.message);
                    });
            }

            function updateEvent() {
                event_key = document.getElementById('event_key').value;
                end_at = document.getElementById('end_at').value;

                //event update route
                axios.post("{{ route('event_update') }}",
                    {
                        event_key: event_key,
                        end_at: end_at
                    })
                    .then(function (response) {
                        toastr.success(response.data.data.message);
                    })
                    .catch(function (error) {
                        toastr.error(error.response.data.message);
                    });
            }


        </script>
    </x-slot>

</x-app-layout>
