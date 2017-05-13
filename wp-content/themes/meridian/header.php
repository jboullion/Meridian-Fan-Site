<?php global $meridian_site_options; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0,user-scalable=no">
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
        <link rel="manifest" href="/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
<!--
				<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
-->
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
    <script>
        //set relative path to theme so all scripts have access to it
        var pagePath = '<?php echo get_template_directory_uri(); ?>/';
    </script>
        <?php m59_get_partial('edges'); ?>
        <div class="row">
            <div id="header" class="container">
                <div id="logo" class="col-md-6 strip-padding">
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo m59_image_dir().'logo.png' ?>" title="<?php bloginfo('name'); ?>" /></a>
                </div>

                <div class="col-md-6 strip-padding">
                    <?php
                        //if (! is_user_logged_in() ){
                            //wp_nav_menu(array('container'=> false, 'depth'=>1, 'menu'=>'account', 'menu_class'=>'', 'menu-id'=>'account-menu'));
                        //}
                    ?>
                    <div id="mobile-search-wrapper">
                        <div id="mobile-menu-btn" class="">
                            <img src="<?php echo m59_image_dir().'menu-btn.png' ?>" />
                        </div>
                        <?php
                            get_search_form(true);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container">
							<?php
							/*
									if ( function_exists( 'yoast_breadcrumb' ) ) {
										echo '<div class="col-xs-12 strip-padding breadcrumbs">';
										yoast_breadcrumb();
										echo '</div>';
									}
									*/
								?>
                <div id="mobile-sidebar" class="col-xs-12 desktop-hide strip-padding">

                    <div id="mobile-menu">
                        <?php
                        wp_nav_menu(array('container'=> false, 'depth'=>2, 'menu'=>'main', 'menu_class'=>'', 'menu-id'=>''));
                        ?>
                    </div>
                </div>
            </div>
        </div>
