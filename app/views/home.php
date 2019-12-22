<?php
function pageMain()
{
	global $actions, $configs, $themes, $db;

	// Page title
	$themes["title"] = "الرئيسية" . " - " . $themes["application_name"];
	
	$skin = new Skin('home/content');
	return $skin->make();
}
?>