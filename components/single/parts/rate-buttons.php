<?php
function RateButtons()
{
    $post_id = get_the_ID();
    $user_id = get_current_user_id();





    if (!is_user_logged_in()) {
?>
        <div x-data="{ hasRated: false }" x-init="hasRated = (JSON.parse(localStorage.getItem('posts_rated')) || []).includes(<?php echo $post_id; ?>);">
            <button
                :class="hasRated ? 'bg-gray-200 hover:bg-gray-300 transform transition-all text-gray-400 cursor-pointer' : 'bg-primary text-myWhite'"
                class="py-3 font-medium rounded-full w-[200px]"
                x-text="hasRated ? 'Already Rated' : 'Rate therapist'"
                x-on:click="if (!hasRated) { isCommentForm = true; }"></button>

        </div>
<?php
        return;
    }

    if ($user_id) {
        $comments = get_comments([
            'post_id' => $post_id,
            'user_id' => $user_id,
        ]);

        if (!empty($comments)) {
            echo '<button class="bg-gray-200 hover:bg-gray-300 transform transition-all py-3 font-medium rounded-full text-gray-400 w-[200px] cursor-pointer">Already Rated</button>';
        } else {
            echo '<button x-on:click="isCommentForm = true" class="bg-primary py-3 font-medium rounded-full text-myWhite w-[200px]">Rate therapist</button>';
        }
    }
}
?>