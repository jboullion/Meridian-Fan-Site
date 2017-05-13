<?php

// stop if not in admin
if(!is_admin()) { return; }

// editor hooks
add_action('admin_enqueue_scripts', 'm59_editor_icons_scripts');
add_filter('mce_css', 'm59_editor_icons_css');
add_filter('mce_external_plugins', 'm59_editor_icons_plugin');
add_filter('mce_buttons', 'm59_editor_icons_button');

// load scripts
function m59_editor_icons_scripts() {
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/m59/lib/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('m59-editor-icons', get_template_directory_uri().'/m59/misc/m59-editor-icons.css');
}

// in-editor css
function m59_editor_icons_css($css) {
	if(!empty($css)) { $css .= ','; }
	$css .= get_template_directory_uri().'/m59/lib/font-awesome/css/font-awesome.min.css';
	return $css;
}

// editor plugin
function m59_editor_icons_plugin($plugins) {
	$plugins['m59_icon'] = get_template_directory_uri().'/m59/misc/m59-editor-icons.js';
	return $plugins;
}

// editor button
function m59_editor_icons_button($buttons) {
	$buttons[] = 'm59_icon_list';
	return $buttons;
}
