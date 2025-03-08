<?php require_once get_stylesheet_directory() . "/components/sidebar-search/sidebar-search.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/search-page/parts/headerSearchPage.php"; ?>


<?php function SearchResult()
{

    global $wp_query;
    global $wp;
?>
    <div>
        <?php HeaderSearchpage() ?>

        <main class="w-full flex justify-center md:py-10 bg-myWhite-bg">
            <div class="md:w-[80vw] flex justify-between gap-10">
                <!-- Entry Container -->
                <div id="entry-container" class="md:w-[70%] flex flex-col gap-2">



                    <div class="flex flex-col gap-2 bg-myWhite  p-6 md:rounded-lg shadow-sm">
                        <div id="header-section" class="pb-2 flex justify-between">
                            <p id="results-count">
                                <?php
                                $stars_filter = isset($_GET['stars']) ? ' with ' . intval($_GET['stars']) . ' stars' : '';
                                printf(
                                    esc_html__('Found %d results%s.', 'blankslate'),
                                    $wp_query->found_posts,
                                    $stars_filter
                                );
                                ?>
                            </p>
                            <form id="filter-form" method="get" action="<?php echo esc_url(home_url($wp->request)); ?>">
                                <label for="orderby"></label>
                                <select name="orderby" id="orderby" onchange="this.form.submit()">
                                    <option value="" disabled selected><?php esc_html_e('Sort', 'blankslate'); ?></option>
                                    <option value="date" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'date') ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Date', 'blankslate'); ?>
                                    </option>


                                    <option value="rating" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'rating') ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Rating', 'blankslate'); ?>
                                    </option>
                                    <option value="modified" <?php echo (isset($_GET['orderby']) && $_GET['orderby'] === 'modified') ? 'selected' : ''; ?>>
                                        <?php esc_html_e('Last Modified', 'blankslate'); ?>
                                    </option>
                                </select>

                                <?php if (get_search_query()) : ?>
                                    <input type="hidden" name="s" value="<?php echo esc_attr(get_search_query()); ?>">
                                <?php endif; ?>
                            </form>
                        </div>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('entry'); ?>
                        <?php endwhile; ?>
                        <!-- Pagination -->
                        <?php get_template_part('nav-below'); ?>
                    </div>
                </div>
                <!-- Sidebar Container -->
                <div class="w-[30%] hidden md:block">
                    <?php echo SidebarSearch() ?>
                </div>
            </div>
        </main>
    </div>

<?php
}
