<?php
function Graphic()
{
    $post_id = get_the_ID();
    $comments = get_comments(array('post_id' => $post_id, 'status' => 'approve'));
    $total_stars = 0;
    $comment_count = 0;
    $star_count = [0, 0, 0, 0, 0]; 

    foreach ($comments as $comment) {
        $rate = get_comment_meta($comment->comment_ID, 'rate', true);
        if ($rate) {
            $total_stars += (int) $rate;
            $comment_count++;
            $star_count[$rate - 1]++;
        }
    }

    // Calculamos los porcentajes
    $percentages = [];
    for ($i = 0; $i < 5; $i++) {
        $percentages[$i] = $comment_count > 0 ? ($star_count[$i] / $comment_count) * 100 : 0;
    }
?>

    <div class="w-full max-w-lg mx-auto">
        <div class="flex flex-col">
            <h2 class="text-text-light pb-4 text-lg font-medium">Percentage of stars received</h2>

            <div class="flex">
                <div class="flex flex-col space-y-3 pt-4">
                    <?php for ($i = 5; $i >= 1; $i--) : ?>
                        <span class="w-8 text-sm font-medium"><?php echo $i; ?> ★</span>
                    <?php endfor; ?>
                </div>
                <div class="flex flex-col space-y-2 w-full border-l-[4px] border-b-[4px] border-solid border-background rounded-bl-xl px-2 py-4">

                    <?php for ($i = 5; $i >= 1; $i--) : ?>
                        <div class="flex items-center ">
                            <div class="flex-1 mx-2 bg-gray-200 h-6 rounded">
                                <div id="bar-<?php echo $i; ?>" class="rounded h-6" style="width: <?php echo $percentages[$i - 1]; ?>%; background-color: <?php echo getBarColor($i); ?>;"></div>
                            </div>
                            <div class="w-8 text-right">
                                <span id="percentage-<?php echo $i; ?>" class="text-sm font-medium"><?php echo round($percentages[$i - 1], 1); ?>%
                                </span>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>

            <div class="flex justify-between pl-10 pt-2">
                <span class="text-lg font-medium text-text-light">0%</span>
                <span class="text-lg font-medium text-text-light">50%</span>
                <span class="text-lg font-medium text-text-light">100%</span>
            </div>

        </div>

    </div>

<?php
}

// Función que devuelve el color de cada barra basado en la estrella
function getBarColor($stars)
{
    switch ($stars) {
        case 5:
            return '#4CAF50'; // 5 estrellas
        case 4:
            return '#2196F3';
        case 3:
            return '#FF9800';
        case 2:
            return '#FFC107'; 
        case 1:
            return '#F44336'; 
        default:
            return '#BDBDBD'; 
    }
}
?>