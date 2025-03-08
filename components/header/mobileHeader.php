<?php function mobileHeader()
{
    $logotype = get_stylesheet_directory_uri() . "/assets/logotype.jpeg";
    require_once get_stylesheet_directory() . "/components/header/parts/sliderMobile.php";

?>
    <header id="main-header-mobile" role="banner" class="flex md:hidden w-full h-14 bg-slate-100 justify-center relative
    z-[999]"
        x-data="{ isOpen: false }">

        <div class="flex items-center justify-between w-[95vw] h-full relative">

            <a href="/" id="branding" class="w-[70px] h-[70px] mt-8 border-solid border-8 border-white">
                <img src="<?php echo $logotype ?>" class="object-contain" />
            </a>

            <i class="fa fa-bars text-lg cursor-pointer" aria-hidden="true" x-on:click="isOpen = !isOpen"></i>

            <div x-show="isOpen" x-on:click="isOpen = false" class="bg-gray-900/50 h-screen w-full fixed top-0 left-0 z-[999]">
                <?php sliderMobile(); ?>
            </div>

        </div>
    </header>
<?php } ?>