<?php
function getIndividualVideo($videoEntry) 
{
  $VidInfo['id'] = $videoEntry->getVideoId();
  $VidInfo['title'] = $videoEntry->getVideoTitle();
  $VidInfo['description'] = $videoEntry->getVideoDescription();
  $VidInfo['tags'] = $videoEntry->getVideoTags();
  return $VidInfo;
}

function wptube_output($atts) {
	extract(shortcode_atts(array(
		'vid_id' => ''
	), $atts));
	$yt = new Zend_Gdata_YouTube();
	$Colors[0] = 'color1=0x2b405b&color2=0x6b8ab6';
	$Colors[1] = '';
	$Colors[2] = 'color1=0x006699&color2=0x54abd6';
	$Colors[3] = 'color1=0x3a3a3a&color2=0x999999';
	$Colors[4] = 'color1=0x234900&color2=0x4e9e00';
	$Colors[5] = 'color1=0xe1600f&color2=0xfebd01';
	$Colors[6] = 'color1=0xcc2550&color2=0xe87a9f';
	$Colors[7] = 'color1=0x402061&color2=0x9461ca';
	$Colors[8] = 'color1=0x5d1719&color2=0xcd311b';
	$VidInfo = $yt->getVideoEntry($vid_id);
	$Video = getIndividualVideo($VidInfo);
	$Content = '<p><b>Video:</b></p>
		<br>
		<p>'.nl2br($Video['description']).'<p>
		<object width="'.get_option('wp_tube_player_width_x').'" height="'.get_option('wp_tube_player_width_y').'"><param name="movie" value="http://www.youtube.com/v/'.$vid_id.'&fs=1&'.$Colors[get_option('wp_tube_player_colors')].'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$vid_id.'&hl=en_US&fs=1&'.$Colors[get_option('wp_tube_player_colors')].'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"  width="'.get_option('wp_tube_player_width_x').'" height="'.get_option('wp_tube_player_width_y').'"></embed></object>';
	return $Content;
}
add_shortcode('wp-tube', 'wptube_output');
?>