<?php
require_once get_stylesheet_directory() . "/components/single/parts/rate-buttons.php";
require_once get_stylesheet_directory() . "/components/comments/form-comment.php";
require_once get_stylesheet_directory() . "/components/single/parts/graphic.php";
require_once get_stylesheet_directory() . "/components/single/parts/save-button.php";


function SingleProfile()
{

    $credential = get_stylesheet_directory_uri() . "/assets/papper.png";
    $formularioBg = get_stylesheet_directory_uri() . "/assets/formulario.jpg";
    $post_id = get_the_ID();
    $rating = get_field('Rating', $post_id);


    if (have_posts()) :
        while (have_posts()) : the_post();
?>
            <div x-data="{ isCommentForm : false }">

                <div class="w-full flex justify-center items-center bg-myWhite-bg md:py-10">
                    <div class="bg-myWhite md:rounded-lg md:w-[80vw] px-2 py-8 md:px-8 md:py-8 flex flex-col md:flex-row justify-between shadow-sm gap-6 md:gap-0">
                        <div id="info-single-section" class="md:w-[50%]">


                            <div id="therapist-info" class="flex gap-4 md:max-w-[78%] mb-4 md:mb-0">

                                <!-- Imagen del terapeuta -->
                                <div id="therapist-img" class="w-[130px] min-w-[130px] min-h-[130px] h-[130px] overflow-hidden rounded-full flex-shrink-0">
                                    <?php
                                    // Mostrar la imagen destacada (si está disponible)
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']);
                                    } else {
                                        // Imagen predeterminada si no tiene imagen destacada
                                        echo '<img src="URL_DE_IMAGEN_DEFAULT" class="w-full h-full object-cover " />';
                                    }
                                    ?>
                                </div>
                                <div id="data-entry" class="flex flex-col gap-1">

                                    <!-- Título del terapeuta -->
                                    <div class="flex items-center  text-text">
                                        <h1 class="text-2xl font-bold leading-none"><?php the_title(); ?></h1>
                                        <div class="pl-2 pt-1"> 
                                            <?php echo SaveButton(); ?>
                                        </div>
                                    </div>

                                    <!-- Stars -->
                                    <div id="stars-entry" class="flex items-center py-1">
                                        <?php

                                        $comments = get_comments(array('post_id' => $post_id, 'status' => 'approve'));
                                        $total_stars = 0;
                                        $comment_count = 0;

                                        foreach ($comments as $comment) {
                                            $rate = get_comment_meta($comment->comment_ID, 'rate', true);
                                            if ($rate) {
                                                $total_stars += (int) $rate;
                                                $comment_count++;
                                            }
                                        }

                                        if ($comment_count > 0) {
                                            $average_stars = $total_stars / $comment_count;
                                            $full_stars = floor($average_stars);
                                            $half_star = ($average_stars - $full_stars) >= 0.5 ? 1 : 0;
                                            $empty_stars = 5 - $full_stars - $half_star;

                                            for ($i = 0; $i < $full_stars; $i++) {
                                                echo '<i class="fa fa-star text-amber-400"></i>';
                                            }
                                            if ($half_star) {
                                                echo '<i class="fa fa-star-half-alt text-amber-400"></i>';
                                            }
                                            for ($i = 0; $i < $empty_stars; $i++) {
                                                echo '<i class="fa fa-star-o text-gray-400"></i>';
                                            }
                                        } else {
                                            for ($i = 0; $i < 5; $i++) {
                                                echo '<i class="fa fa-star-o  text-gray-400"></i>';
                                            }
                                        }
                                        echo '<div class="flex items-center">
                                        <span class="text-sm pl-1 font-medium"> (' . ($rating > 0 ? number_format($rating, 1) : '0') . ')</span>
                                    </div>';

                                        ?>
                                    </div>

                                    <!-- Address -->
                                    <div id="address-entry" class="text-sm">
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

                                    <div id="website-entry" class="text-sm">
                                        <?php
                                        $address = get_field('Website'); // ACF Address field
                                        if ($address) : ?>
                                            <p><?php echo esc_html($address); ?></p>
                                        <?php else : ?>
                                            <span></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php RateButtons(); ?>
                                </div>
                            </div>



                            <div id="therapist-credentials" class="flex gap-4 items-center pt-6 pb-12">


                                <div class=" w-[120px] h-[70px] rounded-full">
                                    <img src="<?php echo $credential ?>" class="object-cover" />

                                </div>

                                <div id="credentials-info" class=" flex flex-col">
                                    <h2 class="text-xl font-medium">Therapist Credentials</h2>
                                    <div id="tax-entry">
                                        <?php
                                        $terms = get_the_terms(get_the_ID(), 'specialties');

                                        if ($terms && !is_wp_error($terms)) :
                                            $first_term = array_shift($terms);
                                            echo '<p class="text-text-light text-sm"> Especialties: ' . esc_html($first_term->name) . '</p>';
                                        else :
                                            echo '<p></p>';
                                        endif;
                                        ?>
                                    </div>
                                    <div id="credentials-link" class="pt-4">
                                        <?php
                                        $proof_id = get_post_meta(get_the_ID(), 'Credentials', true);

                                        if ($proof_id) {
                                            $credentials_url = wp_get_attachment_url($proof_id);
                                            if ($credentials_url) {
                                                echo '<a class="text-text-light hover:text-primary cursor-pointer border-[1px] border-solid border-text-light text-xs hover:border-primary transition-all py-2 px-4 rounded-full font-medium" target="_blank" href="' . esc_url($credentials_url) . '">View Archive</a>';
                                            } else {
                                                echo '<p>El archivo no tiene una URL válida.</p>';
                                            }
                                        } else {
                                            echo '<p>No se encontró el archivo adjunto.</p>';
                                        }
                                        ?>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div id="graphic-container" class="md:w-[50%]">
                            <?php Graphic(); ?>
                        </div>
                    </div>
                </div>

                <div x-show="isCommentForm" class="z-[999] w-screen bg-white flex justify-center items-center fixed top-0 left-0 flex-col bg-center bg-no-repeat bg-cover" style="background-image: url('<?php echo $formularioBg ?>');">
                    <!-- Fondo con opacidad -->
                    <div class="w-screen fixed inset-0 bg-black opacity-50 z-0"></div>

                    <!-- Contenedor del formulario con desplazamiento -->
                    <div class="relative z-10 w-screen">
                        <!-- Aquí va el contenido del formulario -->
                        <?php FormComment(); ?>
                    </div>
                </div>
    <?php
        endwhile;
    endif;
}
    ?>