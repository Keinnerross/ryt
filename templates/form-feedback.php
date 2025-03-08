<?php
$formularioBg = get_stylesheet_directory_uri() . "/assets/formulario.jpg";

/* Template Name: Form Feedback*/
get_header();
?>


<div class="flex justify-center items-center md:h-screen flex-col bg-center bg-no-repeat bg-cover relative" style="background-image: url('<?php echo $formularioBg ?>');">
<div class="w-full top-0 absolute h-screen inset-0 bg-black opacity-50 z-0 hidden md:block"></div>


    <div class="px-6 py-8 md:rounded-xl md:shadow-lg bg-white w-full md:w-[400px] relative z-10 h-full md:h-auto">
        <h2 class="text-3xl font-bold pb-6">Feedback Form</h2>
        <form class="flex flex-col gap-4" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="enviar_formulario">

            <div class="py-2 px-4  rounded-full bg-background flex gap-4 items-center border border-gray-200 ">
                <i class="fa fa-user text-text-lightX2" aria-hidden="true"></i>
                <input class="outline-0 bg-transparent w-full text-sm" type="text" name="name" placeholder="Your Name" required>
            </div>

            <div class="py-2 px-4 rounded-full bg-background flex gap-4 items-center border border-gray-200 ">
                <i class="fa fa-envelope text-text-lightX2" aria-hidden="true"></i>
                <input class="outline-0 bg-transparent w-full text-sm" type="email" name="email" placeholder="Your Email" required>

            </div>



            <div>

                <label name="message" class="gap-2 text-sm font-medium text-text-light pb-2 flex items-center">
                    <i class="fa fa-share text-xs" aria-hidden="true"></i> Thanks for share your opinion with us!
                </label>
                <textarea id="comment" name="comment"
                    class="bg-background p-4 border leading-5 text-text-light text-sm border-gray-200 w-full rounded-lg shadow-sm focus:ring-primary focus:border-primary focus:outline-none resize-none"
                    rows="4" placeholder="Describe your experience" required></textarea>
            </div>

            <div class="mt-2 flex justify-center w-full">
                <button type="submit" class="w-full bg-primary font-bold text-white py-4 px-4 rounded-full hover:bg-primary-dark">Send Feedback</button>
            </div>




        </form>

    </div>
</div>




<?php get_footer(); ?>