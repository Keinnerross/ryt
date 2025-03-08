<?php $defaultProfilePicture = get_stylesheet_directory_uri() . "/assets/default-profile.jpg"; ?>
<?php
/* Template Name: My Account */

get_header();
?>

<div id="wptime-plugin-preloader"></div>

<div class="flex flex-col justify-center items-center bg-myWhite md:bg-background md:h-[80vh] mt-8 md:mt-0">
    <div class="w-full md:w-[85vw] ">

        <div class="border-solid border-b-[1px] border-gray-300 w-full mt-4 mb-10">
            <h1 class="ml-4 md:ml-0 w-32 border-solid border-b-[2px]  text-lg font-semibold cursor-pointer border-text-light text-text-light hover:text-text hover:border-text transition-all duration-100 ease-out">My Account</h1>
        </div>

        <div class="md:flex justify-between gap-8 bg-myWhite md:rounded-xl p-8 shadow-sm md:h-[60vh] ">

            <!-- User Data -->
            <div x-data="{ isEdit : false, fileSelected: false }" id="info-container" class="w-full flex gap-4 md:w-1/2">
                <!-- Foto de perfil -->
                <div class="flex flex-col items-center gap-3">
                    <div class="w-[100px] h-[100px] md:w-[120px] md:h-[120px] overflow-hidden rounded-full cursor-pointer relative hover:bg-gray-200" id="profile-picture-container">
                        <?php
                        $user_id = get_current_user_id();
                        $attachment_id = get_user_meta($user_id, 'profile_picture', true);
                        $profile_picture_url = wp_get_attachment_url($attachment_id);

                        if ($attachment_id && $profile_picture_url) {
                            echo '<img src="' . esc_url($profile_picture_url) . '" alt="Foto de perfil" class="w-full h-full object-cover" />';
                        } else {
                            echo '<img src="' . esc_url($defaultProfilePicture) . '" alt="Foto de perfil predeterminada" class="w-full h-full object-cover" />';
                        }
                        ?>

                        <!-- Efecto hover con contenido -->
                        <div class="absolute inset-0 flex items-center rounded-full justify-center opacity-50  md:opacity-0 bg-myBlack md:hover:opacity-80 transition-opacity duration-300">
                            <span class="text-white text-lg text-center w-[70%] leading-none"> <i class="fa fa-camera" aria-hidden="true"></i></span>
                        </div>
                    </div>


                    <!-- Formulario para subir una nueva foto de perfil -->
                    <input type="file" id="profile-picture" class="hidden" @change="fileSelected = $event.target.files.length > 0" />
                    <button id="upload-profile-picture" class="bg-gray-400 hover:bg-primary transform transition-all text-white px-2 py-1 font-bold rounded-3xl text-xs " x-show="fileSelected">
                        Update Picture
                    </button>

                    <span>
                        <a href="<?php echo wp_logout_url(); ?>" x-show="!fileSelected" class="text-text-light hover:text-text cursor-pointer text-xs border-[1px] border-solid border-text-light hover:border-text-text font-semibold px-2 py-1 rounded-xl transition duration-200 ease-in-out">Log Out</a>
                    </span>
                </div>

                <!-- Información Personal -->
                <div id="personal-info" class="md:px-6 border rounded w-full">
                    <header class="flex justify-between w-full items-start pb-4 md:pb-0">
                        <h2 class=" md:text-xl font-semibold pb-2 font-montserrat">Personal Info</h2>
                        <p x-show="!isEdit" class="md:block cursor-pointer text-text-light hover:text-text transition duration-300 ease-in-out text-sm hover:underline" x-on:click="isEdit = true">Edit info</p>
                        <div x-show="isEdit" class="flex gap-4 items-center">

                            <span x-on:click="isEdit = false" class="hidden md:block cursor-pointer text-text-light hover:text-text transition duration-300 ease-in-out text-sm hover:underline" >Cancel</span>
                            <button id="save-changes" class="bg-primary text-white px-4 py-1 rounded-md md:rounded-lg text-xs md:text-sm">Save</button>
                        </div>

                    </header>
                    <div class="flex flex-col gap-4">
                        <div>
                            <label for="username" class="font-bold text-sm">Last Name</label>
                            <p id="username"><?php echo wp_get_current_user()->user_login; ?></p>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Email</p>
                            <p><?php echo wp_get_current_user()->user_email; ?></p>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold py-1 font-montserrat">Password</h2>
                            <div x-show="!isEdit">
                                <p class="font-bold text-sm pb-1 " for="password">Change your password</p>
                                <input value="*******" class="border p-2 w-full rounded-2xl leading-none" disabled />
                            </div>

                            <!-- Change Password Input -->
                            <div x-show="isEdit" class="flex flex-col gap-1">
                                <div>
                                    <label class="font-bold text-sm mb-1" for="password">Change your password</label>
                                    <input type="password" id="password" placeholder="New password" class="border p-2 w-full !rounded-2xl" />
                                </div>
                                <div>
                                    <label class="font-bold text-sm mb-1" for=" confirm-password">Confirm new password</label>
                                    <input type="password" id="confirm-password" placeholder="Confirm new password" class="border p-2 w-full !rounded-2xl" />
                                </div>
                            </div>
                        </div>
                        <!-- Password View -->
                    </div>
                </div>
            </div>
            <!-- User Reviews -->
            <div id="recent-reviews" class="md:w-1/2 mt-10 md:mt-0">

                <div class="md:max-h-full md:overflow-auto md:min-h-[20vh]">
                    <h2 class="text-xl font-semibold pb-2 font-montserrat">My Reviews</h2>

                    <?php
                    $args = array(
                        'user_id' => get_current_user_id(),
                        'post_type' => 'therapists',
                        'status' => array('approve', 'hold'),
                        'orderby' => 'comment_date',
                        'order' => 'DESC',
                    );

                    $comments = get_comments($args);

                    if ($comments) {
                        foreach ($comments as $comment) {
                            $rating = get_comment_meta($comment->comment_ID, 'rate', true);
                            $therapist_url = get_permalink($comment->comment_post_ID);
                            $comment_ID = $comment->comment_post_ID;
                            $post_title = get_the_title($comment_ID);
                            $post_thumbnail_url = get_the_post_thumbnail_url($comment_ID, 'full');
                    ?>



                            <!-- Card my Reviews -->
                            <a href="<?php echo esc_url($therapist_url); ?>" class="w-full">
                                <div class="review-card w-full p-4 mb-4 border shadow-sm rounded-xl hover:bg-background transition-all duration-100 ease-out">
                                    <div class="flex justify-between items-start">

                                        <div class="flex gap-1">
                                            <!-- Img Entry Comment -->

                                            <div class="w-[75px] md:w-[90px] ">
                                                <div class="w-[70px] h-[70px]  md:w-[85px] md:h-[85px] overflow-hidden rounded-full">
                                                    <?php

                                                    if ($post_thumbnail_url) {
                                                        echo '<img class="object-cover w-full h-full rounded-full" src="' . $post_thumbnail_url . '" alt="' . $post_title . '" />';
                                                    } ?>

                                                </div>

                                            </div>


                                            <div id="comment-card-info" class="leading-0">
                                                <h3 class="font-semibold md:text-xl"><?php echo get_the_title($comment_ID); ?></h3>
                                                <div class="rating text-lg">
                                                    <?php

                                                    $full_stars = floor($rating);
                                                    $half_star = ($rating - $full_stars) >= 0.5 ? true : false;
                                                    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

                                                    for ($i = 0; $i < $full_stars; $i++) {
                                                        echo '<i class="fa fa-star text-amber-400"></i>';
                                                    }
                                                    if ($half_star) {
                                                        echo '<i class="fa fa-star-half-alt text-amber-400"></i>';
                                                    }
                                                    for ($i = 0; $i < $empty_stars; $i++) {
                                                        echo '<i class="fa fa-star-o text-gray-400"></i>';
                                                    }
                                                    ?>
                                                </div>


                                                <div id="status">

                                                    <?php if ($comment->comment_approved === '0') : ?>
                                                        <div class="w-20 py-1 px-1 text-center text-xs border-solid border-[1px] rounded-full  border-yellow-500 text-yellow-500 hover:text-yellow-600 hover:border-yellow-600">
                                                            <span>In Reviews</span>
                                                        </div>

                                                    <?php else : ?>
                                                        <div class="w-20 py-1 px-1 text-center text-xs border-solid border-[1px] rounded-full border-green-500  text-green-500  hover:text-green-600 hover:border-green-600">
                                                            <span>Approved</span>
                                                        </div>

                                                    <?php endif; ?>
                                                </div>

                                            </div>

                                        </div>
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </div>
                                    <p class="pt-2 text-sm text-text">
                                        <?php echo get_comment_date('F j, Y', $comment->comment_ID); ?>

                                    </p>


                                </div>
                            </a>
                    <?php
                        }
                    } else {
                        echo '<p>Your reviews will appear here</p>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const isUserLoggedIn = document.body.classList.contains("logged-in");

        if (!isUserLoggedIn) {
            window.location.href = "/log-in/";
            return;
        }

        // Mostrar la imagen seleccionada sin hacer click en "Subir Foto"
        const container = document.getElementById('profile-picture-container');
        const inputFile = document.getElementById('profile-picture');
        const profileImage = container.querySelector('img'); // Selecciona la imagen en el contenedor

        // Escuchar el evento de cambio en el input de archivo
        inputFile.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result; // Actualiza el src de la imagen al archivo seleccionado
                };
                reader.readAsDataURL(file);
            }
        });

        const saveButton = document.getElementById("save-changes");
        const passwordField = document.getElementById("password");
        const confirmPasswordField = document.getElementById("confirm-password");

        saveButton.addEventListener("click", function() {
            const password = passwordField.value;
            const confirmPassword = confirmPasswordField.value;

            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden.");
                return;
            }

            const formData = new FormData();
            formData.append("action", "save_user_changes");
            formData.append("password", password);

            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        location.reload();
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("Ha ocurrido un error. Intenta de nuevo.");
                });
        });

        container.addEventListener('click', () => {
            inputFile.click();
        });

        document.getElementById("upload-profile-picture").addEventListener("click", function() {
            const fileInput = document.getElementById("profile-picture");
            const file = fileInput.files[0];
            if (!file) {
                alert("Selecciona una foto para subir.");
                return;
            }

            const formData = new FormData();
            formData.append("action", "upload_profile_picture");
            formData.append("profile_picture", file);

            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                        document.querySelector("img.avatar").src = data.profile_picture_url;
                    } else {
                        alert(data.message);
                    }
                });
        });
    });
</script>

<?php get_footer(); ?>