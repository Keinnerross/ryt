</div><!-- .col-full -->
</div><!-- #content -->
</div><!-- #page -->



<?php wp_footer(); ?>
<div class="">
    <footer class="bg-gray-100 pt-10 flex flex-col items-center justify-center">
        <div class="md:w-[80vw]  container mx-auto px-4">

            <div class="flex justify-between gap-8 mb-8 text-gray-600">

                <div class='md:w-[40%] md:flex flex-col justify-center text-center md:text-left'>
                    <h3 class="font-semibold text-gray-800 pb-2 text-xl">Who we are?</h3>
                    <p class='text-sm   pb-4 '>Our goal is to help you find the right professional for your emotional and mental health needs. We know how important it is to have the support of a therapist who understands your needs and gives you the safe space to grow and heal. </p>

                </div>

                <div class="w-[40%] hidden md:flex justify-between gap-8">

                    <div class=' flex flex-col pl-[30%] '>
                        <h3 class="font-semibold text-gray-800 text-xl">Menu</h3>

                        <?php wp_nav_menu(array(
                            'menu'                 => 'footer-menu',
                            'link_before' => '<span itemprop="name">',
                            'link_after' => '</span>',
                            'container'            => 'ul',
                            'menu_class'           => 'pt-2 h-full flex flex-col gap-2 text-sm',

                        )); ?>

                    </div>
                    <div class='block'>
                        <h3 class="font-semibold text-gray-800 text-xl">Resources</h3>
                        <?php wp_nav_menu(array(
                            'menu'                 => 'resources-footer-menu',
                            'link_before' => '<span itemprop="name">',
                            'link_after' => '</span>',
                            'container'            => 'ul',
                            'menu_class'           => 'pt-2 h-full flex flex-col gap-2 text-sm',

                        )); ?>
                    </div>

                </div>

                <!-- <div class='md:block flex justify-center flex-col items-center'>
                    <h3 class="font-semibold text-gray-800 text-xl">Contact</h3>
                    <ul class="text-sm  text-gray-600 flex flex-col items-center md:items-start gap-2 pt-2">

                        <a href='#' class='flex gap-2 items-center'>
                            <i class="fa fa-envelope text-text" aria-hidden="true"></i>
                            <li class="text-sm">info@rateyourtherapist.com</li>
                        </a>





                    </ul>
                </div> -->
            </div>

            <div class="flex justify-center pb-6">
                <h3 class="text-gray-600 text-sm text-center">©2025 All rights reserved. Powered by <a class="font-semibold" href="https://duranttbros.com/">Duranttbros</a>
                </h3>
            </div>
        </div>
    </footer>
</div>


</body>

</html>