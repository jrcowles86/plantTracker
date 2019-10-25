<?php

class Input {

    public static function sanitize($dirty) {
        return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    }

    /* The get() method executes the sanitize() method above after determining whether $input is from $_POST or $_GET. */
    public static function get($input) {
        if (isset($_POST[$input])) {
            return self::sanitize($_POST[$input]);
        } else if (isset($_GET[$input])) {
            return self::sanitize($_GET[$input]);
        }
    }

}