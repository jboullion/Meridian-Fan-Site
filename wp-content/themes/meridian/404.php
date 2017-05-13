<?php get_header(); the_post();
//TODO: Setup a check for wp-admin.php and redirect
do_action('m59-begin-content');
?>
    <h1>404 Error</h1>

    <div class="entry">
        You are unable to go anywhere.
    </div>
<?php
do_action('m59-end-content');
get_footer(); ?>