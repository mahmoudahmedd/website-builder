<?php
function pageMain()
{
	global $actions, $configs, $themes, $db;

	$themes["nearest_locations"] = getNearestLocations();
	
	// Page title
	$themes["title"] = "أستكشف الأقرب" . " - " . $themes["application_name"];
	
	$skin = new Skin('explore/content');
	return $skin->make();
}
?>