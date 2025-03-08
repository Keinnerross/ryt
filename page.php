<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div itemprop="mainContentOfPage" class="entry-content w-full flex flex-col items-center min-h-[80vh]">

                <div class="w-[90%]">


                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('itemprop' => 'image'));
                    } ?>
                    <?php the_content(); ?>
                    <div class="entry-links"><?php wp_link_pages(); ?></div>
                </div>
            </div>

        </article>
       
<?php endwhile;
endif; ?>
<?php get_footer(); ?>