<?php function StarsFilter()
{
?>
    <div class="w-full">

        <h2 class="text-xl font-bold mb-4">Filter by Stars</h2>
        <div class="flex flex-col">
            <template x-for="stars in [5, 4, 3, 2, 1]" :key="stars">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-background px-4 py-2 rounded-full">
                    <input
                        type="checkbox"
                        name="stars"
                        :value="stars"
                        :checked="selectedStars == stars"
                        class="w-5 h-5 border-2 border-gray-600 rounded-full appearance-none  focus:outline-none relative"
                        @change="toggleStarFilter(stars)" />
                    <div class="flex items-center gap-2">
                        <span x-text="stars"></span>
                        <span>Stars</span>
                        <span>&#9733;</span>
                    </div>
                </label>
            </template>
        </div>


        <script>
            function toggleStarFilter(stars) {
                const url = new URL(window.location.href);
                const currentStars = url.searchParams.get('stars');

                // Si ya está seleccionado el mismo valor, desmarcarlo
                if (currentStars === String(stars)) {
                    url.searchParams.delete('stars');
                } else {
                    // De lo contrario, seleccionar el nuevo filtro
                    url.searchParams.set('stars', stars);
                }

                // Asegurarse de que sólo un filtro esté activo
                document.querySelectorAll('input[name="stars"]').forEach((checkbox) => {
                    if (checkbox !== event.target) {
                        checkbox.checked = false;
                    }
                });

                // Redirigir con la nueva URL
                window.location.href = url.toString();
            }
        </script>
    </div>
<?php
}
