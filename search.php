    <?php require_once get_stylesheet_directory() . "/components/search-page/searchEmpty.php"; ?>
    <?php require_once get_stylesheet_directory() . "/components/search-page/searchNoFound.php"; ?>
    <?php require_once get_stylesheet_directory() . "/components/search-page/searchResult.php"; ?>


    <?php get_header(); ?>
    <?php if (empty(get_search_query())) : ?>
        <!-- Busquedas Vacias Empty -->
        <?php SearchEmpty($wp_query) ?>

    <?php elseif (have_posts()) : ?>
        <!-- Resultados de busqueda  -->
        <?php SearchResult() ?>


    <?php else : ?>
        <!-- Resultados no encontrados  -->
        <?php SearchNoFound() ?>


    <?php endif; ?>

    <?php get_footer(); ?>