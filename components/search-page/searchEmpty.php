<?php require_once get_stylesheet_directory() . "/components/search-page/parts/headerSearchPage.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/sidebar-search/sidebar-search.php"; ?>


<?php function SearchEmpty($wp_query)
{

    global $wp;
?>
    <div>
        <!-- Empty Header -->
        <?php HeaderSearchpage() ?>
        <!-- Empty Content -->
        <main class="w-full flex justify-center md:py-10 bg-myWhite-bg">
            <div class="md:w-[80vw] flex justify-between gap-10">
                <!-- Entry Container -->
                <div id="entry-container" class="w-full md:w-[70%] flex flex-col gap-2">
                    <div class="flex flex-col gap-2 bg-myWhite  p-6 rounded-lg shadow-sm">
                        <div id="header-section" class="pb-2 flex justify-between">
                            <p id="results-count">
                                All Therapists
                            </p>

                        </div>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('entry'); ?>
                        <?php endwhile; ?>

                        <!-- Pagination -->
                        <?php get_template_part('nav-below'); ?>
                    </div>
                </div>
                <!-- Sidebar Container -->
                <div class="hidden md:block w-[30%]">
                    <?php echo SidebarSearch() ?>
                </div>
            </div>
        </main>
    </div>


<?php
}
