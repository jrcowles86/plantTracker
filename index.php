<?php

use Core\Database;
use Core\Router;

/* Declare constants that are necessary to build directory paths. Allows us to require additional .php files, autoload
   functions and tie the disparate .php files of our application together. Can't place these in config.php because they're
   needed to specify the directory so the config constants and helper functions can be imported! */
define('DS', DIRECTORY_SEPARATOR);
//echo DS . '<br><br>';

define('ROOT', dirname(__FILE__));
//echo 'This is ROOT constant: ' . ROOT . '<br><br>';

/* Require config.php, which hold most of the global constants the application will need. */
require_once(ROOT . DS . 'config' . DS . 'config.php');

/* Require any helper functions defined to assist with development. Most of these functions are shortcuts of some kind. */
require_once(ROOT . DS . 'lib' . DS . 'helpers.php');

function autoloader($class) {
    /* The namespace backslash must be converted to the standard directory path forwardslash. '\\' is the only way to work around
       the backslash's default behavior for declaring escape characters. */
        $path = explode('\\', $class);
        $className = array_pop($path);
        $lower = [];
        foreach ($path as $element) {
            $lower[] = strtolower($element);
        }
        array_push($lower, $className);
        $directory = ROOT . DS . implode('/', $lower) . '.php';
        //echo '<b>This is $class:</b> ' . $class . '<br>';
        //echo '<b>This is $directory:</b> ' . $directory . '<br><br>';
        require_once($directory);
}

spl_autoload_register('autoloader');

/* Start a new session or resume an existing one. Produces a unique Session ID (SID) for each user. Once started, session
   variables can be populated to store relevant data about each user. Session data in key-value pairs using the $_SESSION[] 
   superglobal array.The stored data can be accessed during lifetime of a session. */
session_start();

/* Explode URL string using the '/' as delimiter. Then, trim off the extra '/' from the left-side of the URL. Implode() 
   essentially transforms a string into an array based on a specified delimiter. */
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [] ;

$database = Database::instance();

Router::route($url);