<?php
function CategoriesFilter() {
    // Obtener todas las especialidades (taxonomía 'specialties')
    $specialties = get_terms([
        'taxonomy' => 'specialties',  // Cambiar por el nombre de tu taxonomía personalizada
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
    ]);

    if ($specialties) :
    ?>
        <div class="w-full">
            <h2 class="text-xl font-bold mb-3">Explore Specialties</h2>
            <ul class="flex flex-col text-base font-medium text-text-dark">
                <?php foreach ($specialties as $specialty) : ?>
                    <li class="py-1 px-4 hover:bg-background cursor-pointer rounded-full w-full">
                        <a href="<?php echo esc_url(get_term_link($specialty)); ?>">
                            <?php echo esc_html($specialty->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php
    endif;
}
