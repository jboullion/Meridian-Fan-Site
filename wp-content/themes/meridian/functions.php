<?php
	// enable html5shiv
	add_theme_support('m59-html5shiv');

	// enable selectivizr
	add_theme_support('m59-selectivizr');

	// enable responsive
	add_theme_support('m59-responsive');

	// enable redirection urls
	#add_theme_support('m59-redirection');

	// enable font awesome
	add_theme_support('m59-font-awesome');

	// includes all of the default powderkeg functions and functionality
	include('m59/functions.php');

	// variables
	#m59_set('var', 'value');

	// image sizes
	#add_image_size('image-960-480c', 960, 480, true);


	// enable customer login logo
	m59_set('m59-login-logo', 'images/logo.png');

  add_image_size('creature-thumb', 120, 120, array('center', 'top'));

// disable default gravity forms styles...by default
	add_action('pre_option_rg_gforms_disable_css', '__return_true');

	// admin scripts/css
	add_action('admin_enqueue_scripts', 'm59_theme_admin_enqueue_scripts');
	function m59_theme_admin_enqueue_scripts() {
		wp_enqueue_style( 'm59-admin', get_stylesheet_directory_uri().'/styles/admin.css', array());
	}

  add_action( 'm59-begin-content', 'm59_begin_content' );
  function m59_begin_content() {
      echo '<div class="row">
                  <div class="container">
											'.m59_get_partial('sidebar', true).'
                      <div class="col-md-9 content  strip-padding">';
      //<div class="piece gold-piece top-piece left-piece"></div>
      //      <div class="piece gold-piece top-piece right-piece"></div>
  }

  add_action( 'm59-end-content', 'm59_end_content' );
	function m59_end_content() {
	    echo '</div>
	            </div>
	        </div>';

	    //<div class="piece gold-piece bottom-piece left-piece"></div>
	    //<div class="piece gold-piece bottom-piece right-piece"></div>
	}

  add_action('init', 'register_cpts');

  function register_cpts() {
      m59_register_cpt(array('name' => 'item', 'icon' => 'dashicons-admin-tools', 'position' => 26));
      m59_register_cpt(array('name' => 'weapon', 'icon' => 'dashicons-hammer', 'position' => 27));
      m59_register_cpt(array('name' => 'armor', 'icon' => 'dashicons-shield-alt', 'position' => 28, 'is_singular' => true));
      m59_register_cpt(array('name' => 'NPC', 'icon' => 'dashicons-universal-access', 'position' => 29));
      m59_register_cpt(array('name' => 'creature', 'icon' => 'dashicons-twitter', 'position' => 30));
      m59_register_cpt(array('name' => 'spell', 'icon' => 'dashicons-rss', 'position' => 31));
      m59_register_cpt(array('name' => 'reagent', 'icon' => 'dashicons-palmtree', 'position' => 32));
      m59_register_cpt(array('name' => 'location', 'icon' => 'dashicons-admin-site', 'position' => 33));
  }

   add_action('init', 'm59_options_init');

  function m59_options_init() {
      global $meridian_site_options;

      //$meridian_site_options = get_fields('options');

      //m59_print($meridian_site_options);
  }

	// front end scripts/css
	add_action('wp_enqueue_scripts', 'm59_theme_enqueue_scripts', 9999);
	function m59_theme_enqueue_scripts() {
/*
				// Import Google Web Fonts
				$fonts = array(
						'Open Sans' => '400',
						'Droid Serif' => '400'
					);

				m59_webfont($fonts);
*/
				// javascript
				wp_enqueue_script('jquery');
				//wp_enqueue_script('lazyload', get_stylesheet_directory_uri().'/js/jquery.lazyload.min.js','','',true);
				if(ENVIRONMENT != 'dev'){
					wp_enqueue_style( 'live', get_stylesheet_directory_uri().'/styles/live.css', array());
					wp_enqueue_script('jquery.site', get_stylesheet_directory_uri().'/js/live.js', 'jQuery',true);

				}else{
					wp_enqueue_style( 'dev', get_stylesheet_directory_uri().'/styles/live.css');
					wp_enqueue_script('jquery.site', get_stylesheet_directory_uri().'/js/live.js', 'jQuery','',true);
				}
	}

  function m59_image_dir() { return get_stylesheet_directory_uri().'/images/'; }

	/**
	 * @desc Generally used to include files but can also be used to return the contents of a file.
	 * @usage m59_get_partial([string] $filename, [bool] false)
	 *
	 * @param $filename
	 * @param bool $value_return
	 */
  function m59_get_partial($filename, $value_return = false){
     global $post, $site_options, $page_options;

     if($value_return){
         ob_start();
         include get_stylesheet_directory().'/partials/'.$filename.'.php';
         $output = ob_get_contents();
         ob_end_clean();

         return $output;
     }else{
         include get_stylesheet_directory().'/partials/'.$filename.'.php';
     }

  }


  function m59_get_first_paragraph($str, $trim = false){
      if($trim){
          $str = strip_tags($str);
      }

      $str = wpautop( $str );
      $str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
      $str = strip_tags($str, '<a><strong><em><img>');

      if($trim){
          $trim_str = $str;

          //make sure to trim to end of word.
          if (preg_match('/^.{1,260}\b/s', $str, $match)){
              $trim_str = $match[0].' [...]';
          }
          //return substr($trim_str, 0, 300); //trim to exact character number.

          return $trim_str;
      } else{
          return $str;
      }

  }

  function m59_show_comments(){
      //echo '<div class="entry">';

      comments_template();
      /*
      wp_editor( '', 'comment', array(
          'textarea_rows' => 15,
          'teeny' => true,
          'quicktags' => false,
          'media_buttons' => false
      ) );

      echo '</div>';*/
  }

  function m59_display_spell_entry($post_id){
      global $wp_query;
      $spell = get_post($post_id);
      $spell_options = get_fields($post_id);

      echo '<div class="entry" id="spell-entry">
              <div class="col-sm-4">
                  <img id="featured-image" src="'.$spell_options['graphic']['url'].'" alt="'.$spell->post_title.'" title="'.$spell->post_title.'" />
              </div>

              <div class="col-sm-8">
                  <h1>'.$spell->post_title.'</h1>
									<p>SCHOOL: '.$spell_options['school'].' <span class="spacer"></span> LEVEL: '.$spell_options['level'].'</p>
									'.apply_filters('the_content', $spell->post_content).'
                  <p>It will cost you '.$spell_options['training_points'].' training points to improve in this skill.</p>
              </div>
              <br clear="both" />
              </div>';

  }

  add_action('wp_ajax_nopriv_m59load_spell', 'm59load_spell', 1);
  add_action('wp_ajax_m59load_spell', 'm59load_spell', 1);
  function m59load_spell() {
      //global $wpdb;

      //m59_print($_POST);
      echo m59_display_spell_entry($_POST['ID']);
      die();
  }

/**
 * BEGIN ADMIN SORTING --------------------------------------------------------------------------------
 */
  /*
  * ADMIN COLUMN - HEADERS
  */
  add_filter('manage_spells_posts_columns', 'add_new_spells_columns');
  function add_new_spells_columns($columns) {
      $columns['level'] =  'Level';
      $columns['school'] = 'School';

      return $columns;
  }

  add_filter('manage_creatures_posts_columns', 'add_new_creatures_columns');
  function add_new_creatures_columns($columns) {
      $columns['maximum_hp'] =  'HP';
      $columns['max_karma'] = 'Karma';

      return $columns;
  }

  add_filter('manage_reagents_posts_columns', 'add_new_reagents_columns');
  function add_new_reagents_columns($columns) {
      $columns['weight'] =  'Weight';

      return $columns;
  }

  /*
   * ADMIN COLUMN - CONTENT
   */
  add_action('manage_spells_posts_custom_column', 'manage_spells_columns', 10, 2);
  function manage_spells_columns($column_name, $post_id) {
      echo get_field($column_name, $post_id);
  }

  add_action('manage_creatures_posts_custom_column', 'manage_creatures_columns', 10, 2);
  function manage_creatures_columns($column_name, $post_id) {
      echo get_field($column_name, $post_id);
  }

  add_action('manage_reagents_posts_custom_column', 'manage_reagents_columns', 10, 2);
  function manage_reagents_columns($column_name, $post_id) {
      echo get_field($column_name, $post_id);
  }

  /*
   * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
   * https://gist.github.com/906872
   */
  add_filter("manage_edit-creatures_sortable_columns", 'creatures_sort');
  function creatures_sort($columns) {
      $custom = array(
          'maximum_hp' 	=> 'maximum_hp',
          'max_karma' 	=> 'max_karma'
      );
      return wp_parse_args($custom, $columns);
  }

  add_filter("manage_edit-spells_sortable_columns", 'spells_sort');
  function spells_sort($columns) {
      $custom = array(
          'level' 	=> 'level',
          'school' 	=> 'school'
      );
      return wp_parse_args($custom, $columns);
  }

  add_filter("manage_edit-reagents_sortable_columns", 'reagents_sort');
  function reagents_sort($columns) {
      $custom = array(
          'weight' 	=> 'weight'
      );
      return wp_parse_args($custom, $columns);
  }

  /*
   * ADMIN COLUMN - SORTING - ORDERBY
   * http://scribu.net/wordpress/custom-sortable-columns.html#comment-4732
   */
  add_filter( 'parse_query', 'spells_column_orderby' );
  function spells_column_orderby( $query ) {

      global $pagenow;
      if (is_admin() && $pagenow=='edit.php' && isset($_GET['orderby']) && isset($_GET['post_type']) &&$_GET['orderby'] !='None'){
          if($_GET['post_type']=='creatures' || $_GET['post_type']=='reagents') {
              $query->query_vars['orderby'] = 'meta_value_num';
          }
          if($_GET['post_type']=='spells') {
              $query->query_vars['orderby'] = 'meta_value';
          }
          $query->query_vars['meta_key'] = $_GET['orderby'];
      }
  }

	/**
	 * Allow Yoast SEO breadcrumbs to understand the hierarchy structure of CPTs.
	 * Especially helpful if you have CPTs with custom rewrites
	 *
	 * @param array 	a list of the links in the breadcrumbs
	 */
	add_filter( 'wpseo_breadcrumb_links', 'm59_wpseo_breadcrumb_links' );
	function m59_wpseo_breadcrumb_links( $links ) {
		global $post;

		if(is_singular( 'npcs' )){
			//add the Contact / Locations page
			$npcs_page = 226;

			array_splice( $links, -1, 0, array(
				array(
					'id'    => $npcs_page
				)
			));

		}elseif(is_singular( 'towers' )){
			$fire_towers = 22;
			$tower_models = 57;

			array_splice( $links, -1, 0, array(
				array(
					'id'    => $fire_towers
				),
				array(
					'id'    => $tower_models
				)
			));
		}elseif(is_singular( 'client-projects' )){
			$client_gallery = 34;

			array_splice( $links, -1, 0, array(
				array(
					'id'    => $client_gallery
				)
			));
		}elseif(is_tax( 'accessory-cat' )){
			$accessories = 28;

			array_splice( $links, -1, 0, array(
				array(
					'id'    => $accessories
				)
			));
		}elseif(is_singular( 'accessories' )){
			$accessories = 28;
			$terms = wp_get_post_terms( $post->ID, 'accessory-cat' );

			array_splice( $links, -1, 0, array(
				array(
					'id'    => $accessories
				),
				array(
					'text' 	 => $terms[0]->name,
					'url'    => get_term_link($terms[0]->term_id)
				)
			));
		}

		//remove the last element from the links array
		//we need to make sure we stick an id => 0 as the last element or else we will remove the anchor link from the last breadcrumb
		if($post->ID != 24){
			array_splice( $links, -1, 1, array('id' => 0));
		}

		return $links;
	}
