<?php get_header(); ?>

<div class="flex flex-col items-center justify-center min-h-screen">

    <div class="overflow-hidden w-[400px] h-[250px]">
        <img
            class="w-full h-full object-cover"
            src="https://media0.giphy.com/avatars/404academy/kGwR3uDrUKPI.gif" />


    </div>
    <h1 class="text-4xl font-bold text-text">Oops! Page Not Found</h1>
    <p class="mt-4 text-lg text-gray-700">Sorry, we can't find the page you're looking for. It may have been moved or deleted.</p>
    <p class="mt-4">
        <a href="<?php echo home_url(); ?>" class="mt-4 inline-block px-6 py-2 text-white bg-blue-600 rounded-full hover:bg-blue-700">
            Back to Homepage
        </a>
    </p>
</div>

<?php get_footer(); ?>