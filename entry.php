<?php require_once get_stylesheet_directory() . "/components/single/parts/save-button.php"; ?>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
        <div class="flex justify-between h-full hover:bg-background p-2 md:p-4 rounded-xl">
            <div class="flex">
                <div class="w-[90px]">
                    <div id="img-entry" class="w-[80px] h-[80px] overflow-hidden rounded-full ">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>" class=" object-cover w-full h-full object-center" />
                        <?php else : ?>
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png" alt="<?php esc_attr_e('Default thumbnail', 'blankslate'); ?>" class="object-cover w-full h-full" />
                        <?php endif; ?>
                    </div>
                </div>

                <div id="info-entry" class="pl-4 md:pl-1">
                    <div id="title-entry">
                        <h1 class="font-bold text-text text-lg">
                            <?php the_title(); ?>
                        </h1>
                    </div>
                    <div id="tax-entry">
                        <?php
                        $terms = get_the_terms(get_the_ID(), 'specialties');

                        if ($terms && !is_wp_error($terms)) :
                            $first_term = array_shift($terms);
                            echo '<p class="text-xs py-[1px] font-medium">' . esc_html($first_term->name) . '</p>';
                        else :
                            echo '<p></p>';
                        endif;
                        ?>
                    </div>


                    <div id="address-entry" class="text-text text-sm">
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


                    <div id="stars-entry" class="pt-1 text-sm flex gap-[1px] items-end">
                        <?php
                        $post_id = get_the_ID();
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
                            echo '<span class="text-xs leading-none text-text pl-2">Reviews (' . $comment_count . ') </span>';
                        } else {
                            for ($i = 0; $i < 5; $i++) {
                                echo '<i class="fa fa-star-o text-gray-400"></i>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php echo SaveButton() ?>

        </div>
    </a>

    <?php if (!is_archive() && !is_search()) : ?>
        <?php get_template_part('entry', 'meta'); ?>
    <?php endif; ?>

    <?php if (is_singular()) {
        get_template_part('entry-footer');
    } ?>
</article>