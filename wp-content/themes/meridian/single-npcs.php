<?php get_header(); the_post();

$options = get_fields();

do_action('m59-begin-content');
?>
    <div class="entry">
        <?php echo '<div class="col-sm-4"><img id="featured-image" src="'.$options['graphic']['url'].'" alt="'.$post->post_title.'" title="'.$post->post_title.'" /></div>'; ?>
        <div class="col-sm-8"> <h1><?php the_title(); ?></h1>
            <?php

            the_content();

            ?>
        </div>
        <br clear="both" />
        <br />
        <?php
          echo '<div class="col-sm-6"><h3>Location</h3>';

          if(! empty($options['location'])) {
              echo '<p><a href="'.get_permalink($options['location']->ID).'">' . $options['location']->post_title . '</a></p>';
          }
          echo '</div>';

          echo '<div class="col-sm-6"><h3>Sells</h3>';
          echo '<ul id="listings" class="no-bullets no-margin">';
          if(! empty($options['items_sold'])) {
              foreach ($options['items_sold'] as $key => $item) {
                  $item_options = get_fields($item['item']->ID);
                  echo '<li><a href="'.get_permalink($item['item']->ID).'"><img class="list-img" src="' . $item_options['graphic']['url'] . '" alt="' . $item['item']->post_title . '"/>' . $item['item']->post_title . '</a></li>';
              }
          }
          if(! empty($options['reagents_sold'])) {
              foreach ($options['reagents_sold'] as $key => $reagent) {
                  $reagent_options = get_fields($reagent['reagent']->ID);
                  echo '<li><a href="'.get_permalink($reagent['reagent']->ID).'"><img class="list-img" src="' . $reagent_options['graphic']['url'] . '" alt="' . $reagent['reagent']->post_title . '"/>' . $reagent['reagent']->post_title . '</a></li>';
              }
          }
          echo '</ul></div>';

          if(! empty($options['comments'])){
            echo '<div class="col-xs-12">
                    <h3>Comments</h3>
                    '.apply_filters('the_content', $options['comments']).'
                  </div>';
          }
        ?>
        <br clear="both" />
    </div>
<?php
//m59_show_comments();
do_action('m59-end-content');
get_footer(); ?>
