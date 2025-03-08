<?php function desktopHeader()
{
    $logotype = get_stylesheet_directory_uri() . "/assets/logo-horizontal.png";

?>
    <header id="main-header-desktop" role="banner" class="hidden md:flex w-full py-2 bg-slate-100 justify-center  z-50 relative shadow-md animate-fade-down">

        <div class=" flex items-center justify-between w-[90vw] h-full relative">

            <!-- Navigation -->
            <div class="flex gap-2 items-center">
                <a href="/" id="branding" class="w-[150px] h-[50px] overflow-x-hidden">
                    <img src="<?php echo $logotype ?>" class="object-contain w-full h-full" />
                </a>



            </div>



            <div>
                <ul class="flex gap-4 text-text font-raleway font-medium transition-all duration-200 tracking-wider">
                    <li><a href="/" class="flex items-center gap-2 px-3 py-3 rounded-xl cursor-pointer hover:bg-gray-200"> <i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                    <li><a href="/?s=" class="flex items-center gap-2 px-3 py-3 rounded-xl cursor-pointer hover:bg-gray-200"><i class="fa fa-address-book" aria-hidden="true"></i> Therapists</a></li>
                    <li><a href="/my-account" class="flex items-center gap-2 px-3 py-3 rounded-xl cursor-pointer hover:bg-gray-200"><i class="fa fa-user" aria-hidden="true"></i></i>My Account</a></li>
                </ul>
            </div>





        </div>

    </header>

<?php  }
