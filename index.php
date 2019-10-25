<?php

/* Declare constants that are necessary to build directory paths. Allows us to require additional .php files, autoload
   functions and tie the disparate .php files of our application together. Can't place these in config.php because they're
   needed to specify the directory so the config constants and helper functions can be imported! */
define('DS', DIRECTORY_SEPARATOR);
//echo DS . '<br><br>';

define('ROOT', dirname(__FILE__));
//echo ROOT . '<br><br>';

/* Require config.php, which hold most of the global constants the application will need. */
require_once(ROOT . DS . 'config' . DS . 'config.php');

/* Require any helper functions defined to assist with development. Most of these functions are shortcuts of some kind. */
require_once(ROOT . DS . 'lib' . DS . 'helpers.php');

/* Superglobal $_SERVER array key 'PATH_INFO omits query string components from URL, such as .php/some/stuff ->?foo=bar
   The key $_SERVER['REQUEST_URI'] will return the entire URI string. */
//echo $_SERVER['PATH_INFO'];   // Provide browser with a url for this to work, like 'http://localhost/users/detail/67893.'
//echo $_SERVER['REQUEST_URI'];

function autoloader($class) {
    if (file_exists(ROOT . DS . 'core' . DS . $class . '.php')) {     // Check 'core' directory for a $class name.
        require_once(ROOT . DS . 'core' . DS . $class . '.php');      // If matches, include class from 'core' directory.
    } else if (file_exists(ROOT . DS . 'controllers' . DS . $class . '.php')) {
        require_once(ROOT . DS . 'controllers' . DS . $class . '.php');
    } else if (file_exists(ROOT . DS . 'models' . DS . $class . '.php')) {
        require_once(ROOT . DS . 'models' . DS . $class . '.php');
    }
}

spl_autoload_register('autoloader');

/* Start a new session or resume an existing one. Produces a unique Session ID (SID) for each user. Once started, session
   variables can be populated to store relevant data about each user. Session data in key-value pairs using the $_SESSION[] 
   superglobal array.The stored data can be accessed during lifetime of a session. Assigning session data is as shown below: 
        $_SESSION["Rollnumber"] = "11"; 
        $_SESSION["Name"] = "Ajay"; */
session_start();

/* Explode URL string using the '/' as delimiter. Then, trim off the extra '/' from the left-side of the URL. Implode() 
   essentially transforms a string into an array based on a specified delimiter. */
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [] ;

$database = Database::instance();

Router::route($url);

/* NOTE: May be worthwhile to build a Request class to parse the URI before the router receives it? Then, build a
   router.php file that actually handles individual routes? */
