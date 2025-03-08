<?php function CustomLogin()
{

    $redirect_to = isset($_GET['redirect_to']) ? urldecode($_GET['redirect_to']) : home_url('/my-account');

    if (is_user_logged_in()) {
        wp_safe_redirect($redirect_to);
        exit;
    }

?>
    <div class="px-8 py-10 md:rounded-2xl bg-background md:shadow-lg w-full h-screen md:h-auto md:w-[400px] md:animate-fade-left" x-show="!isRegister">

        <?php $inputClass = "bg-myWhite py-2 px-2 focus:outline-none focus:ring-0  w-[92%] " ?>


        <form id="login-form" method="post" action="" onsubmit="return loginUser(event)" class="flex flex-col gap-4 ">
            <header class="leading-tight pt-8 md:pt-0">
                <h2 class="text-3xl text-text font-bold pb-2">Login</h2>

                <p class="text-sm text-text-lightX2">Please log in to your account to rate therapists</p>
            </header>

            <?php wp_nonce_field('login_action_nonce', 'login_nonce'); ?>

            <div class="flex flex-col gap-2 ">
                <label for="log" class="text-text-lightX2 text-sm">Email Address</label>

                <div class="bg-myWhite border border-solid border-gray-300 rounded-2xl px-2">
                    <i class="fa fa-envelope text-gray-300" aria-hidden="true"></i>
                    <input class="<?php echo $inputClass ?>" placeholder="youremail@email.com" type="text" name="log" id="log" value="" required>
                </div>
            </div>

            <div class="flex flex-col gap-2 pb-4 pt-2">
                <label for="pwd" class="text-text-lightX2 text-sm">Password</label>
                <div class="bg-myWhite border border-solid border-gray-300 rounded-2xl px-2">
                    <i class="fa fa-key text-gray-300" aria-hidden="true"></i>
                    <input class="<?php echo $inputClass ?>" type="password" name="pwd" id="pwd" placeholder="*******" required>
                </div>
                <div>
                    <a href="<?php echo wp_lostpassword_url(); ?>" class="text-xs text-gray-500 hover:underline">Forgot your password?</a>
                </div>
                <div id="error-message" class="hidden text-red-500 text-xs font-semibold"></div> <!-- Mensaje de error -->

            </div>

            <button type="submit" class="px-2 py-4 bg-primary hover:bg-primary-dark transition-all !duration-50000 rounded-full text-white font-semibold">Access</button>
            <div class="flex justify-center">
                <p class="text-sm pt-2">don't have an account yet? <a class="cursor-pointer text-primary font-semibold" x-on:click='isRegister = true'>Sign Up</a></p>
            </div>
        </form>

    </div>


    <script>
        function loginUser(event) {
            event.preventDefault();

            var username = document.getElementById('log').value;
            var password = document.getElementById('pwd').value;

            var nonce = document.getElementById('login_nonce').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.success) {
                        window.location.href = '<?php echo esc_url($redirect_to); ?>';
                    } else {
                        // Mostrar el error en el frontend
                        var errorMessageDiv = document.getElementById('error-message');
                        errorMessageDiv.textContent = response.message || 'Incorrect username or password';
                        errorMessageDiv.classList.remove('hidden'); // Mostrar el mensaje de error
                        console.log(response.message || 'Incorrect username or password');
                    }
                }
            };

            xhr.send('action=login_action&log=' + encodeURIComponent(username) + '&pwd=' + encodeURIComponent(password) + '&login_nonce=' + encodeURIComponent(nonce));
            return false;
        }
    </script>

<?php
}
