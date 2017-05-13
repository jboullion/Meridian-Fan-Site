<?php
get_header(); the_post();

do_action('m59-begin-content');
?>
    <div class="row">
        <div id="spells-wrap">
            <?php
            global $school;
            $school = get_field('school',$post->ID);

            m59_get_partial('spell-menu');

            echo '<div class="col-md-8 entry-target strip-padding" id="entry-target">';
            m59_display_spell_entry($post->ID);
            //m59_show_comments();
            //comments_template( );
            echo '</div>';

            ?>
            <br clear="both" />
        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            //TODO: SEE disqus-comment-system\disqus.php
/*
            loadSpell('<?php echo $post->ID; ?>');

            function loadSpell(postID) {
                $.post("<?php echo get_template_directory_uri(); ?>/ajax/return_spell.php", {id: postID})
                    .done(function( data ) {
                        $(".entry-target").html(data);



                    });//post
            }//loadSpell
            */
        });//jQuery
    </script>
<?php

do_action('m59-end-content');
get_footer(); ?>
