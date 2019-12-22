<?php
function pageMain()
{
	global $actions, $configs, $themes, $db, $profile;

	// Not logged
	if($profile["phone_number"]) 
	{
		header("Location: " . $themes["dashboard_url"]);
	}
	
	if(isset($_POST["register"])) 
	{
		if (!isset($_POST["manager_name"]) || 
			!isset($_POST["phone_number"]) || 
			!isset($_POST["password"])) 
		{
			header("Location: " . $themes["register_url"]);
		}

		$tempProfile = new Profile();
		$tempProfile->managerName = $_POST["manager_name"];
		$tempProfile->phoneNumber = $_POST["phone_number"];
		$tempProfile->password = $_POST["password"];

		// ProfileController usage
		$profileController = new ProfileController();
		$profileController->db = $db;
		$profileController->url = $configs["url"];
		$profileController->profile = $tempProfile;
		

		$themes["register_msg"] = $profileController->process();

		if($themes["register_msg"] == 1) 
		{
			header("Location: " . $themes["dashboard_url"]);
		}
	}

	// Page title
	$themes["title"] = "إنشاء حساب جديد" . " - " . $themes["application_name"];;

	$skin = new Skin('register/content');
	return $skin->make();
}
?>