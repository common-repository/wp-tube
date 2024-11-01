<?php
//Create the Skoop admin menu
add_action('admin_menu', 'wp_tube_opp_menu');
function wp_tube_opp_menu() {
    add_options_page('WP-Tube Settings', 'WP-Tube Settings', 'level_10', 'wp_tube_options_pg', 'wp_tube_options_pg');
}

function wp_tube_options_pg() {
	global $WP_TUBE, $wpdb;
	require($WP_TUBE['ServerDIR'].'/lib/options.lib.php');
}
?>