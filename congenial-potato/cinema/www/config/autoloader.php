<?php
    //define('PATH_ROOT',  $_SERVER['DOCUMENT_ROOT']);
    const DB_NAME = "database";
    const BD_USER_NAME = "admin";
    const BD_PASSWORD = "test";
    const BD_HOST = "db";
    const DB_PORT = 3306;

    spl_autoload_register(
        function($class_name)
        {
            include $_SERVER['DOCUMENT_ROOT'] . "/classes/" . $class_name . '.php';
        }
    );
?>
