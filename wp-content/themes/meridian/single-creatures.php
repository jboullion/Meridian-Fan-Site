<?php get_header(); the_post();

$creature_options = get_fields();

do_action('m59-begin-content');
?>

    <div class="entry">
        <?php echo '<div class="col-sm-4"><img id="featured-image" src="'.$creature_options['graphic']['url'].'" alt="'.$post->post_title.'" title="'.$post->post_title.'" /></div>'; ?>
        <?php
            echo '<div class="col-sm-8">
                  <h1>'.get_the_title().'</h1>
                  <p>HP: '.$creature_options['maximum_hp'].' <span class="spacer"></span> KARMA: '.$creature_options['max_karma'].'</p>';

            the_content();

            echo '<p>This monster is level '.$creature_options['level'].'.</p>';

            echo '</div><br clear="both" /><br />';
            echo '<div class="col-sm-6"><h3>Locations</h3>';
            echo '<ul id="locations" class="no-bullets no-margin">';
            if(! empty($creature_options['locations'])) {
                foreach ($creature_options['locations'] as $key => $location) {
                    echo '<li><a href="'.get_permalink($location['location']->ID).'">' . $location['location']->post_title . '</a></li>';
                }
            }
            echo '</ul></div>';

            echo '<div class="col-sm-6"><h3>Drops</h3>';
            echo '<ul id="listings" class="no-bullets no-margin">';
            if(! empty($creature_options['drops'])) {
                foreach ($creature_options['drops'] as $key => $drop) {
                    $drop_options = get_fields($drop['drop']->ID);
                    echo '<li><a href="'.get_permalink($drop['drop']->ID).'"><img class="list-img" src="' . $drop_options['graphic']['url'] . '" alt="' . $drop['drop']->post_title . '"/>' . $drop['drop']->post_title . '</a></li>';
                }
            }
            echo '</ul></div>';

            if(! empty($creature_options['comments'])){
              echo '<div class="col-xs-12">
                      <h3>Comments</h3>
                      '.apply_filters('the_content', $creature_options['comments']).'
                    </div>';
            }
        ?>
        <br clear="both" />
    </div>
<?php
//m59_show_comments();
do_action('m59-end-content');
get_footer(); ?>
