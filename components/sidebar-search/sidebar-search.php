<?php require_once get_stylesheet_directory() . "/components/sidebar-search/parts/stars-filter.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/sidebar-search/parts/categories-filter.php"; ?>


<?php function SidebarSearch()
{
?>
    <div class="w-full">
        <div id="sidebar-container" x-data="{ selectedStars: new URLSearchParams(window.location.search).get('stars') }">
            <div id="sidebar" class="bg-myWhite p-4 rounded-lg shadow-sm">
                <?php echo StarsFilter() ?>
                <div class="pt-6"> 
                    <?php echo CategoriesFilter() ?>

                </div>

            </div>
        </div>
    </div>


<?php
}
