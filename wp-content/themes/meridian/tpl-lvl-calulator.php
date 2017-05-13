<?php
/* Template Name: Level Calculator */

get_header();
the_post();

do_action('m59-begin-content');
?>

  <h1><?php the_title(); ?></h1>
  <div class="entry">
      <?php the_content(); ?>

      <hr />

      <form id="lvl-calc" method="post" action="">
        <div class="form-group half-size">
          <label>Intellect</label><input type="number" class="form-control number-input" placeholder="1-60" id="int" value="1" min="1" max="60">
        </div>

        <hr />

        <?php

          $schools = array('Banditry', 'Faren', 'Jala', 'Kraanan', 'Qor', 'Riija', "Shal'ille", 'Sorcery', 'Weapon Craft', 'Witchery');

          foreach($schools as $school){
            echo '<div class="form-group half-size">
                    <label>'.$school.'</label><select class="form-control school">
                        <option value="0"> -- </option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select>
                  </div>';
          }

        ?>
        <hr />

        <div class="form-group half-size current">
          <label>Spells in current level?</label
            ><select class="form-control" id="spells-in-level">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected="selected">3 or more</option>
            </select>
        </div>

        <div class="form-group half-size current">
          <label>Current %</label
            ><input type="number" class="form-control number-input" placeholder="" id="spell-1"  min="0" max="99" value="1"
          ><input type="number" class="form-control number-input" placeholder="" id="spell-2"  min="0" max="99" value="1"
          ><input type="number" class="form-control number-input" placeholder="" id="spell-3"  min="0" max="99" value="1">
        </div>

        <hr />

        <div class="form-group half-size">
          <strong>You Need:</strong> <span id="need">? points to level</span>
        </div>
      </form>
  </div>
<script>
    //Check out the github for a detailed breakdown of the actual calculations:
    //https://github.com/OpenMeridian/Meridian59/blob/master/kod/object/active/holder/nomoveon/battler/player.kod
    //function PlayerCanLearn
    //starting at line 12272

    jQuery(document).ready(function($) {
      //I could have sworn this should have been 87? Have I been wrong this whole time?
      var MIN_NEEDED_TO_ADVANCE = 75;
      var POINTS_SLOPE = 7;
      var maxSkillPoints = 297;
      var vlLevelPoints = [0,1,2,4,6,8,10];
      var piMaxLearnPoints = 16 //this might be 18 now that 60 is max intellect...?
      var maxInt = 60; //50 for most, 60 is only for deamons!

      //limit the highest intellect
      $('#lvl-calc').on('keyup', '#int', function(e){
        if($(this).val() > 60) $(this).val(60);
      });

      //limit the value of the current % input
      $('#lvl-calc').on('keyup', '.current input', function(e){
        if($(this).val() > 99) $(this).val(99);
      });

      $('#spells-in-level').change(function(e){
        var spellsInLevel = parseInt($('#spells-in-level').val());

        switch(spellsInLevel){
          case 1:
            $('#spell-2').hide().val(0);
            $('#spell-3').hide().val(0);
            break;
          case 2:
            $('#spell-2').show().val(1);
            $('#spell-3').hide().val(0);
            break;
          case 3:
            $('#spell-2').show().val(1);
            $('#spell-3').show().val(1);
            break;
        }

      });

      //whenever something is updated...update.
      $('#int, .school, .current input, #spells-in-level').change(function(e){
        var nSchool = 0;
        var int = parseInt($('#int').val());
        var iHave = 0;
        var spellsInLevel = parseInt($('#spells-in-level').val());
        var iPoints = 0;

        $('.school').each(function(i){
          //totalLevels += parseInt($(this).val());
          var level = $(this).val();
          if(parseInt($(this).val()) > 0){
            iPoints += vlLevelPoints[level];
          }

        });

        //for some reason the code has +2 points added for any new spell / skill above level 1 (where it only adds 1).
        //since no one needs a level calculator for level fucking 1, just always add 2
        iPoints += 2;

        //add up total current percent
        iHave += parseInt($('#spell-1').val());
        iHave += parseInt($('#spell-2').val());
        iHave += parseInt($('#spell-3').val());

        iNeed =  (iPoints * POINTS_SLOPE)
                  + (maxSkillPoints - (piMaxLearnPoints * POINTS_SLOPE))
                  - Math.ceil(((int * 2 * POINTS_SLOPE) / 5)); //not sure what is going on, need to test this. seems to be off by one level.

        //there is a minimum needed to advanced to next level (except for level 1)
        if(iNeed < MIN_NEEDED_TO_ADVANCE) iNeed = MIN_NEEDED_TO_ADVANCE;

        if (spellsInLevel == 1){
          iNeed = iNeed / 3;
        }else if(spellsInLevel == 2){
          iNeed = (iNeed*2)/3;
        }

        if(spellsInLevel < 3){
          iNeed = Math.ceil(iNeed);
        }

        if(iHave > iNeed){
          //cheater
          $('#need').html('0 points to level');
        }else if(iNeed > maxSkillPoints ){
          $('#need').html('You are max level');
        }else{
          $('#need').html((iNeed - iHave)+' points to level');
        }

      });

    });
</script>
<?php
do_action('m59-end-content');
get_footer();
