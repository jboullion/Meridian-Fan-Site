<?php
	
	// prints out an array with <pre> tags
	function m59_print($input, $force = false) { 
		if(ENVIRONMENT != 'live' || $force === true){
			echo '<pre>'.print_r($input, true).'</pre>'; 
		}
	}

	//short function call for m59_print
	function pkp($input, $force = false) { 
		m59_print($input, $force);
	}

	// remove 'http(s)://' from any passed url
	function m59_filter_http($input) { return preg_replace('/^http[s]?:\/\/([^\/]*)/i', '', $input); }
		
	// recursively cycles through the post hierarchy to find all children infinte levels down
	function m59_get_all_children($parent_post = null, $orderby = 'menu_order', $order = 'ASC', $num_posts = '-1') {
		global $post;
		
		if(!$parent_post) { $parent_post = $post; }
		elseif(is_numeric($parent_post)) { $parent_post = get_post($parent_post); }
		
		if(count($children = get_posts(array('numberposts'=>$num_posts, 'order'=>$order, 'orderby'=> $orderby, 'post_parent'=>$parent_post->ID, 'post_type'=>$parent_post->post_type)))) {
			foreach($children as &$c) {
				$c->children = m59_get_all_children($c);
			}
			return $children;
		}
	}
	
	// cycles through the current post hierarchy to find the parent post
	function m59_get_post_hierarchy($parent_post = '') {
		
		// if an id isn't provided, use the current post
		if(!$parent_post) { global $post; $parent_post = $post; }
		
		// if there still isn't a parent post, gtfo
		if(!$parent_post) { return; }
		
		// "climb" the page hierarchy to find the top level page
		while($parent_post->post_parent) { $parent_post = get_post($parent_post->post_parent); }
		
		// "climb" back down to get the children
		$parent_post->children = m59_get_all_children($parent_post);
		
		// return an array of all the pages
		return $parent_post;
	}
	
	// checks to see if the current user is super admin
	function m59_is_admin() {
		global $current_user;
		return in_array('administrator', $current_user->roles);
	}
	
	// uses wordpress' paginate_links function with some default variables
	function m59_paginate_links($args = array()) {
		global $wp_query;
		
		$args = wp_parse_args($args, array('total'=>$wp_query->max_num_pages));
		
		$pages = paginate_links(array(
			'base' => preg_replace('/page\/\d*\/$/', '', $_SERVER['REQUEST_URI']).'page/%#%/',
			'current' => max(1, get_query_var('paged')),
			'format' => 'page/%#%/',
			'mid_size' => 1,
			'next_text' => '&raquo;',
			'prev_text' => '&laquo;',
			'total' => $args['total'],
			'type' => 'array'
		));

		if(is_array($pages)) {
			$paged = get_query_var('paged') == 0 ? 1 : get_query_var('paged');
			$r = '<ul class="pagination">';
			foreach($pages as $page) {
				$r.= '<li'.(preg_match('/current/', $page) ? ' class="active"' : '').'>'.$page.'</li>';
			}
			$r.= '</ul>';
		}

		return $r;
	}
	
	// filters any passed string through the_content wordpress filter (will process any shortcodes, etc...)
	function m59_the_content($input) {
		return apply_filters('the_content', $input);
	}
	
	// get relative url of specified file, relative to the theme folder
	function m59_theme_relative($file) { return m59_filter_http(m59_theme_full($file)); }

	// get absolute url of specified file, relative to the theme folder
	function m59_theme_full($file) { return get_stylesheet_directory_uri().'/'.$file; }

	// function to get time relative to timezone set in admin
	function m59_time() { return current_time('timestamp'); }
	
	// function to get datetime relative to timezone set in admin
	function m59_datetime() { return current_time('mysql'); }
	
	// get image url, of specified size, by id, image array or image object
	function m59_get_image($id, $size='full') {
		$url = '';
		if(is_numeric($id)) {
			$image = wp_get_attachment_image_src($id, $size);
			if(is_array($image) && (count($image) > 0)) {
				$url = m59_filter_http($image[0]);
			}
		} else if(is_array($id) || is_object($id)) {
			$info = (array)$id;
			if(($size == 'full') && !empty($info['url'])) {
				$url = m59_filter_http($info['url']);
			} else if(isset($info['sizes']) && is_array($info['sizes']) && !empty($info['sizes'][$size])) {
				$url = m59_filter_http($info['sizes'][$size]);
			}
		}
		return $url;
	}

	// get url of post id
	function m59_get_link($id) {
		return m59_filter_http(get_permalink($id));
	}
	
	// format the phone numbers to be uniform through the site
	function m59_format_phone($phone, $extension = '', $formats = array()) {
		$formats = wp_parse_args($formats, array('format-7'=>'$1-$2',
															  'format-10'=>"($1) $2-$3",
															  'format-11'=>"$1 ($2) $3-$4"));
		$phone = preg_replace('/[^0-9]/','',$phone);
		$len = strlen($phone);
		if($len == 7) {
			$phone = preg_replace("/([0-9]{3})([0-9]{4})/", $formats['format-7'], $phone);
		} else if($len == 10) {
			$phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", $formats['format-10'], $phone);
		} else if($len == 11) {
			$phone = preg_replace("/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/", $formats['format-11'], $phone);
		}
		return $phone.($extension ? ' ext. '.$extension : '');
	}
	
	// register a custom post type: ex: m59_register_cpt(array('name' => 'FAQ', 'icon' => 'dashicons-format-status', 'position' => 5, 'is_singular' => true));
	function m59_register_cpt($cpt_array = array()){
		$default_cpt = array( 'name' => '', 
							'icon' => 'dashicons-admin-post', 
							'position' => 4, 
							'description' => '', 
							'is_singular' => false, 
							'exclude_from_search' => false,
							'supports' => array('title','editor','thumbnail','page-attributes'),
							'taxonomies' => array(),
							'has_archive' => false,
							'rewrite' => array(),
							'public' => true,
						);	
		if(! empty($cpt_array)){
			$cpt_array = wp_parse_args( $cpt_array, $default_cpt );
			$slug = strtolower($cpt_array['name']);
			$plural = (substr($slug, -1) == 's') ? 'es' : 's';
			
			if(substr($slug, -1) == 'y' && ! $cpt_array['is_singular']){
				$slug = rtrim($slug, 'y');
				$plural = 'ies';
			}
			
			$plural_slug = ($cpt_array['is_singular']) ? $slug : $slug.$plural;
			$plural_slug = str_replace(" ", "-", $plural_slug);
			$label = ucwords(str_replace("-", " ", $cpt_array['name']));

			$is_y = false;
			if(substr($label, -1) == 'y' && ! $cpt_array['is_singular']){
				$label = rtrim($label, 'y');
				$is_y = true;
			}

			$plural_label = ($cpt_array['is_singular']) ? $label : $label.$plural;
			
			//we removed the y from the label to put on an ies...now let's add the Y back.
			if($is_y){
				$label .= 'y';
			}
			
			register_post_type( $plural_slug, array(
								'label' => $plural_label,
								'description' => $cpt_array['description'],
								'public' => $cpt_array['public'],
								'show_ui' => true,
								'show_in_menu' => true,
								'exclude_from_search' => $cpt_array['exclude_from_search'],
								'capability_type' => 'post',
								'map_meta_cap' => true,
								'hierarchical' => $cpt_array['hierarchical'],
								'has_archive' => $cpt_array['has_archive'],
								'rewrite' => $cpt_array['rewrite'],
								'query_var' => true,
								'taxonomies' => $cpt_array['taxonomies'],
								'menu_position' => $cpt_array['position'],
								'menu_icon' => $cpt_array['icon'],
								'supports' => $cpt_array['supports'],
								'labels' => array (
									'name' => $plural_label,
									'singular_name' => $label,
									'menu_name' => $plural_label,
									'add_new' => 'Add '.$label,
									'add_new_item' => 'Add New '.$label,
									'edit' => 'Edit',
									'edit_item' => 'Edit '.$label,
									'new_item' => 'New '.$label,
									'view' => 'View '.$plural_label,
									'view_item' => 'View '.$label,
									'search_items' => 'Search '.$plural_label,
									'not_found' => 'No '.$plural_label.' Found',
									'not_found_in_trash' => 'No '.$plural_label.' Found in Trash',
									'parent' => 'Parent '.$label
								)
							)); 
		}
	}

	/**
	 * Helper function for registering a taxonomy
	 *
	 * @param string $tax_name  	A url safe taxonomy name / slug
	 * @param string $post_type 	What post type this taxonomy will be applied to
	 * @param string $menu_title 	The title of the taxonomy. Human Readable.
	 * @param array  $rewrite 	 	Overwrite the rewrite
	 */
	function m59_register_taxonomy($tax_name = '', $post_type = '', $menu_title = '', $rewrite = array()){

		if(empty($rewrite)){
			$rewrite = array( 'slug' => $tax_name );
		}

		register_taxonomy(
			$tax_name,
			$post_type,
			array(
				'label' => __( $menu_title ),
				'rewrite' => $rewrite, 
				'capabilities' => array(
					'assign_terms' => 'edit_posts',
					'edit_terms' => 'edit_posts'
				),
				'hierarchical' => true
			)
		);
	}
	
	// get a m59-specific value
	function m59_get($key) {
		return m59_value($key);
	}
	
	// set a m59-specific value -- returns previous value
	function m59_set($key, $value=null) {
		return m59_value($key, $value);
	}
	
	// get/set a m59-specific value
	function m59_value() {
		static $list = array();
		
		// initialize value
		$value = null;
		
		// 1 argument = get, 2 arguments = set, anything else = invalid
		switch(func_num_args()) {
		
			// get value
			case 1:
				$key = func_get_arg(0);
				if(is_string($key)) {
					$value = (isset($list[$key]) ? $list[$key] : null);
				}
				break;
				
			// set value (and return old value)
			case 2:
				$key = func_get_arg(0);
				if(is_string($key)) {
					$value = (isset($list[$key]) ? $list[$key] : null);
					$list[$key] = func_get_arg(1);
				}
				break;
			
			// invalid usage
			default:
				break;
		}
		
		// return current/previous value
		return $value;
	}
	
	// remove callbacks from specified action/filter, with optional function name and priority
	function m59_unhook($name, $func=null, $pri=null) {
		global $wp_filter;
	
		// check for callbacks assigned to a specific filter name
		if(empty($name) || !is_array($wp_filter) || empty($wp_filter[$name])) {
			return;
		}
	
		// check for function name and priority
		if(($func === null) && ($pri === null)) {
			return remove_all_actions($name);
		}
	
		// reference the specified filter list
		$filters = &$wp_filter[$name];
	
		// initialize callback removal list
		$list = array();
	
		// search callbacks within a priority
		if($pri !== null) {
			if(!empty($filters[$pri])) {
		
				// with specific function name
				if($func !== null) {
					if(isset($filters[$pri][$func])) {
						$list[] = array($name, $func, $pri);
					}
			
				// without specific function name
				} else {
					foreach($filters[$pri] as $call=>$item) {
						$list[] = array($name, $call, $pri);
					}
				}
			}
		
		// search all callback priorities
		} else {
			foreach($filters as $pri=>$group) {
				if(isset($group[$func])) {
					$list[] = array($name, $func, $pri);
				}
			}
		}
	
		// remove identified callbacks
		if(!empty($list)) {
			foreach($list as $item) {
				remove_action($item[0], $item[1], $item[2]);
			}
		}
	}

	//Output Bootstrap grid clearfixes for varying heights on grid items
	//that are not sectioned off with rows
	/* Usage: m59_brkpnt(($c+1),array('xs'=>2,'sm'=>2,'md'=>3,'lg'=>3));
	*  $c is the current count key in a foreach
	*  $breakpoints are a key => value pair array for all of the grid sizes (xs,sm,md,lg)
	*  $echo is whether or not to echo or return the result
	*/
	function m59_brkpnt($c,$breakpoints, $echo = true){
		if(!is_array($breakpoints)){ return; }
		$class = '';
		foreach($breakpoints as $prefix => $size){
			$class .= $c%$size == 0 ? ' visible-'.$prefix: ''; 
		}
		$return = $class ? '<div class="clearfix'.' '.$class.'"></div>' : '';
		if($echo){ echo $return; }else{ return $return; }
	}

	/**
	 * Use WordPress' antispambot() to obfuscate the site's email, to protect from harvestor bots
	 *
	 * @param string $email The email address to obfuscate
	 * @param string $text 	The text to display to the user (for the mailto:email link)
	 * 
	 * @return string 		The obfuscated email address formatted as a link.
	 */
	function m59_antispam_email($email = "", $text = "" ){
		if (! filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			if($text == ""){
				$text = antispambot($email);
			}
			$clean_link = '<a href="mailto:'.antispambot($email).'">'.$text.'</a>';
			
			return	$clean_link;
			
		}
	}

	/**
	 * Get the img path quickly
	 * 
	 * @return string the images directory
	 */
	function m59_img_path() {
		return get_stylesheet_directory_uri().'/images/';
	}

	/**
	 * Parse the ID from a youtube url
	 * @param  string $url a long youtube string. Pretty much any youtube url string
	 * @return string      video id
	 */
	function m59_get_youtube_id($url){
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
			return $match[1];
		}
	}

	//Allows a user to setup WordPress for HTML emails
	function set_html_content_type() {
		return 'text/html';
	}
