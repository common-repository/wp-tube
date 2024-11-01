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
  return $videoEntry->getVideoId();
}

function getuploads($userName)                    
{     
  $yt = new Zend_Gdata_YouTube();
  $yt->setMajorProtocolVersion(2);
  return getVideoFeed($yt->getuserUploads($userName));
}  

echo "<pre>";
$VidEntrys = getuploads($_POST['wpt_username']);
echo "</pre>";

//Clear the old entrys
$wpdb->query( "DELETE FROM ".$wpdb->prefix . "wp_tube_vids" );

//Enter the new ones
foreach ($VidEntrys as $Video) {
	$insert = "INSERT INTO ".$wpdb->prefix . "wp_tube_vids" .
            " (wpt_ytid) " .
            "VALUES ('$Video')";

      $results = $wpdb->query( $insert );
}
?>