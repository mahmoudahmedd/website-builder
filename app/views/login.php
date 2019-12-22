<?php
function pageMain()
{
	global $actions, $configs, $themes, $db, $profile;

	// Not logged
	if($profile["phone_number"]) 
	{
		header("Location: " . $themes["dashboard_url"]);
	}

	if(isset($_POST["login"])) 
	{
		if (!isset($_POST["phone_number"]) || 
			!isset($_POST["password"])) 
		{
			header("Location: " . $themes["login_url"]);
		}

		$tempProfile = new Profile();
		$tempProfile->phoneNumber = $_POST["phone_number"];
		$tempProfile->password = $_POST["password"];

		// ProfileController usage
		$profileController = new ProfileController();
		$profileController->db = $db;
		$profileController->url = $configs["url"];
		$profileController->profile = $tempProfile;

		$auth = $profileController->auth(1);


		if(is_array($auth)) 
		{
			header("Location: " . $themes["dashboard_url"]);
		} 
		else 
		{
			$themes["login_msg"] = notificationBox("alert alert-danger", $auth, 1);
		}
	}

	// Page title
	$themes["title"] = "تسجيل الدخول" . " - " . $themes["application_name"];
	

	$skin = new Skin('login/content');
	return $skin->make();
}
?>