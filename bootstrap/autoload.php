<?php
// Session start
session_start();

define("COOKIE_PATH", preg_replace("|https?://[^/]+|i", '', $configs["url"]) . "/");
session_set_cookie_params(null, COOKIE_PATH);

$configs = $actions = $themes = array();

// config dir
$configs = require_once(ROOT . DS . "config" . DS . "app.php");
$actions = require_once(ROOT . DS . "config" . DS . "actions.php");

// src dir
require_once(ROOT . DS . "src" . DS . "database" . DS . "connection.php");

// app dir
require_once(ROOT . DS . "app" . DS . "skin.php");
require_once(ROOT . DS . "app" . DS . "functions.php");

// controllers dir
require_once(ROOT . DS . "app" . DS . "controllers" . DS ."profile_controller.php");

// models dir
require_once(ROOT . DS . "app" . DS . "models" . DS ."profile.php");


$themes["url"] = $configs["url"];
$themes["application_name"] = $configs["name"];
$themes["year"] = date('Y');
$themes["theme_url"] = "resources";
$themes["email"] = $configs["email"];
$themes["phone"] = $configs["phone"];

// Social network info
$themes["whatsapp"]  = $configs["whatsapp"];
$themes["messenger"] = $configs["messenger"];
$themes["instagram"] = $configs["instagram"];
$themes["facebook"]  = $configs["facebook"];
$themes["twitter"]   = $configs["twitter"];

$themes["dashboard_url"] = $configs["url"] . "/dashboard";
$themes["home_url"]      = $configs["url"] . "/index.php?a=home";
$themes["explore_url"]   = $configs["url"] . "/index.php?a=explore";
$themes["pricing_url"]   = $configs["url"] . "/index.php?a=pricing";
$themes["login_url"]     = $configs["url"] . "/index.php?a=login";
$themes["register_url"]  = $configs["url"] . "/index.php?a=register";
$themes["recover_url"]   = $configs["url"] . "/index.php?a=recover";
$themes["logout_url"]    = $configs["url"] . "/index.php?a=logout";
$themes["services_url"]  = $configs["url"] . "/index.php?a=services";
$themes["help_url"]      = $configs["url"] . "/index.php?a=help";
$themes["about_url"]     = $configs["url"] . "/index.php?a=about";
$themes["contact_url"]   = $configs["url"] . "/index.php?a=contact";
$themes["tos_url"]       = $configs["url"] . "/index.php?a=tos";
$themes["privacy_url"]   = $configs["url"] . "/index.php?a=privacy";

// ProfileController usage
$profileController = new ProfileController();
$profileController->db = $db;
$profileController->url = $configs["url"];
$profile = $profileController->auth(0);

