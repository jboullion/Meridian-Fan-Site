<?php

//define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/meridian/wp-load.php' );


global $wp_query;
$spell = get_post($_POST['id']);
$spell_options = get_fields($_POST['id']);

echo '<div class="entry" id="spell-entry">
        <div class="col-sm-4">
            <img id="featured-image" src="'.$spell_options['graphic']['url'].'" alt="'.$spell->post_title.'" title="'.$spell->post_title.'" />
        </div>

        <div class="col-sm-8">
            <h1>'.$spell->post_title.'</h1>'.apply_filters('the_content', $spell->post_content).'
            <p>It will cost you '.$spell_options['training_points'].' training points to improve in this skill.</p>
        </div>
        <br clear="both" />
    </div>';

//comments_template( );
/*
$page_id = $_POST['id'];
$page_url = get_permalink($page_id);
$page_title = $spell->post_title;
$disqus_script = <<<hd
<script type="text/javascript">
        DISQUS.reset({
          reload: true,
          config: function () {
            this.page.identifier = '$page_id';
            this.page.url = '$page_url';
            this.page.title = "$page_title";
          }
        });
</script>
hd;

echo $disqus_script;
*/