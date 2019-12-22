<?php
return
[
    // Application name
    "name" => "رُفوف",

    // Application description
    "description" => "رُفوف",

    // Application version
    "version" => "1.0.0",

    // Application URL
    "url" => "http://localhost:8080/it/test",

    // Application e-mail
    "email" => "info@roufuf.com",

    // Accounts per IP
    "accounts_per_ip" => 5,

    // Phone number
    "phone" => "+201024970738",

    // Social network credentials
    "facebook" => "",
    "messenger" => "",
    "instagram" => "",
    "twitter" => "",
    "whatsapp" => "",

    /**
     *  Default Database Connection Name
     *  Here you may specify which of the database connections below you wish
     *  to use as your default connection for all database work.
     */
    "default_connection" => "mysql",

    /**
     *  Database Connections
     *  Here are each of the database connections setup for your application.
     *  to use as your default connection for all database work.
     */
    "connections" => 
    [
        "mysql" => 
        [
            "host"     => "127.0.0.1",
            "username" => "root",
            "password" => "",
            "db_name"  => "1_database",
        ],
    ],
];