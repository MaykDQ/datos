<?php
    require_once 'config.php';
    include_once 'meekrodb.php';

    DB::$host                           = $host;
    DB::$user                           = $user;
    DB::$password                       = $password;
    DB::$dbName                         = $dbName;

    DB::$error_handler                  = false;
    DB::$throw_exception_on_error       = true;

    $current_timestamp                  = date("Y-m-d H:i:s");

    error_reporting(0);


    define("DB_HOST", $host );
    define("DB_USER", $user );
    define("DB_PASS", $password );
    define("DB_NAME", $dbName );
?>