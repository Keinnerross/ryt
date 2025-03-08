<?php function HeaderSearchpage()
{
?>
    <header class="bg-myBlack w-full h-40 text-myWhite flex justify-center items-center">
        <div class="w-[80vw]">
            <?php get_search_form(); ?>
        </div>
    </header>
<?php
}
