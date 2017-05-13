<?php

//Instead of loading all of wordpress I just want to load the $wpdb and as little as possible.
//REDUCED RESPONSE TIME FROM 1 second per call to about 100ms per call. so about 10 times faster
define( 'SHORTINIT', true );

require_once( $_SERVER['DOCUMENT_ROOT'] . '/meridian/wp-load.php' );

function m59_print($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

global $wpdb;

function m59_ajax_creatures($creatures){
    global $wpdb;
    $site_url = $wpdb->get_var("SELECT option_value as url FROM `{$wpdb->prefix}options` WHERE `option_name` = 'siteurl'");
    foreach ($creatures as $key => $creature) {
        $creature_hp = $wpdb->get_var("SELECT meta_value as hp FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'maximum_hp' AND `post_id` = ".$creature->ID);
        $creature_karma = $wpdb->get_var("SELECT meta_value as karma FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'max_karma' AND `post_id` = ".$creature->ID);
        $creature_graphic_id = $wpdb->get_var("SELECT meta_value FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'graphic' AND `post_id` = ".$creature->ID);
        $creature_graphic_src = $wpdb->get_var("SELECT guid as src FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'attachment' AND `ID` = ".$creature_graphic_id);

        echo '<div class="image-div creatures" data-name="' . $creature->post_title . '" data-id="' . $creature->ID . '" data-karma="' . $creature_karma . '" data-hp="' . $creature_hp . '">
              <a href="'. $site_url . '/creatures/'.$creature->post_name.'/">
                    <table class="img-wrap"><tr><td>';

        if (!empty($creature_graphic_src)) {

            echo '<img class="lazy" src="' . $creature_graphic_src . '"  alt="" />';
        }
        echo '</td></tr></table><p class="title">' . $creature->post_title . '<br /><small>Max HP: ' . $creature_hp . '<br />Max Karma: ' . $creature_karma . '</small></p>';
        echo '</a></div>';

    }
}

function m59_ajax_npcs($npcs){
    global $wpdb;
    $site_url = $wpdb->get_var("SELECT option_value as url FROM `{$wpdb->prefix}options` WHERE `option_name` = 'siteurl'");
    foreach ($npcs as $key => $npc) {

        $npc_graphic_id = $wpdb->get_var("SELECT meta_value FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'graphic' AND `post_id` = ".$npc->ID);
        $npc_graphic_src = $wpdb->get_var("SELECT guid as src FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'attachment' AND `ID` = ".$npc_graphic_id);

        echo '<div class="image-div npcs" data-name="' . $npc->post_title . '" data-id="' . $npc->ID . '">
              <a href="'. $site_url . '/npcs/'.$npc->post_name.'/">
                    <table class="img-wrap"><tr><td>';

        if (!empty($npc_graphic_src)) {

            echo '<img class="" src="' . $npc_graphic_src . '"  alt="" />';
        }
        echo '</td></tr></table><p class="title">' . $npc->post_title . '</p>';
        echo '</a></div>';

    }
}

function m59_ajax_locations($locations){
    global $wpdb;
    $site_url = $wpdb->get_var("SELECT option_value as url FROM `{$wpdb->prefix}options` WHERE `option_name` = 'siteurl'");
    foreach ($locations as $key => $loc) {

        $loc_graphic_id = $wpdb->get_var("SELECT meta_value FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'graphic' AND `post_id` = ".$loc->ID);
        $loc_graphic_src = $wpdb->get_var("SELECT guid as src FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'attachment' AND `ID` = ".$loc_graphic_id);

        echo '<div class="image-div locations" data-name="' . $loc->post_title . '" data-id="' . $loc->ID . '">
              <a href="'. $site_url . '/locations/'.$loc->post_name.'/">
              <table class="img-wrap"><tr><td>';

      if (!empty($loc_graphic_src)) {

        echo '<img class="" src="' . $loc_graphic_src . '"  alt="" />';
      }
      echo '</td></tr></table><p class="title">' . $loc->post_title . '</p>';
        echo '</a></div>';

    }
}


function m59_ajax_reagents($reagents){
    global $wpdb;
    $site_url = $wpdb->get_var("SELECT option_value as url FROM `{$wpdb->prefix}options` WHERE `option_name` = 'siteurl'");
    foreach ($reagents as $key => $reagent) {

        $reagent_graphic_id = $wpdb->get_var("SELECT meta_value FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'graphic' AND `post_id` = ".$reagent->ID);
        $reagent_graphic_src = $wpdb->get_var("SELECT guid as src FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'attachment' AND `ID` = ".$reagent_graphic_id);

        echo '<div class="image-div reagents" data-name="' . $reagent->post_title . '" data-id="' . $reagent->ID . '">
                <a href="'. $site_url . '/reagents/'.$reagent->post_name.'/">
                    <table class="img-wrap"><tr><td>';

        if (!empty($reagent_graphic_src)) {

            echo '<img class="" src="' . $reagent_graphic_src . '"  alt="" />';
        }
        echo '</td></tr></table><p class="title">' . $reagent->post_title . '</p>';
        echo '</a></div>';

    }
}

function m59_ajax_items($items){
    global $wpdb;
    $site_url = $wpdb->get_var("SELECT option_value as url FROM `{$wpdb->prefix}options` WHERE `option_name` = 'siteurl'");
    foreach ($items as $key => $item) {
        $post_type = $wpdb->get_var("SELECT post_type FROM `{$wpdb->prefix}posts` WHERE `ID` = ".$item->ID);
        if($post_type == 'items') {
            $item_type = $wpdb->get_var("SELECT meta_value as type FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'type' AND `post_id` = " . $item->ID);
        }else{
            $item_type = ucfirst($post_type);
        }

        //$item_weight = $wpdb->get_var("SELECT meta_value as karma FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'weight' AND `post_id` = ".$item->ID);

        $item_graphic_id = $wpdb->get_var("SELECT meta_value FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'graphic' AND `post_id` = ".$item->ID);
        $item_graphic_src = $wpdb->get_var("SELECT guid as src FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'attachment' AND `ID` = ".$item_graphic_id);

        echo '<div class="image-div items '.$item_type.'" data-type="'.$item_type.'" data-name="' . $item->post_title . '" data-id="' . $item->ID . '">
                <a href="'. $site_url . '/'.$post_type.'/'.$item->post_name.'/">
                    <table class="img-wrap"><tr><td>';

        if (!empty($item_graphic_src)) {

            echo '<img class="" src="' . $item_graphic_src . '"  alt="" />';
        }
        echo '</td></tr></table><p class="title"><small>Type: ' . $item_type . '</small><br />' . $item->post_title . '</p>';
        echo '</a></div>';

    }
}

function m59_ajax_basic($posts){
    global $wpdb;
    $site_url = $wpdb->get_var("SELECT option_value as url FROM `{$wpdb->prefix}options` WHERE `option_name` = 'siteurl'");
    foreach ($posts as $key => $post) {

        $graphic_id = $wpdb->get_var("SELECT meta_value FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'graphic' AND `post_id` = ".$post->ID);
        $graphic_src = $wpdb->get_var("SELECT guid as src FROM `{$wpdb->prefix}posts` WHERE `post_type` = 'attachment' AND `ID` = ".$graphic_id);

        echo '<div class="image-div '.strtolower($posts->post_title).'" data-name="' . $post->post_title . '" data-id="' . $post->ID . '">
                  <a href="'. $site_url . '/'.strtolower($posts->post_title).'/'.$post->post_name.'/">
                  <table class="img-wrap"><tr><td>';

        if (!empty($graphic_src)) {

            echo '<img class="" src="' . $graphic_src . '"  alt="" />';
        }
        echo '</td></tr></table><p class="title">' . $post->post_title . '</p>';
        echo '</a></div>';

    }
}




if(! empty($_POST['post_type'])) {

    $post_type = $_POST['post_type'];
    $post_type = str_replace('\\', '',$post_type);
    $get_ids = "SELECT {$wpdb->prefix}posts.ID
                                  FROM {$wpdb->prefix}posts
                                  WHERE {$wpdb->prefix}posts.post_type IN ( '".$post_type."' )
                                  AND {$wpdb->prefix}posts.post_status = 'publish'";

    $ids = $wpdb->get_results($get_ids);

    $ids_array = array();
    foreach ($ids as $key => $id) {
        $ids_array[] = $id->ID;
    }

    $get_posts = "SELECT {$wpdb->prefix}posts.* FROM {$wpdb->prefix}posts WHERE ID IN (" . implode(",", $ids_array) . ")
                  ORDER BY {$wpdb->prefix}posts.post_title ASC";

    $posts = $wpdb->get_results($get_posts);

    if (!empty($posts)) {

        switch($_POST['post_type']) {
            //CREATURES
            case 'creatures':
                m59_ajax_creatures($posts);
                break;
            //ITEMS
            case substr($post_type, 0, 5) == 'items':
                m59_ajax_items($posts);
                break;
            //LOCATIONS
            case 'locations':
                m59_ajax_locations($posts);
                break;
            default:
                m59_ajax_basic($posts);
        }
    } else {
        echo 'empty';
    }
}
exit;
