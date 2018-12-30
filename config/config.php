<?php
/**
 * PHP Configuration
 * User: Surajit Basak
 * Date: 30-12-2018
 * Time: 20:30
 */

// Configuration for database
define('DB_HOST', 'localhost');
define('DB_NAME', 'post_a');
define('DB_USER', 'root');
define('DB_PASS', '');

// Root folder
define('ROOT', dirname(__DIR__));

try
{
    $opts = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    );
    $dbh = new PDO('mysql:host='. DB_HOST . '; dbname=' . DB_NAME . ';', DB_USER, DB_PASS, $opts);
} catch (PDOException $e)
{
    echo $e->getMessage();
}

function autoload_classes($classname)
{
    require 'helper/'.$classname.'.php';
}

spl_autoload_register('autoload_classes');