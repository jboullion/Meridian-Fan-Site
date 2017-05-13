<?php
/* Template Name: Reagents Template */

get_header(); the_post();

function display_reagents($args){
    global $lazy_count;
    $reagents = get_posts($args);

    //m59_print($creature_array);
    if(! empty($reagents)) {

        $lazy_load = "";
        foreach ($reagents as $key => $reagent) {

            if($lazy_count++ > 10){
                $lazy_load = "lazy";
            }

            $reagent_options = get_fields($reagent->ID);

            echo '<div class="image-div reagents">

                        <table class="img-wrap"><tr><td><a href="' . get_permalink($reagent->ID) . '">';

            if (!empty($reagent_options['graphic']['url'])) {

                echo '<img class="'.$lazy_load.'" data-original="' . $reagent_options['graphic']['sizes']['medium'] . '" '.($lazy_load == ""? 'src="' . $reagent_options['graphic']['sizes']['medium'] . '"':"").'  alt="" />';
            }
            echo '</a></td></tr></table><p class="title">' . $reagent->post_title . '</p>';

            echo '</div>';
        }
    }
}

do_action('m59-begin-content');
?>

    <div class="">
        <?php the_content(); ?>
    </div>

    <div id="images-wrap">
        <?php

            $args = array(
                'posts_per_page'=> -1,
                'orderby'       => array('post_title' => 'ASC'),
                'post_type'     => 'reagents',
                'post_status'   => 'publish'
            );

            display_reagents($args);

        ?>
        <br clear="both" />
    </div>
<?php
do_action('m59-end-content');
get_footer();
