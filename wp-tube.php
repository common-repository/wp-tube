<?php
/*
Plugin Name: WP-Tube
Plugin URI: http://www.cake-spoon.com/wp-tube
Description: WP-Tube allows your blog to automaticaly update your blog with videos from YouTube. Using the Zend GData API it gets the title, description and tags from your video and puts them in your post. Info: GData version 1.10.2 - 02/24/2010
Version: 1.0.2.1
Author: Sam Rudge
Author URI: http://www.cake-spoon.com/
License: GPL3
*/

//Base vars
$WP_TUBE['BaseDIR'] = get_option('siteurl') .'/wp-content/plugins/' . basename(dirname(__FILE__));
$WP_TUBE['ServerDIR'] = dirname(__FILE__);

//Set the new include path to include this DIR
set_include_path($WP_TUBE['ServerDIR']);

//Get the library
require_once('Zend/Loader.php');
Zend_Loader::loadClass('Zend_Gdata_YouTube');

//Install
require($WP_TUBE['ServerDIR'].'/lib/install.lib.php');

//Check install
if(get_option('wp_tube_dbv') == '') {
	wp_tube_install();
}

//Admin
require($WP_TUBE['ServerDIR'].'/lib/admin.lib.php');

//And the bit that checks for posts
add_action('wp_head', 'wptube_do');

function wptube_do() {
	global $WP_TUBE, $wpdb;
	if ( time()-(get_option('wp_tube_bump'))*60 >= get_option('wp_tube_lud') ) {
		require($WP_TUBE['ServerDIR'].'/lib/frontend.lib.php');
	}
}

require($WP_TUBE['ServerDIR'].'/lib/shortcode.lib.php');
?>