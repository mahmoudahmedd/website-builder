<?php
/**
 *  @file    index.php
 *  @date    18/12/2019
 *  @version 1.0.0
 */


// Define root path
define('ROOT', realpath(__DIR__));

// Define directory separator
define('DS', DIRECTORY_SEPARATOR); 

// Bootstrap the application and do action
require_once(ROOT . DS . "bootstrap" . DS . "application.php");

// Run the application
Application::run();
