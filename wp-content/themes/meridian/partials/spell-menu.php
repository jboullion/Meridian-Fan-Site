<?php
global $school;
$meta_query[] = array(	'key'     => 'school',
    'value'   => $school,
    'compare' => 'LIKE');

$args = array(
    'posts_per_page'=> -1,
    'orderby'       => 'title',
    'order'         => 'ASC',
    'post_type'     => 'spells',
    'meta_query' 	=> $meta_query
);

$unordered_spells = get_posts($args);

// m59_print($unordered_spells);

$spells = array();
foreach($unordered_spells as $key => $spell){
    //$spell_fields = get_fields($spell->ID);
    //$spells[(int)$spell_fields['level']][] = array_merge((array)$spell,$spell_fields );
    $spell_fields = get_field('level',$spell->ID);
    $spells[(int)$spell_fields][] = $spell;
}

ksort($spells);

echo '<div class="open-spells-div desktop-hide"><button id="open-spells" class="button full-width">'.$school.'</button></div>';

echo '<div id="screen-shade"></div>';
echo '<div id="spell-menu" class="col-md-3">';
echo '<h1>'.$school.'</h1>';
foreach($spells as $level => $spell_level){
    echo '<ul class="school-levels"><li><h3>Level '.$level.'</h3><ul>';
    //m59_print( $spell_level);
    foreach($spell_level as $skey => $spell) {
        $spell_icon = get_field('menu_icon',$spell->ID);
        $spell_img = '';
        if(! empty($spell_icon['url'])){
            $spell_img = '<img class="spell-icon" src="'.$spell_icon['url'].'" alt="'.$spell->post_title.'" />';
        }
        echo '<li><a href="'.get_permalink($spell->ID).'">'.$spell_img.''.$spell->post_title.'</a></li>';
    }

    echo '</ul></li></ul>';
}

echo '<br clear="both" /></div>';
