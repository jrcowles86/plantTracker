<?php

/* Router class is not instantiated, as it only contains a single, static function. The router is intended to interpret 
   something like a URI string and do nothing other than to route that string (and of course any payload passed to 
   POST/PUT) to an appropriate piece of logic that knows what to do with it. */

class Router {

    public static function route($url) {

        /* Determine the appropriate controller to call. Can use ternary operator or if-else clause. Pick-out the first
           element of the $url array and array_shift that element off before passing $url along to capture $method value. */
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER ;
        array_shift($url);

        /* Determine the appropriate method to call. Also uses ternary operator, ucwords() not required for $method name. */
        $method = (isset($url[0]) && $url[0] != '') ? $url[0] : DEFAULT_METHOD ;
        array_shift($url);

        /* Check if $controller and $method values match existing classes and methods. If not, redirect to the Home class 
           and index() method. */
        if (!class_exists($controller)) {
            $controller = DEFAULT_CONTROLLER;
            $method = DEFAULT_METHOD;
        } else if (class_exists($controller) && !method_exists($controller, $method)) {
            $method = DEFAULT_METHOD;
        }

        $params = $url;
        $object = new $controller($controller, $method);
        
        call_user_func_array([$object, $method], $params);
    }

    public static function redirect($location) {
        if (!headers_sent()) {
            /* If headers are not set, redirect manually using root directory and $location provided by function call. */
            header('Location: ' . ROOT_DIRECTORY . $location);
            exit();
        } else {
            /* If headers are sent, use Javascript to redirect to new $location. */
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . ROOT_DIRECTORY . $location . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
            echo '</noscript>';
            exit();
        }
    }

}