<?php
/* Template Name: Location Template */

get_header(); the_post();
$meridian_page_options = get_fields();

function display_locations($args){

    $locations = get_posts($args);

    if(! empty($locations)) {

        foreach ($locations as $key => $location) {
            $location_options = get_fields($location->ID);

            echo '<div class="image-div">
                    <div class="img-wrap"><a href="' . get_permalink($location->ID) . '">';

            if (!empty($location_options['graphic']['sizes']['medium'])) {
                echo '<img src="' . $location_options['graphic']['sizes']['medium'] .'"  alt="" />';
            }
            echo '</a></div><p class="title">' . $location->post_title . '</p>';

            echo '</div>';
        }
    }
}

do_action('m59-begin-content');

?>

    <div class="">
        <?php //the_content(); ?>
    </div>

    <div class="sort-btns">
      <div id="refine">
        <label>Find:</label>
        <input type="text" name="content-search" value="" id="content-search" />
      </div>
    </div>

    <div id="images-wrap">
      <?php

          $args = array(
              'posts_per_page'=> -1,
              'orderby'       => array('post_title' => 'ASC'),
              'post_type'     => 'locations',
              'post_status'   => 'publish'
          );

          display_locations($args);

      ?>
    </div>
    <script>

        jQuery(document).ready(function($) {
            //loadContent('locations', null);
        });
    </script>
<?php
do_action('m59-end-content');
get_footer(); ?>
