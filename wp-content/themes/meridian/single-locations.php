<?php get_header(); the_post();

$options = get_fields();

do_action('m59-begin-content');
?>
    <div class="entry">
        <?php
          echo '<div class="col-xs-12">
                  <h1>'.get_the_title().'</h1>
                  <img id="featured-image" src="'.$options['graphic']['url'].'" alt="'.$post->post_title.'" title="'.$post->post_title.'" />
                  '.apply_filters('the_content', get_the_content()).'
                </div>';
        ?>
        <br clear="both" />
    </div>
<?php
//m59_show_comments();
do_action('m59-end-content');
get_footer(); ?>
