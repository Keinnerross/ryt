<?php get_header(); ?>

<?php $bannerImg = get_stylesheet_directory_uri() . "/assets/banner.jpeg"; ?>
<?php $card1 = get_stylesheet_directory_uri() . "/assets/Home1.jpg"; ?>
<?php $card2 = get_stylesheet_directory_uri() . "/assets/Home2.jpg"; ?>
<?php $card3 = get_stylesheet_directory_uri() . "/assets/Home3.jpg"; ?>
<?php require_once get_stylesheet_directory() . "/components/home/parts/homeCard.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/home/parts/searchHome.php"; ?>


<div>
    <div id="mainBanner" style="background-image: url('<?php echo $bannerImg ?>');" class="flex h-[60vh] md:h-[82vh] justify-center items-center bg-no-repeat bg-cover bg-bottom relative md:overflow-hidden animate-fade animate-delay-500">

        <div class="md:px-0 md:w-1/2 flex flex-col items-center text-sm md:text-2xl font-light text-white tracking-widest text-center font-montserrat ">
            <div class="max-w-fit  bg-black px-4 pt-1">
                <p>RATE YOUR THERAPIST IS AN</p>
                <p>INNOVATIVE PLATFORM THAT</p>
            </div>
            <div class="max-w-fit  bg-black px-4 pb-1">
                <p>EMPOWERS CLIENTS TO REVIEW THEIR</p>
                <p>THERAPISTS AND HELPS OTHERS FIND</p>
            </div>
            <p class="max-w-fit bg-black px-4 pb-1 pt-0">THE RIGHT</p>

            <div id="search" class="h-full py-4 mt-4 "><?php SearchHome() ?></div>
        </div>
        <svg id="wave" class="absolute bottom-[-5px] md:bottom-[-50px]" style="transform:rotate(0deg); transition: 0.3s" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
                    <stop stop-color="rgba(255, 255, 255, 1)" offset="0%"></stop>
                </linearGradient>
            </defs>
            <path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,50L80,41.7C160,33,320,17,480,18.3C640,20,800,40,960,40C1120,40,1280,20,1440,13.3C1600,7,1760,13,1920,15C2080,17,2240,13,2400,25C2560,37,2720,63,2880,70C3040,77,3200,63,3360,63.3C3520,63,3680,77,3840,78.3C4000,80,4160,70,4320,58.3C4480,47,4640,33,4800,36.7C4960,40,5120,60,5280,65C5440,70,5600,60,5760,55C5920,50,6080,50,6240,45C6400,40,6560,30,6720,21.7C6880,13,7040,7,7200,13.3C7360,20,7520,40,7680,41.7C7840,43,8000,27,8160,26.7C8320,27,8480,43,8640,51.7C8800,60,8960,60,9120,65C9280,70,9440,80,9600,85C9760,90,9920,90,10080,75C10240,60,10400,30,10560,28.3C10720,27,10880,53,11040,65C11200,77,11360,73,11440,71.7L11520,70L11520,100L11440,100C11360,100,11200,100,11040,100C10880,100,10720,100,10560,100C10400,100,10240,100,10080,100C9920,100,9760,100,9600,100C9440,100,9280,100,9120,100C8960,100,8800,100,8640,100C8480,100,8320,100,8160,100C8000,100,7840,100,7680,100C7520,100,7360,100,7200,100C7040,100,6880,100,6720,100C6560,100,6400,100,6240,100C6080,100,5920,100,5760,100C5600,100,5440,100,5280,100C5120,100,4960,100,4800,100C4640,100,4480,100,4320,100C4160,100,4000,100,3840,100C3680,100,3520,100,3360,100C3200,100,3040,100,2880,100C2720,100,2560,100,2400,100C2240,100,2080,100,1920,100C1760,100,1600,100,1440,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
        </svg>

    </div>

    <div class="flex flex-col items-center py-10 md:py-20">

        <h2 class="text-text text-2xl md:text-4xl font-raleway tracking-wider font-bold pb-10 md:pb-16 md:w-[30%] text-center px-4 md:px-0">Discover & Share Your Therapy Experience</h2>

        <div id="cardsContainer" class="w-[80vw] grid grid-cols-1 md:grid-cols-3 gap-8">

            <?php homeCard($card1, "Search Therapist", "Find the right therapist for you using our comprehensive directory."); ?>

            <?php homeCard($card2, "Rate Their Performance", "Your experience and contribution helps improve our community."); ?>

            <a href="mailto:feedback@rateyourtherapist.com?subject=Feedback%20to%20improve">
                <?php homeCard($card3, "Help Us Improve", "Leave your feedback and help us make this site even better."); ?>
            </a>

        </div>
    </div>

</div>

<?php

get_footer();
