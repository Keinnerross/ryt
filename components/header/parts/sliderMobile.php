<?php

function sliderMobile()
{
?>

    <div class=" w-[70%] h-screen px-6 py-10 bg-slate-50 absolute right-0 top-0 animate-fade-left animate-duration-[800ms]" x-on:click.stop>
        <div class="">

            <h3 class="py-8 font-medium text-3xl">Howdy👋!</h3>
            <nav id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" class="flex ">

                <?php wp_nav_menu(array(
                    'menu'                 => 'mobile-menu',
                    'theme_location' => 'mobile-menu',
                    'link_before' => '<span itemprop="name">',
                    'link_after' => '</span>',
                    'container'            => 'ul',
                    'menu_class'           => 'h-full flex flex-col gap-4 text-lg',

                )); ?>

            </nav>
        </div>


    </div>

<?php }
