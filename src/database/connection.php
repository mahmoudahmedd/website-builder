<?php

class MySQLConnection
{
    public static $connection;

    /**
     * MySQLConnection constructor
     */
    private function __construct() {}

    function getConnection() 
    {
        if(MySQLConnection::$connection != null)
        {
            return MySQLConnection::$connection;
        }
        else
        {
            global $configs;
            
            // MySQL credentials
            $host = $configs["connections"]["mysql"]["host"];
            $username =$configs["connections"]["mysql"]["username"];
            $password = $configs["connections"]["mysql"]["password"];
            $dbName = $configs["connections"]["mysql"]["db_name"];

            MySQLConnection::$connection = new mysqli($host, $username, $password, $dbName);

            if(MySQLConnection::$connection->connect_errno) 
            {
                die("Failed to connect to MySQL: (" . MySQLConnection::$connection->connect_errno . ") " . MySQLConnection::$connection->connect_error);
            }

            return MySQLConnection::$connection;
        }
    }
}

if($configs["default_connection"] == "mysql")
{
    $db = MySQLConnection::getConnection();
}
