<?php function NavBelowComments()
{


?>
    <div class="paginated-comments-links flex gap-1">
        <?php
        // Mostrar la paginación de los comentarios
        paginate_comments_links(array(
            'prev_text' => '<span class="block px-4 py-2 bg-primary text-white rounded-full shadow hover:bg-primary-dark transition">&larr; Back</span>',
            'next_text' => '<span class="block px-4 py-2 bg-primary text-white rounded-full shadow hover:bg-primary-dark transition">Next &rarr;</span>',
            'before_page_number' => '<span class="page-number w-4 h-4 flex items-center justify-center p-4 cursor-pointer rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition">',
            'after_page_number' => '</span>',
        ));
        ?>
    </div>
<?php
}


