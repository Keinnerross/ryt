<?php require_once get_stylesheet_directory() . "/components/header/desktopHeader.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/header/mobileHeader.php"; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>
    <div id="wrapper" class="hfeed">
        <?php desktopHeader(); ?>
        <?php mobileHeader(); ?>




        <div id="container">
            <main id="content" role="main"></main>