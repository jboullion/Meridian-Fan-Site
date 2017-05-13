<?php
/* Template Name: Items Template */

get_header(); the_post();

do_action('m59-begin-content');
?>

    <div class="sort-btns">
        <?php the_content(); ?>

        <div id="refine">
          <label>Find:</label>
          <input type="text" name="content-search" value="" id="content-search" />
        </div>

        <div id="sort-holder">
          <label class="col-xs-12">FILTER</label>
          <button class="button col-sm-4 sort">Armor</button>
          <button class="button col-sm-4 sort">Drink</button>
          <button class="button col-sm-4 sort">Food</button>
          <button class="button col-sm-4 sort">Miscellaneous</button>
          <button class="button col-sm-4 sort">Weapons</button>
          <button class="button col-sm-4 sort">Wearable</button>
          <br clear="both" />
        </div>

    </div>

    <div id="images-wrap">

    </div>

    <br clear="both" />
<script>

    jQuery(document).ready(function($) {

        //loading items, armor and weapons right now.
        loadContent("items', 'armor', 'weapons",function () {
            initSorting();
        });

        function initSorting() {
            //could just do a ('body').on('click', 'button.sort'... but then I can't use tclick for some reason

            //INIT OBJECTS
            var imageWrapper = jQuery('#images-wrap');

            //SORT
            $('button.sort').on('click', function (e) {
                $('.image-div').hide();
                var sortBy = $(this).html();
                $('.' + sortBy).show();
            });
        }
    });
</script>
<?php
do_action('m59-end-content');
get_footer();
