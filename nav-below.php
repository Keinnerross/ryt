<?php
$big = 999999999;

$pagination = paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $wp_query->max_num_pages,
    'prev_text' => '<span class="block px-4 py-2 bg-primary text-white rounded-full shadow hover:bg-primary-dark transition">&larr; Back</span>',
    'next_text' => '<span class="block px-4 py-2 bg-primary text-white rounded-full shadow hover:bg-primary-dark transition">Next &rarr;</span>',
    'before_page_number' => '<span class=" w-4 h-4 flex items-center justify-center p-4 cursor-pointer rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition">',
    'after_page_number' => '</span>',
    'screen_reader_text' => esc_html__('Posts navigation', 'blankslate'),
));

if ($pagination) :
    echo '<nav class="flex justify-end mt-6 gap-2 px-4">';
    echo $pagination;
    echo '</nav>';
endif;
