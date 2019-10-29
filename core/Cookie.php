<?php

namespace Core;

class Cookie {

    public static function set($name, $value, $expiry) {
        if (setCookie($name, $value, time()+$expiry, '/')) {
            return true;
        }
        return false;
    }

    /* Delete cookie the default PHP way by forcing a timeout/expiration. */
    public static function delete($name) {
        self::set($name, '', time() -1);
    }

    /* Returns the current value associated with the key $name provided to method get(). */
    public static function get($name) {
        return $_COOKIE[$name];
    }

    /* Method exists() checks if the provided $_COOKIE superglobal key $name exists. Returns a boolean value. */
    public static function exists($name) {
        return isset($_COOKIE[$name]);
    }

}
