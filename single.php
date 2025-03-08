<?php require_once get_stylesheet_directory() . "/components/single/single-profile.php"; ?>
<?php require_once get_stylesheet_directory() . "/components/commons/notification.php"; ?>



<?php get_header(); ?>
<div id="wptime-plugin-preloader"></div>
<?php echo SingleProfile(); ?>

<?php if (!is_user_logged_in()) {
    Notification();
} ?>

<?php if (comments_open() && !post_password_required()) {
    comments_template('', true);
} ?>

<!-- Save in localStorage -->
<div x-data="storageValidation()" x-init="init()">
    <script>
        function storageValidation() {
            return {
                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('comment_posted_anonymous') && urlParams.get('comment_posted_anonymous') === '1') {
                        const postId = <?php echo get_the_ID(); ?>;
                        let postIds = JSON.parse(localStorage.getItem('posts_rated')) || [];
                        if (!postIds.includes(postId)) {
                            postIds.push(postId);
                            localStorage.setItem('posts_rated', JSON.stringify(postIds));
                            window.location.reload();
                        }
                    }
                }
            }
        }
    </script>
</div>

<?php get_footer(); ?>