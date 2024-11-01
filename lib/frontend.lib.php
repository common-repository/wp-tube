<?php
function getVideoFeed($videoFeed)
{
  $count = 1;
  foreach ($videoFeed as $videoEntry) {
    $VidContents[$count] = printVideoEntry($videoEntry);
    $count++;
  }
  return $VidContents;
}

function printVideoEntry($videoEntry) 
{
  $VidInfo['id'] = $videoEntry->getVideoId();
  $VidInfo['title'] = $videoEntry->getVideoTitle();
  $VidInfo['description'] = $videoEntry->getVideoDescription();
  $VidInfo['tags'] = $videoEntry->getVideoTags();
  return $VidInfo;
}

function getuploads($userName)                    
{     
  $yt = new Zend_Gdata_YouTube();
  $yt->setMajorProtocolVersion(2);
  return getVideoFeed($yt->getuserUploads($userName));
}  

$VidEntrys = getuploads(get_option('wp_tube_user'));

foreach ($VidEntrys as $Video) {
	$find_vids = "SELECT * FROM " . $wpdb->prefix . "wp_tube_vids WHERE wpt_ytid = '".$Video['id']."'";
	$get_vids = count($wpdb->get_results($find_vids));
	if ( $get_vids == 0 ) {
		//Start creating post
		$Content = '[wp-tube vid_id="'.$Video['id'].'" /]';
		
		// Create post object
		  $my_post = array();
		  $my_post['post_title'] = $Video['title'];
		  $my_post['post_content'] = $Content;
		  $my_post['post_status'] = 'publish';
		  $my_post['post_category'] = get_option('wp_tube_cat');
		  $my_post['tags_input'] = implode(',', $Video['tags']);
		
		// Insert the post into the database
		  $laid = wp_insert_post( $my_post );
		  wp_set_post_categories($laid, array(get_option('wp_tube_cat')));
		$insert = "INSERT INTO ".$wpdb->prefix . "wp_tube_vids" .
            " (wpt_ytid) " .
            "VALUES ('".$Video['id']."')";

      	$results = $wpdb->query( $insert );
	}
}
update_option('wp_tube_lud', time());
?>