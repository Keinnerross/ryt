<?php 

function SaveButton()
{
    global $post;
    $user_id = get_current_user_id();
    $favoritos = get_user_meta($user_id, 'therapists_saved', true);

    $is_favorite = in_array($post->ID, (array)$favoritos); // Asegurarse de que favoritos sea un array

?>
    <div x-data="{ isSave: <?php echo $is_favorite ? 'true' : 'false'; ?> }" class="cursor-pointer text-lg" x-on:click.prevent="toggleFavorito(<?php echo $post->ID; ?>)">
        <i x-show="isSave" class="fa fa-bookmark" aria-hidden="true" x-on:click="isSave = false"></i>
        <i x-show="!isSave" class="fa fa-bookmark-o text-gray-400" aria-hidden="true" x-on:click="isSave = true"></i>
    </div>

    <script>
        function toggleFavorito(entryId) {
            jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'save_entry_user',
                    entry_id: entryId
                },
                success: function(response) {
                    console.log("Favorito guardado!");
                    // Agregar Notificaciones de guardado
                },
                error: function() {
                    alert("Hubo un error al guardar el favorito.");
                }
            });
        }
    </script>
<?php
}
