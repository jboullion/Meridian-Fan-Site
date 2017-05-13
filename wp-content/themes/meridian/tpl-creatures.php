<?php
/* Template Name: Creatures Template */

get_header(); the_post();

?>
<?php

do_action('m59-begin-content');
?>

    <div class="sort-btns">
        <?php //the_content(); ?>

        <div id="refine">
          <label>Find:</label>
          <input type="text" name="content-search" value="" id="content-search" />
        </div>

        <div id="sort-holder">
          <label class="col-xs-12">SORT</label>
          <button class="button col-sm-4 sort" id="sort-name" data-order="Asc">Name</button>
          <button class="button col-sm-4 sort" data-sort-by="hp,name" id="sort-hp" data-order="">HP</button>
          <button class="button col-sm-4 sort" id="sort-karma" data-order="">Karma</button>
          <br clear="both" />
        </div>
    </div>

    <div id="images-wrap">
    </div>

    <br clear="both" />
<script>
    var imageWrapper = jQuery('#images-wrap');

    jQuery(document).ready(function($){

        loadContent('creatures', function(){
            initSorting();
        });

        $.fn.reverse = [].reverse;

        function initSorting() {

            //INIT OBJECTS
            var imageWrapper = jQuery('#images-wrap');
            //SORT
            $('#sort-holder').on('click', '#sort-hp', function () {

                sortAllDivs($(this), sortDivsHP)
            });

            $('#sort-holder').on('click', '#sort-karma', function () {
                sortAllDivs($(this), sortDivsKarma)
            });

            $('#sort-holder').on('click', '#sort-name', function () {
                sortAllDivs($(this), sortDivsName);
            });

        }

    });

    function loadCreatures(creature){
        return {id: creature.attr('data-id'),name: creature.attr('data-name'), hp: creature.attr('data-hp'),karma: creature.attr('data-karma')};
    }

    sortDivsHP = function (a, b) {
        return a.getAttribute('data-hp') - b.getAttribute('data-hp') || alphabetical(a, b);
    }
    sortDivsKarma = function (a, b) {

        return parseInt(a.getAttribute('data-karma')) - parseInt(b.getAttribute('data-karma')) || alphabetical(a, b);
    }
    sortDivsName = function (a, b) {
        return alphabetical(a, b);
    }

    function alphabetical(a, b)
    {
        var A = a.getAttribute('data-name').toLowerCase();
        var B = b.getAttribute('data-name').toLowerCase();
        if (A < B){
            return -1;
        }else if (A > B){
            return  1;
        }else{
            return 0;
        }
    }

    function sortAllDivs(element,sortFunction){

      if (element.attr('data-order') == "Asc") {
          //allWrappers[creatureTypes[i]].find
          jQuery('.creatures')
              .sort(sortFunction)
              .reverse()
              //.appendTo( allWrappers[creatureTypes[i]] );
              .appendTo( imageWrapper );
          element.attr('data-order', "Desc");
      } else {
          //allWrappers[creatureTypes[i]].find('.creatures')
          jQuery('.creatures')
              .sort(sortFunction)
              .appendTo( imageWrapper );
          element.attr('data-order', "Asc");
      }

    }

</script>
<?php
do_action('m59-end-content');
get_footer();
