<?php
// Session start
session_start();

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
$themes["login_url"]     = $configs["url"] . "/index.php?a=login";
$themes["register_url"]  = $configs["url"] . "/index.php?a=register";
$themes["logout_url"]    = $configs["url"] . "/index.php?a=logout";



// ProfileController usage
$profileController = new ProfileController();
$profileController->db = $db;
$profileController->url = $configs["url"];
$profile = $profileController->auth(0);

