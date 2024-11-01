<?php
//De-activation
register_deactivation_hook( __FILE__, 'wp_tube_remove' );

//Activation
register_activation_hook( __FILE__, 'wp_tube_install' );

function wp_tube_install() {
	add_option('wp_tube_user', '');
	add_option('wp_tube_default_player', '1');
	add_option('wp_tube_player_colors', '1');
	add_option('wp_tube_player_width_x', '640');
	add_option('wp_tube_player_width_y', '385');
	add_option('wp_tube_bump', 20);
	add_option('wp_tube_custom_player', '');
	wp_tube_int_db();
}

function wp_tube_remove() {
	update_option('wp_tube_default_player', '0');
	update_option('wp_tube_player_colors', '0');
	update_option('wp_tube_player_width_x', '0');
	update_option('wp_tube_player_width_y', '0');
	update_option('wp_tube_custom_player', '0');
}

//Int DB
function wp_tube_int_db () {
   global $wpdb;
   $table_name = $wpdb->prefix . "wp_tube_vids";
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      $sql = "CREATE TABLE " . $table_name . " (
	  wpt_id int NOT NULL AUTO_INCREMENT,
	  wpt_ytid VARCHAR(255),
	  UNIQUE KEY id (wpt_id)
	);";

      dbDelta($sql);
   }

      $wpdb->query($sql);
   add_option('wp_tube_dbv', '1.0');
}

?>