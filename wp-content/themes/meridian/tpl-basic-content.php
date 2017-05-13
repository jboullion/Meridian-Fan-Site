<?php
/* Template Name: Basic Content Template */

get_header(); the_post();
$meridian_page_options = get_fields();

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
    </div>
    <script>

        jQuery(document).ready(function($) {
            loadContent('<?php echo $meridian_page_options['post_type']; ?>', null);
        });
    </script>
<?php
do_action('m59-end-content');
get_footer(); ?>
