<?php require_once get_stylesheet_directory() . "/templates/parts/custom-login.php"; ?>
<?php require_once get_stylesheet_directory() . "/templates/parts/custom-register.php"; ?>

<?php $bannerLogin = get_stylesheet_directory_uri() . "/assets/login.jpg" ?>

<?php
/* Template Name: Custom Access */
get_header();
?>

<div x-data="{isRegister: false}" class="relative md:flex justify-center items-center h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo $bannerLogin ?>');">

    <!-- Capa oscura encima del fondo con Tailwind -->
    <div class="absolute inset-0 bg-black opacity-50 z-0"></div>

    <div class="relative z-10">
        <?php CustomLogin(); ?>
        <?php CustomRegister(); ?>
    </div>

</div>

<?php get_footer(); ?>