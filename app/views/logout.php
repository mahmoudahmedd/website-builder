<?php
function pageMain()
{
	global $actions, $configs, $themes, $db, $profile;


	if($profile["phone_number"]) 
	{
		$tempProfile = new Profile();
		$tempProfile->phoneNumber = $_POST["phone_number"];
		$tempProfile->password = $_POST["password"];

		// ProfileController usage
		$profileController = new ProfileController();
		$profileController->db = $db;
		$profileController->url = $configs["url"];
		$profileController->profile = $tempProfile;
		
        $profileController->logout();

        header("Location: " . $themes["home_url"]);
	}

	// Page title
	$themes["title"] = "تسجيل الدخول" . " - " . $themes["application_name"];
	
	$skin = new Skin('logout/content');
	return $skin->make();
}
?>