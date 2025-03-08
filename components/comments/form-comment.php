<?php
function FormComment()
{
    // Verifica si los comentarios están abiertos
    if (comments_open()) :
?>
        <div class="w-screen flex justify-center md:pb-20 overflow-y-auto h-[100vh] md:h-screen md:py-10" x-data="{ rating: 0, hoverRating: 0, showErrorMsj : false }">
            <div class="bg-background md:rounded-2xl p-8 md:w-[580px] md:h-[675px] h-screen animate-fade">
                <form id="custom-comment-form" action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" enctype="multipart/form-data" x-on:submit.prevent="if (rating > 0) { $el.submit(); } else { showErrorMsj = true }">

                    <p x-on:click="isCommentForm= false" class="cursor-pointer hover:underline"><i class="fa fa-arrow-left" aria-hidden="true"></i> Return Profile</p>

                    <div id="info-therapist" class="flex flex-col items-center text-center pb-8 pt-8 md:pt-0">
                        <div id="therapist-img" class="w-[120px] h-[120px] overflow-hidden rounded-full">
                            <?php
                            if (has_post_thumbnail()) {
                                the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']);
                            } else {
                                echo '<img src="URL_DE_IMAGEN_DEFAULT" class="w-full h-full object-cover" />';
                            }
                            ?>
                        </div>
                        <div id="data-entry" class="flex flex-col gap-1">

                            <!-- Título del terapeuta -->
                            <h1 class="text-3xl font-bold text-text"><?php the_title(); ?></h1>

                            <!-- Dirección -->
                            <div id="address-entry" class="text-sm text-text-light">
                                <?php
                                $address = get_field('Address');
                                $city = get_field('city');
                                $state_address = get_field('state_address');
                                $zip_code = get_field('zip_code');

                                $output = '';
                                $output .= $address ? esc_html($address) . ' ' : '';
                                $output .= $city ? esc_html($city) . ' ' : '';
                                $output .= $state_address ? esc_html($state_address) . ' ' : '';
                                $output .= $zip_code ? esc_html($zip_code) . ' ' : '';

                                echo $output ?: esc_html__('No address provided.', 'blankslate');
                                ?>
                            </div>

                            <!-- Campo de valoración -->
                            <div class="flex justify-center">
                                <label for="rate" class="hidden">Rate</label>
                                <div class="flex text-3xl">
                                    <template x-for="i in 5" :key="i">
                                        <span
                                            :class="{'text-yellow-500': i <= (hoverRating || rating), 'text-gray-300': i > (hoverRating || rating)}"
                                            class="cursor-pointer"
                                            @mouseover="hoverRating = i"
                                            @mouseleave="hoverRating = 0"
                                            @click="rating = i; $nextTick(() => $refs.ratingInput.value = i)">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </template>
                                </div>

                                <input type="hidden" name="rate" x-ref="ratingInput" :value="rating" required>

                            </div>
                            <span x-show="showErrorMsj" class="text-red-500 text-xs font-medium">Please select a rating</span>


                        </div>
                    </div>

                    <!-- Campo para el comentario -->
                    <div>
                        <label for="comment" class="gap-2 text-sm font-medium text-text-light pb-2 flex items-center">
                            <i class="fa fa-share text-xs" aria-hidden="true"></i> Share your opinion with other users
                        </label>
                        <textarea id="comment" name="comment"
                            class="bg-background p-4 border leading-5 text-text-light text-sm border-gray-200 w-full rounded-lg shadow-sm focus:ring-primary focus:border-primary focus:outline-none resize-none"
                            rows="4" placeholder="Describe your experience" required></textarea>

                        <?php
                        if (is_user_logged_in()) {
                            // El usuario NO está logueado
                            echo '
                            <!-- Campo anónimo -->
                             <div class="flex justify-between items-center mt-2">
                            <label for="anonymous" class="inline-flex items-center text-sm font-medium text-text-light">
                                <input type="checkbox" id="anonymous" name="anonymous" class="mr-1"> Comment anonymously
                            </label>';
                        } else {
                            echo '<div class="flex justify-end items-center mt-2">';
                        }
                        ?>
                        <!-- Contador de caracteres -->
                        <span id="charCount" class="text-sm text-gray-500">0/500</span>
                    </div>
            </div>
        
            <!-- Botón de enviar -->
            <div class="mt-6 flex justify-center w-full">
                <button type="submit" class="w-[90%] bg-primary font-bold text-white py-4 px-4 rounded-full hover:bg-primary-dark">Send Rate</button>
            </div>


            <!-- Descargo de responsabildad -->

            <div class="pt-8 text-gray-600 flex justify-center">
                <div class="flex items-start gap-2 px-2">
                    <input class="mt-1" type="checkbox" required />
                    <p class="font-medium cursor-pointer text-xs">
                        By (checking here) and submitting a review you are making a representation and warranty that you were actually a patient under the care of the named provider. Any submission made where that is not the case may result in possible adverse legal repercussions for you.
                    </p>
                </div>
            </div>


            <?php
            comment_id_fields();
            do_action('comment_form', get_the_ID());
            ?>
            </form>
        </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const textarea = document.getElementById("comment");
                const charCount = document.getElementById("charCount");
                const maxChars = 500;

                textarea.addEventListener("input", function() {
                    const length = textarea.value.length;
                    charCount.textContent = `${length}/${maxChars}`;

                    if (length > maxChars) {
                        textarea.value = textarea.value.substring(0, maxChars);
                        charCount.textContent = `${maxChars}/${maxChars}`;
                    }
                });
            });

            // // Mostrar el nombre del archivo seleccionado
            // function updateFileName() {
            //     var fileInput = document.getElementById('proof');
            //     var fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file selected';
            //     document.getElementById('file-name').textContent = fileName;
            // }
        </script>

<?php
    endif;
}
