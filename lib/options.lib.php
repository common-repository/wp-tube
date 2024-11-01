<div id="SKP_Settings_Divider" style="padding:10px;">
  <h2>Settings</h2>
  <?php
	if ( $_POST['WP_tube_post'] == 'true' ) {
	if ( $_POST['wpt_username'] != get_option('wp_tube_user') ) {
		require('lib/update.lib.php');
	}
	update_option('wp_tube_player_colors', $_POST['wpt_color']);
	update_option('wp_tube_player_width_x', $_POST['wpt_x']);
	update_option('wp_tube_player_width_y', $_POST['wpt_y']);
	update_option('wp_tube_bump', $_POST['wpt_bounce']);
	update_option('wp_tube_user', $_POST['wpt_username']);
	update_option('wp_tube_cat', $_POST['wpt_cat']);
	?>
    <div class="updated fade">
      <p>The options have been updated =)</p>
    </div>
    <script type="text/javascript" language="javascript">
        <!--
            function skp_reload_page() {
                document.location = document.location;
            }
            
			setTimeout('skp_reload_page()', 2000);
        //-->
    </script>
    </div>
    <?php
	} else {
	?>
    <p>If you don't understand any of these options head over to <a href="http://www.cake-spoon.com/wp-tube#docs" target="_blank">http://www.cake-spoon.com/wp-tube</a></p>
  <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="WP_tube_settings_form">
    <input name="WP_tube_post" type="hidden" value="true">
    Youtube username: <input name="wpt_username" id="wpt_username" type="text" value="<?php echo get_option('wp_tube_user'); ?>"><br>
    Check for new videos every <input name="wpt_bounce" type="text" value="<?php echo get_option('wp_tube_bump'); ?>"> minutes<br>
    Posts Category: <select name="wpt_cat"> 
     <option value=""><?php echo attribute_escape(__('Select Category')); ?></option> 
     <?php 
      $categories= get_categories(array('hide_empty' => false)); 
      foreach ($categories as $cat) {
        $option = '<option value="'.$cat->cat_ID.'"';
		if ( $cat->cat_ID == get_option('wp_tube_cat') ) {
			$option .= ' selected="selected"';
		}
		$option .= ">";
        $option .= $cat->cat_name;
        $option .= '</option>';
        echo $option;
      }
     ?>
    </select>
    <br><br />
    <b>Player Options</b><br><br>
    Player Colors:<br>
    Currently selected:
    <?php
	$Pos = 46*get_option('wp_tube_player_colors');
	echo '<div id="curr_sel_plr" style="background: url(\'http://s.ytimg.com/yt/img/themes/embed_selection-vfl81006.png\') no-repeat scroll -'.$Pos.'px 0px transparent; height:23px; width:46px;"></div>';
		?>
        <br>
    <div style="position:relative; height:32px;">
    <?php
	$i = 0;
	while ( $i <= 9 ) {
		$Left = 50*$i;
		$Pos = 46*$i;
		echo '<div style="background: url(\'http://s.ytimg.com/yt/img/themes/embed_selection-vfl81006.png\') no-repeat scroll -'.$Pos.'px 0px transparent; height:23px; width:46px; position:absolute; top:0px; left:'.$Left.'px;" onclick="setColor(\''.$i.'\');"></div>&nbsp;&nbsp;';
		$i++;
	}
	?>
    </div>
    <br>
    Player dimensions: <input name="wpt_x" type="text" value="<?php echo get_option('wp_tube_player_width_x'); ?>" size="3">X<input name="wpt_y" type="text"  value="<?php echo get_option('wp_tube_player_width_y'); ?>" size="3" /><br>
    <input name="wpt_color" type="hidden" value="<?php echo get_option('wp_tube_player_colors'); ?>" id="wpt_color" />
    <input name="WP_tube_Submit" type="submit" value="Save All Options" onClick="return sbt();"/>
  </form>
</div>
<script type="text/javascript" language="javascript">
function setColor(int) {
	var posit = 46*int;
	document.getElementById('curr_sel_plr').style.background = "url(\'http://s.ytimg.com/yt/img/themes/embed_selection-vfl81006.png\') no-repeat scroll -"+posit+"px 0px transparent";
	document.getElementById('wpt_color').value = int;
}
function sbt() {
	if ( confirm('Once you comit your settings you cannot undo.\nDo you wish to continue?') == true ) {
		if ( document.getElementById('wpt_username').value != '<?php echo get_option('wp_tube_user'); ?>' ) {
			if ( confirm('Your username has been changed, the cache will now be updated so the video\'s you\'ve already uploaded don\'t get put in the blog\nThis may take up to 30 seconds depending on the number of videos you have. It will only index public videos!') == true ) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	} else {
		return false;
	}
}
</script>
<?php
}
?>