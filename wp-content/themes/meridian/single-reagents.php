<?php get_header(); the_post();

$reagents_options = get_fields();

do_action('m59-begin-content');
?>


    <div class="entry">
        <?php echo '<div class="col-sm-4"><img id="featured-image" src="'.$reagents_options['graphic']['url'].'" alt="'.$post->post_title.'" title="'.$post->post_title.'" /></div>'; ?>
        <div class="col-sm-8"> <h1><?php the_title(); ?></h1>
        <?php

            the_content();

        ?>
        </div>
        <br clear="both" />
    </div>
<?php
//m59_show_comments();
do_action('m59-end-content');
get_footer(); ?>
