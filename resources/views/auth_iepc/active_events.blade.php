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


    <x-slot name="scripts">
        <script type="text/javascript">



        </script>
    </x-slot>

</x-app-layout>
