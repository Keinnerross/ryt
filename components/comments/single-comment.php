<?php
function SingleComment($args, $depth)
{
    $defaultProfilePicture = get_stylesheet_directory_uri() . "/assets/default-profile.jpg";
    $defaultProfilePicture2 = get_stylesheet_directory_uri() . "/assets/default-profile.webp";

    $comment_id = get_comment_ID();
    $user_id = get_current_user_id();
    $user_votes = get_comment_meta($comment_id, 'user_votes', true);
    $user_has_voted = is_array($user_votes) && in_array($user_id, $user_votes);

    $useful = get_comment_meta($comment_id, 'useful', true);
    $ifAnonymous = get_comment_meta($comment_id, 'anonymous', true);
    $rate = get_comment_meta($comment_id, 'rate', true);
    $useful = ($useful !== '' && $useful !== false) ? $useful : 0;
    $comment = get_comment($comment_id);
    $author_id = $comment->user_id;
    $attachment_id = get_user_meta($author_id, 'profile_picture', true);
    $profile_picture_url = wp_get_attachment_url($attachment_id);
    $content = $comment->comment_content;
?>
    <li x-data="{ 
                currentUseful: <?php echo $useful; ?>, 
                user_has_voted: <?php echo $user_has_voted ? 'true' : 'false'; ?>,
                toggleVote() {
                    if (this.user_has_voted) {
                        this.currentUseful--;
                    } else {
                        this.currentUseful++;
                    }
                    this.user_has_voted = !this.user_has_voted;

                    this.updateVoteInDatabase(); // Llamamos a la función para actualizar el voto en la base de datos
                },
                async updateVoteInDatabase() {
                    const commentId = '<?php echo $comment_id; ?>';
                    const response = await fetch('/wp-admin/admin-ajax.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            action: 'toggle_vote',
                            comment_id: commentId,
                            user_has_voted: this.user_has_voted,
                        })
                    });
                    const data = await response.json();
                    if (data.success) {
                        console.log('Voto actualizado correctamente');
                    } else {
                        console.log('Hubo un error al actualizar el voto');
                    }
                }
            }"
        class="mb-10" id="comment-<?php comment_ID(); ?>">

        <!-- User Dates -->
        <div class="flex justify-between">
            <div id="user-data" class="flex gap-2 items-center">
                <div class="w-14 h-14 rounded-full overflow-hidden">
                    <?php
                    if ($ifAnonymous) {
                        echo '<img src="' . $defaultProfilePicture2 . '" alt="User Avatar" class="object-cover" />';
                    } else {
                        echo '<img src="' . ($profile_picture_url ? $profile_picture_url : $defaultProfilePicture) . '" alt="User Avatar" class="object-cover" />';
                    }
                    ?>
                </div>

                <p class="text-xl font-medium">
                    <?php
                    if ($ifAnonymous) {
                        echo "Anonymous";
                    } else {
                        echo get_comment_author();
                    }
                    ?>
                </p>
            </div>
            <div class="hover:bg-background cursor-pointer text-text-lightX2 text-sm flex w-7 h-7 justify-center items-center rounded-full">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </div>
        </div>

        <!-- Stars -->
        <div id="stars-container" class="text-lg mt-2">
            <?php
            if ($rate > 0) {
                $full_stars = floor($rate);
                $half_star = ($rate - $full_stars) >= 0.5;
                $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                for ($i = 0; $i < $full_stars; $i++) {
                    echo '<i class="fa fa-star text-amber-400"></i>';
                }
                if ($half_star) {
                    echo '<i class="fa fa-star-half-alt text-amber-400"></i>';
                }
                for ($i = 0; $i < $empty_stars; $i++) {
                    echo '<i class="fa fa-star-o text-gray-400"></i>';
                }
            } else {
                for ($i = 0; $i < 5; $i++) {
                    echo '<i class="fa fa-star-o text-gray-400"></i>';
                }
            }
            ?>
        </div>

        <!-- Comment Status -->
        <div id="status" class="py-1">
            <?php if ($comment->comment_approved === '0') : ?>
                <div class="w-20 py-1 px-1 text-center text-xs border-solid border-[1px] rounded-full border-yellow-500 text-yellow-500 hover:text-yellow-600 hover:border-yellow-600">
                    <span>In Reviews</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Comment review -->
        <div class="py-1">
            <p class="text-sm"><?php echo $content ?></p>
        </div>

        <div class="text-xs text-gray-500 pb-2"><?php echo get_comment_date(); ?></div>

        <!-- Useful Count -->
        <div class="pb-1">
            <span class=" text-xs"  x-text="currentUseful === 1 ? currentUseful + ' person found this review helpful' : (currentUseful >= 2 ? currentUseful + ' people found this review helpful' : '')"></span>
        </div>

        <!-- Useful Controllers -->
        <?php if ($comment->comment_approved === '1') : ?>
            <div class="flex items-center text-xs gap-1">
                <p>Did you find it useful?</p>
                <?php
                if (!is_user_logged_in()) {
                ?>
                    <a href="/log-in" class="bg-gray-50 border-[1px] border-solid border-text-light text-xs font-medium hover:bg-gray-300 px-2 rounded-full">
                        yes
                    </a>
                <?php
                } else {
                ?>
                    <button
                        x-on:click="toggleVote()"
                        :class="{
                            'text-green-700 bg-gray-200 border-gray-200  font-semibold': user_has_voted,
                            'bg-gray-50  border-text-light ': !user_has_voted,
                            'text-xs font-medium hover:bg-gray-300 px-2 rounded-full border-[1px] border-solid' : true
                        }">
                        yes
                    </button>

                <?php
                }
                ?>
            </div>
        <?php endif; ?>
    </li>

<?php
}
?>