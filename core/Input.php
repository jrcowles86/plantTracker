<?php

namespace Core;

class Input {

    /* Running $_POST values through htmlentities() ensures HTML characters are converted into 'entities' that can't be used to
       inject <script> tags or other nefariousness into your application. */
    public static function sanitize($input) {
        return htmlentities($input, ENT_QUOTES, "UTF-8");
    }

    /* The get() method executes the sanitize() method above after determining whether $input is from $_POST or $_GET. */
    public static function cleanItem($input) {
        if (isset($_POST[$input])) {
            return self::sanitize($_POST[$input]);
        } else if (isset($_GET[$input])) {
            return self::sanitize($_GET[$input]);
        }
    }

    public static function cleanArray(array $input) {
        $cleanInput = [];
        if (isset($_POST)) {
            foreach ($input as $key => $value) {
                $cleanValue = self::sanitize($value);
                $cleanKey = self::sanitize($key);
                $cleanInput[$cleanKey] = $cleanValue;
            }
            return $cleanInput;
        } else if (isset($_GET)) {
            foreach ($input as $key => $value) {
                $cleanValue = self::sanitize($value);
                $cleanKey = self::sanitize($key);
                $cleanInput[$cleanKey] = $cleanValue;
            }
            return $cleanInput;
        }
    }

}
