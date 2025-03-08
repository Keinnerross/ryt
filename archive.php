<?php require_once get_stylesheet_directory() . "/components/sidebar-search/sidebar-search.php"; ?>

<?php get_header(); ?>

<?php
$current_term = get_queried_object();

if (empty($current_term)) : ?>
    <article id="post-0" class="post no-results not-found">
        <header class="bg-myBlack w-full h-40 text-myWhite flex justify-center items-center">
            <div class="w-[80vw]">
                <h1 class="entry-title"><?php esc_html_e('No results found for this specialty', 'blankslate'); ?></h1>
                <p><?php esc_html_e('Please try another specialty.', 'blankslate'); ?></p>
            </div>
        </header>
    </article>
<?php elseif (have_posts()) : ?>
    <header class="bg-myBlack w-full h-40 text-myWhite flex justify-center items-center">
        <div class="w-[80vw]">
            <h1 class="entry-title" itemprop="name">
                <?php
                // Mostrar el nombre de la especialidad
                echo esc_html__('Specialty: ', 'blankslate') . esc_html($current_term->name);
                ?>
            </h1>
            <div id="search" class="h-full py-4 "><?php get_search_form(); ?></div>
        </div>
    </header>

    <main class="w-full flex justify-center py-10 bg-myWhite-bg">
        <div class="w-[80vw] flex justify-between gap-10">

            <!-- Entry Container -->
            <div id="entry-container" class="w-[70%] flex flex-col gap-2">
                <div class="flex flex-col gap-2 bg-myWhite  p-6 rounded-lg">
                    <div id="header-section" class="pb-2 flex justify-between">
                        <p id="results-count">
                            <?php
                            printf(
                                esc_html__('Found %d results for %s.', 'blankslate'),
                                $wp_query->found_posts,
                                esc_html($current_term->name)
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
                        <!-- Aquí se incluye el template de entry.php para renderizar las publicaciones -->
                        <?php get_template_part('entry'); ?>
                    <?php endwhile; ?>

                    <!-- Pagination -->
                    <?php get_template_part('nav-below'); ?>
                </div>
            </div>

            <!-- Sidebar Container -->
            <div class="w-[30%]">
                <?php echo SidebarSearch() ?>
            </div>
        </div>
    </main>
<?php else : ?>
    <article id="post-0" class="post no-results not-found">
        <header class="bg-myBlack w-full h-40 text-myWhite flex justify-center items-center">
            <div class="w-[80vw]">
                <h1 class="entry-title" itemprop="name"><?php esc_html_e('Nothing Found', 'blankslate'); ?></h1>
            </div>
        </header>

        <main class="w-full flex justify-center py-10 bg-myWhite-bg">
            <div class="w-[80vw] flex justify-between gap-10">

                <!-- Entry Container -->
                <div id="entry-container" class="w-[70%] flex flex-col gap-2">
                    <div class="flex flex-col gap-2 bg-myWhite border-[1px] border-solid border-gray-300 p-6 rounded-lg">
                        <div class="entry-content min-h-[50vh]" itemprop="mainContentOfPage">
                            <p><?php esc_html_e('Sorry, no therapists found under this specialty.', 'blankslate'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Container -->
                <div class="w-[30%]">
                    <?php echo SidebarSearch() ?>
                </div>
            </div>
        </main>
    </article>
<?php endif; ?>

<?php get_footer(); ?>