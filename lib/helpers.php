<?php

use Core\Model\Users;

function dnd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function sanitize($dirty) {
    return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}

function currentUser() {
    return Users::currentLoggedInUser();
}

/* Important function that iterates through each key => value pair in the $_POST superglobal array, executing the sanitize() 
   function.  */
function postedValues($dirtyPost) {
    $cleanPost = [];
    foreach ($dirtyPost as $key => $value) {
        $cleanValue = sanitize($value);
        $cleanPost[$key] = $cleanValue;
    }
    return $cleanPost;
}
