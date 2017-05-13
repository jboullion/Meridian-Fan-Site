<?php
/* Template Name: Single School Template */

get_header(); the_post();

do_action('m59-begin-content');
?>
<div class="row">
    <div id="spells-wrap">
        <?php
            global $school;
            $school = $post->post_title;

            m59_get_partial('spell-menu');

            echo '<div class="col-md-8" id="entry-target">';
                //m59_display_spell_entry(605);
            echo '</div>';

        ?>
        <br clear="both" />
    </div>
</div>

<script>
    jQuery(document).ready(function($){
        //$( "#objectID" ).load( "test.php", { "choices[]": [ "Jon", "Susan" ] } );
        /*
        $('ul.school-levels a').tclick(function(e){
            e.preventDefault();
            var targetID = $(this).attr('data-target');
            $.ajax({
                type: 'POST',
                url: '/meridian/wp-admin/admin-ajax.php',
                data: 'action=m59load_spell&ID='+targetID,
                success: function(data){
                    $('#entry-target').html(data);
                }
            });
        });*/
        //GET AJAX CALL INFORMATION FROM SPECIAL OLYMPICS / CENTURY HOUSE SITE
    });
</script>
<?php
do_action('m59-end-content');
get_footer(); ?>