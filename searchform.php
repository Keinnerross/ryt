<form role="search" method="get" class="search-form md:w-[400px] flex  items-center gap-2 bg-white px-4 py-2 rounded-full" action="<?php echo esc_url(home_url('/')); ?>">
    <i class="fa fa-search text-myBlack" aria-hidden="true"></i>
    <label class="w-full">
        <input type="search" placeholder="Search a therapist" class="w-full search-field outline-none text-text-light text-base tracking-tight font-medium" value="<?php echo get_search_query(); ?>" name="s" title="Search for:" id="search-input" />
    </label>

    <button type="submit" class="search-submit rounded-full bg-myBlack text-sm font-medium px-4 py-2 tracking-tight">
        Search
    </button>

    <!-- Contenedor donde se aplicará Type.js -->
</form>