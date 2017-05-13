<?php
get_header(); the_post();

do_action('m59-begin-content');
?>
<div class="videoWrapper">
  <iframe src="https://www.youtube.com/embed/8x3JiS6EIz0?feature=oembed" frameborder="0" allowfullscreen=""></iframe>
</div>
<div class="entry">
        <?php the_content(); ?>
    </div>
<?php
do_action('m59-end-content');
get_footer(); ?>
