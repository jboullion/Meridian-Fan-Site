<?php
/* Template Name: NPC Template */

get_header(); the_post();

function display_npc($args){
    global $lazy_count;
    $npcs = get_posts($args);

    //m59_print($creature_array);
    if(! empty($npcs)) {

        $lazy_load = "";
        foreach ($npcs as $key => $npc) {
            $npc_options = get_fields($npc->ID);

            if($lazy_count++ > 10){
                $lazy_load = "lazy";
            }

            echo '<div class="image-div">

                        <div class="img-wrap"><a href="' . get_permalink($npc->ID) . '">';

            if (!empty($npc_options['graphic']['url'])) {

                echo '<img class="'.$lazy_load.'" data-original="' . $npc_options['graphic']['sizes']['medium'] . '" '.($lazy_load == ""? 'src="' . $npc_options['graphic']['sizes']['medium'] . '"':"").'  alt="" />';
            }
            echo '</a></div><p class="title">' . $npc->post_title . '</p>';

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
                'post_type'     => 'npcs',
                'post_status'   => 'publish'
            );

            display_npc($args);

        ?>
        <br clear="both" />
    </div>
<?php
do_action('m59-end-content');
get_footer();
