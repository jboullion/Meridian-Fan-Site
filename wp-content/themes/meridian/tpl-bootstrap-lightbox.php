<?php
/* Template Name: Bootbox Template */

get_header(); the_post();
$meridian_page_options = get_fields();

do_action('m59-begin-content');



function m59_ajax_npcs($npcs){
    global $wpdb;

    foreach ($npcs as $key => $npc) {
        $npc_fields = get_fields($npc->ID);
        echo '<a id="gallery-image-'.$key.'" data-key="'.$key.'" data-href="'.$npc_fields['graphic']['url'].'" data-toggle="modal"  data-title="Data Title '.$key.'"><div class="image-div creatures" data-name="' . $npc->post_title . '" data-id="' . $npc->ID . '">
                    <table class="img-wrap"><tr><td>';

        if (!empty($npc_fields['graphic']['url'])) {

            echo '<img class="" src="' . $npc_fields['graphic']['url'] . '"  alt="" />';
        }
        echo '</td></tr></table><p class="title">' . $npc->post_title . '</p>';
        echo '</div></a>';

    }
}
?>

    <div class="">
        <?php the_content(); ?>
    </div>

    <div id="images-wrap" class="gallery-items">
        <?php

            $args = array(
                'posts_per_page'   => 10,
                'post_type'        => 'npcs',
            );
            $posts = get_posts($args);
            m59_ajax_npcs($posts);


        ?>
    </div>
    <script>

        jQuery(document).ready(function($){

            $('.gallery-items > a').bind(bind,function(e){
                e.preventDefault();
                var target = $(this);
                setModalContent(target);
                console.log('test');
            });

            $('#gallery-modal .modal-control').bind(bind,function(e){
                var imageKey = parseInt($(this).attr('data-key'));
                var target = $('.grid-item #gallery-image-'+imageKey);
                setModalContent(target);
            });

            var wrapper = jQuery('#images-wrap');
            wrapper.append('<div class="modal fade" id="gallery-modal">'+
            '<div class="modal-dialog">'+
            '<div class="modal-content">'+
            '<div class="modal-header">'+
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<h4 class="modal-title"></h4>'+
            '</div>'+
            '<div class="modal-body">'+
            '<img id="modal-image" src="" />'+
            '<a class="modal-control prev" data-key="">'+
            '<i class="fa fa-chevron-left"></i>'+
            '</a>'+
            '<a class="modal-control next" data-key="">'+
            '<i class="fa fa-chevron-right"></i>'+
            '</a></div></div></div></div>');
        });

        function setModalContent(target){

            jQuery('#gallery-modal .modal-title').html(target.attr('data-title'));
            jQuery('#gallery-modal #modal-image').attr('src',target.attr('data-href'));

            //may want to set a loading image here and then hide it when the image is loaded in case there is a rather large image that takes a while to load.
            //$('#loading-gif').show();

            // Get on screen image
            jQuery("#gallery-modal #modal-image").load(function(){
                //$('#loading-gif').hide();

                var screenImage = jQuery("#gallery-modal #modal-image");

                // Create new offscreen image to test
                var theImage = new Image();
                theImage.src = screenImage.attr("src");

                // Get accurate measurements from that.
                var imageWidth = theImage.width + 30; //15px padding on each side
                var imageHeight = theImage.height;

                jQuery('#gallery-modal .modal-dialog').css({width:imageWidth});

                var imageKey = parseInt(target.attr('data-key'));    //target.index( this )
                var items = jQuery('.grid-item').length - 1;

                if(imageKey > 0){
                    var prevKey = parseInt(imageKey) - 1;
                }else{
                    var prevKey = items;
                }

                if(imageKey < items){
                    var nextKey = parseInt(imageKey) + 1;
                }else{
                    var nextKey = 0;
                }

                jQuery('#gallery-modal .modal-control.prev').attr('data-key', prevKey);
                jQuery('#gallery-modal .modal-control.next').attr('data-key', nextKey);
            });

        }

    </script>

<?php
do_action('m59-end-content');
get_footer(); ?>