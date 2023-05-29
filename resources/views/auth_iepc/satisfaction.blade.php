<x-app-layout>
    <div class="py-6">
        <div class="sm:px-6 mx-2 lg:px-8">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                    {{-- Title Form --}}
                    <div class="mt-5 md:mt-0 ">
                        <h1 class="block">Envia encuestas de satisfaccion</h1>
                    </div>

                    <div class="grid grid-cols-3 gap-4" id="form_event">


                        {{-- Users combobox--}}
                        <div class="col-span-1 sm:col-span-1">
                            <label for="users" class="block text-sm font-medium text-gray-700">Elije alguna institución registrada: </label>
                            <select name="users" id="users" autocomplete="users"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="0">Selecciona alguna institución</option>
                            </select>
                        </div>

                        {{-- Email --}}
                        <div class="col-span-1 sm:col-span-1" id="emailForm">
                            <label for="email" class="block text-sm font-medium text-gray-700">O escribe el email destino: </label>
                            <input type="text" name="email" id="email" autocomplete="email"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>



                        {{-- Subject --}}
                        <div class="col-span-3 sm:col-span-3">
                            <label for="subject" class="block text-sm font-medium text-gray-700">Asunto: </label>
                            <input type="text" name="subject" id="subject" autocomplete="subject"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        {{-- Message --}}
                        <div class="col-span-3 sm:col-span-3">
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje: </label>
                            <textarea name="message" id="message" autocomplete="message" rows="5"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>


                        {{-- Button Form --}}
                        <div>
                            <button id="submit_button"
                                    class="btn-block inline-flex w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enviar
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <x-slot name="scripts">
        <script type="text/javascript">

            // function to send email about satisfaction survey
            function sendEmail(e) {
                e.preventDefault();
                var email = document.getElementById("email").value;
                var users_select = document.getElementById("users");
                if (users_select.value == 0) {if (email == '') {
                        toastr.error('El campo email es obligatorio');
                        return;
                    }
                } else {
                    email = users_select.value;
                }
                var subject = document.getElementById("subject").value;
                var message = document.getElementById("message").value;

                var submit_button = document.getElementById('submit_button');
                submit_button.disabled = true;
                submit_button.innerHTML = 'Enviando...';

                var data = {
                    email: email,
                    subject: subject,
                    message: message,
                };

                axios.post("{{ route('send_email') }}", data)
                    .then(function (response) {
                        submit_button.disabled = false;
                        submit_button.innerHTML = 'Guardar';
                        document.getElementById("email").value = '';
                        document.getElementById("subject").value = '';
                        document.getElementById("message").value = '';

                        // show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Correo enviado',
                            text: 'El correo se ha enviado correctamente',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })
                    .catch(function (error) {
                        // console.log(error);
                        for (var key in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(key)) {
                                toastr.error(error.response.data.errors[key]);
                            }
                        }

                        submit_button.disabled = false;
                        submit_button.innerHTML = 'Guardar';
                    });
            }

            // get all users function
            function getUsers() {
                axios.get("{{ route('user_index') }}")
                    .then(function (response) {
                        var users = response.data;

                        var users_select = document.getElementById("users");
                        for (var i = 0; i < users.length; i++) {
                            // if it has administrador level, it is not shown
                            if (users[i].level != "Administrador") {
                                var option = document.createElement("option");
                                option.value = users[i].email;
                                option.text = users[i].name + ' - ' + users[i].email;
                                users_select.appendChild(option);
                            }

                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

            // create function to hide and show email input
            function changeEmail() {
                var users_select = document.getElementById("users");
                var email_input = document.getElementById("emailForm");
                if (users_select.value == 0) {
                    email_input.style.display = "block";
                } else {
                    email_input.style.display = "none";
                }
            }



            document.addEventListener('DOMContentLoaded', function () {
                // add event listener to submit button
                getUsers();
                document.getElementById('submit_button').addEventListener('click', sendEmail);
            });

            // add event listener to users combobox
            document.getElementById('users').addEventListener('change', changeEmail);

        </script>
    </x-slot>

</x-app-layout>
