<?php

require_once(ROOT . DS . "bootstrap" . DS . "autoload.php");

class Application 
{
    // Application constructor
    private function __construct() {}
    
    /**
     * Run the application
     *
     * @return void
     */
    public static function run() 
    {
        global $actions, $configs, $themes, $db, $profile;

        if(isset($_GET['a']) && isset($actions[$_GET['a']])) 
        {
            $pageName = $actions[$_GET['a']];
        } 
        else 
        {
            $pageName = "home";
        }

        // 
        require_once(ROOT . DS . "app" . DS . "views" . DS . "{$pageName}.php");

        $themes["content"]   = pageMain();
        if(is_array($profile) && !empty($profile["phone_number"])) 
        {
            $themes["menu"] = menu($profile);
        } 
        else
        {
            $themes["menu"] = menu(false);
        }

        $skin = new Skin("wrapper");
        echo $skin->make();


        // Clean-up environment
        mysqli_close($db);
    }
}