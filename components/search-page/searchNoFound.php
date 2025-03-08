<?php require_once get_stylesheet_directory() . "/components/search-page/parts/headerSearchPage.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/sidebar-search/sidebar-search.php"; ?>



<?php function SearchNoFound()
{

?>
    <div>
        <?php HeaderSearchpage() ?>
        <main class="w-full flex justify-center md:py-10 bg-myWhite-bg">
            <div class="md:w-[80vw] flex justify-between gap-10">

                <!-- Entry Container -->
                <div id="entry-container" class="md:w-[70%] flex flex-col gap-2">
                    <div class="flex flex-col gap-2 bg-myWhite p-6 md:rounded-lg shadow-sm">
                        <div class="entry-content min-h-[50vh] pt-4" itemprop="mainContentOfPage">
                            <p><?php esc_html_e('Sorry, nothing matched your search. Please try again.', 'blankslate'); ?></p>
                        </div>
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
