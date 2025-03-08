<?php function SearchHome()
{
?>
    <form role="search" method="get" class="w-[90vw] md:w-[600px] search-form flex items-center gap-2 bg-white px-4 py-2 rounded-full" action="<?php echo esc_url(home_url('/')); ?>">
        <i class="fa fa-search text-myBlack" aria-hidden="true"></i>
        <label class="w-full">
            <input type="search" placeholder="Search a therapist" class="w-full search-field outline-none text-text-light text-base tracking-tight font-medium" value="<?php echo get_search_query(); ?>" name="s" title="Search for:" id="search-input" />
        </label>
        <button type="submit" class="search-submit rounded-full bg-myBlack text-sm font-medium px-4 py-2 tracking-tight">
            Search
        </button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

    <script>
        var options = {
            strings: ["Search by therapist name", "Find a therapist by zip code", "Search by state"], 
            typeSpeed: 50,
            backSpeed: 50,
            backDelay: 1000,
            loop: true,
        };
        var typed = new Typed("#search-input", options);
        var searchInput = document.getElementById("search-input");

        searchInput.addEventListener("focus", function() {
            typed.destroy();
            this.id = "search-input-focused";
            this.classList.remove("text-text-light");
            this.classList.add("text-text");
        });
    </script>

<?php
}
