<?php
/* Template Name: Downloads Template */
  get_header();
  the_post();
  $downloads = get_field('downloads');
  do_action('m59-begin-content');
?>
  <h1><?php the_title(); ?></h1>
    <div class="entry" id="downloads">
        <?php the_content(); ?>
        <?php
            if(! empty($downloads)):
              foreach($downloads as $download):
                echo '<div class="download">
                      <h4>'.$download['title'].'</h4>
                      <span class="author">Author: '.$download['author'].'</span>
                      '.$download['description'].'
                      <a href="'.$download['file']['url'].'" download>'.$download['file']['filename'].'</a>
                    </div>';
              endforeach;
            endif;
          ?>
    </div>
<?php
do_action('m59-end-content');
get_footer(); ?>
