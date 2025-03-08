<?php function Notification()
{

?>

    <div x-data="notificationComponent()" x-show="isAfter" id="noti-before-rate" class="w-[90vw] md:w-[500px] fixed bottom-6 left-1/2 md:left-auto md:right-6 transform -translate-x-1/2 md:transform-none rounded-md bg-myBlack flex justify-center text-white animate-fade-up animate-duration-[600ms] animate-delay-200">

        <div class="rounded-l-md w-2 absolute left-0 top-0 h-full bg-green-700"></div>
        <div class="absolute right-4 top-2 h-full">
            <span x-on:click="isAfter = false" class="cursor-pointer font-semibold">x</span>
        </div>
        <div class="flex items-center gap-4 shadow-md p-4">
            <div>
                <div class="w-12 h-12 bg-green-700 rounded-full flex justify-center items-center">
                    <i class="fa fa-check text-2xl" aria-hidden="true"></i>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex gap-2 items-center">
                    <h2 class="font-bold text-lg">Rating sent</h2>
                    <div class="w-20 py-1 px-1 text-center text-xs border-solid border-[1px] rounded-full border-yellow-500 text-yellow-500 hover:text-yellow-600 hover:border-yellow-600">
                        <span>In Reviews</span>
                    </div>
                </div>
                <p class="text-xs">Your rating will be processed anonymously. If you'd like to track the status of your reviews and manage future feedback, consider <a class="font-bold text-yellow-600" href="/log-in">creating an account</a> for seamless follow-ups.</p>
            </div>
        </div>
    </div>

    <script>
        function notificationComponent() {
            return {
                isAfter: false,
                init() {
                    // Detect "comment_posted=1" in the URL
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('comment_posted_anonymous') && urlParams.get('comment_posted_anonymous') === '1') {
                        this.isAfter = true; // Show the notification
                    }
                }
            }
        }
    </script>


<?php
}
