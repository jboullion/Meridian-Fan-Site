<?php
/* Template Name: Homepage Template */

get_header();
the_post();

do_action('m59-begin-content');
?>
    <div class="entry">
        <?php the_content(); ?>
    </div>
<?php
do_action('m59-end-content');
get_footer(); ?>
