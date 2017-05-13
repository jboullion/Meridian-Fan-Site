<?php

	// if we aren't on the frontend, get out
	if(is_admin()) { return; }

	// displays the pk logo on wp-login.php  page
	add_action('login_head', 'm59_login_head');
	function m59_login_head() {

		// customer logo css
		$logo = m59_get('m59-login-logo');
		if(!empty($logo)) {

			// physical stylesheet directory
			$dir = get_stylesheet_directory().'/styles/';

			// create stylesheet directory, if it doesn't exist
			if(!is_dir($dir)) { mkdir($dir); }

			// customer logo css file
			$css = $dir.'/login.css';

			// generate the customer logo css
			if(is_dir($dir) && !file_exists($css) && function_exists('getimagesize')) {
				$file = get_stylesheet_directory().'/'.$logo;
				if(file_exists($file)) {
					$size = getimagesize($file);
					if(is_array($size) && (count($size) > 1)) {

						// get width/height
						$width = $size[0];
						$height = $size[1];

						// generate new css file
						ob_start();
						@include(dirname(__FILE__).'/../misc/login.css.php');
						$output = ob_get_contents();
						ob_end_clean();

						// save css file
						if(!empty($output)) { file_put_contents($css, $output); }
					}
				}
			}

			// load the customer logo css
			if(file_exists($css)) {
				wp_enqueue_style('m59.login', get_template_directory_uri().'/styles/login.css');
				return;
			}
		}

		// default logo css
		wp_enqueue_style('m59.login', get_template_directory_uri().'/m59/styles/login.css');
	}

	// add ie compatability
	add_action('wp_footer', 'm59_wp_footer', 500);
	function m59_wp_footer() {
		echo current_theme_supports('m59-html5shiv') ? '<!--[if lt IE 9]><script src="'.get_stylesheet_directory_uri().'/pk/lib/html5shiv/html5shiv.js"></script><![endif]-->' : '';
		echo current_theme_supports('m59-selectivizr') ? '<!--[if lt IE 9]><script src="'.get_stylesheet_directory_uri().'/pk/lib/selectivizr/selectivizr.min.js"></script><![endif]-->' : '';
		echo current_theme_supports('m59-responsive') ? '<!--[if lt IE 9]><script src="'.get_stylesheet_directory_uri().'/pk/lib/respond/respond.js"></script><![endif]-->' : '';
	}


	if(current_theme_supports('m59-pdfing')){
		//Open all pdf links in the browser using pdf.js
		add_action('wp_footer', 'm59_wp_footer_pdf');
	}

	/**
	 * Build up all fonts into a single Google font call.
	 * @param  array  $fonts array(font_name => font_weights)
	 */
	function m59_webfont($fonts = array()){
		//example link
		//<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700|Merriweather:400,700,700i" rel="stylesheet">
		global $is_IE;

		if($is_IE){
			//IE < 9 cannot load multiple Google Fonts in one call.
			if(! empty($fonts)){
				foreach($fonts as $font_name => $font_weights){
					$slug = 'font-'.str_replace(' ', '-', strtolower(trim($font_name)));
					wp_register_style($slug, '//fonts.googleapis.com/css?family='.$font_name.':'.$font_weights);
					wp_enqueue_style($slug);
				}
			}else{
				wp_register_style('open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,700');
				wp_enqueue_style('open-sans');
			}

		}else{
			//Load all fonts in one call
			$font_string = '';
			if(! empty($fonts)){
				$c = 0;
				foreach($fonts as $font_name => $font_weights){
					$font_string .= ($c > 0?'|':'').$font_name.':'.$font_weights;
					$c++;
				}
			}else{
				$font_string = 'Open+Sans:400,700';
			}

			wp_register_style('m59-fonts', '//fonts.googleapis.com/css?family='.$font_string);
			wp_enqueue_style('m59-fonts');
		}

	}

	// update error messages displayed to give less info away
	add_filter('login_errors', 'm59_login_errors');
	if(!function_exists('m59_login_errors')) { // function is used/declared in the m59-update plugin as well
		function m59_login_errors() {
			return 'The username and password combination you entered is invalid. <a href="'.wp_lostpassword_url().'">Lost your password</a>?';
		}
	}
