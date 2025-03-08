<?php
function CustomRegister()
{

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);

        // Validaciones
        if (!email_exists($email)) { // Verificar si el correo no está en uso
            $userdata = array(
                'user_login' => $last_name, // Usar el apellido como nombre de usuario
                'user_email' => $email,
                'user_pass' => $password,
            );

            // Insertar al usuario en la base de datos
            $user_id = wp_insert_user($userdata);

            if (!is_wp_error($user_id)) {
                // Hacer login al usuario después del registro
                $creds = array(
                    'user_login'    => $email,
                    'user_password' => $password,
                    'remember'      => true,
                );
                $user_signon = wp_signon($creds, false);

                if (is_wp_error($user_signon)) {
                    echo 'Error al iniciar sesión.';
                } else {
                    // No redirigir aún, capturamos 'redirect_to' con JS
?>
                    <script type="text/javascript">
                        document.addEventListener('DOMContentLoaded', function() {
                            // Obtener el parámetro 'redirect_to' de la URL
                            const currentUrl = new URL(window.location.href);
                            const redirectTo = currentUrl.searchParams.get('redirect_to');

                            // Si 'redirect_to' está presente, redirigir al usuario
                            if (redirectTo) {
                                window.location.href = decodeURIComponent(redirectTo); 
                            } else {
                                window.location.href = '<?php echo home_url('/my-account'); ?>';
                            }
                        });
                    </script>
    <?php
                    exit; 
                }
            } else {
                echo "Error: " . $user_id->get_error_message();
            }
        } else {
            echo "El correo ya está registrado.";
        }
    }
    ?>
    <?php $inputClass = "bg-myWhite py-2 px-2 focus:outline-none focus:ring-0  w-[92%] " ?>

    <div class="p-8 md:rounded-2xl bg-background md:shadow-lg md:w-[400px] h-screen md:h-auto flex flex-col gap-4 md:animate-fade-left" x-show="isRegister">

        <header class="leading-tight pt-8">
            <h2 class="text-3xl font-semibold pb-1">Sign Up</h2>

            <p class="text-sm text-text-lightX2">Please log in to your account to rate therapists</p>
        </header>

        <form id="register-form" method="post" class="flex flex-col gap-4"> <!-- Cambié <div> por <form> -->

            <div class="flex flex-col gap-2 ">
                <label for="last_name" class="text-text-lightX2">Last Name</label>

                <div class="bg-myWhite border border-solid border-gray-300 rounded-2xl px-2">
                    <i class="fa fa-user text-gray-300" aria-hidden="true"></i>
                    <input class="<?php echo $inputClass ?>" type="text" id="last_name" name="last_name" placeholder="Your real last name" required>
                </div>
            </div>



            <div class="flex flex-col gap-2 ">
                <label for="email" class="text-text-lightX2">Email</label>


                <div class="bg-myWhite border border-solid border-gray-300 rounded-2xl px-2">
                    <i class="fa fa-envelope text-gray-300" aria-hidden="true"></i>
                    <input class="<?php echo $inputClass ?>" type="email" id="email" name="email" placeholder="youremail@email.com" required>

                </div>
            </div>


            <div class="flex flex-col gap-2 ">
                <label for="password" class="text-text-lightX2">Password</label>



                <div class="bg-myWhite border border-solid border-gray-300 rounded-2xl px-2">
                    <i class="fa fa-key text-gray-300" aria-hidden="true"></i>
                    <input class="<?php echo $inputClass ?>" type="password" id="password" name="password" placeholder="*******" required>

                </div>
            </div>





            <input class="px-2 py-4 bg-primary hover:bg-primary-dark transition-all !duration-50000 !rounded-full text-white font-semibold cursor-pointer" type="submit" value="Register">

            <div class="flex justify-center py-4">
                <p>
                    Already have an account? <a x-on:click="isRegister = false" class="text-primary font-bold cursor-pointer">Login</a>
                </p>
            </div>
        </form>
    </div>


















    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Seleccionamos el formulario de registro
            const registerForm = document.getElementById('register-form');

            // Al enviar el formulario, preventimos el comportamiento por defecto (recargar página)
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Recogemos los datos del formulario
                const lastName = document.getElementById('last_name').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                // Preparamos los datos para enviarlos
                const formData = new FormData();
                formData.append('action', 'custom_register_action');
                formData.append('nonce', '<?php echo wp_create_nonce('register_nonce'); ?>');
                formData.append('last_name', lastName);
                formData.append('email', email);
                formData.append('password', password);

                // Realizamos la solicitud AJAX con fetch
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json()) // Convertimos la respuesta a JSON
                    .then(data => {
                        if (data.success) {
                            // Verificamos si la respuesta tiene la propiedad redirect_url
                            const redirectTo = new URLSearchParams(window.location.search).get('redirect_to');
                            const redirectUrl = redirectTo ? decodeURIComponent(redirectTo) : '<?php echo home_url("/my-account"); ?>';

                            // Redirigimos al usuario
                            window.location.href = redirectUrl;
                        } else {
                            alert(data.data.message); // Mostramos un mensaje de error
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    </script>


<?php
}
?>