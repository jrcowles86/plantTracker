<?php

/* Session will be a parent class, but will not be extended directly. This class will be used primarily for code 
   organization anbd will contain primarily static methods. */

class Session {

    /* Use ternary operator to check if the $_SESSION 'name' key has a value; return true or false. */
    public static function exists($name) {
        return (isset($_SESSION['name'])) ? true : false ;
    }

    /* Return the value corresponding to $name key from $_SESSION superglobal. */
    public static function get($name) {
        return $_SESSION[$name];
    }

    /* The set() method takes a key and value pair and sets the $_SESSION superglobal to store that data. */
    public static function set($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /* Check that $name exists in $_SESSION, and if so, unset the key => value pair in $_SESSION. */
    public static function delete($name) {
        if (self::exists($name)) {
            unset($_SESSON[$name]);
        }
    }

    /* Acquires and stores the User Agent from the HTTP header with data regarding the user's browser and system. 
       This variation discards the user's browser version as those elements changes frequently. Default user agent is:
       Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36
       The $regex uses preg_replace, removes numbers following forward slash '/' to produce a cleaner user agent string: 
       Mozilla (X11; Linux x86_64) AppleWebKit (KHTML, like Gecko) Chrome Safari. */
    public static function userAgent() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $regex = '/\/[a-zA-Z0-9.]+/';
        $newAgent = preg_replace($regex, '', $userAgent);
        return $newAgent;
    }

}
