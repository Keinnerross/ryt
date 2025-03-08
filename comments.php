<?php require_once get_stylesheet_directory() . "/components/comments/nav-below-comments.php" ?>

<div id="comments" class="flex justify-center">
    <?php
    if (have_comments()) :
        // Separa los comentarios en dos tipos: "comments" y "pings" (trackbacks/pingbacks).
        global $comments_by_type;
        $comments_by_type = separate_comments($comments);

        // Si hay comentarios regulares (no pings ni trackbacks).
        if (!empty($comments_by_type['comment'])) :
    ?>

            <section id="comments-container" class="flex flex-col py-10 px-4 w-[80vw]">
                <div class="md:w-[70%]">
                    <header class="w-full flex justify-between items-center pb-8">
                        <h2 class="font-bold text-xl">Reviews (<?php echo get_comments_number(); ?>)</h2>

                        <form id="filter-form" method="get" action="<?php echo esc_url(get_permalink()); ?>">
                            <label for="orderby" class="sr-only"><?php esc_html_e('Sort by', 'blankslate'); ?></label>
                            <select name="orderby" id="orderby" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
                                <option value="" disabled selected><?php esc_html_e('Sort', 'blankslate'); ?></option>
                                <option value="newest" <?php selected(get_query_var('orderby'), 'newest'); ?>>
                                    <?php esc_html_e('Newest', 'blankslate'); ?>
                                </option>
                                <option value="oldest" <?php selected(get_query_var('orderby'), 'oldest'); ?>>
                                    <?php esc_html_e('Oldest', 'blankslate'); ?>
                                </option>
                                <option value="useful" <?php selected(get_query_var('orderby'), 'useful'); ?>>
                                    <?php esc_html_e('Featured', 'blankslate'); ?>
                                </option>
                            </select>
                        </form>
                    </header>

                    <div class="w-full">
                        <ul>
                            <?php
                            wp_list_comments('type=comment');
                            ?>
                        </ul>
                    </div>
                    <div class="flex justify-end px-2">

                        <?php
                        // Obtener el número total de páginas y la página actual
                        $total_pages = get_comment_pages_count();

                        // Si hay varias páginas de comentarios, muestra navegación en la parte superior.
                        if ($total_pages > 1) : ?>
                            <?php NavBelowComments() ?>
                        <?php endif; ?>
                    </div>

                </div>


            </section>

    <?php
        endif;
    endif;
    ?>
</div>