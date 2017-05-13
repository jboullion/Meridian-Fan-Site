<?php get_header(); the_post();

do_action('m59-begin-content');
?>
  <h1><?php the_title(); ?></h1>
    <div class="entry">

        <?php the_content(); ?>
    </div>
<?php
do_action('m59-end-content');
get_footer(); ?>
